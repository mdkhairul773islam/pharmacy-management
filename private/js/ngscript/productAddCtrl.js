app.controller('productAddCtrl',['$scope','$http',function($scope,$http){
	
	$scope.getAllSubcategory = function (){
		$scope.allSubCategory = [];
		var where = {
			table : 'subcategory',
			cond  :{
				category : $scope.category
			} 
		};
		$http({
			method : "POST",
			url    : url + 'read',
			data   : where
		}).success(function(response){			
			if (response.length > 0) {				
				$scope.allSubCategory = response;
			}else{
				$scope.allSubCategory = [];
			}
		});

		
	}
}]);