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

    {* loading local javascript*}
    <script src="/adminlibs/bfk.js"></script>

</head>

<body>
    {* outer container *}    
    <div class="container header">

<p>
{if $adminrole == 'admin' || $adminrole == 'superadmin'}
<a class="btn btn-default" href="/adminlibs/">Biblioteksoversikt</a>
<a class="btn btn-default" href="index.php?do=editLibrary">Nytt bibliotek</a>
{/if}
{if $adminrole == 'superadmin'}
<a class="btn btn-default" href="/adminlibs/index.php?do=showUsers">Vis brukere</a> 
<a class="btn btn-default" href="index.php?do=editUser">Ny bruker</a>
{/if}
<a class="btn btn-default" href="index.php?do=changePassword&id={$loggedinID}&username={$loggedinUsername}">Endre passord</a>
<a class="btn btn-default" href="index.php?do=logOut">Logg ut</a>
</p>


    </div>
    <div class="container content">
    



