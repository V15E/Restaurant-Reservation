<!-- //TODO: When something needs to be done. -->
<!-- //! When something should be aware/cautious of. -->
<!-- //* When something is informational. -->
<!-- //? When something is questionable. -->

<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- //TODO: replace the favicon here -->
    <link rel="icon" type="image/png" sizes="32x32" href="img/spider.bmp">
    <!-- //TODO: replace the title here -->
    <title>Monkies. Restaurant</title>
    <!-- //* visit https://www.w3schools.com/tags/tag_meta.asp about metadata tags. -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- //* links to css folder for "additional styles" -->
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <!-- //* links to bootstrap cdn css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <!-- //* links to font-awesome cdn css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- //* links to jquery cdn js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>

<!-- //? This style tag is questionable. Are the styles used below used in other places? -->
<!-- //! The styles below may affect with the other styles that you design. -->
<style>
    .flex-column {
        max-width: 260px;
    }

    .container {
        background: #f9f9f9;
    }

    .img {
        margin: 5px;
    }

    .logo img {
        width: 150px;
        height: 250px;
        margin-top: 90px;
        margin-bottom: 40px;
    }
</style>

<body>
    <!-- //* the main navbar of this website -->
    <nav class="navbar navbar-expand-md navbar-light fixed-top">
        <div class="container">
            <!-- //* goes back to homepage button in the navbar -->
            <a class="navbar-brand" href="../index.php">
                <!-- //TODO: change title here -->
                <strong><em>Chocolate & Moer</em></strong>
            </a>
            <!-- //* this is the hamburger icon that you see when it's on mobile mode -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navi">
                <ul class="navbar-nav mr-auto">
                    <!-- //* this is a PHP code that decides which navbar layout to show based on who's logged in and who's not -->
                    <?php
                    //set navigation bar when logged in
                    if (isset($_SESSION['user_id'])) {
                        //* default setting only show the "reservation" and "view reservations" buttons for normal users
                        echo '
                        <li class="nav-item">
                            <a class="nav-link" href="reservation.php">New Reservation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="view_reservations.php">View Reservations</a>
                        </li>
                        ';
                        //* set navigation bar when logged in and role of admin
                        if ($_SESSION['role'] == 2) {
                            echo '
                            <li class="nav-item">
                                <a class="nav-link" href="schedule.php">Edit Schedule</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="tables.php">Edit Tables</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="view_tables.php">View Tables</a>
                            </li>
                            ';
                        }
                    }
                    //* when not logged in (About Us | Gallery | Reservation | Find Us) on the navbar
                    else {
                        echo '
                        <li class="nav-item">
                        <a class="nav-link" href="#aboutus">About Us</a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link" href="#gallery">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#reservation">Reservation</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#footer">Find Us</a>
                        </li>
                        ';
                    }
                    ?>
                </ul>

                <?php
                //* log out button when user is logged in
                if (isset($_SESSION['user_id'])) {
                    echo '
                    <form class="navbar-form navbar-right" action="includes/logout.inc.php" method="post">
                    <button type="submit" name="logout-submit" class="btn btn-outline-dark">Logout</button>
                    </form>';
                } else {
                    echo '
                    <div>
                    <ul class="navbar-nav ml-auto">
			        <li><a class="nav-link fa fa-sign-in" data-toggle="modal" data-target="#myModal_reg">&nbsp;Sing Up</a></li>
			        <li><a class="nav-link fa fa-user-plus" data-toggle="modal" data-target="#myModal_login">&nbsp;Login</a></li>
                    </ul>
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
    </nav>

    <!-- //* the modal screen that appears when login button is clicked -->
    <div class="container">
        <!-- //* the modal -->
        <div class="modal fade" id="myModal_login">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- //* modal header which contains "Login" and "x" button -->
                    <div class="modal-header">
                        <!-- //* login text -->
                        <h4 class="modal-title">Login</h4>
                        <!-- //* close button -->
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- //* modal body -->
                    <div class="modal-body">
                        <!-- //* php code to show login screen and error handling of credentials -->
                        <?php
                        if (isset($_GET['error1'])) {
                            //* script for modal to appear when error
                            echo '
                                <script>
                                $(document).ready(function(){
                                $("#myModal_login").modal("show");
                                });
                                </script>
                            ';
                            //* error handling of log in
                            if ($_GET['error1'] == "emptyfields") {
                                echo '<h5 class="text-danger text-center">Fill all fields, Please try again!</h5>';
                            } else if ($_GET['error1'] == "error") {
                                echo '<h5 class="text-danger text-center">Error Occured, Please try again!</h5>';
                            } else if ($_GET['error1'] == "wrongpwd") {
                                echo '<h5 class="text-danger text-center">Wrong Password, Please try again!</h5>';
                            } else if ($_GET['error1'] == "error2") {
                                echo '<h5 class="text-danger text-center">Error Occured, Please try again!</h5>';
                            } else if ($_GET['error1'] == "nouser") {
                                echo '<h5 class="text-danger text-center">Username or email not found, Please try again!</h5>';
                            }
                        }
                        //* adds a line after that error message
                        echo '<br>';
                        ?>
                        <!-- //* this is for the signin form -->
                        <div class="signin-form">
                            <!-- //* form for the signing in form -->
                            <form action="includes/login.inc.php" method="post">
                                <p class="hint-text">If you have already an account please log in.</p>
                                <!-- //* for the username/email field -->
                                <div class="form-group">
                                    <input type="text" class="form-control" name="mailuid" placeholder="Username Or Email" required="required">
                                </div>
                                <!-- //* for the password field -->
                                <div class="form-group">
                                    <input type="password" class="form-control" name="pwd" placeholder="Password" required="required">
                                </div>
                                <!-- //* for the submit button -->
                                <div class="form-group">
                                    <button type="submit" name="login-submit" class="btn btn-dark btn-lg btn-block">Log In</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- //* modal footer which contains "Close" button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- //* the modal screen that appears when signin button is clicked -->
    <div class="container">
        <!-- //* the modal -->
        <div class="modal fade" id="myModal_reg">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- //* modal header which contains "Login" and "x" button -->
                    <div class="modal-header">
                        <!-- //* register text -->
                        <h4 class="modal-title">Register</h4>
                        <!-- //* close button -->
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- //* modal body -->
                    <div class="modal-body">
                        <!-- //* php code to show login screen and error handling of credentials -->
                        <?php
                        if (isset($_GET['error'])) {
                            //* script for modal to appear when error
                            echo '
                                <script>
                                $(document).ready(function(){
                                $("#myModal_reg").modal("show");
                                });
                                </script>
                            ';
                            //* error handling of log in
                            if ($_GET['error'] == "emptyfields") {
                                echo '<h5 class="bg-danger text-center">Fill all fields, Please try again!</h5>';
                            } else if ($_GET['error'] == "invalidemailusername") {
                                echo '<h5 class="bg-danger text-center">Username or Email are taken!</h5>';
                            } else if ($_GET['error'] == "invalidemail") {
                                echo '<h5 class="bg-danger text-center">Invalid Email, Please try again!</h5>';
                            } else if ($_GET['error'] == "usernameemailtaken") {
                                echo '<h5 class="bg-danger text-center">Username or email is taken, Please try again!</h5>';
                            } else if ($_GET['error'] == "invalidusername") {
                                echo '<h5 class="bg-danger text-center">Invalid Username, Please try again!</h5>';
                            } else if ($_GET['error'] == "invalidpassword") {
                                echo '<h5 class="bg-danger text-center">Invalid password, Please try again!</h5>';
                            } else if ($_GET['error'] == "passworddontmatch") {
                                echo '<h5 class="bg-danger text-center">Password must match, Please try again!</h5>';
                            } else if ($_GET['error'] == "error1") {
                                echo '<h5 class="bg-danger text-center">Error Occured, Try again!</h5>';
                            } else if ($_GET['error'] == "error2") {
                                echo '<h5 class="bg-danger text-center">Error Occured, Try again!</h5>';
                            }
                        }
                        //* script for modal to appear when success
                        if (isset($_GET['signup'])) {
                            echo '
                                <script>
                                $(document).ready(function(){
                                $("#myModal_reg").modal("show");
                                });
                                </script>
                            ';
                            //* success message
                            if ($_GET['signup'] == "success") {
                                echo '<h5 class="bg-success text-center">Sign up was successfull! Please Log in!</h5>';
                            }
                        }
                        //* adds a line after that error message
                        echo '<br>';
                        ?>
                        <!-- //* this is for the signup form -->
                        <div class="signup-form">
                            <form action="includes/signup.inc.php" method="post">
                                <!-- //* welcoming message for create account -->
                                <p class="hint-text">Create your account. It's free and only takes a minute.</p>
                                <!-- //* username area -->
                                <div class="form-group">
                                    <input type="text" class="form-control" name="uid" placeholder="Username" required="required">
                                    <small class="form-text text-muted">Username must be 4-20 characters long</small>
                                </div>
                                <!-- //* email area -->
                                <div class="form-group">
                                    <input type="email" class="form-control" name="mail" placeholder="Email" required="required">
                                </div>
                                <!-- //* password area -->
                                <div class="form-group">
                                    <input type="password" class="form-control" name="pwd" placeholder="Password" required="required">
                                    <small class="form-text text-muted">Password must be 6-20 characters long</small>
                                </div>
                                <!-- //* password repeat area -->
                                <div class="form-group">
                                    <input type="password" class="form-control" name="pwd-repeat" placeholder="Confirm Password" required="required">
                                </div>
                                <!-- //* terms of use and privacy area -->
                                <div class="form-group">
                                    <label class="checkbox-inline"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
                                </div>
                                <!-- //* click to submit/register -->
                                <div class="form-group">
                                    <button type="submit" name="signup-submit" class="btn btn-dark btn-lg btn-block">Register Now</button>
                                </div>
                            </form>
                            <!-- //* gets the user to sign in modal -->
                            <div class="text-center">Already have an account? <a href="#">Sign in</a></div>
                        </div>
                    </div>
                    <!-- //* modal footer which contains "Close" button -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>