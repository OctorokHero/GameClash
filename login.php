<?php

    session_name("login");
    session_start();

    require_once ("DB.class.php");
    
    $db = new DB();

    if(isset($_SESSION['message'])){
        echo($_SESSION['message']);
        unset($_SESSION['message']);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = mysqli_real_escape_string($db->getConn(),$_POST['name']);
        $password = mysqli_real_escape_string($db->getConn(),$_POST['password']);
        /*
        $options = [
            'cost' => 11,
        ];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);
        */
        $role = 0;

        $userData = $db->getAttendee($name, $password);
        //echo '<script>console.log($userData); </script>';
        //echo var_dump($userData == null)
        if($userData != 0){
            $role = $userData['role'];
            //echo '<script>console.log($role); </script>';
            switch($role){
                //Admin login
                case 1:
                    $_SESSION['user'] = $name;
                    $_SESSION['role'] = $role;
                    //echo var_dump($_SESSION['role']);
                    header("Location: admin_home.php");
                    break;
                //Event Manager login
                case 2:
                    $_SESSION['id'] = $userData['idattendee'];
                    $_SESSION['user'] = $name;
                    $_SESSION['role'] = $role;
                    header("Location: event_manager_home.php");
                    break;
                //Attendee login
                case 3:
                    $_SESSION['id'] = $userData['idattendee'];
                    $_SESSION['user'] = $name;
                    $_SESSION['role'] = $role;
                    header("Location: attendee_home.php");
                    break;
            }
        } else {
            $_SESSION["message"] = "Incorrect login.";
            header("Location: login.php");
        }
    }

?>
<html>
    <body>
        <form action="" method="POST">
            Username: <input type="text" name="name"><br />
            Password: <input type="text" name="password"><br />
            <input type="submit" value="Login">
        </form>
    </body>
</html>