<?php
//  Author: Ali Hamza
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

	<title>Edit profile</title>
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
								<li><a href="admin.php" data-hover="Home">Home</a></li>
								<li ><a href="" data-hover="Home">Catalogue</a></li>
								<li ><a href="" data-hover="Home">Manage Users</a></li>
								<li class="dropdown menu__item active">
									<a href="#" class="dropdown-toggle menu__link active" data-toggle="dropdown" data-hover="Pages" role="button" aria-haspopup="true"
									    aria-expanded="false">Account<span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="editProfileAdmin.php">Edit Profile</a></li>
										<li><a href="resetPasswordAdmin.php">Reset Password</a></li>
									</ul>
								</li>
								<li><a href="contact.html" data-hover="Contact">Logout</a></li>
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
					<h3 style="color:#ffa500;" align="center"> Edit Profile</h3><br>
					<form action="#" method="post" >
						<div class="form-fields-agileinfo">
							<p>Last Name</p>
							<input type="text" id="lastName" value="" />
						</div>
						<div class="form-fields-agileinfo">
							<p>Role</p>
							<input type="text" id="email" value="" />
						</div>
						<div class="form-fields-agileinfo">
							<p>Location</p>
							<input type="text" id="location" value="" />
						</div>
						<br>
						<p>User Type</p>
						<select class="form-control" id="sel1">
							<option type="text" value="admin">Admin</option>
							<option type="text" value="customer">Customer</option>
						</select>
						<input type="submit" value="Update">
					</form>
			</div>
			<br><br><br>
			
	</div>

	
	<!--//Slider-->
	<!--//Header-->

<?php
    //including footer HTML
    include( __DIR__ . '/footer.php');
?>	
				
			