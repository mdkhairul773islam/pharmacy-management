
// Client transaction controller 
app.controller('ClientTransactionCtrl', ['$scope', '$http', function($scope, $http) {
	$scope.sign = 'Receivable';
	$scope.csign = 'Receivable';
    $scope.remission = 0;
	$scope.payment = 0.00;
	$scope.displayBalance = 0.00;

	// get client Banlance information
	$scope.getclientInfo = function(){
		var total_debit = total_credit = total_balance = 0;

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
	   		    $scope.mobile = response[0].mobile;
	   		    $scope.photo  = response[0].path;
	   		    
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
	   		
	   		//console.log(response);

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
	   			});

	   			total_balance  = parseFloat(total_debit) - parseFloat(total_credit) + parseFloat($scope.initial_balance);

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
		var total = $scope.displayBalance - parseFloat($scope.payment);

		$scope.csign = (total >= 0) ? "Receivable" : "Payable";

		return Math.abs(total-$scope.remission).toFixed(2);
	}

}]);
