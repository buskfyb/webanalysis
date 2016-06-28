{* include the headerfile *}
{include file="admin_header.tpl"}

<h1>Endre passord</h1>

<form action="/adminlibs/index.php" method="POST" id="userForm">
<input type="hidden" name="do" value="reallyChangePassword">
<input type="hidden" name="id" value="{$id}">
<table class="table">
    <tr>
        <td>Brukernavn:</td><td>{$username}</td>
    </tr>
    <tr>
        <td>Nytt passord:</td><td><input type="password" id="password" name="password" value="">  <span class="redMsg" id="password_error"></span></td>
    </tr>
    <tr>
        <td></td><td><input type="button" onclick="validatePasswordForm()" value="Lagre"></td>
    </tr>            
</table>
</form>



{* include the footerfile *}
{include file="admin_footer.tpl"}
