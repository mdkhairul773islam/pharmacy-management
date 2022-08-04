// sale controller
app.controller('NewSaleEntryCtrl', function ($scope, $http) {
    
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
    
    $scope.sign = "Receivable";
    $scope.c_sign = "Receivable";
    $scope.previous_balance = 0;
    

    //get sale type
    $scope.getsaleType = function (type) {
        if (type == "cash") {
            $scope.active = true;
            $scope.active1 = false;
        } else {
            $scope.active = false;
            $scope.active1 = true;
        }
    };
    
    
    // get cliend info
    $scope.getClientInfo = function (party_code) {
        //console.log(party_code);

        if (typeof party_code !== 'undefined' && party_code != '') {

            // get party info
            $http({
                method: 'POST',
                url : url + 'result',
                data: {
                    table: 'parties',
                    cond: {code: party_code, trash: '0'}
                }
            }).success(function (response) {
                if (response.length > 0) {
                    
                    $scope.party_address = response[0].address;
                    
                    // get party transaction
                    $http({
                        method: 'POST',
                        url : url + 'result',
                        data: {
                            table: 'partytransaction',
                            cond: {party_code: response[0].code, trash: '0'},
                            select: ['SUM(credit) AS credit', 'SUM(debit) AS debit']
                        }
                    }).success(function (tranRes) {
                        
                        var credit = (!isNaN(parseFloat(tranRes[0].credit)) ? parseFloat(tranRes[0].credit) : 0);
                        var debit = (!isNaN(parseFloat(tranRes[0].debit)) ? parseFloat(tranRes[0].debit) : 0);

                        var balance = parseFloat(response[0].initial_balance) + parseFloat(debit) - parseFloat(credit);
                    
                        $scope.balance = Math.abs(balance).toFixed(2);
                        $scope.cl = Math.abs(response[0].credit_limit);
                        $scope.previous_balance = balance;
                        $scope.sign = (balance < 0) ? "Payable" : "Receivable";
                       
                    });
                }
            });
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
                        min_sale_price: parseFloat(response[0].sell_price),
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
        if ($scope.stype == "credit") {
            var balance = parseFloat($scope.previous_balance) + parseFloat($scope.getGrandTotalFn()) - parseFloat($scope.payment);
        
            $scope.c_sign = (balance < 0 ? 'Payable' : 'Receivable');
            $scope.promise_date = (balance > 0 ? true : false);
            $scope.status = (balance < 0 ? 'Return' : 'Due');
            
            if ($scope.c_sign == "Receivable" && $scope.cl < Math.abs(balance)) {
                $scope.isDisabled = true;
                $scope.message = "Total is being crossed the Credit Limit!";
            } else {
                $scope.isDisabled = false;
                $scope.message = "";
            }
            console.log(balance);
            return Math.abs(balance.toFixed(2));
        }else{  
            $scope.isDisabled = false;
            $scope.message = "";
            
            var balance = parseFloat($scope.getGrandTotalFn()) - parseFloat($scope.payment);
            
            $scope.c_sign = (balance < 0 ? 'Payable' : 'Receivable');
            $scope.promise_date = (balance > 0 ? true : false);
            $scope.status = (balance < 0 ? 'Return' : 'Due');
        
            return Math.abs(balance.toFixed(2));
        }
    };
    

    $scope.deleteItemFn = function (index) {
        $scope.cart.splice(index, 1);
    };
});
