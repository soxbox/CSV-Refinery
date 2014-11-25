<div ng-controller="CleanColumnCtrl" ng-init="init()">
    {% if (not(columnToClean.previousColumnId is empty)) %}
        {{ link_to("datacleaning/column/" ~ columnToClean.previousColumnId, "Previous") }}
    {% endif %}
    <h1>Column # {{ columnToClean.column.columnNumber }} - "<span>{{ not(columnToClean.column.name is empty) ? columnToClean.column.name : columnToClean.column.originalName }}</span>"</h1>
    {% if (not(columnToClean.nextColumnId is empty)) %}
        {{ link_to("datacleaning/column/" ~ columnToClean.nextColumnId, "Next") }}
    {% endif %}


    {{ form('datacleaning/applyfilter/' ~ columnToClean.column.id, 'method': 'post') }}
        <p>
            <label>Filter:</label>
            <select id="filterId" name="filterId">
                <option value=""{{ (columnToClean.column.filterId is empty) ? ' selected' : '' }}>Select a Filter</option>
                {% for thefilter in filters %}
                    <option value="{{ thefilter.id }}"{{ (columnToClean.column.filterId is empty) ? '' : (columnToClean.column.filterId == thefilter.id ? ' selected' : '') }}>{{ thefilter.name }}</option>
                {% endfor %}
            </select>
            <label>Validator:</label> Phone Number Validator
        </p>

        {{ submit_button('Apply Filter') }}

        <table>
            <tr>
                <th>Row Number</th>
                <th>Original Data</th>
                <th></th>
                <th>Cleaned Data</th>
            </tr>
            {% for cell in columnToClean.column.cells %}
                <tr>
                    <td>{{ cell.getRow().rowNumber }}</td>
                    <td>{{ cell.originalValue }}</td>
                    <td></td>
                    <td>{{ cell.value }}</td>
                </tr>
            {% endfor %}
        </table>
    </form>
</div>