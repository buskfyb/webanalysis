
{* include the headerfile *}
{include file="admin_header.tpl"}

<h1>{$heading}</h1>

<form action="/adminlibs/index.php" method="POST" id="userForm">
<input type="hidden" name="do" value="{$doaction}">
<input type="hidden" name="id" value="{$id}">
<table class="table">
    <tr>
        <td>Brukernavn:</td><td><input type="text" id="username" name="username" value="{$username}">  <span class="redMsg" id="username_error"></span></td>
    </tr>
    <tr>
        <td>Navn:</td><td><input type="text" id="name" name="name" value="{$name}"> <span class="redMsg" id="name_error"></span></td>
    </tr>
    <tr>
        <td>Epost:</td><td><input type="text" id="email" name="email" value="{$email}">  <span class="redMsg" id="email_error"></span></td>
    </tr>
    <tr>
        <td>Rolle:</td><td>
        <select name="role">
            <option value="admin">admin</option>
            <option value="superadmin" {if $role == 'superadmin'}SELECTED{/if}>superadmin</option>
        </select>
        </td>
    </tr>
    <tr>
        <td>Passord:</td><td>{if $doaction == 'dbUpdateUser'}<a href="?do=changePassword&id={$id}&username={$username}">Endre passord</a>{else}<input type="password" id="password" name="password" value="{$password}">  <span class="redMsg" id="password_error"></span>{/if}</td>
    </tr>
    <tr>
        <td></td><td><input type="button" onclick="validateUserForm({if $doaction == 'dbUpdateUser'}false{else}true{/if})" value="Lagre"> <span class="redMsg">{$savemsg}</span></td>
    </tr>            
</table>
</form>



{* include the footerfile *}
{include file="admin_footer.tpl"}
