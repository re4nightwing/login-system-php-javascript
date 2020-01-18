<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("location: index.php");
    } else if(isset($_COOKIE['username'])) {
        header("location: index.php");
    }
?>
<html>
    <head>
        <title>Login | Hello World</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <header>
            <a class="register" href="register.php">Register</a>
            <h1 id="headding">Hello World 👋 </h1>
        </header>
        <div class="main">
            <h1>LOG-IN</h1>
            <div class="ruler"></div>
            <form action="login.php" method="POST">
                <p>Username : </p>
                <div class="input-group mb-3 mt-3">
                    <input class="form-control" type="text" name="username" id="username">
                </div>
                <p>Password : </p>
                <div class="input-group mb-3 mt-3">
                    <input class="form-control" type="password" name="password" id="password">
                    <div class="input-group-append">
                        <span class="input-group-text" id="bulleye" onclick="bulleye();"><img id="showNoEye" src="img/eye-regular.svg" width="20" height="20"></span>
                    </div>
                </div>
                <button class="log" type="submit" name="submit">Login</button>
            </form> 
            <p id="errors"></p>
            <a class="create" href="register.php">Create a Account</a>   
        </div>
        <footer>
            <p>Hello World #01 2K20</p>
        </footer>
        <?php 
            include 'mysqli_conn.php';
            if ($conn->connect_error) {
                die("Connection Failed :".$conn->connect_error);}

            if(isset($_POST['submit'])){
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = mysqli_real_escape_string($conn, $_POST['password']);

                if($username === "" or $password === ""){
                    ?>
                    <script>
                        $('#errors').html('Please Fill All Fields');
                        $('input[type=text],input[type=password]').addClass("warn");
                        $('form').keyup(function() {
                            $('#errors').fadeOut('slow');
                            setTimeout(() => $('input[type=text],input[type=password]').removeClass("warn"), 300);
                        });
                    </script>
                    <?php
                } else{
                    $query = "SELECT password FROM login where username = '$username'";
                    $result = $conn->query($query);
                    if($result->num_rows > 0){
                        while($row = mysqli_fetch_array($result)){
                            echo $row['password'];
                            $dbhashed_password = $row['password'];
                            if(password_verify($password, $dbhashed_password) == 1){
                                $_SESSION['username'] = $username;
                                setcookie("username",$username, time() + 89400);
                                ?>
                                <script>
                                    $('#errors').css("color", "#4dcc7d");
                                    $('#errors').html("Logged In Successfully");
                                    $('form').keyup(function() {
                                        $('#errors').fadeOut('slow');
                                    });
                                </script>
                                <?php
                                header("location: index.php");
                            } else{
                                ?>
                                <script>
                                    $('#errors').html('Invalid Password.');
                                    $('#username').val("<?= $username ?>");
                                    $('input[type=password]').addClass("warn");
                                    $('form').keyup(function() {
                                        $('#errors').fadeOut('slow');
                                        setTimeout(() => $('input[type=password]').removeClass("warn"), 300);
                                    });
                                </script>
                                <?php
                            }
                        }
                    } else{
                        ?>
                        <script>
                            $('#errors').html('Invalid Username.');
                            $('input[type=text],input[type=password]').addClass("warn");
                            $('form').keyup(function() {
                                $('#errors').fadeOut('slow');
                                setTimeout(() => $('input[type=text],input[type=password]').removeClass("warn"), 300);
                            });
                        </script>
                        <?php
                    }
                }
            }
        ?>
        <script>
            function bulleye(){
                var nope = $('#password').attr('type');
                if(nope == 'password'){
                    $('#password').prop('type','text');
                    $('#showNoEye').attr('src','img/eye-slash-regular.svg')
                } else{
                    $('#password').prop('type','password');
                    $('#showNoEye').attr('src','img/eye-regular.svg')
                }
            }
        </script>
    </body>
</html>