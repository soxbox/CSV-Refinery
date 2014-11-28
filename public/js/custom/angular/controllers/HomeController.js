csvRefineryControllers.controller('HomeController', ['$scope', '$http', 'apiService',
    function ($scope, $http, apiService) {

        $scope.UrlBase = urlBase;
        $scope.Error = null;
        $scope.ErrorHandler = function (response) {
            // TODO: we need some general handling of errors

            // response.config
            // response.data
            // response.headers
            // response.status
            $scope.Error = response;
        };

        $scope.Files = null;

        //#region controller initialization logic
        $scope.init = function () {

            apiService.files().query()
                .$promise.then(
                function (result, status) {
                    // get requests just return the data
                    $scope.Files = result;
                },
                $scope.ErrorHandler);
        };
        //#endregion controller initialization logic
    }]);