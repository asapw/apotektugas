<?php 
	include ('connection.php');
	$id		= $_GET['id'];
	$img 	= $_GET['img'];
	
	unlink('image/'.$img);
	$sql	=  "DELETE FROM dtobat WHERE id_obat='$id'";
	$result = mysqli_query($con,$sql);
	if($result) {
		header("location:selectObat.php");
	}
	else{
		echo "Query Error : ".mysqli_error($con);
	}
?>