// add purchase entry
app.controller('PurchaseEntry', function($scope, $http){

	$scope.active = true;
	$scope.cart = [];

	$scope.amount = {
		total: 0,
		totalDiscount: 0,
		transport_cost: 0,
		grandTotal: 0,
		paid: 0,
		due: 0
	};

	$scope.voucher_validation = false;
	$scope.batch_validation = false;


	// check voucher exists
	$scope.voucherExistsFn = function(voucher_no) {

		if (typeof voucher_no !== 'undefined' && voucher_no.length > 2){

			$http({
				method: 'post',
				url: url + 'result',
				data: {
					table: 'saprecords',
					cond : {voucher_no: voucher_no, trash: '0'},
					select: ['voucher_no']
				}
			}).success(function(voucherInfo) {

				if(voucherInfo.length > 0) {
					$scope.voucher_validation = true;
				} else {
					$scope.voucher_validation = false;
				}
			});
		}else{
			$scope.voucher_validation = false;
		}
	};

	// get party balance and info
	$scope.partyInfo = {
		balance: 0,
		sign: 'Receivable',
		csign: 'Receivable'
	};

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

		var product_code = $(this).val();

		if (typeof product_code !== 'undefined'){

			$scope.active = false;

			var condition = {
				table: 'products',
				cond: {
					product_code   : product_code,
					status         : "available"
				}
			};

			$http({
				method: 'POST',
				url: url + 'result',
				data: condition
			}).success(function(response){

				if(response.length > 0){
					var item = {
						product_name   : response[0].product_name,
						product_code   : response[0].product_code,
						product_cat    : response[0].product_cat,
						subcategory    : response[0].subcategory,
						generic_name   : response[0].generic_name,
						batch_no       : '',
						expire_date    : '',
						unit 		   : response[0].unit,
						price          : parseFloat(response[0].purchase_price),
						sale_price     : parseFloat(response[0].sale_price),
						quantity       : 1,
						discount       : 0,
						subtotal       : 0,
					};
					$scope.cart.push(item);
					console.log(111, response[0]);
				}else{
					$scope.cart = [];
				}
			});
		}
	});

	// get set subtotal
	$scope.setSubtotalFn = function(index){
	    var total = 0;
		total = $scope.cart[index].price * $scope.cart[index].quantity;
		$scope.cart[index].subtotal = total.toFixed(2);
		return $scope.cart[index].subtotal;
	};

	// get subtotal
	$scope.getTotalFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += parseFloat(item.subtotal);
		});

		$scope.amount.total = total.toFixed(2);
		return $scope.amount.total;
	};

	// get total quantity
	$scope.getTotalQuantityFn = function(){
		var total = 0;
		angular.forEach($scope.cart, function(item){
			total += item.quantity;
		});
		return total;
	};

	// get grand total
	$scope.getGrandTotalFn = function(){
		$scope.amount.grandTotal = parseFloat($scope.amount.total - $scope.amount.totalDiscount + $scope.amount.transport_cost) ;
		return $scope.amount.grandTotal.toFixed(2);
	};

	// get current balance
	$scope.getCurrentTotalFn = function() {

		var total = 0;

		var previous_balance = ($scope.partyInfo.sign == 'Receivable' ? parseFloat($scope.partyInfo.balance) : -parseFloat($scope.partyInfo.balance));

		total =  (previous_balance - parseFloat($scope.amount.grandTotal)) + parseFloat($scope.amount.paid);

		$scope.partyInfo.csign = (total < 0 ? 'Payable' : 'Receivabel');

		return Math.abs(total.toFixed(2));
	};

	$scope.deleteItemFn = function(index){
		$scope.cart.splice(index, 1);
	};

});