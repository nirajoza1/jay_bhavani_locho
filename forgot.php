
<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn = mysqli_connect("localhost", "root", "", "newproject");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $reset_token)
{
    require('mailer/Exception.php');
    require('mailer/PHPMailer.php');
    require('mailer/SMTP.php');

    $mail = new PHPMailer(true);

    try {
        //Server settings                   //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'vikramkohli277@gmail.com';                     //SMTP username
        $mail->Password   = 'zjysmgkymgaepshq';                                       //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('vikramkohli277@gmail.com', "Jai bhavani Locho");
        $mail->addAddress($email);     //Add a recipient
        //Attachments
        //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Password Link For Forgot password';
        $mail->Body    = "Response of your forgot Password  <br> <b> Click link below </b>
                            <br>
                            <a href='http://localhost/tasty-master/tasty-master/changepass.php?email=$email&token=$reset_token'> Reset Password</a>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (!$conn) {
    die("not connected" . mysqli_connect_error());
} else {
    echo "connected successfully";
}

if (isset($_POST['register'])) {
    $email = $_POST['email'];

    // Insert data into the database
    $query = "SELECT * FROM `users` WHERE `email`='$email' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    print_r($data);
    
    $uname = $data['uname'];
    
    echo $uname;
    
    if (mysqli_num_rows($result) > 0) {
        echo " ///present in database";
        
        $reset_token=bin2hex(random_bytes(16));
        date_default_timezone_set('Asia/kolkata');
        $date=date("Y-m-d");
        $query="UPDATE `users` SET `token`='$reset_token' WHERE `email`='$email'";
        if(  mysqli_query($conn, $query) && sendMail($_POST['email'],$reset_token) ){
            echo " /// works ";
            echo "<script>window.alert('Password reset email has been sent to your email address. Please check your inbox.')</script>";
            $_SESSION['uname'] = $uname;

            echo $_SESSION["uname"];

        }
        else{
            echo "///not wokrking";
        }

    } else {
        echo " ///not present in database";
    }
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Jay Bhavani Locho &mdash; Online Food Website</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Free HTML5 Website Template by freehtml5.co" />
    <meta name="keywords" content="free website templates, free html5, free template, free bootstrap, free website template, html5, css3, mobile first, responsive" />
    <meta name="author" content="freehtml5.co" />

    <!-- Facebook and Twitter integration -->
    <meta property="og:title" content="" />
    <meta property="og:image" content="" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:description" content="" />
    <meta name="twitter:title" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:url" content="" />
    <meta name="twitter:card" content="" />

    <link href="https://fonts.googleapis.com/css?family=Cormorant+Garamond:300,300i,400,400i,500,600i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Icomoon Icon Fonts-->
    <link rel="stylesheet" href="css/icomoon.css">
    <!-- Bootstrap  -->
    <link rel="stylesheet" href="css/bootstrap.css">

    <!-- Flexslider  -->
    <link rel="stylesheet" href="css/flexslider.css">
    <!-- Date Time -->
    <link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">

    <!-- Theme style  -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Modernizr JS -->
    <script src="js/modernizr-2.6.2.min.js"></script>
    <!-- FOR IE9 below -->
    <!--[if lt IE 9]>
	<script src="js/respond.min.js"></script>
	<![endif]-->

</head>

<body>

    <div class="fh5co-loader"></div>

    <div id="page">
        <nav class="fh5co-nav" role="navigation">
            <!-- <div class="top-menu"> -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 text-center logo-wrap">
                        <div id="fh5co-logo"><a href="index.html">Jay Bhavani Locho<span>.</span></a></div>
                    </div>
                    <div class="col-xs-12 text-center menu-1 menu-wrap">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <!-- <li><a href="menu.php">Menu</a></li>
                            <li class="has-dropdown">
                                <a href="gallery.php">Gallery</a>
                                <ul class="dropdown">
                                    <li><a href="#">Events</a></li>
                                    <li><a href="#">Food</a></li>
                                    <li><a href="#">Coffees</a></li>
                                </ul>
                            </li> -->
                            <li class=""><a href="registration.php">Registration</a></li>
                            <li class=""><a href="login.php">Login</a></li>
                            <li><a href="about.php">About</a></li>
                            <li><a href="contact.php">Contact</a></li>
                        </ul>
                    </div>
                </div>

            </div>
            <!-- </div> -->
        </nav>

        <!-- <header id="fh5co-header" class="fh5co-cover js-fullheight" role="banner" style="background-image: url(images/hero_1.jpeg);" data-stellar-background-ratio="0.5">
		<div class="overlay"></div>
		<div class="container">
			<div class="row">
				<div class="col-md-12 text-center">
					<div class="display-t js-fullheight">
						<div class="display-tc js-fullheight animate-box" data-animate-effect="fadeIn">
							<h1>Reserved a Table Today!</h1>
							<h2>Brought to you by <a href="http://freehtml5.co/" target="_blank">freehtml5.co</a></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header> -->


        <div id="fh5co-reservation-form" class="fh5co-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 fh5co-heading animate-box">
                        <h2>Forgot Password</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <p>Step into Flavor Paradise: Register In is the Key to Your Tastebud's Desires!.</p>
                            </div>
                        </div>
                    </div> 

                    <div class="col-lg-6 col-lg-push-6 col-lg-6 col-lg-push-6" style="margin-left: -280px;">
                        <form action="#" id="form-wrap" method="post">

                            <div class="row form-group">
                                <div class="col-md-12">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-12">
                                    <input type="submit"  name = "register" class="btn btn-primary btn-outline btn-lg" value="Send Link">
                                </div>
                            </div>

                        </form>
                    </div>


                </div>
            </div>
        </div>



        <footer id="fh5co-footer" role="contentinfo" class="fh5co-section">
            <div class="container">
                <div class="row row-pb-md">
                    <div class="col-md-4 fh5co-widget">
                        <h4>Tasty</h4>
                        <p>Facilis ipsum reprehenderit nemo molestias. Aut cum mollitia reprehenderit. Eos cumque dicta adipisci architecto culpa amet.</p>
                    </div>
                    <div class="col-md-2 col-md-push-1 fh5co-widget">
                        <h4>Links</h4>
                        <ul class="fh5co-footer-links">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Menu</a></li>
                            <li><a href="#">Gallery</a></li>
                        </ul>
                    </div>

                    <div class="col-md-2 col-md-push-1 fh5co-widget">
                        <h4>Categories</h4>
                        <ul class="fh5co-footer-links">
                            <li><a href="#">Landing Page</a></li>
                            <li><a href="#">Real Estate</a></li>
                            <li><a href="#">Personal</a></li>
                            <li><a href="#">Business</a></li>
                            <li><a href="#">e-Commerce</a></li>
                        </ul>
                    </div>

                    <div class="col-md-4 col-md-push-1 fh5co-widget">
                        <h4>Contact Information</h4>
                        <ul class="fh5co-footer-links">
                            <li>198 West 21th Street, <br> Suite 721 New York NY 10016</li>
                            <li><a href="tel://1234567920">+ 1235 2355 98</a></li>
                            <li><a href="mailto:info@yoursite.com">info@yoursite.com</a></li>
                            <li><a href="http://https://freehtml5.co">freehtml5.co</a></li>
                        </ul>
                    </div>

                </div>

                <div class="row copyright">
                    <div class="col-md-12 text-center">
                        <p>
                            <small class="block">&copy; 2016 Free HTML5. All Rights Reserved.</small>
                            <small class="block">Designed by <a href="http://freehtml5.co/" target="_blank">FreeHTML5.co</a> Demo Images: <a href="http://unsplash.co/" target="_blank">Unsplash</a></small>
                        </p>
                        <p>
                        <ul class="fh5co-social-icons">
                            <li><a href="#"><i class="icon-twitter2"></i></a></li>
                            <li><a href="#"><i class="icon-facebook2"></i></a></li>
                            <li><a href="#"><i class="icon-linkedin2"></i></a></li>
                            <li><a href="#"><i class="icon-dribbble2"></i></a></li>
                        </ul>
                        </p>
                    </div>
                </div>

            </div>
        </footer>
    </div>

    <div class="gototop js-top">
        <a href="#" class="js-gotop"><i class="icon-arrow-up22"></i></a>
    </div>

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>
    <!-- jQuery Easing -->
    <script src="js/jquery.easing.1.3.js"></script>
    <!-- Bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Waypoints -->
    <script src="js/jquery.waypoints.min.js"></script>
    <!-- Waypoints -->
    <script src="js/jquery.stellar.min.js"></script>
    <!-- Flexslider -->
    <script src="js/jquery.flexslider-min.js"></script>

    <!-- Date Time -->
    <script src="js/moment.min.js"></script>
    <script src="js/bootstrap-datetimepicker.js"></script>


    <!-- Main -->
    <script src="js/main.js"></script>


    
</body>

</html>

