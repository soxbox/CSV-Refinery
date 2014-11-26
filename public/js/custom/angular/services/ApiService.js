csvRefineryApp.factory('apiService', function ($resource, $q) {
    var apiResource = $resource('/csvrefinery/api/filtersList', {}, {
        'filtersList': { method: 'GET', isArray: true }
    });
    return {
        FiltersList: function () {
            return apiResource.filtersList();
        }
    }
})