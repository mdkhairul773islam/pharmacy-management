//  Edit Sale Ctrl
app.controller('EditSaleEntryCtrl', ['$scope', '$http', function($scope, $http) {

	$scope.promise_date = true;
	$scope.isDisabled = false;

	$scope.cart = [];
	$scope.info = {};

	$scope.payment = 0;
	$scope.total_discount = 0;
	$scope.partyInfo = {
		'balance': 0,
		'sign': 'Receivable',
		'csign': 'Receivable',
	};


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
				$scope.payment = parseFloat(recordInfo[0].paid);

				// get party balance info
				if (recordInfo[0].sap_type == 'credit'){

					$http({
						method: 'POST',
						url: url + 'client_balance',
						data: {party_code: recordInfo[0].party_code}
					}).success(function (balanceInfo) {

						var balance = 0;
						if (parseFloat(balanceInfo.balance) < 0) {
							balance = parseFloat(recordInfo[0].paid) - (Math.abs(parseFloat(balanceInfo.balance)) + parseFloat(recordInfo[0].total_bill));
						} else {
							balance = (parseFloat(balanceInfo.balance) + parseFloat(recordInfo[0].paid)) - parseFloat(recordInfo[0].total_bill);
						}

						$scope.partyInfo.balance = Math.abs(parseFloat(balance).toFixed(2));
						$scope.partyInfo.sign = (parseFloat(balance) < 0 ? 'Payable' : 'Receivable');
					});
				}else{
					$scope.partyInfo.balance = 0;
					$scope.partyInfo.sign = 'Receivable';
				}


				// get sap items info
				$scope.cart = [];

				$http({
					method: 'post',
					url: url + 'join',
					data: {
						tableFrom: 'sapitems',
						tableTo: 'stock',
						joinCond: 'sapitems.stock_id=stock.id',
						cond: {
							'sapitems.voucher_no': recordInfo[0].voucher_no,
							'sapitems.trash': '0',
						},
						select: ['sapitems.*','sapitems.name AS product_name' ,'stock.name', 'stock.quantity AS stock_qty', 'stock.category', 'stock.subcategory', 'stock.batch_no', 'stock.expire_date']
					}
				}).success(function (itemInfo) {

					if (itemInfo.length > 0) {

						angular.forEach(itemInfo, function (row, index){

                            var productName;        
                            if(row.product_name !== '' && row.product_name !== null){
                                productName = row.product_name; 
                            }else{
                                productName = row.name;
                            }
                            
							var item = {
								id: row.id,
								stock_id: row.stock_id,
								product_name: productName,
								product_code: row.product_code,
								batch_no: row.batch_no,
								expire_date: row.expire_date,
								unit: row.unit,
								purchase_price: parseFloat(row.purchase_price),
								old_price: parseFloat(row.sale_price),
								sale_price: parseFloat(row.sale_price),
								min_sale_price: parseFloat(row.sale_price),
								old_quantity: parseFloat(row.quantity),
								stock_qty: parseFloat(row.stock_qty),
								quantity: parseFloat(row.quantity),
								old_discount: parseFloat(row.discount),
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

	// sat old subtotal
	$scope.setOldSubtotalFn = function (index) {
		var total = 0;
		total = ($scope.cart[index].old_price * $scope.cart[index].old_quantity) - $scope.cart[index].old_discount;
		$scope.cart[index].old_subtotal = total.toFixed(2);
		return $scope.cart[index].old_subtotal;
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
		total = parseFloat($scope.getTotalFn()) - parseFloat($scope.total_discount);
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


		/*if ($scope.stype == "credit") {
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
		}*/

		return Math.abs(total.toFixed(2));
	};
}]);


