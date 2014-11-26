<h1>Files</h1>

<p>
[[  link_to("csvfiles/upload", "Upload New File") ]]
</p>

<table>
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Upload Date</th>
        <th>Columns</th>
        <th>Rows</th>
        <th></th>
    </tr>
    {% for file in files %}
        <tr>
            <td>[[ file.id ]]</td>
            <td>[[ link_to("csvfiles/view/" ~ file.id, file.name) ]]</td>
            <td>[[ file.uploadDate ]]</td>
            <td>[[ file.originalColumnCount ]]</td>
            <td>[[ file.originalRowCount ]]</td>
            <td>[[ link_to("csvfiles/export", "Export") ]]</td>
            <td>
                [[ form('csvfiles/delete/' ~ file.id, 'method': 'post') ]]
                [[ submit_button('Delete', "onclick":"return ConfirmDelete()") ]]
                </form>
            </td>
        </tr>
    {% endfor %}
</table>

<script type="text/javascript">
    function ConfirmDelete()
    {
        return confirm("Are you sure you want to delete?");
    }
</script>