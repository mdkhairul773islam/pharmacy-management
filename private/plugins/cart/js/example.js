$(document).ready(function() {
    
	var exampleBarChartData = {
		"datasets": {
			"values": [7200000, 8000000, 7000000, 6500000, 5000000, 6000000],
			"labels": [
				"Jan", 
				"Feb", 
				"Mar", 
				"Apr", 
				"May",
				"Jun"
			],
			"color": "green"
		},
		"title": "Monthly Sale Chart",
		"noY": true,
		"height": "300px",
		"width": "450px",
		"background": "#FFFFFF",
		"shadowDepth": ".5"
	};
	MaterialCharts.bar("#bar-chart-sale", exampleBarChartData)

	var exampleBarChartData = {
		"datasets": {
			"values": [7200000, 8000000, 7000000, 6500000, 5000000, 6000000],
			"labels": [
				"Jan", 
				"Feb", 
				"Mar", 
				"Apr", 
				"May",
				"Jun"
			],
			"color": "blue"
		},
		"title": "Monthly Purchase Chart",
		"noY": true,
		"height": "300px",
		"width": "450px",
		"background": "#FFFFFF",
		"shadowDepth": ".5"
	};
	MaterialCharts.bar("#bar-chart-purchase", exampleBarChartData)

	var exampleBarChartData = {
		"datasets": {
			"values": [7200000, 8000000, 7000000, 6500000, 5000000, 6000000],
			"labels": [
				"Jan", 
				"Feb", 
				"Mar", 
				"Apr", 
				"May",
				"Jun"
			],
			"color": "red"
		},
		"title": "Monthly Cost Chart",
		"noY": true,
		"height": "300px",
		"width": "450px",
		"background": "#FFFFFF",
		"shadowDepth": ".5"
	};
	MaterialCharts.bar("#bar-chart-cost", exampleBarChartData)



		var examplePieChartData = {
		"dataset": {
			"values": [5, 30, 5, 20, 40],
			"labels": [
				"Apples", 
				"Oranges", 
				"Berries", 
				"Peaches", 
				"Bananas"
			],
		},
		"title": "Most Sale",
		"height": "300px",
		"width": "450px",
		"background": "#FFFFFF",
		"shadowDepth": "1"
	};

	MaterialCharts.pie("#pie-chart-example", examplePieChartData)
});
