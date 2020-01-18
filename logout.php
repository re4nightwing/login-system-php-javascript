<?php
    session_start();
    session_destroy();
    setcookie("username",$username, time() - 89400);
    header("location: login.php");
