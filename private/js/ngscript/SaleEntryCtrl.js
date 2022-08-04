// sale controller
app.controller('SaleEntryCtrl', function ($scope, $http) {
    
    $scope.active = true;
    $scope.active1 = false;
    $scope.promise_date = true;
    $scope.isDisabled = false;
    $scope.cart = [];

    $scope.stype = "cash";

    $scope.payment = 0;
    $scope.total_discount = 0;
    
    $scope.discount_percentege = 0;
    $scope.total_discount_m = 0;
    

    //get sale type
    $scope.getsaleType = function (type) {
        if (type == "cash") {
            $scope.active = true;
            $scope.active1 = false;
            $scope.partyInfo.code = '';
            $scope.partyInfo.balance = 0;
            $scope.partyInfo.sign = "Receivable";
        } else {
            $scope.active = false;
            $scope.active1 = true;
            $scope.partyInfo.balance = 0;
            $scope.partyInfo.sign = "Receivable";
        }
    };


    // add product in cart
    $('#productList').on('change', function () {

        var stock_id = $(this).val();

        if (typeof stock_id !== 'undefined' && stock_id != '') {

            // get product in stock
            $http({
                method: 'POST',
                url : url + 'result',
                data: {
                    table: 'stock',
                    cond: {id: stock_id, trash: '0'}
                }
            }).success(function (response) {
                if (response.length > 0) {
                    var newItem = {
						id: response[0].id,
                        product_name: response[0].name,
						product_code: response[0].code,
						batch_no: response[0].batch_no,
						expire_date: response[0].expire_date,
                        unit: response[0].unit,
                        godown: response[0].godown,
                        stock_qty: parseInt(response[0].quantity),
                        purchase_price: parseFloat(response[0].purchase_price),
                        sale_price: parseFloat(response[0].sell_price),
                        quantity: 1,
                        discount: 0,
                        subtotal: 0,
                        subcategory: '',
                        self_name: '',
                    };
                    
                     $http({
                        method: 'POST',
                        url : url + 'result',
                        data: {
                            table: 'products',
                            cond: {product_code: response[0].code}
                        }
                    }).success(function (response2) {
                        if(response2.length > 0){
                            newItem.subcategory = (response2[0].subcategory).replaceAll('_', ' ');
                            newItem.self_name   = (response2[0].self_name).replaceAll('_', ' ');
                        }
                    });
                    $scope.cart.push(newItem);
                }
            });
        }
    });

    // set total profit
    $scope.getProfitFn = function (index) {
        var total = 0;
        total = (($scope.cart[index].sale_price - $scope.cart[index].purchase_price) * $scope.cart[index].quantity) - $scope.cart[index].discount;
        $scope.cart[index].profit = total.toFixed(2);
        return $scope.cart[index].profit;
    };

    // get total profit
    $scope.totalProfitFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (profit) {
            total += parseFloat(profit.profit);
        });
        return total.toFixed(2);
    };

    // sat subtotal
    $scope.setSubtotalFn = function (index) {
        var total = 0;
        total = ($scope.cart[index].sale_price * $scope.cart[index].quantity) - $scope.cart[index].discount;
        $scope.cart[index].subtotal = total.toFixed(2);
        return $scope.cart[index].subtotal;
    };

    // set purchase subtotal
    $scope.purchaseSubtotalFn = function (index) {
        var total = 0;
        total = $scope.cart[index].purchase_price * $scope.cart[index].quantity;
        $scope.cart[index].purchase_subtotal = total.toFixed(2);
        return $scope.cart[index].purchase_subtotal;
    };

    // get purchase total
    $scope.getPurchaseTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.purchase_subtotal);
        });
        return total.toFixed(2);
    };

    // get total balance
    $scope.getTotalFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.subtotal);
        });
        
        return total.toFixed(2);
    };

    $scope.getTotalQtyFn = function () {
        var total = 0;
        angular.forEach($scope.cart, function (item) {
            total += parseFloat(item.quantity);
        });
        return total;
    };


    $scope.getGrandTotalFn = function () {
        var total = 0;
        var grand_total = $scope.getTotalFn();
        var discount = ((grand_total/100)*$scope.discount_percentege)+parseFloat($scope.total_discount);
        $scope.total_discount_m = discount;
        total = grand_total - discount;
        return total.toFixed(2);
    };


    $scope.getCurrentTotalFn = function () {

        var total = 0;

        if ($scope.partyInfo.sign == 'Receivable') {
            total = (parseFloat($scope.partyInfo.balance) + parseFloat($scope.getGrandTotalFn())) - parseFloat($scope.payment);
        } else {
            total = (parseFloat($scope.payment) + parseFloat($scope.partyInfo.balance)) - parseFloat($scope.getGrandTotalFn());
        }

        $scope.partyInfo.csign = (total < 0 ? 'Payable' : 'Receivable');
        $scope.promise_date = (total > 0 ? true : false);
        $scope.status = (total < 0 ? 'Return' : 'Due');


        if ($scope.stype == "credit") {
            if ($scope.partyInfo.csign == "Receivable" && $scope.partyInfo.cl < Math.abs(total)) {
                $scope.isDisabled = true;
                $scope.message = "Total is being crossed the Credit Limit!";
            } else {
                $scope.isDisabled = false;
                $scope.message = "";
            }
        }else{
            $scope.isDisabled = false;
            $scope.message = "";
        }

        return Math.abs(total.toFixed(2));
    };


    // get party info
    $scope.partyInfo = {
        name: '',
        mobile: '',
        address: '',
        balance: 0,
        cl: 0,
        sign: 'Receivable',
        csign: 'Receivable'
    };

    $scope.findPartyFn = function (party_code) {

        if (typeof party_code !== 'undefined') {

            $http({
                method: 'POST',
                url: url + 'result',
                data: {
                    table: "parties",
                    cond: { code: party_code}
                }
            }).success(function (response) {

                if (response.length > 0) {

                    $scope.partyInfo.code = response[0].code;
                    $scope.partyInfo.name = response[0].name;
                    $scope.partyInfo.contact = response[0].mobile;
                    $scope.partyInfo.address = response[0].address;
                    $scope.partyInfo.cl = parseFloat(response[0].credit_limit);

                    // get client balnace
                    $http({
                        method: 'POST',
                        url: url + 'client_balance',
                        data: {party_code: response[0].code}
                    }).success(function (balanceInfo) {
                        $scope.partyInfo.balance = Math.abs(balanceInfo.balance);
                        $scope.partyInfo.sign = balanceInfo.status;
                    });
                }
            });
        }
    };

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    };
});
