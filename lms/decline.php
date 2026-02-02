<?php 
	/* 
	 We will include config.php for connection with database.

	*/
	include_once('config.php');

	$id = $_GET['id'];
	$sql = "UPDATE `reservations` SET `is_approved` = 'false' WHERE id=:id";
	$prep = $conn->prepare($sql);
	$prep->bindParam(':id',$id);
	$prep->execute();

	header("Location: list_books.php");
 ?>