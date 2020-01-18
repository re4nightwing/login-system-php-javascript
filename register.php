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
        <title>Register | Hello World</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </head>
    <body>
        <header>
            <a class="register" href="login.php">Login</a>
            <h1 id="headding">Hello World 👋 </h1>
        </header>
        <div class="main">
            <h1>Register</h1>
            <div class="ruler"></div>
            <form action="register.php" method="POST">
                <p>Username : </p>
                <div class="input-group mb-3 mt-3">
                    <input class="form-control" type="text" name="username" id="username">
                </div>
                <p>E-mail : </p>
                <div class="input-group mb-3 mt-3">
                    <input class="form-control" type="text" name="email" id="email">
                </div>
                <p>Password : </p>
                <div class="input-group mb-3 mt-3">
                    <input class="form-control" type="password" name="password" id="password">
                    <div class="input-group-append">
                        <span class="input-group-text" id="bulleye" onclick="bulleye(document.getElementById('password').name);"><img id="showNoEye" src="img/eye-regular.svg" width="20" height="20"></span>
                    </div>
                </div>
                <p>Confirm Password : </p>
                <div class="input-group mb-3 mt-3">
                    <input class="form-control" type="password" name="cpassword" id="cpassword">
                    <div class="input-group-append">
                        <span class="input-group-text" id="bulleye" onclick="bulleye(document.getElementById('cpassword').name);"><img id="cshowNoEye" src="img/eye-regular.svg" width="20" height="20"></span>
                    </div>
                </div>
                <button class="log" type="submit" name="submit" >Register</button>
            </form>
            <p id="errors"></p> 
        </div>
        <footer>
            <p>Hello World #01 2K20</p>
        </footer>
        <?php 
            include 'mysqli_conn.php';
            if ($conn->connect_error) {
                die("Connection Failed :".$conn->connect_error);}

            if(isset($_POST['submit'])){
                $username = mysqli_real_escape_string($conn,$_POST['username']);
                $email = mysqli_real_escape_string($conn,$_POST['email']);
                $password = mysqli_real_escape_string($conn,$_POST['password']);
                $cpassword = mysqli_real_escape_string($conn,$_POST['cpassword']);
                

                if($username === "" or $email === "" or $password === "" or $cpassword === ""){
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
                } else if($password != $cpassword){
                    ?>
                    <script>
                        $('#errors').html("Passwords doesn't Match.");
                        $('#username').val("<?= $username ?>");
                        $('#email').val("<?= $email ?>");
                        $('#password').val("<?= $password ?>");
                        $('#cpassword').val("<?= $cpassword ?>");
                        $('input[type=text],input[type=password]').addClass("warn")
                        $('form').keyup(function() {
                            $('#errors').fadeOut('slow');
                            setTimeout(() => $('input[type=text],input[type=password]').removeClass("warn"), 500);
                        });
                    </script>
                    <?php
                } else {
                    $check_bit = 1;
                    $query = "SELECT username, email FROM login";

                    $result = $conn->query($query);
                    if($result->num_rows > 0){
                        while($row = mysqli_fetch_array($result)){
                            if($username === $row['username']){
                                $check_bit = 0;
                                ?>
                                <script>
                                    $('#errors').html("Username Already in Use.");
                                    $('#username').css("border", "solid 2px #fc121b");
                                    $('#username').keyup(function() {
                                        $('#errors').fadeOut('slow');
                                    });
                                </script>
                                <?php
                            }
                            if($email === $row['email']){
                                $check_bit = 0;
                                ?>
                                <script>
                                    $('#errors').html("E-mail Already in Use.");
                                    $('#password').css("border", "solid 2px #fc121b");
                                    $('#password').keyup(function() {
                                        $('#errors').fadeOut('slow');
                                    });
                                </script>
                                <?php
                            }
                        }
                    }
                    if($check_bit === 1){
                        $password_hash = password_hash($password, PASSWORD_DEFAULT);
                        $query = "INSERT INTO `login`(`username`, `email`, `password`) VALUES ('$username','$email','$password_hash')";

                        if($conn->query($query) === TRUE) {
                            ?>
                            <script>
                                $('#errors').css("color", "#4dcc7d");
                                $('#errors').html("Registered Successfully");
                            </script>
                            <?php
                        } else{
                            ?>
                            <script>
                                $('#errors').html("Something Went Wrong.Try Again Later.");
                            </script>
                            <?php
                        }
                    }
                } $conn->close();
            }
        ?>
        <script>
            function bulleye(onename){
                if(onename == 'password'){
                    var nope = $('#password').attr('type');
                    if(nope == 'password'){
                        $('#password').prop('type','text');
                        $('#showNoEye').attr('src','img/eye-slash-regular.svg')
                    } else{
                        $('#password').prop('type','password');
                        $('#showNoEye').attr('src','img/eye-regular.svg')
                    }
                } else if(onename == 'cpassword'){
                    var nope = $('#cpassword').attr('type');
                    if(nope == 'password'){
                        $('#cpassword').prop('type','text');
                        $('#cshowNoEye').attr('src','img/eye-slash-regular.svg')
                    } else{
                        $('#cpassword').prop('type','password');
                        $('#cshowNoEye').attr('src','img/eye-regular.svg')
                    }
                }
            }
        </script>
    </body>
</html>