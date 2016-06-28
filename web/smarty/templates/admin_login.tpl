<html>
<head>

 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    {* loading jquerty *}
    <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>

    {* loading bootstrap *}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    {* loading datatables *}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.11/css/dataTables.bootstrap.min.css">
    <script src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>

    {* loading stylesheet for backend application *}
    <link rel="stylesheet" href="/adminlibs/styles_backend.css">

</head>

<body>
 
<div class="container content">

<h1>Logg inn</h1>    

<table>
<form id="loginform" action="login.php" method="POST">
<input type="hidden" name="do" value="login">
<tr><td>Brukernavn:</td><td><input type="text" name="username"></td></tr>
<tr><td>Passord:</td><td><input type="password" name="password"></td></tr>
<tr><td></td><td><input type="submit" value="Logg inn"></td></tr>
</form>
</table>

<br><br>
<p><span class="redMsg">{$msg}</span></p>
<br>


<h2>Glemt passord?</h2>
<table>
<form id="forgotform" action="login.php" method="POST">
<input type="hidden" name="do" value="forgot">
<tr><td>Brukernavn:</td><td><input type="text" name="username"></td></tr>
<tr><td></td><td><input type="submit" value="Resett passord"></td></tr>
</form>


{* include the footerfile *}
{include file="admin_footer.tpl"}
