var app = angular.module("MainApp", ['angularUtils.directives.dirPagination','ngSanitize']);

// var url = window.location.origin + '/lcp/ajax/';
// var siteurl = window.location.origin + '/lcp/';

var url = window.location.origin + '/ajax/';
var siteurl = window.location.origin + '/';

// custom filter in Angular js
app.filter('removeUnderScore', function() {
	return function(input) {
		return input.replace(/_/gi, " ");
	}
});

app.filter('textToLower', function() {
	return function(input) {
		return input.replace(/_/gi, " ").toLowerCase();
	}
});

//remove underscore and ucwords
app.filter("textBeautify", function(){
	return function (str) {
		var str = str.replace(/_/gi, " ").toLowerCase(),
        	txt = str.replace(/\b[a-z]/g, function(letter) {
        		return letter.toUpperCase();
    		});

    	return txt;
    }
});

//remove dash and ucwords
app.filter("removeDash",function(){
	return function (str) {
	  var str = str.replace(/-/gi, " ").toLowerCase();
          txt = str.replace(/\b[a-z]/g, function(letter) {
         return letter.toUpperCase();
     });
    return txt;
   }
});


app.filter('join', function(){
	return function(input) {
		console.log(typeof input);
		return (typeof input==='object') ? "" : input.join();
	}
});


app.filter("showStatus",function(){
	return function(input){
        if(input == 1){
        	return "Available";
        }else{
        	return "Not Available";
        }
	}
});


app.filter("status",function(){
	return function(input){
        if(input == "active"){
        	return "Running";
        }else{
        	return "Blocked";
        }
	}
});


app.filter("fNumber",function(){
	return function(input){
		var myNum = new Intl.NumberFormat('en-IN').format(input);
		return  myNum;
	}
});

//SMS Controller
app.controller("CustomSMSCtrl", ["$scope", "$log", function($scope, $log){
	$scope.msgContant = "";
	$scope.totalChar = 0;
	$scope.msgSize = 1;

	$scope.$watch(function(){
		var charLength = $scope.msgContant.length,
		message = $scope.msgContant,
		messLen = 0;
		
		
		
		
	var english = /^[~!@#$%^&*(){},.:/-_=+A-Za-z0-9 ]*$/;
	
	if (english.test(message)){
	        if( charLength <= 160){ messLen = 1; }
		else if( charLength <= 306){ messLen = 2; }
		else if( charLength <= 459){ messLen = 3; }
		else if( charLength <= 612){ messLen = 4; }
		else if( charLength <= 765){ messLen = 5; }
		else if( charLength <= 918){ messLen = 6; }
		else if( charLength <= 1071){ messLen = 7; }
		else if( charLength <= 1080){ messLen = 8; }
		else { messLen = "Equal to an MMS!"; }		
		
	}else{
	        if( charLength <= 63){ messLen = 1; }
		else if( charLength <= 126){ messLen = 2; }
		else if( charLength <= 189){ messLen = 3; }
		else if( charLength <= 252){ messLen = 4; }
		else if( charLength <= 315){ messLen = 5; }
		else if( charLength <= 378){ messLen = 6; }
		else if( charLength <= 441){ messLen = 7; }
		else if( charLength <= 504){ messLen = 8; }		
		else { messLen = "Equal to an MMS!"; }
	}

		

		$scope.totalChar = charLength;
		$scope.msgSize = messLen;
	});
}]);
