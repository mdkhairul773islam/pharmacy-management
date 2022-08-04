// Edit Purchase Entry
app.controller('EditPurchaseEntry', function ($scope, $http) {

    $scope.partyInfo = {
		balance: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };

    $scope.total_discount = 0;
    $scope.transport_cost = 0;
    $scope.payment = 0;

    $scope.$watch('voucher_no', function (voucher_no) {

        // get purchase record info
        $http({
            method: 'post',
            url: url + 'result',
            data: {
                table: 'saprecords',
                cond: {'saprecords.voucher_no': voucher_no, 'saprecords.trash': '0'}
            }
        }).success(function (recordInfo) {

            if (recordInfo.length > 0) {

                $scope.total_discount = parseFloat(recordInfo[0].total_discount);
                $scope.transport_cost = parseFloat(recordInfo[0].transport_cost);
                $scope.payment = parseFloat(recordInfo[0].paid);

                // get party balance info
                $http({
                    method: 'POST',
                    url: url + 'supplier_balance',
                    data: {party_code: recordInfo[0].party_code}
                }).success(function (balanceInfo) {

                    var previous_balance = parseFloat(balanceInfo.balance) + parseFloat(recordInfo[0].total_bill) - parseFloat(recordInfo[0].paid);

                    $scope.partyInfo.balance = Math.abs(parseFloat(previous_balance).toFixed(2));
                    $scope.partyInfo.sign = (parseFloat(previous_balance) < 0 ? 'Payable' : 'Receivable');
                });


                // get sap items info
                $scope.cart = [];

                $http({
                    method: 'post',
                    url: url + 'join',
                    data: {
                        tableFrom: 'sapitems',
                        tableTo: 'stock',
                        joinCond: 'sapitems.id=stock.item_id',
                        cond: {
                            'sapitems.voucher_no': recordInfo[0].voucher_no,
                            'sapitems.trash': '0',
                        },
                        select: ['sapitems.*', 'stock.name', 'stock.category', 'stock.subcategory', 'stock.batch_no', 'stock.expire_date']
                    }
                }).success(function (itemInfo) {

                    if (itemInfo.length > 0) {
                        angular.forEach(itemInfo, function (row, index) {

                            var item = {
                                id: row.id,
                                product_name: row.name,
                                product_code: row.product_code,
                                product_cat: row.category,
                                subcategory: row.subcategory,
                                batch_no: row.batch_no,
                                expire_date: row.expire_date,
                                unit: row.unit,
                                old_price: parseFloat(row.purchase_price),
                                price: parseFloat(row.purchase_price),
                                sale_price: parseFloat(row.sale_price),
                                old_quantity: parseFloat(row.quantity),
                                quantity: parseFloat(row.quantity),
                                discount: parseFloat(row.discount),
                                old_subtotal: 0,
                                subtotal: 0,
                            };

                            $scope.cart.push(item);
                        });
                    }
                });
            }
        });
    });

    // set old  subtotal
    $scope.setOldSubtotalFn = function (index) {
        var total = 0;
        total = $scope.cart[index].old_price * $scope.cart[index].old_quantity;
        $scope.cart[index].old_subtotal = total.toFixed(2);
        return $scope.cart[index].old_subtotal;
    };

    // set subtotal
    $scope.setSubtotalFn = function (index) {
        var total = 0;
        total = $scope.cart[index].price * $scope.cart[index].quantity;
        $scope.cart[index].subtotal = total.toFixed(2);
        return $scope.cart[index].subtotal;
    };

    // get total quantity
    $scope.getTotalQuantityFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += item.quantity;
        });
        return total;
    };

    // get total amount
    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
        });
        return total.toFixed(2);
    };

    // get grand total
    $scope.getGrandTotalFn = function () {
        var total = 0;
        total = (parseFloat($scope.getTotalFn()) - parseFloat($scope.total_discount)) + parseFloat($scope.transport_cost);
        return total.toFixed(2);
    };

	// get current balance
	$scope.getCurrentTotalFn = function() {
		var total = 0;

        var previous_balance = ($scope.partyInfo.sign == 'Receivable' ? parseFloat($scope.partyInfo.balance) : -parseFloat($scope.partyInfo.balance));

        total =  (previous_balance - parseFloat($scope.getGrandTotalFn())) + parseFloat($scope.payment);

		$scope.partyInfo.csign = (total < 0 ? 'Payable' : 'Receivabel');

		return Math.abs(total.toFixed(2));
	};
});

