// company transaction controller start here
app.controller('SupplierTransactionCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.balance = 0;
	$scope.sign = "Receivable";

	$scope.payment = 0;
	$scope.remission = 0;
	$scope.csign = "Receivable";

	// get supplier Banlance information
	$scope.getCompanyInfo = function(){
		var total_debit = total_credit = total_remission = total_balance = 0.00;

		var condition = {
		   	table : "parties",
			cond :{
				code : $scope.code
			}
	   	};

	   	$http({
	   		method : 'POST',
	   		url    : url + 'read',
	   		data   : condition
	   	}).success(function(response){
	   		if (response.length > 0) {
	   			$scope.initial_balance = response[0].initial_balance;
	   			total_balance = parseFloat(response[0].initial_balance);

	   			$scope.displayBalance = total_balance;
				$scope.balance = Math.abs(total_balance);

				if(total_balance < 0) {
					$scope.sign = 'Payable';
				} else {
					$scope.sign = 'Receivable';
				}
	   		}

	   	});


	   	// fetch partytransaction records
	   	
	   	var transaction = {
	   		table: 'partytransaction',
	   		cond : {
	   			party_code : $scope.code,
	   			trash      : '0'
	   		}
	   	};

	   	$http({
	   		method : 'POST',
	   		url    : url + 'read',
	   		data   : transaction
	   	}).success(function(records){
	   		if (records.length > 0) {
	   			//console.log(records);
	   			angular.forEach(records,function(item,index){
	   				total_credit += parseFloat(item.credit);
	   				total_debit	+= parseFloat(item.debit);
	   				total_remission	+= parseFloat(item.remission);
	   			});

	   			total_balance  = parseFloat(total_debit) - parseFloat(total_credit) + parseFloat(total_remission) + parseFloat($scope.initial_balance);

	   			$scope.displayBalance = total_balance;
				$scope.balance = Math.abs(total_balance).toFixed(2);
				if(total_balance < 0) {
					$scope.sign = 'Payable';
				} else {
					$scope.sign = 'Receivable';
				}
	   		}
	   	});
	};

	$scope.getTotalFn = function() {
		var total = 0.00;

		if($scope.sign == 'Receivable') {
			total = parseFloat($scope.balance) + parseFloat($scope.payment) - parseFloat($scope.remission);
			$scope.csign = "Receivable";
		} else {
			total = parseFloat($scope.balance) - parseFloat($scope.payment) - parseFloat($scope.remission);

			if(total > 0) {
				$scope.csign = "Payable";
			} else {
				$scope.csign = "Receivable";
			}
		}

		return Math.abs(total).toFixed(2);
	}
}]);
