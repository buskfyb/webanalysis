<?php

// get everything initialized like db and smarty 28-05-2016 PMB
require_once('../../config/config.php');
require_once('libs/functions.php');

// first we initialize a little 16-06-2016 PMB
$smarty->assign('msg','');

// if we have a password in the request, we will check 16-06-2016 PMB
if (isset($_REQUEST['username'])) {
    
    if ($_REQUEST['do'] == 'login') {  // We are doing login PMB 16-06-2016

        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
    
        // first we get the hashed password from the db, using the username as key
        if (!$stmt = mysqli_prepare($dblink, "SELECT id, password, role FROM users WHERE username = ?")) {
            echo mysqli_error($dblink);
            exit();
        }    

        if (!mysqli_stmt_bind_param($stmt, "s", $username)) {echo mysqli_error($dblink);exit();}
        if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
        if (!mysqli_stmt_bind_result($stmt, $id, $dbpassword, $dbrole)) {echo mysqli_error($dblink);exit();} 

        mysqli_stmt_fetch($stmt);

        if (password_verify($password, $dbpassword)) { // password correct
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['role'] = $dbrole;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            
            session_regenerate_id(true);
             
            // redirect to index.php after setting credentials
            header("Location: index.php");
            exit();

        }
        else {      // password incorrect
            $smarty->assign('msg', 'Brukernavn og passord stemmer dessverre ikke.');                
        }

        
    }
    else {   // We are not doing login, therefore it is a password reset

            $username = $_REQUEST['username'];
            // first we find the user in the DB
            if (!$stmt = mysqli_prepare($dblink, "SELECT id, email FROM users WHERE username = ?")) {echo mysqli_error($dblink);exit();           }    
            if (!mysqli_stmt_bind_param($stmt, "s", $username)) {echo mysqli_error($dblink);exit();}
            if (!mysqli_stmt_execute($stmt)) {echo mysqli_error($dblink);exit();}        
            if (!mysqli_stmt_bind_result($stmt, $id, $email)) {echo mysqli_error($dblink);exit();} 
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);

            if (!empty($email)) {
                // creating a semi random password PMB 16-06-2016
                $pw = chr(mt_rand(97,122)).mt_rand(0,9).chr(mt_rand(97,122)).mt_rand(10,99).chr(mt_rand(97,122)).mt_rand(100,999);       

                // update the password in the db
                $hashedpw = password_hash($pw, PASSWORD_DEFAULT);
                if (!mysqli_query($dblink, "UPDATE users SET password = '" . $hashedpw . "' WHERE id = " . $id)) {echo mysqli_error($dblink);exit();}

                mail($email, 'Nytt passord', $pw);            
                $smarty->assign('msg', 'Passordet er nå sendt på epost til den registrerte adressen.');
            }
            else { // no user with this username ... hackers probing? PMB 16-06-2016
                
            }
    }

}

$smarty->display('admin_login.tpl');



?>