//show all Sub Category
app.controller("showsubcategoryCtrl",function($scope,$http,$log){
	$scope.reverse=false;
	$scope.perPage="20";
	$scope.subcategorys=[];
	var obj={'table':'subcategory'};
	$http({
		method:'POST',
		url:url+'read',
		data:obj
	}).success(function(response){
		angular.forEach(response,function(values,index){
		  values['sl']=index+1;
		  $scope.subcategorys.push(values);
		});

		 //Pre Loader
		$("#loading").fadeOut("fast",function(){
			$("#data").fadeIn('slow');
		});
	});
});