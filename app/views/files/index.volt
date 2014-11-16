<h1>Files</h1>

<p>
{{  link_to("files/upload", "Upload New File") }}
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
            <td>{{ file.id }}</td>
            <td>{{ link_to("files/view/" ~ file.id, file.name) }}</td>
            <td>{{ file.uploadDate }}</td>
            <td>{{ file.originalColumnCount }}</td>
            <td>{{ file.originalRowCount }}</td>
            <td>{{ link_to("files/export", "Export") }}</td>
        </tr>
    {% endfor %}
</table>