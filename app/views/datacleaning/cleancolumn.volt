{% if (not(previousColumnId is empty)) %}
    {{ link_to("datacleaning/cleancolumn/" ~ previousColumnId, "Previous") }}
{% endif %}
<h1>Column # {{ column.columnNumber }} - <span>{{ column.name }}</span></h1>
{% if (not(nextColumnId is empty)) %}
    {{ link_to("datacleaning/cleancolumn/" ~ nextColumnId, "Next") }}
{% endif %}
<p>
    <label>Filter:</label>
    <select>
        <option>Phone Number</option>
    </select>
    <label>Validator:</label> Phone Number Validator
</p>

<table>
    <tr>
        <th>Row Number</th>
        <th>Original Data</th>
        <th></th>
        <th>Cleaned Data</th>
    </tr>
    {% for cell in column.cells %}
        <tr>
            <td>{{ cell.getRow().rowNumber }}</td>
            <td>{{ cell.originalValue }}</td>
            <td></td>
            <td>{{ cell.value }}</td>
        </tr>
    {% endfor %}
</table>

