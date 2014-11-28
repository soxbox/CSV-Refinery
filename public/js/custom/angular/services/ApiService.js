csvRefineryApp.factory('apiService', function ($resource, $q) {
    return {
        filterDefinitions: function () {
            return $resource(urlBase + 'api/filterdefinitions');
        },
        jobs: function () {
            return $resource(urlBase + 'api/filterdefinitions');
        },
        files: function () {
            return $resource(urlBase + 'api/files/:fileId', {fileId: '@id'}, {
                toggleHeaderRow: {url: "api/files/:fileId/toggleHeaderRow", params: {fileId: '@id'}, method:'POST', isArray:false}
            });
        },
        columns: function () {
            return $resource(urlBase + 'api/columns/:columnId', {columnId: '@id'}, {
                applyFilter: {url: "api/files/:fileId/applyFilter", params: {fileId: '@id'}, method:'POST', isArray:false}
            });
        },
        rows: function () {
            return $resource(urlBase + 'api/rows/:rowId', {rowId: '@id'});
        },
        cells: function () {
            return $resource(urlBase + 'api/cells/:cellId', {cellId: '@id'});
        }
    }
});