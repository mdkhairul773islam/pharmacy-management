app.controller("allClientCtrl",function($scope, $http) {
   $scope.perPage 	= "50";
   $scope.reverse 	= false;
   $scope.allParty 	= [];

	var where = {
		table : 'parties',
		cond: {
			type : 'client',
			trash: '0'
		}
	};

	$http({
		method: "POST",
		url: url + "read",
		data: where
	}).success(function(response) {		
		if(response.length > 0) {
			angular.forEach(response, function(row, index) {			  
				response[index].sl = index + 1;

				var condition = {
					table: 'partytransaction',
					cond: {
						party_code : row.code,
						trash	   : '0'
					}
				};
				

				$http({
					method : "POST",
					url    : url + "read",
					data   : condition
				}).success(function(records){
					var total_debit = total_credit = total_balance = 0.00;					
					if (records.length > 0) {


						angular.forEach(records,function(record,sl){
							total_debit += parseFloat(record.debit);
							total_credit += parseFloat(record.credit);
						});

						total_balance = (parseFloat(total_debit) - parseFloat(total_credit) + parseFloat(response[index].initial_balance)).toFixed(2);

						response[index].initial_balance = Math.abs(parseFloat(response[index].initial_balance));
						response[index].balance = Math.abs(total_balance);

						if (total_balance < 0) {
							response[index].color = 'color: red; font-weight: bold;';
							response[index].balance_status = 'Payable';
						}else{
							response[index].color = 'color: green; font-weight: bold;';
							response[index].balance_status = 'Receivable';
						}
					}else{

						total_balance = parseFloat(response[index].initial_balance).toFixed(2);

						response[index].initial_balance = Math.abs(parseFloat(response[index].initial_balance));
						response[index].balance = Math.abs(total_balance);

						if (total_balance < 0) {
							response[index].color = 'color: red; font-weight: bold;';
							response[index].balance_status = 'Payable';
						}else{
							response[index].color = 'color: green; font-weight: bold;';
							response[index].balance_status = 'Receivable';
						}
					}
				});
			});
			$scope.allParty = response;
		}


		// loading
		$("#loading").fadeOut("fast", function(){
	   	 	$("#data").fadeIn('slow');
	   	});
	});
});
