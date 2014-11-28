<div ng-controller="HomeController as hc" ng-init="init()">
    <h1>Files</h1>

    <h2>Upload File</h2>
    [[ form('', 'class': 'form-inline', 'method': 'post', 'enctype': 'multipart/form-data') ]]
    <span>
        [[ file_field('fileToUpload') ]]
        [[ submit_button('Upload') ]]
    </span>
    </form>

    <table>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Upload Date</th>
            <th>Columns</th>
            <th>Rows</th>
            <th></th>
        </tr>
            <tr ng-repeat="file in Files">
                <td>{{ file.id }}</td>
                <td><a href="{{ UrlBase + 'view/' + file.id }}">{{ file.name }}</a></td>
                <td>{{ file.uploadDate  }}</td>
                <td>{{ file.originalColumnCount  }}</td>
                <td>{{ file.originalRowCount }}</td>
                <td>Export</td>
            </tr>
    </table>

    <script type="text/javascript">
        function ConfirmDelete()
        {
            return confirm("Are you sure you want to delete?");
        }
    </script>
</div>
[[ javascript_include("js/custom/angular/controllers/HomeController.js") ]]