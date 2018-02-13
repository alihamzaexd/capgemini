<?php

require_once(dirname(__FILE__).'/db_connect.php');

	// function to valide user sign up interms to email
	function validateSignup(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmPassword'];
		
		// variable to hold error messages
		$errorMessage = null;
		if($password != $confirmPassword)
		{
			// update error massage
			$errorMessage = $errorMessage."<li>Password fields do not match.</li>";
		}
		$sql =<<<EOF
      SELECT * from USERS where email = '{$email}';
EOF;
		$ret = pg_query($conn, $sql);
		$row = pg_fetch_row($ret);
		//echo count($row);
		if($row) 
		{
			$errorMessage = $errorMessage."<li> Email already exists.</li>";
		}
		if($errorMessage!= null){
			// show error to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<ul> ".$errorMessage." </ul>';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			return false;
		}else{
			return true;
		}	
	}// end of function
	
	//=======================================================================================================================
    // function to add new user to the database
	function addUser(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$email = $_POST['email'];
		$companyName = $_POST['company'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmPassword'];
	
		 $sql =<<<EOF
      INSERT INTO USERS (first_name,last_name,company_name,email,password,user_type)
      VALUES ('{$firstName}', '{$lastName}','{$companyName}','{$email}','{$password}','customer');
EOF;

        $res = pg_query($conn, $sql);

        if($res){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Sign up Successful !</strong> Your account has been created.';</script>";
			// make error div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
			echo "<script> document.getElementById('errorDiv').style.display = 'none'; </script>";
        }
	    else{
            // show success message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = '<strong>Sign up failed!</strong>Problem in connection';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			echo "<script> document.getElementById('successDiv').style.display = 'none'; </script>";
        }
	}// end of function
	
	
	//==========================================================================================================
	function login(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		// fetching form values
		$email = $_POST['loginEmail'];
		$password = $_POST['loginPassword'];
		
		$databasePassword; $databaseUserId; $databaseUserType;$databaseEmail;
			// AUTHENTICATION SECTION
        $sql =<<<EOF
        SELECT id,password,email,user_type from USERS WHERE email = '{$email}';
EOF;
	   $ret = pg_query($conn, $sql);
	   if(!$ret) {
			// show error to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Database connection error occured.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
	   }else{ 
			$databasePassword=null;
	        while($row = pg_fetch_row($ret)) {
				$databaseUserId = $row[0]; // storing user ID , will be used in future
				$databasePassword = $row[1]; // fetching password stored in database	
				$databaseEmail = $row[2]; // fetching email stored in database	
				$databaseUserType = $row[3]; // determines if user is admin type or customer user
		    }
		    # later, here validation from database is done
            if(($password != null) && ($password == $databasePassword)){
				
				$_SESSION['userType'] = $databaseUserType;
				$_SESSION['valid'] = true;
				$_SESSION['userId'] = $databaseUserId;
				$_SESSION['email'] = $databaseEmail;
				// show success message to the specified div
			    echo "<script>  document.getElementById('successMessage').innerHTML = '<strong>Login Successful !</strong>';</script>";
			    // make error div visible
			    echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
				
				if($databaseUserType == 'customer'){ // if one of users, will be sent to customer home otherwise will be sent to admin home page
					echo "<script> function refreshPage() {
					window.location.replace('customer.php')
				}
					window.setTimeout(refreshPage, 2000);</script>";
				}else{
				   echo "<script> function refreshPage() {
					window.location.replace('admin.php')
				}
					window.setTimeout(refreshPage, 2000);</script>";
				}
		    }else{
			    // show error to the specified div
			    echo "<script>  document.getElementById('errorMessage').innerHTML = '<ul><li>Incorrect Email or Password.</li></ul>';</script>";
			    // make error div visible
			    echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			}
		}
	}// end of login function	
	
	//=========================================================================================================
	// function to fetch user details from database
	function getUserPersonalDetails(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$email = $_SESSION['email'];
		$sql =<<<EOF
      SELECT first_name,last_name,company_name,role,location from USERS where email = '{$email}';
EOF;
		$ret = pg_query($conn, $sql);
		$row = pg_fetch_row($ret);
		if($row) 
		{
		    $_SESSION['firstName'] = $row[0];
			$_SESSION['lastName'] = $row[1];
			$_SESSION['companyName'] = $row[2];
			$_SESSION['role'] = $row[3];
			$_SESSION['location'] = $row[4];
		
		}else{
				// show error message to the specified div
				echo "<script>  document.getElementById('errorMessage').innerHTML = '<ul><li>Problem in accessing account details.</li></ul>';</script>";
				// make error div visible
				echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	//================================================================================================
	// function to fetch user detials from database
	function updateUserPersonalDetails(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		// to redirect user/admin to edit profile pages accordingly
		$pageForReload = "";
		if($_SESSION['userType'] == "admin"){
			$pageForReload = "editProfileAdmin.php";
		}else{
			$pageForReload = "editProfileCustomer.php";
		}
		
		$email = $_SESSION['email'];
		// fetching form values
		$lastName = $_POST['lastName'];
		$role = $_POST['role'];
		$location = $_POST['location'];
		
		$sql =<<<EOF
		UPDATE USERS SET 
		last_name = '{$lastName}',
        role = '{$role}',
		location = '{$location}'
		WHERE email = '{$email}';
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = 'Personal details updated successfully!';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
			echo "<script> function refreshPage() {
					window.location.replace('".$pageForReload."')
				}
					window.setTimeout(refreshPage, 2000);</script>";
		}
		else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in connection. Personal details cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			echo "<script> function refreshPage() {
					window.location.replace('".$pageForReload."')
				}
					window.setTimeout(refreshPage, 2000);</script>";
		}
	}// end of function
	
	//=======================================================================================================
	// function to update user password
	function resetPassword(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		// to redirect user/admin to edit profile pages accordingly
		$pageForReload = "";
		if($_SESSION['userType'] == "admin"){
			$pageForReload = "resetPasswordAdmin.php";
		}else{
			$pageForReload = "resetPasswordCustomer.php";
		}
		
		// email from session
		$email = $_SESSION['email'];
		
		// form values
		$newPassword = $_POST['password'];
		$confirmPassword = $_POST['confirmPassword'];
		
		// if password fields match
		if($newPassword == $confirmPassword)
	   {	
			 $sql =<<<EOF
		  UPDATE USERS SET password = '{$newPassword}' WHERE email = '{$email}';
EOF;
			$res = pg_query($conn, $sql);
			if($res){
				// show success message to the specified div
				echo "<script>  document.getElementById('successMessage').innerHTML = 'Password updated successfully!';</script>";
				// make success div visible
				echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
				echo "<script> function refreshPage() {
					window.location.replace('".$pageForReload."')
				}
					window.setTimeout(refreshPage, 2000);</script>";
			}
			else{
				// show error message to the specified div
				echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in connection. Password cannot be updated';</script>";
				// make error div visible
				echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
				echo "<script> function refreshPage() {
					window.location.replace('".$pageForReload."')
				}
					window.setTimeout(refreshPage, 2000);</script>";
			}
		}else{  // means fields don't match
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Password fields do not match. Type carefully.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	//========================================================================================================
	
	// function to fetch user details from database
	function getSpecificUserDetails($userId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		
		$sql =<<<EOF
      SELECT last_name,role,location,user_type from USERS where id = '{$userId}';
EOF;
		$ret = pg_query($conn, $sql);
		$row = pg_fetch_row($ret);
		if($row) 
		{
			$_SESSION['editUserId'] = $userId;
		    $_SESSION['editUserLastName'] = $row[0];
			$_SESSION['editUserRole'] = $row[1];
			$_SESSION['editUserLocation'] = $row[2];
			$_SESSION['editUserType'] = $row[3];
		
		}else{
				// show error message to the specified div
				echo "<script>  document.getElementById('errorMessage').innerHTML = '<ul><li>Problem in accessing account details.</li></ul>';</script>";
				// make error div visible
				echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	//===========================================================================================================
	// update user user details 
	function updateSpecificUserDetails($userId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		// page to be redirected on after details are updated
		$pageForReload = "manageUsers.php";
		
		// fetching form values
		$lastName = $_POST['editLastName'];
		$role = $_POST['editRole'];
		$location = $_POST['editLocation'];
		$userType = $_POST['editUserType'];
		
		$sql =<<<EOF
		UPDATE USERS SET 
		last_name = '{$lastName}',
        role = '{$role}',
		location = '{$location}',
		user_type = '{$userType}'
		WHERE id = '{$userId}';
EOF;
		$res = pg_query($conn, $sql);
		if($res){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = 'User details updated successfully!';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
			echo "<script> function refreshPage() {
					window.location.replace('".$pageForReload."')
				}
					window.setTimeout(refreshPage, 2000);</script>";
		}
		else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in connection. Personal details cannot be updated';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	//================================================================================================================
	// function to fetch users from database
	function getAllUsers(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =<<<EOF
	    SELECT id,first_name,last_name,email,user_type 
		FROM USERS;
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr>
						<td>".$row[0]."</td>
						<td>".$row[1]."</td>
						<td>".$row[2]."</td>
						<td>".$row[3]."</td>
						<td>".$row[4]."</td>
						<td>
							<form action='editUserProfileAdmin.php' method='post'>
								<input type='text' name='updateTargetUserId' id='updateTargetUserId' style='display:none;' value=".$row[0]." />
								<button class='btn btn-success' type='submit'>edit</button>
							</form>
							<br>
							<form action='deleteUserProfileAdmin.php' method='post'>
								<input type='text' name='updateTargetUserId' id='updateTargetUserId' style='display:none;' value=".$row[0]." />
								<button class='btn btn-danger' type='submit'>Delete</button>
							</form>
						</td>
					  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing users.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	//===============================================================================================================================
	// function to fetch items from database
	function getAllItems(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =<<<EOF
	    SELECT title,description,value,type,item_id
		FROM ITEMS where is_deleted ='no';
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr>
						<td>".$row[0]."</td>
						<td>".$row[1]."</td>
						<td>".$row[2]."</td>
						<td>".$row[3]."</td>
						<td>
							<form action='databaseFunctions.php' method='post'>
								<input type='text' name='targetItemToDelete' id='targetItemToDelete' style='display:none;' value=".$row[4]." />
								<button class='btn btn-danger' type='submit'>Delete</button>
							</form>
						</td>
					  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing users.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	//===========================================================================================
	// function to delete items
	function deleteItem($itemId){
		
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$status = "yes";
		$sql =<<<EOF
	    UPDATE ITEMS SET 
		is_deleted = '{$status}' where item_id ='{$itemId}';
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		    // show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = 'Item deleted successfully!';</script>";
			// make success div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
			echo "<script> function refreshPage() {
					window.location.replace('editCatalogAdmin.php')
				}
					window.setTimeout(refreshPage, 0);</script>";
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in deletion.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			echo "<script> function refreshPage() {
					window.location.replace('editCatalogAdmin.php')
				}
					window.setTimeout(refreshPage, 0);</script>";
		}		
	}// end of function
	//================================================================================================================
	// function to add new user to the database
	function addItem(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		
		$itemTitle = $_POST['itemTitle'];
		$itemDescription = $_POST['itemDescription'];
		$itemType = $_POST['itemType'];
		$itemValue = $_POST['itemValue'];
		$itemStatus = "no";
	
		 $sql =<<<EOF
      INSERT INTO ITEMS (title,description,type,value,is_deleted)
      VALUES ('{$itemTitle}', '{$itemDescription}','{$itemType}',{$itemValue},'{$itemStatus}');
EOF;

        $res = pg_query($conn, $sql);

        if($res){
			// show success message to the specified div
			echo "<script>  document.getElementById('successMessage').innerHTML = 'Item added.';</script>";
			// make error div visible
			echo "<script> document.getElementById('successDiv').style.display = 'block'; </script>";
			echo "<script> function refreshPage() {
					window.location.replace('editCatalogAdmin.php')
				}
					window.setTimeout(refreshPage, 2000);</script>";
        }
	    else{
            // show success message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Item could not be added.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
			echo "<script> function refreshPage() {
					window.location.replace('editCatalogAdmin.php')
				}
					window.setTimeout(refreshPage, 2000);</script>";
        }
	}// end of function
	
	//================================================================================================================================
	// function to fetch items from database
	function getServicesCatalogue(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =<<<EOF
	    SELECT title,description,value,type,item_id
		FROM ITEMS where is_deleted ='no' AND item_id NOT IN (SELECT item_id from BASKET where user_id = '{$_SESSION['userId']}');
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		  while($row = pg_fetch_row($ret)) 
		    {
			  echo "<tr>
						<td>".$row[0]."</td>
						<td>".$row[1]."</td>
						<td>".$row[2]."</td>
						<td>".$row[3]."</td>
						<td> <form action='' method='post'>
						    <input type='number' style='max-width:100px; color:green;' name='targetItemToBasketQuantity' id='targetItemToBasketQuantity' required='required'/>
						</td>
						<td>
							
								<input type='text' name='targetItemToBasket' id='targetItemToBasket' style='display:none;' value=".$row[4]." />
								<button class='btn btn-success' type='submit'>Add to Basket</button>
							</form>
						</td>
					  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing services catalogue.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	//=======================================================================================================================
    // function to add new user to the database
	function addItemToBasket($itemId,$itemQuantity){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
	
		 $sql =<<<EOF
      INSERT INTO BASKET (item_id,user_id,item_quantity)
      VALUES ({$itemId}, {$_SESSION['userId']},{$itemQuantity});
EOF;

        $res = pg_query($conn, $sql);

        if($res){
			// show success message to the specified div
			echo "<script>alert('Item added to basket.');
			window.location.replace('serviceCatalougeCustomer.php');
			</script>";
        }
	    else{
            // show success message to the specified div
			echo "<script>alert('Could not add item to basket.');
			window.location.replace('serviceCatalougeCustomer.php');
			</script>";
        }
	}// end of function
	//=====================================================================================================================
	// fetch basket items against a user
	function getBasketItemsCustomer(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		$sql =<<<EOF
	    SELECT title,description,value,type,item_id
		FROM ITEMS where is_deleted ='no' AND item_id IN (SELECT item_id from BASKET where user_id = '{$_SESSION['userId']}');
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		    while($row = pg_fetch_row($ret)) 
		    {
			    $sqlQuantity =<<<EOF
	            SELECT item_quantity from BASKET where user_id = '{$_SESSION['userId']}' AND item_id = '{$row[4]}';
EOF;
		        $retQuantity = pg_query($conn, $sqlQuantity);
				$rowQuantity = null;
				if($retQuantity){
					$rowQuantity = pg_fetch_row($retQuantity); 
				}
			  
				  echo "<tr>
							<td>".$row[0]."</td>
							<td>".$row[1]."</td>
							<td>".$row[2]." Credits</td>
							<td>".$row[3]."</td>
							<td>".$rowQuantity[0]."</td>
							<td>".$rowQuantity[0]*$row[2]." Credits</td>
							<td>
								<form action='' method='post'>
									<input type='text' name='targetItemToRemoveBasket' id='targetItemToRemoveBasket' style='display:none;' value=".$row[4]." />
									<button class='btn btn-danger' type='submit'>Remove</button>
								</form>
							</td>
						  </tr>";
		    }
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing basket.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	//===========================================================================================
	// function to add new user to the database
	function removeItemFromBasket($itemId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
	
		 $sql =<<<EOF
      DELETE from BASKET
      WHERE  item_id = {$itemId} AND user_id={$_SESSION['userId']};
EOF;

        $res = pg_query($conn, $sql);

        if($res){
			// show success message to the specified div
			echo "<script>alert('Item removed from basket.');
			window.location.replace('basketCustomer.php');
			</script>";
        }
	    else{
            // show success message to the specified div
			echo "<script>alert('Could not remove item from basket.');
			window.location.replace('basketCustomer.php');
			</script>";
        }
	}// end of function
	//=====================================================================================================================
	// function to add new user to the database
	function getBasketTotalCost($userId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
	    $sql =<<<EOF
	    SELECT SUM(item.value*basket.item_quantity) FROM ITEMS as item, BASKET as basket 
		WHERE item.item_id = basket.item_id AND basket.user_id = '{$userId}';
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		    $row = pg_fetch_row($ret);
		    echo $row[0];
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing basket.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	
	//=======================================================================================================================
    // function to add new user to the database
	function addCustomerQuote($userId,$userComments){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
		// getting system date to store with quote
		$date = date('Y-m-d');
		
		$totalCost=0;
		$sql1 =<<<EOF
	    SELECT SUM(item.value*basket.item_quantity) FROM ITEMS as item, BASKET as basket 
		WHERE item.item_id = basket.item_id AND basket.user_id = '{$userId}';
EOF;
		$ret1 = pg_query($conn, $sql1);
		if($ret1){
		    $row1 = pg_fetch_row($ret1);
		    $totalCost = $row1[0];
		}
	
		$sql =<<<EOF
		INSERT INTO QUOTES (user_id,status,submitted_on,customer_comments,total_cost)
		VALUES ({$userId},'In Review','{$date}','{$userComments}',{$totalCost});
EOF;
        $res = pg_query($conn, $sql);
        if($res){
			// fetching newly inserted quote ID
			$sqlQuoteId =<<<EOF
			SELECT quote_id FROM QUOTES 
			WHERE user_id = '{$userId}' ORDER BY quote_id DESC;
EOF;
			$resQuoteId = pg_query($conn, $sqlQuoteId);
			if($resQuoteId)
			{
				$rowQuoteId = pg_fetch_row($resQuoteId);
				// newly inserted quote ID
				$newQuoteId = $rowQuoteId[0];
				
				// fetching items in the basket with quantity
				$sqlItemsBasket =<<<EOF
				SELECT item_id,item_quantity FROM BASKET 
				WHERE user_id = '{$userId}';
EOF;
				$resItemsBasket = pg_query($conn, $sqlItemsBasket);
				if($resItemsBasket)
				{
					//fetch all items and insert to quote master table
					while($rowItemsBasket = pg_fetch_row($resItemsBasket)) 
					{
						$sqlInsetItemWithQuote =<<<EOF
						INSERT INTO QUOTE_MASTER (item_id,quote_id,item_quantity)
						VALUES ({$rowItemsBasket[0]},{$newQuoteId},{$rowItemsBasket[1]});
EOF;
						$resInsertItemWithQuote = pg_query($conn, $sqlInsetItemWithQuote);
					} // end while
					
					$sqlDeleteBasket =<<<EOF
					DELETE FROM BASKET WHERE user_id = '{$userId}';
EOF;
					$resDeleteBasket = pg_query($conn, $sqlDeleteBasket);
					
					if($resDeleteBasket){
						echo "<script>alert('Quote added.');
						window.location.replace('customer.php');
						</script>";
					}
				}
			} //end if	
        }
	    else{ 
			echo "<script>alert('Basket is empty, Quote cannot be added.');
			window.location.replace('customer.php');
			</script>";
        }
	}// end of function
	//=====================================================================================================================//=====================================================================================================================
	// function to add new user to the database
	function getQuotes($userId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
	    $sql =<<<EOF
	    SELECT quote_id,submitted_on,reviewed_on,status,total_cost
		from QUOTES where user_id = '{$userId}';
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		    //fetch all items and insert to quote master table
			while($row = pg_fetch_row($ret)) 
			{
				  echo "<tr>
							<td>".$row[0]."</td>
							<td>".$row[1]."</td>
							<td>".$row[2]."</td>
							<td>".$row[3]."</td>
							<td>".$row[4]." Credits</td>
							<td>
								<form action='' method='post'>
									<input type='text' name='targetQuoteForDetail' id='targetQuoteForDetail' style='display:none;' value=".$row[0]." />
									<button class='btn btn-info' type='submit' name='getQuote' id='getQuote'>Details</button>
								</form>
							</td>
						  </tr>";
			}
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing quotes.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	//=====================================================================================================================//=====================================================================================================================
	// function to add new user to the database
	function getInreviewQuotes(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
	    $sql =<<<EOF
	    SELECT quote_id,submitted_on,total_cost
		from QUOTES where status = 'In Review';
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		    //fetch all items and insert to quote master table
			while($row = pg_fetch_row($ret)) 
			{
				  echo "<tr>
							<td>".$row[0]."</td>
							<td>".$row[1]."</td>
							<td>".$row[2]." Credit</td>
							<td>
								<form action='' method='post'>
									<input type='text' name='targetQuoteForReview' id='targetQuoteForReview' style='display:none;' value=".$row[0]." />
									<button class='btn btn-info' type='submit' name='showQuoteReviewAdmin' id='showQuoteReviewAdmin'>Details</button>
								</form>
							</td>
						  </tr>";
			}
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing quotes.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	//=======================================================================================================================================
	// function to add new user to the database
	function getReviewedQuotes(){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
	    $sql =<<<EOF
	    SELECT quote_id,submitted_on,reviewed_on,total_cost
		from QUOTES where status != 'In Review';
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		    //fetch all items and insert to quote master table
			while($row = pg_fetch_row($ret)) 
			{
				  echo "<tr>
							<td>".$row[0]."</td>
							<td>".$row[1]."</td>
							<td>".$row[2]."</td>
							<td>".$row[3]." Credit</td>
							<td>
								<form action='quoteDetailsPage.php' method='post'>
									<input type='text' name='targetQuoteForDetail' id='targetQuoteForDetail' style='display:none;' value=".$row[0]." />
									<button class='btn btn-info' type='submit' name='showQuoteDetailsAdmin' id='showQuoteDetailsAdmin'>Details</button>
								</form>
							</td>
						  </tr>";
			}
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing quotes.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	//=============================================================================================================
	
	// to get items against a single quote
	function getQuoteItems($quoteId){
		// building database connection
		$connectionClass = new DB_CONNECT();
		$conn  = $connectionClass->connect();
	    $sql =<<<EOF
	    SELECT qm.item_quantity,it.title,it.description,it.value,it.type
		from QUOTE_MASTER as qm,ITEMS as it where it.item_id = qm.item_id and qm.quote_id = '{$quoteId}';
EOF;
		$ret = pg_query($conn, $sql);
		if($ret){
		    //fetch all items and insert to quote master table
			while($row = pg_fetch_row($ret)) 
			{
				  echo "<tr>
							<td>".$row[1]."</td>
							<td>".$row[2]."</td>
							<td>".$row[3]."</td>
							<td>".$row[4]."</td>
							<td>".$row[3]*$row[0]."</td>
						  </tr>";
			}
		}else{
			// show error message to the specified div
			echo "<script>  document.getElementById('errorMessage').innerHTML = 'Problem in accessing quote items.';</script>";
			// make error div visible
			echo "<script> document.getElementById('errorDiv').style.display = 'block'; </script>";
		}
	}// end of function
	//================================================================================================
	
	// just account deletion and admin quote approval section remain behind. link qoute details page to user ciew quote details button as well.
	
	
	if(isset($_POST['targetItemToDelete'])){
		deleteItem($_POST['targetItemToDelete']);
	}
	
	
	
?>