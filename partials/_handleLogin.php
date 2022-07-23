<?php
$showError = "false";
if($_SERVER['REQUEST_METHOD']=="POST")
{
    include '_dbconnect.php';
    $email = $_POST['loginemail'];
    $name = $_POST['loginname'];
    $pass = $_POST['loginpassword'];
    $sql = "select * from `users` where user_name='$name'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1)
    {
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass, $row['user_pass']))
        {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['srno'] = $row['srno'];
            $_SESSION['user_email'] = $email;
            $_SESSION['user_name'] = $name;

        }
         header("Location:/forum_site/index.php");        
        
    }
    header("Location:/forum_site/index.php");        
}
?>