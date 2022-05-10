<% if $Datalist %>
<datalist id="{$DatalistID.XML}">
    <% loop $Datalist %>
    <option value="{$Value.XML}"<% if $Label %> label="{$Label.XML}"<% end_if %>>
    <% end_loop %>
</datalist>
<% end_if %>
