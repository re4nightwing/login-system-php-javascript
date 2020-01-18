<html>
    <head>
        <title>Home | Hello World</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <style>
            .fullVersion{
                text-align:center;
                background-color:#404664;
                padding:40px 60px 150px 60px;
                margin:0 3% 0 3%;
                color:#fff;
            }
        </style>
    </head>
    <body onload="loadFunction()">
        <div id="loader"><img id="loadimg" src="img/loading2.gif" ></div>
        <div id="content_sector">
            <header>
                <a class="register" href="load.html">Log Out</a>
                <h1 id="headding">Hello World 👋 </h1>
            </header>
            <div class="fullVersion">
                <form action="index.php" method="POST">
                    <input type="text" id="idOfUser">
                    <input type="text" id="username">
                </form>
                <?php
                    session_start();
                    include 'mysqli_conn.php';
                    if(isset($_SESSION['username'])){
                        
                        $sessionData = $_SESSION['username'];

                        $query = "SELECT * FROM login WHERE username = '$sessionData'";

                        $result = $conn->query($query);
                        if($result->num_rows > 0){
                            while($row =mysqli_fetch_array($result)) {
                                ?>
                                <script>
                                    $('#idOfUser').val("<?= $row['ID'] ?>");
                                    $('#username').val("<?= $row['username'] ?>");
                                </script>
                                <?php
                            }
                        }
                    } else if(isset($_COOKIE['username'])) {
                        
                            $cookieData = $_COOKIE['username'];
        
                            $query = "SELECT * FROM login WHERE username = '$cookieData'";
        
                            $result = $conn->query($query);
                            if($result->num_rows > 0){
                                while($row =mysqli_fetch_array($result)) {
                                    ?>
                                    <script>
                                        $('#idOfUser').val("<?= $row['ID'] ?>");
                                        $('#username').val("<?= $row['username'] ?>");
                                    </script>
                                    <?php
                                }
                            }
                    }
                    else{
                        header("location: login.php");
                    }
                ?>
            </div>
        </div>
        <script>
            var loadVar;

            function loadFunction() {
                $("body").addClass("blackout");
                loadVar = setTimeout(showPage, 2000);
            }

            function showPage() {
                $("#loader").animate({ opacity: 0 });
                setTimeout(function() {
                    $("body").removeClass("blackout");
                    $("#loader").css("display", "none");
                    $("#content_sector").css("display", "block");
                }, 1000);
                
            }
        </script>
    </body>

</html>