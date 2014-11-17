<h1>View File</h1>
<ul>
    <li>Id: {{ file.id }}</li>
    <li>Name: {{ file.name }}</li>
    <li>Uploaded: {{ file.uploadDate }}</li>
    <li>Has Header Row: {{ file.hasHeaderRow ? 'true' : 'false' }}</li>
    <li>Original Row Count: {{ file.originalRowCount }}</li>
    <li>Original Column Count: {{ file.originalColumnCount }}</li>
</ul>
<p>{{ link_to("datacleaning/index/" ~ file.id, "Clean Data") }}</p>

<h2>Rows</h2>
<table>
    <tr>
        <th>Id</th>
        <th>Row Number</th>
        <th>Is Header Row</th>
        <th>Skip in Output</th>
    </tr>
    {% for row in file.rows %}
        <tr>
            <td>{{ row.id }}</td>
            <td>{{ row.rowNumber }}</td>
            <td>{{ row.isHeaderRow ? 'true' : 'false' }}</td>
            <td>{{ row.skipInOutput ? 'true' : 'false' }}</td>
        </tr>
    {% endfor %}
</table>

<h2>Columns</h2>
<table>
    <tr>
        <th>Id</th>
        <th>Column Number</th>
        <th>Original Name</th>
        <th>Name</th>
    </tr>
    {% for column in file.columns %}
        <tr>
            <td>{{ column.id }}</td>
            <td>{{ column.columnNumber }}</td>
            <td>{{ column.originalName }}</td>
            <td>{{ column.name }}</td>
        </tr>
    {% endfor %}
</table>

<h2>Cells</h2>
<table>
    <tr>
        <th>Id</th>
        <th>Column Number</th>
        <th>Row Number</th>
        <th>Original Value</th>
        <th>Value</th>
    </tr>
    {% for cell in file.cells %}
        <tr>
            <td>{{ cell.id }}</td>
            <td>{{ cell.getColumn().columnNumber }}</td>
            <td>{{ cell.getRow().rowNumber }}</td>
            <td>{{ cell.originalValue }}</td>
            <td>{{ cell.value }}</td>
        </tr>
    {% endfor %}
</table>

<p>
    {{  link_to("csvfiles", "All Files") }}
</p>