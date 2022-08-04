// add purchase entry
app.controller('returnPurchaseProduct', function($scope, $http){

	$scope.active = true;
	$scope.validation = true;
	$scope.cart = [];


	// get party balance and info
	$scope.partyInfo = {
		balance: 0,
		sign: 'Receivable',
		csign: 'Receivable'
	};

	$scope.payment        = 0;
	$scope.total_discount = 0;
	$scope.transport_cost = 0;

	$scope.setPartyfn = function(party_code) {

		if (typeof party_code !== 'undefined'){

			$http({
				method: 'POST',
				url   : url + 'supplier_balance',
				data  : {party_code: party_code}
			}).success(function(balanceInfo){
				$scope.partyInfo.balance = Math.abs(parseFloat(balanceInfo.balance));
				$scope.partyInfo.sign = balanceInfo.status;
			});

		}
	};


	// add new product in to cart
	$('#productList').on('change', function (){

		var stock_id = $(this).val();

		if (typeof stock_id !== 'undefined' && stock_id != ''){

			$scope.active = false;

			// get product in stock
			$http({
				method: 'POST',
				url: url + 'result',
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
						price: parseFloat(response[0].purchase_price),
						sale_price: parseFloat(response[0].sell_price),
						quantity: 1,
						discount: 0,
						subtotal: 0,
					};
					$scope.cart.push(newItem);
				}else{
					$scope.cart = [];
				}
			});
		}
	});

	// set subtotal
	$scope.setSubtotalFn = function(index){
		var total = 0;
		total = $scope.cart[index].price * $scope.cart[index].quantity;
		$scope.cart[index].subtotal = total.toFixed(2);
		return $scope.cart[index].subtotal;
	};

	// get total quantity
	$scope.getTotalQuantityFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += item.quantity;
		});
		return total;
	};

	// get subtotal
	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.subtotal);
		});
		return total.toFixed(2);
	};


	// get grand total
	$scope.getGrandTotalFn = function(){
		var total = 0;
		total = parseFloat($scope.getTotalFn() - $scope.total_discount + $scope.transport_cost) ;
		return total.toFixed(2);
	};

	// get current balance
	$scope.getCurrentTotalFn = function() {

		var total = 0;

		var previous_balance = ($scope.partyInfo.sign == 'Receivable' ? parseFloat($scope.partyInfo.balance) : -parseFloat($scope.partyInfo.balance));

		total =  (previous_balance + parseFloat($scope.getGrandTotalFn())) - parseFloat($scope.payment);

		$scope.partyInfo.csign = (total < 0 ? 'Payable' : 'Receivabel');


		if ($scope.cart.length > 0){
			$scope.validation = false;
		}else {
			$scope.validation = true;
		}

		return Math.abs(total.toFixed(2));
	};

	$scope.deleteItemFn = function(index){
		$scope.cart.splice(index, 1);
	};

});