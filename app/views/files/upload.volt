{% if (not(errors is empty)) %}
    <h2>Save Errors</h2>
    <ul>
        {% for error in errors %}
        <li>{{ error }}</li>
        {% endfor %}
    </ul>
{% else %}
    <h1>Upload File</h1>
    {{ form('files/upload', 'class': 'form-inline', 'method': 'post', 'enctype': 'multipart/form-data') }}
    <span>
        {{ file_field('fileToUpload') }}
        {{ submit_button('Upload') }}
    </span>
    </form>
{% endif %}

<p>
    {{  link_to("files", "Go Back") }}
</p>