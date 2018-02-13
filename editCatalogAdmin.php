<?php
//  Author: Ali Hamza
session_start();

// redirects users to login page if user is not of type customer
if($_SESSION['userType'] != 'admin')
{
  header("Location: index.php");
}

// including files with database configuration and function
require_once(dirname(__FILE__).'/db_connect.php');
require_once(dirname(__FILE__).'/databaseFunctions.php');

// building database connection
$connectionClass = new DB_CONNECT();
$conn  = $connectionClass->connect();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

	<title>Edit Catalogue</title>
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
							<h1><a class="navbar-brand" href="admin.php"><span>C</span>apgemini</a></h1>
						</div>
					</div>

					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">
						<nav class="cl-effect-1" id="cl-effect-1">
							<ul class="nav navbar-nav">
								<li ><a href="admin.php" data-hover="Home">Home</a></li>
								<li class="active"><a href="" data-hover="Home">Catalogue</a></li>
								<li ><a href="manageUsers.php" data-hover="Home">Manage Users</a></li>
								<li class="dropdown menu__item">
									<a href="#" class="dropdown-toggle menu__link active" data-toggle="dropdown" data-hover="Pages" role="button" aria-haspopup="true"
									    aria-expanded="false">Account<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="editProfileAdmin.php">Edit Profile</a></li>
										<li><a href="resetPasswordAdmin.php">Reset Password</a></li>
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
		<div class="container" style="margin-left:30%">
		 <br> <br> <br>
		    <!--footer-->
	        <div class="contact-middle" style="background:rgba(0, 0, 0, 0.8); max-width:50%;">
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
					<h3 style="color:#ffa500;" align="center"> Add New Item</h3><br>
					<form action="" method="post" >
					
						<div class="form-fields-agileinfo">
							<p>Title</p>
							<input type="text" id="itemTitle" name="itemTitle" required ="required"/>
						</div>
						<div class="form-fields-agileinfo">
							<p>Description</p>
							<input type="text" id="itemDescription" name="itemDescription" required ="required"/>
						</div>
						<div class="form-fields-agileinfo">
							<p>Value</p>
							<input type="number" id="itemValue" name="itemValue"  required ="required"/>
						</div>
						<br>
						<p>Item Type</p>
						<select class="form-control" id="itemType" name="itemType">
							<option type="text" value="Test Artifacts" >Test Artifacts</option>
							<option type="text" value="Onshore Resources">Onshore Resources</option>
							<option type="text" value="Offshore Resources">Offshore Resources</option>
							<option type="text" value="Tools">Tools</option>
							<option type="text" value="Non-Test">Non-Test</option>
							<option type="text" value="Miscellaneous">Miscellaneous</option>
						</select>
						<input type="submit" value="Add Item" name="addItem">
					</form>
			</div>		
	    </div>
		<div class="container">
		 <br> <br> <br>
			<!--footer-->
	        <div class="contact-middle" align="center" style="background:rgba(0, 0, 0, 0.8);">
	 
				<h3 style="color:#ffa500;">Edit Catalogue</h3><br>
				<div class="table-responsive">
					<table class="table" id="example2" style="color:white; !important">
						<thead>
						  <tr>
							<th><p>Title</p></th>
							<th><p>Description</p></th>
							<th><p>Value</p></th>
							<th><p>Type</p></th>
							<th><p>Delete</p></th>
						  </tr>
						</thead>
						<tbody>
						 <?php getAllItems();?>
						</tbody>
					</table>
				</div>
			</div>
			<br><br><br>
			<!-- table 2-->
	    </div>
	</div>

	
	<!--//Slider-->
	<!--//Header-->
<script>
$(document).ready(function(){
    $('#example2').DataTable();
});
</script>

<?php
    //including footer HTML
    include( __DIR__ . '/footer.php');
	
	// add new item
    if(isset($_POST['addItem'])){
		// calling function to update selected user details
		addItem();	
	}
?>	