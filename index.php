<?php
session_start();

if(isset($_SESSION['userType']))
{
    if($_SESSION['userType'] == 'customer')
	{
	  header("Location: customer.php");
	}
	if($_SESSION['userType'] == 'admin')
	{
	  header("Location: admin.php");
	}
} // if for userType ends


// including file with database configuration
require_once(dirname(__FILE__).'/db_connect.php');
require_once(dirname(__FILE__).'/databaseFunctions.php');

// building database connection
$connectionClass = new DB_CONNECT();
$conn  = $connectionClass->connect();

?>

<!--
Author: Ali Hamza
-->
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Capgemini</title>
	<!-- Meta-tags -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Tract Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //Meta-tags -->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" /><!-- //Bootstrap Css -->
	<link href="css/font-awesome.css" rel="stylesheet"><!-- //Font-awesome Css -->
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" /><!-- //Required Css -->
	<!--fonts-->
	<link href="//fonts.googleapis.com/css?family=Megrim" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Josefin+Sans:100,300,400,600,700" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
	<!--//fonts-->

</head>

<body>
	<!--Slider-->
	<div class="slider">
		<!-- //header -->
		<div class="header-bottom">
			<div class="container">
				<nav class="navbar navbar-default">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
				  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
						<div class="logo">
							<h1><a class="navbar-brand" href="index.php"><span>C</span>apgemini</a></h1>
						</div>
					</div>
					<!-- /.navbar-collapse -->
				</nav>
			</div>
		</div>
		<div class="contact-agile" id="contact">
		
		<div class="container">
		
			<div id="successDiv" class="alert alert-success alert-dismissible" role="alert" style="display:none; font-size:20px; " >
				<div id="successMessage" >
					<!-- success messages are shown here. -->
				</div>
			</div>
			<div id="errorDiv" class="alert alert-danger alert-dismissible" role="alert" style="display:none; font-size:20px;">
				<div id="errorMessage" style="padding-left:5%;">
					<!-- error messages are shown here. -->
				</div>
			</div>	
		
			<div class="contact-eql">
				<div class="contact-middle" style="background:rgba(0, 0, 0, 0.8);">
					<h4>Login</h4>
					<form action="" method="post">
						<div class="form-fields-agileinfo">
							<p>Email</p>
							<input type="email" id="loginEmail" name="loginEmail"  placeholder="John@email.com" required="required" />
						</div>
						<div class="form-fields-agileinfo">
							<p>Password</p>
							<input type="password" id="loginPassword" name="loginPassword" required="required" />
						</div>
						<input type="submit" name="Login" value="Login">
					</form>
				</div>
				<div class="contact-middle" style="background:rgba(0, 0, 0, 0.8);">
				    
					<h4>Signup</h4>
					<form action="" method="post">
						<div class="form-fields-agileinfo">
							<p>First Name</p>
							<input type="text" id="firstName" name="firstName" placeholder="John" required="required" />
						</div>
						<div class="form-fields-agileinfo">
							<p>Last Name</p>
							<input type="text" id="lastName" name="lastName" placeholder="Doe"  />
						</div>
						<div class="form-fields-agileinfo">
							<p>Email</p>
							<input type="email" id="email" name="email" placeholder="John@email.com" required="required" />
						</div>
						<div class="form-fields-agileinfo" >
							<p style="padding-top:15px;">Company</p>
							<input type="text" id="company" name="company" required="required" />
						</div>
						<div class="form-fields-agileinfo">
							<p style="padding-top:15px;">Password</p>
							<input type="password" id="password" name="password" required="required" />
						</div>
						<div class="form-fields-agileinfo">
							<p style="padding-top:15px;">Confirm Password</p>
							<input type="password" id="confirmPassword" name="confirmPassword" required="required" />
						</div>
						<input type="submit" name="Signup" value="Signup">
					</form>
				</div>
			</div>
		</div>
	</div>
	</div>

	<!--//Slider-->
	<!--//Header-->

<?php
    //including footer HTML
    include( __DIR__ . '/footer.php');
	
	// account creation/signup
    if(isset($_POST['Signup'])){
		// calling function to validate signup
		$signupValidation = validateSignup();
		if($signupValidation == true)
			{
			addUser();	
			}
	}
	//login function
	if(isset($_POST['Login'])){
		login();	
	}
	
	
?>	