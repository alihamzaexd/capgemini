<?php
//  Author: Ali Hamza
session_start();

// redirects users to login page if user is not of type customer
if($_SESSION['userType'] != 'customer')
{
  header("Location: index.php");
}

// including files with database configuration and function
require_once(dirname(__FILE__).'/db_connect.php');
require_once(dirname(__FILE__).'/databaseFunctions.php');

// building database connection
$connectionClass = new DB_CONNECT();
$conn  = $connectionClass->connect();

// getting user personal information to be used in this page
getUserPersonalDetails();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

	<title>Home</title>
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
	<link href="css/paginationStyling.css" rel="stylesheet">

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
							<h1><a class="navbar-brand" href="customer.php"><span>C</span>apgemini</a></h1>
						</div>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
						<nav class="cl-effect-1" id="cl-effect-1">
							<ul class="nav navbar-nav">
								<li class="active"><a href="customer.php" data-hover="Home">Home</a></li>
								<li ><a href="serviceCatalougeCustomer.php" data-hover="Home">Services Catalogue</a></li>
								<li ><a href="basketCustomer.php" data-hover="Home">My Basket <?php echo "| ";echo getBasketTotalCost($_SESSION['userId'])." Credits";?></a></li>
								<li class="dropdown menu__item">
									<a href="#" class="dropdown-toggle menu__link active" data-toggle="dropdown" data-hover="Pages" role="button" aria-haspopup="true"
									    aria-expanded="false">Account<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="editProfileCustomer.php">Edit Profile</a></li>
										<li><a href="resetPasswordCustomer.php">Reset Password</a></li>
									</ul>
								</li>
								<li><a href="logout.php" data-hover="Contact">Logout</a></li>
							</ul>
						</nav>
					</div>
					<!-- /.navbar-collapse -->
				</nav>
			</div>
		</div>
		<div class="container">
		 <br> <br> <br>
		    <!--footer-->
	        <div class="contact-middle"  style="background:rgba(0, 0, 0, 0.8);">
	 
				<h3 style="color:#ffa500;" align="center">Welcome <?php if(isset($_SESSION['firstName'])){ echo $_SESSION['firstName']." ".$_SESSION['lastName']; }?>!</h3><br>
				<h2>Account Details:</h2>
				<hr>
				<p>First Name:</p> <p style="margin-left:10%"><?php if(isset($_SESSION['firstName'])){ echo $_SESSION['firstName'];}?></p>
				<p>Last Name:</p>  <p style="margin-left:10%"><?php if(isset($_SESSION['lastName'])){ echo $_SESSION['lastName'];}else{echo "---Please set---";}?></p>
				<p>Email:</p>  <p style="margin-left:10%"><?php if(isset($_SESSION['email'])){ echo $_SESSION['email'];}?></p>
				<p>Company:</p>  <p style="margin-left:10%"><?php if(isset($_SESSION['companyName'])){ echo $_SESSION['companyName'];}?></p>
				<p>Location:</p>  <p style="margin-left:10%"><?php if(isset($_SESSION['location'])){ echo $_SESSION['location'];}else{echo "---Please set---";}?></p>
             
	        </div>
			<br><br>
			<!--footer-->
	        <div class="contact-middle" align="center" style="background:rgba(0, 0, 0, 0.8);">
	 
				<h3 style="color:#ffa500;">My Quotes</h3><br>
				<div class="table-responsive">
					<table class="table" id="example1" style="color:white; !important">
						<thead>
						  <tr>
							<th ><p>Quote Id</p></th>
							<th><p>Date Submitted</p></th>
							<th><p>Date Reviewed</p></th>
							<th><p>Total Cost</p></th>
							<th><p>Status</p></th>
							<th><p>Details</p></th>
						  </tr>
						</thead>
						<tbody>
						    <?php getQuotes($_SESSION['userId']); ?>
						</tbody>
					</table>
				</div>
			</div>
			<!-- table 1-->
			<br><br><br>
			
	</div>

	
	<!--//Slider-->
	<!--//Header-->
<script>
function showQuoteDetails(value){
	alert(value);
}

$(document).ready(function(){
    $('#example1').DataTable();
});
$(document).ready(function(){
    $('#example2').DataTable();
});
</script>

<?php
    //including footer HTML
    include( __DIR__ . '/footer.php');
?>	