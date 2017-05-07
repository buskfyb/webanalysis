<?php

// get everything initialized like db and smarty 28-05-2016 PMB
require_once('../../config/config.php');
require_once('libs/functions.php');

// get session 16-06-2016 PMB
session_start();


// check for login! 16-06-2016 PMB
if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit();
}

// initialise the do variable, to show front page as default 28-05-2016 PMB
$do = "showFront";

if (isset($_REQUEST['do'])) {
    $do = $_REQUEST['do'];
}


// assigning the session to smarty 16-06-2016 PMB
$smarty->assign('adminrole', $_SESSION['role']);
$smarty->assign('loggedinID', $_SESSION['id']);
$smarty->assign('loggedinUsername', $_SESSION['username']);

// global var to show if we are in dev mode or not PMB 2017-05-05
$smarty->assign('development', $development);


// switching for all legal actions 28-05-2016 PMB
switch ($do) {
    case 'showFront':
        showFront();
        break;    
    case 'logOut':
        logOut();
        break;    
    case 'reallyChangePassword':
        $id = $_POST['id'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        reallyChangePassword($id, $password);
        break;
    case 'changePassword':
        $id = $_GET['id'];
        $username = $_GET['username'];
        changePassword($id, $username);
        break;
    case 'editLibrary':
        $id = 0;
        if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {$id = $_REQUEST['id'];}
        editLibrary($id);
        break;
    case 'dbInsertLibrary':
        $libraryname = $_POST['libraryname'];
        $siteid = $_POST['siteid'];
        $population = $_POST['population'];
        $URL = $_POST['URL'];
        dbInsertLibrary($libraryname, $siteid, $population, $URL);
        break;
    case 'dbUpdateLibrary':
        $libraryname = $_POST['libraryname'];
        $siteid = $_POST['siteid'];
        $population = $_POST['population'];
        $URL = $_POST['URL'];
        $id = $_POST['id'];
        dbUpdateLibrary($libraryname, $siteid, $population, $URL, $id);
        break;
    case 'deleteLibrary':
        $id = $_REQUEST['id'];
        deleteLibrary($id);
        break;
    case 'reallyDeleteLibrary':
        $id = $_REQUEST['id'];
        reallyDeleteLibrary($id);
        break;
    case 'showUsers':
        showUsers();
        break;    
    case 'editUser':
        $id = 0;
        if (isset($_REQUEST['id']) && !empty($_REQUEST['id'])) {$id = $_REQUEST['id'];}
        editUser($id);
        break;
    case 'dbInsertUser':
        $username = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        dbInsertUser($username, $name, $email, $role, $password);
        break;
    case 'dbUpdateUser':
        $username = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $id = $_POST['id'];
        dbUpdateUser($username, $name, $email, $role, $id);
        break;
    case 'deleteUser':
        $id = $_REQUEST['id'];
        deleteUser($id);
        break;
    case 'reallyDeleteUser':
        $id = $_REQUEST['id'];
        reallyDeleteUser($id);
        break;
    default:
        break;
}



?>