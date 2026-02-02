<?php 

	session_start();

	include_once('config.php');

	if(isset($_POST['submit']))
	{
		
		$username = $_POST['username'];

	
		$password = $_POST['password'];

	
		if (empty($username) || empty($password)) {

			echo "Please fill in all fields
			";

		}
		else{

			//If false, we will create a query to select id,emri,username,email,password,is_admin from users table based on each username
			$sql = "SELECT id, emri, username, email, password, is_admin FROM users WHERE username=:username";

			//We use prepared statement as a feature used to execute the same sql statement repeatedly with high efficiency
			$selectUser = $conn->prepare($sql);

			//bindParam binds a parameter to the specified variable name, so we bind :username to $username variable

			$selectUser->bindParam(":username", $username);

			/* At a later time, the application binds the values to the parameters, and the database executes the statement.
			 The application may execute the statement as many times as it wants with different values */

			$selectUser->execute();

			/*The fetch() method allows you to fetch a row from a result set associated with a PDOStatement object. Internally,
			 the fetch() method fetches a single row from a result set and moves the internal pointer to the next row in the result set.*/

			$data = $selectUser->fetch();

			//We will check if $data value(which in this case would be username) does not exist:
			if ($data == false) {
				

				//If the condition is true, then we will echo this message
				echo "The user does not exist
				";
			}else{

					
				if (password_verify($password, $data['password'])) {
					
					$_SESSION['id'] = $data['id'];
					$_SESSION['username'] = $data['username'];
					$_SESSION['email'] = $data['email'];
					$_SESSION['emri'] = $data['emri'];
					$_SESSION['is_admin'] = $data['is_admin'];

					
					header('Location: dashboard.php');
				}
				else{
					
					echo "The password is not valid";
				}

			}

		}


	}


 ?>