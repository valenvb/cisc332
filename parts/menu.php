<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<header>
    <div class="collapse bg-light" id="navbarHeader">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                    <p class="text-muted"></p>
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                    <ul class="list-unstyled">
                        <li>
                        <?php
                        if(!(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"])){
                            ?>
                            <a href="login.php" class="text-dark">Log in</a>
                            <?php
                        } else {
                            echo("<a>User: ".$_SESSION['username']."</a>");
                        }
                        ?>
                        </li>
                        <?php
                        //echo "Session set: ".isset($_SESSION["logged_in"]);
                        if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"]){
                            ?>
                            <li>
                            <a href='member/profile.php' class='text-dark'>Profile</a>
                            <li>
                            <li>
                            <a href='/omts/login.php?logout=0' class='text-dark'>Log out</a>
                            <li>
                            <?php
                        }
                        if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] && $_SESSION['user_type']==="A"){?>
<li>
                            <a href="admin/" class="text-dark">Admin Page</a>
                        </li>
                        <?php } 
                        ?>
                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar navbar-light bg-light box-shadow">
        <div class="container d-flex justify-content-between">
            <a href="http://localhost:8888/omts" class="navbar-brand d-flex align-items-center">
                <strong>OMTS</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</header>