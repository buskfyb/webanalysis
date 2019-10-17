<?php

// File that contains all actions in the admin area
// 28-05-2016 PMB


// shows front page of admin area 28-05-2016 PMB
function showFront() {
    // smarty is global object 28-05-2016 PMB
    global $smarty;
    global $dblink;
    
    // first we need to get all libraries 28-05-2016 PMB
    if (!$result = mysqli_query($dblink, "SELECT l.id, l.libraryname, l.siteid, l.population, 
        l.category, l.URL, c.name as categoryname, l.import_msg, external_ref 
        FROM libraries l 
        left join categories c on l.category = c.id
        order by l.libraryname ASC"
        )) {
        echo mysqli_error($dblink);
        exit();
    }

    $smarty->assign('libraries', mysqli_fetch_all($result, MYSQLI_ASSOC));

    $smarty->display('admin_front.tpl');  
}



function changePassword($id, $username) {
    global $smarty;

    // do some checking here that the user is allowed PMB 16-06-2016
    if ($_SESSION['role'] == 'superadmin' || $_SESSION['id'] == $id) {
        $smarty->assign('id', $id);
        $smarty->assign('username', $username);
        $smarty->display('admin_changePassword.tpl');    
    }
    else {echo "illegal action"; exit();} // user is not authorized
}


function reallyChangePassword($id, $password) {
    // global objects 28-05-2016 PMB
    global $smarty;
    global $dblink;

    if (!$stmt = mysqli_prepare($dblink, "UPDATE users SET password=? WHERE id = ?")) {
        echo mysqli_error($dblink);
        exit();
    }
    if (!mysqli_stmt_bind_param($stmt, "sd", $password, $id)) {echo mysqli_error($dblink);exit();};
    if (!mysqli_stmt_execute($stmt))  {echo mysqli_error($dblink);exit();};        


    showFront();

}



// shows all users 15-06-2016 PMB
function showUsers() {
    // smarty is global object 28-05-2016 PMB
    global $smarty;
    global $dblink;
    
    // first we need to get all users 15-06-2016 PMB
    if (!$result = mysqli_query($dblink, "SELECT id, username, email, role, name  FROM users")) {
        echo mysqli_error($dblink);
        exit();
    }

    $smarty->assign('users', mysqli_fetch_all($result, MYSQLI_ASSOC));
    $smarty->display('admin_users.tpl');  
}

function editUser($userid = 0, $savemsg = '')  {
    // smarty is global object 28-05-2016 PMB
    global $smarty;
    global $dblink;

    // init of variables in the templates 28-05-2016 PMB
    $smarty->assign('id', '');
    $smarty->assign('username', '');
    $smarty->assign('name', '');
    $smarty->assign('email', '');
    $smarty->assign('role', '');
    $smarty->assign('password', '');

    $smarty->assign('heading', 'Ny bruker');
    $smarty->assign('savemsg', $savemsg);
    $smarty->assign('doaction', 'dbInsertUser');

    // if userid is not 0, then we are editing a user 28-05-2016 PMB
    if ($userid != 0) {
        // get data for the user 28-05-2016 PMB
        if (!$stmt = mysqli_prepare($dblink, "SELECT id, username, name, role, email, password FROM users WHERE id = ?")) {
            echo mysqli_error($dblink);
            exit();
        }    

        if (!mysqli_stmt_bind_param($stmt, "d", $userid)) {echo mysqli_error($dblink);exit();}
        if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
        if (!mysqli_stmt_bind_result($stmt, $id, $username, $name, $role, $email, $password)) {echo mysqli_error($dblink);exit();} 
        if (!mysqli_stmt_fetch($stmt)) {echo mysqli_error($dblink);exit();};

        // assign info about user to the smarty object. 28-05-2016 PMB
        $smarty->assign('id', $userid);
        $smarty->assign('username', $username);
        $smarty->assign('name', $name);
        $smarty->assign('role', $role);
        $smarty->assign('email', $email);
        $smarty->assign('password', $password);

        $smarty->assign('heading', 'Rediger bruker');
        $smarty->assign('doaction', 'dbUpdateUser');
    }
    
    $smarty->display('admin_user.tpl');
}


function dbInsertUser($username, $name, $email, $role, $password) {
    // smarty is global object 28-05-2016 PMB
    global $smarty;
    global $dblink;


    if (!$stmt = mysqli_prepare($dblink, "INSERT INTO users (username, name, email, role, password) VALUES (?,?,?,?,?)")) {
        echo mysqli_error($dblink);
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $username, $name, $email, $role, $password);
    mysqli_stmt_execute($stmt);        

    $lastid = mysqli_insert_id($dblink);


    editUser($lastid, 'Lagret');    
}


function dbUpdateUser($username, $name, $email, $role, $id) {
    // global objects 28-05-2016 PMB
    global $smarty;
    global $dblink;

    if (!$stmt = mysqli_prepare($dblink, "UPDATE users SET username=?, name=?, email=?, role=? WHERE id = ?")) {
        echo mysqli_error($dblink);
        exit();
    }
    if (!mysqli_stmt_bind_param($stmt, "ssssd", $username, $name, $email, $role, $id)) {echo mysqli_error($dblink);exit();};
    if (!mysqli_stmt_execute($stmt))  {echo mysqli_error($dblink);exit();};        

    
    // message to inform about success 28-05-2016 PMB
    editUser($id, 'Lagret');

}


function deleteUser($id) {
    // global objects 28-05-2016 PMB
    global $smarty;
    global $dblink;
    
    if (!$stmt = mysqli_prepare($dblink, "SELECT id, username, name, email, role FROM users WHERE id = ?")) {
        echo mysqli_error($dblink);
        exit();
    }    

    if (!mysqli_stmt_bind_param($stmt, "d", $id)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
    if (!mysqli_stmt_bind_result($stmt, $id, $username, $name, $email, $role)) {echo mysqli_error($dblink);exit();} 

    mysqli_stmt_fetch($stmt);

    $smarty->assign('id', $id);
    $smarty->assign('username', $username);
    $smarty->assign('name', $name);
    $smarty->assign('email', $email);
    $smarty->assign('role', $role);
    
    $smarty->display('admin_deleteconfirmUser.tpl');
}


function reallyDeleteUser($id) {
    global $dblink;

    if (!$stmt = mysqli_prepare($dblink, "DELETE FROM users WHERE id = ?")) {
        echo mysqli_error($dblink);
        exit();
    }    

    if (!mysqli_stmt_bind_param($stmt, "d", $id)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();} 

    // function that shows the front page 28-05-2016 PMB
    showUsers();    
}


function getCategories() {
    // smarty is global object 28-05-2016 PMB
    global $smarty;
    global $dblink;
    
    // get all categories and return them as an array PMB 2017-05-07
    if (!$result = mysqli_query($dblink, "SELECT id, name FROM categories")) {
        echo mysqli_error($dblink);
        exit();
    }

    $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $categories;
}


function editLibrary($libid = 0, $savemsg = '')  {
    // smarty is global object 28-05-2016 PMB
    global $smarty;
    global $dblink;

     // init of variables in the templates 28-05-2016 PMB
    $smarty->assign('id', '');
    $smarty->assign('libraryname', '');
    $smarty->assign('siteid', '');
    $smarty->assign('population', '');
    $smarty->assign('URL', '');
    $smarty->assign('category', '');
    $smarty->assign('categories', getCategories());
    $smarty->assign('external_ref', '');
    $smarty->assign('heading', 'Nytt bibliotek');
    $smarty->assign('savemsg', $savemsg);
    $smarty->assign('doaction', 'dbInsertLibrary');

    // if libid is not 0, then we are editing a library 28-05-2016 PMB
    if ($libid != 0) {
        // get data for the library 28-05-2016 PMB
        if (!$stmt = mysqli_prepare($dblink, "SELECT id, libraryname, siteid, population, URL, category, external_ref FROM libraries WHERE id = ?")) {
            echo mysqli_error($dblink);
            exit();
        }    

        if (!mysqli_stmt_bind_param($stmt, "d", $libid)) {echo mysqli_error($dblink);exit();}
        if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
        if (!mysqli_stmt_bind_result($stmt, $id, $libraryname, $siteid, $population, $URL, $category, $external_ref)) {echo mysqli_error($dblink);exit();} 
        if (!mysqli_stmt_fetch($stmt)) {echo mysqli_error($dblink);exit();};

        // assign info about library to the smarty object. 28-05-2016 PMB
        $smarty->assign('id', $libid);
        $smarty->assign('libraryname', $libraryname);
        $smarty->assign('siteid', $siteid);
        $smarty->assign('population', $population);
        $smarty->assign('URL', $URL);
        $smarty->assign('category', $category);
        $smarty->assign('external_ref', $external_ref);
        $smarty->assign('heading', 'Rediger bibliotek');
        $smarty->assign('doaction', 'dbUpdateLibrary');
    }
    
    $smarty->display('admin_library.tpl');
}

// function that updates the total libraries population when a library is inserted or updated
function updateTotalLibrary() {
    global $dblink;
    global $total_id;

    // get total population excluding the total library 03-06-2016 PMB
    $result = mysqli_query($dblink, "SELECT SUM(population) as totalpopulation FROM libraries where siteid != '" . $total_id . "'");
    $population = mysqli_fetch_array($result);

    mysqli_query($dblink, "UPDATE libraries SET population = " . $population[0] . " WHERE siteid = '" . $total_id . "'");
}

function dbInsertLibrary($libraryname, $siteid, $population, $URL, $category, $external_ref) {
    // smarty is global object 28-05-2016 PMB
    global $smarty;
    global $dblink;

    if (!$stmt = mysqli_prepare($dblink, "INSERT INTO libraries (libraryname, siteid, population, URL, category, external_ref) VALUES (?,?,?,?,?,?)")) {
        echo mysqli_error($dblink);
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssdsds", $libraryname, $siteid, $population, $URL, $category, $external_ref);
    mysqli_stmt_execute($stmt);

    $lastid = mysqli_insert_id($dblink);

    // update population for the library with total traffic 03-06-2016 PMB
    updateTotalLibrary();

    editLibrary($lastid, 'Lagret');    
}

function dbUpdateLibrary($libraryname, $siteid, $population, $URL, $category, $external_ref, $id) {
    // global objects 28-05-2016 PMB
    global $smarty;
    global $dblink;

    if (!$stmt = mysqli_prepare($dblink, "UPDATE libraries SET libraryname=?, siteid=?, population=?, URL=?, category=?, external_ref=? WHERE id = ?")) {
        echo mysqli_error($dblink);
        exit();
    }
    if (!mysqli_stmt_bind_param($stmt, "ssdsdsd", $libraryname, $siteid, $population, $URL, $category, $external_ref, $id)) {echo mysqli_error($dblink);exit();};
    if (!mysqli_stmt_execute($stmt))  {echo mysqli_error($dblink);exit();};        

    // update population for the library with total traffic 03-06-2016 PMB
    updateTotalLibrary();
    
    // message to inform about success 28-05-2016 PMB
    editLibrary($id, 'Lagret');

}

function deleteLibrary($id) {
    // global objects 28-05-2016 PMB
    global $smarty;
    global $dblink;

    if (!$stmt = mysqli_prepare($dblink, "SELECT id, libraryname, siteid, population FROM libraries WHERE id = ?")) {
        echo mysqli_error($dblink);
        exit();
    }    

    if (!mysqli_stmt_bind_param($stmt, "d", $id)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
    if (!mysqli_stmt_bind_result($stmt, $id, $libraryname, $siteid, $population)) {echo mysqli_error($dblink);exit();} 

    mysqli_stmt_fetch($stmt);

    $smarty->assign('id', $id);
    $smarty->assign('libraryname', $libraryname);
    $smarty->assign('siteid', $siteid);
    $smarty->assign('population', $population);
    
    $smarty->display('admin_deleteconfirm.tpl');
}


function reallyDeleteLibrary($id) {
    global $dblink;

    if (!$stmt = mysqli_prepare($dblink, "DELETE FROM libraries WHERE id = ?")) {
        echo mysqli_error($dblink);
        exit();
    }    

    if (!mysqli_stmt_bind_param($stmt, "d", $id)) {echo mysqli_error($dblink);exit();}
    if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();} 

    // update population for the library with total traffic 03-06-2016 PMB
    updateTotalLibrary();
     
    // function that shows the front page 28-05-2016 PMB
    showFront();    
}

function logOut() {
    session_destroy();
    header("Location: /");
    exit();
}


?>