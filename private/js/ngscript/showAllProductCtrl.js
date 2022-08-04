//show all Product Controller
app.controller("showAllProductCtrl", function($scope, $http){
	$scope.perPage	= "20";
	$scope.products	= [];

	var where = {
		table:'products'
	};


	$http({
		method : 'POST',
		url    : url+'read',
		data   : where
	}).success(function(response) {
		if(response.length > 0){
			angular.forEach(response,function(values, index){
				values['sl'] = index + 1;
				$scope.products.push(values);
			});
		} else {
			$scope.products = [];
		}

		//Loader
		$("#loading").fadeOut("fast",function(){
			$("#data").fadeIn('slow');
		});

		console.log($scope.products);
	});
});