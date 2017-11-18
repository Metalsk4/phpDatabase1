<?php
	$dbhost="localhost";
	$username="root";
	$password="";
	$dbname="logindata";
	$conn=mysqli_connect($dbhost, $username, $password, $dbname);

if (isset($_POST['submit'])) {
	$Uname=mysqli_real_escape_string($conn,$_POST['uid']);
	$Upwd=mysqli_real_escape_string($conn,$_POST['pwd']);
	$Uemail=mysqli_real_escape_string($conn,$_POST['email']);

	//Error handlers
	//Check for empty fields
	if (empty($Uname) ||empty($Upwd)||empty($Uemail)) {
		header("Location: index.html?Error=empty");
		echo "Fill all fields";
		exit();
	}else

   //check if email is valid
	if (!filter_var($Uemail, FILTER_VALIDATE_EMAIL)) {
		header("Location: index.html?Error=INVALID EMAIL");
		echo "Invalid Email";
		exit();
	}else{
		$sql="SELECT & FROM users WHERE UID='$Uname'"; 
		//checking if user already exit
		$result = mysqli_query($conn, $sql);
		$resultcheck = mysqli_num_rows($result);

		if ($resultcheck>0) {
			header("Location: index.html?error=UserAlreadyExist");
			echo "</br>UserAlreadyExist";
			exit();
		} else {
			//Hashing the password
			$hashedPWD = password_hash($Upwd, PASSWORD_DEFAULT);
			
			//Insert the user into database

			$sql = "INSERT INTO users(UID, PASSWORD, EMAIL) values('$Uname','$hashedPWD','$Uemail')";

			mysqli_query($conn, $sql);
			header("Location: index.html?Signup=Success");
			echo "</br>Success";
			exit();
		}
		
	}
} else {
	header("Location: index.html");
	echo "</br>Not Successful";
	exit();
}

