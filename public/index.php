<?php

require_once "../private/autoloader.php";




$error = "";

if($_POST){
    $error = "kan niet inloggen met deze gegevens";
    $user_info = userManager::GetUserByName($_POST["username"]);
    if($user_info !== false){
        if(
            password_verify($_POST["password"], $user_info->password)){
                session_start();
                $_SESSION["id"] = $user_info->id;
                $_SESSION["username"] = $user_info->username;

                if($user_info->is_admin == 1){
                    header("location: mainscreen-admin.php");
                    }
                    if($user_info->is_admin == 0){
                        header("location: mainscreen-employee.php");
                    }
            }
}
}
?>

<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/shared.css">
    <title>Login</title>
</head>
<body class="login-wrap">
    <div class="login-panel">
        <h1>Inloggen</h1>
        <form method="post">
            <div class="login-error"><?php echo $error; ?></div>
            <label for="username">Gebruikersnaam</label>
            <input name='username' type='text'>
            <label for="password">Wachtwoord</label>
            <input name='password' type='password'>
            <input type='submit'>
        </form>
    </div>
</body>
</html><?php
