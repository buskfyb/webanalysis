{* include the headerfile *}
{include file="admin_header.tpl"}


<h1>Brukere</h1>

<table id="libraryTable" class="table table-striped display">
<thead>
        <tr>
            <th>Brukernavn</th>
            <th>Navn</th>
            <th>Epost</th>
            <th>Rolle</th>
            <th></th>
            <th></th>
        </tr>
</thead>
<tbody>
{foreach from=$users item=u}
   <tr>
    <td>{$u.username}</td>
    <td>{$u.name}</td>
    <td>{$u.email}</td>
    <td>{$u.role}</td>
    <td><a href="/adminlibs/index.php?do=editUser&id={$u.id}">Rediger</a></td>
    <td><a href="/adminlibs/index.php?do=deleteUser&id={$u.id}">Slett</a></td>
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
