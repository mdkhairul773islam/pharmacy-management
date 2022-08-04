//cost controller start here
app.controller("costCtrl",['$scope','$http',function($scope,$http){
    $scope.perPage = "10";
    $scope.reverse = false;
    $scope.fields = [];

	var obj = {
		table : "cost_field"
	};

	$http({
		method : "POST",
		url : url + "read",
		data : obj
	}).success(function(response){
		if(response.length>0){
			angular.forEach(response,function(values,index){
				values['sl'] = index + 1;
				$scope.fields.push(values);
			});
		}else{
			$scope.fields = [];
		}
	});
	
	
	
	$scope.getFieldName = function(name){
	    $scope.oldname = name;
	}
	
	
}]);
