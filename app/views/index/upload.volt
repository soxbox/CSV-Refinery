{% if (not(errors is empty)) %}
    <h2>Save Errors</h2>
    <ul>
        {% for error in errors %}
        <li>[[ error ]]</li>
        {% endfor %}
    </ul>
{% else %}

{% endif %}

<p>
    [[  link_to("", "Go Back") ]]
</p>