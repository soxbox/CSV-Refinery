csvRefineryControllers.controller('CleanColumnController', ['$scope', '$http', 'apiService',
    function ($scope, $http, apiService) {

        $scope.Error = null;
        $scope.ErrorHandler = function (response) {
            // TODO: we need some general handling of errors

            // response.config
            // response.data
            // response.headers
            // response.status
            $scope.Error = response;
        };

        $scope.Filters = null;
        $scope.Filter = null;

        //#region controller initialization logic
        $scope.init = function () {

            apiService.FiltersList()
                .$promise.then(
                function (data, status) {
                    if (data != null && data != '' && JSON.stringify(data) != '[]') {
                        $scope.Filters = data;
                    } else {
                        $scope.Filters = [];
                    }
                },
                $scope.ErrorHandler);
        };
        //#endregion controller initialization logic
    }]);