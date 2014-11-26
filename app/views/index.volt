<!DOCTYPE html>
<html ng-app="CsvRefineryApp">
	<head>
		<title>CSV Refinery</title>
        {#<script src="~/bower_components/jquery/dist/jquery.js"></script>
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.css" />
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap-theme.css" />
        <script src="bower_components/bootstrap/dist/js/bootstrap.js"></script>#}

	</head>
	<body>
        [[ content() ]]

        [[ javascript_include("components/angular/angular.js") ]]
        [[ javascript_include("components/angular-resource/angular-resource.js") ]]
        [[ javascript_include("js/custom/angular/app.js") ]]
        [[ javascript_include("js/custom/angular/services/ApiService.js") ]]
        [[ javascript_include("js/custom/angular/controllers/CleanColumnController.js") ]]
	</body>
</html>