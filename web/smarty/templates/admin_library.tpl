
{* include the headerfile *}
{include file="admin_header.tpl"}

<h1>{$heading}</h1>

<form action="/adminlibs/index.php" method="POST" id="libraryForm">
<input type="hidden" name="do" value="{$doaction}">
<input type="hidden" name="id" value="{$id}">
<table class="table">
    <tr>
        <td>Navn:</td><td><input type="text" id="libraryname" name="libraryname" value="{$libraryname}">  <span class="redMsg" id="libraryname_error"></span></td>
    </tr>
    <tr>
        <td>Piwik id:</td><td><input type="text" id="siteid" name="siteid" value="{$siteid}"> <span class="redMsg" id="siteid_error"></span></td>
    </tr>
    <tr>
        <td>Innbyggertall:</td><td><input type="text" id="population" name="population" value="{$population}">  <span class="redMsg" id="population_error"></span></td>
    </tr>
    <tr>
        <td>URL:</td><td><input type="text" id="URL" name="URL" value="{$URL}">  <span class="redMsg" id="URL_error"></span></td>
    </tr>
    <tr>
        <td></td><td><input type="button" onclick="validateForm()" value="Lagre"> <span class="redMsg">{$savemsg}</span></td>
    </tr>            
</table>
</form>



{* include the footerfile *}
{include file="admin_footer.tpl"}
