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
                function (result, status) {
                    if (result.redirect) {
                        window.location.href = result.redirect;
                    }
                    else if (result.data != null && result.data != '' && JSON.stringify(result.data) != '[]') {
                        $scope.Filters = result.data;
                    } else {
                        $scope.Filters = [];
                    }
                },
                $scope.ErrorHandler);
        };
        //#endregion controller initialization logic
    }]);