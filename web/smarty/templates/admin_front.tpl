{* include the headerfile *}
{include file="admin_header.tpl"}


<h1>Biblioteksoversikt</h1>

<table id="libraryTable" class="table table-striped display">
<thead>
        <tr>
            <th>Navn</th>
            <th>Piwik id</th>
            <th>Befolkning</th>
            <th>URL</th>
            <th></th>
            <th></th>
        </tr>
</thead>
<tbody>
{foreach from=$libraries item=l}
   <tr>
    <td>{$l.libraryname}</td>
    <td>{$l.siteid}</td>
    <td>{$l.population}</td>
    <td>{$l.URL}</td>
    <td><a href="/adminlibs/index.php?do=editLibrary&id={$l.id}">Rediger</a></td>
    <td><a href="/adminlibs/index.php?do=deleteLibrary&id={$l.id}">Slett</a></td>
   </tr>
{/foreach}
</tbody>
</table>

{literal}
<script>
$(document).ready( function () {
    $('#libraryTable').DataTable();
} );
$('#libraryTable').DataTable( {
    paging: false,
    "info": false,
    "columns": [
        null,
        null,
        null,
        null,
        { "orderable": false },
        { "orderable": false }
      ],
    "language": {
        "search": "Søk"
    }      
} );

</script>
{/literal}

{* include the footerfile *}
{include file="admin_footer.tpl"}
