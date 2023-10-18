<?php 
	include ('connection.php');
	if(isset($_POST['insert'])){
		//$img	= $_FILES['foto']['name'];
		$loc 	= $_FILES['foto']['tmp_name'];
		$nm		= $_POST['nama'];
		$kg		= $_POST['kd_gol'];
		$ks		= $_POST['kd_sed'];
		$hrg	= $_POST['harga'];
		$expire	= $_POST['expire'];
		$filenm = $nm.'-'.uniqid().'.png';
		move_uploaded_file($loc, 'image/'.$filenm);
		$sql 	= "INSERT INTO dtobat (image, nama_obat, kd_golongan,kd_sediaan, harga, expire_date) 
				   VALUES ('$filenm','$nm','$kg','$ks','$hrg','$expire')";
		$result = mysqli_query($con,$sql);
		if($result) {
			header("location:selectObat.php");
		}
		else{
			echo "Query Error : ".mysqli_error($con);
		}
	}
	else{
		echo "<b>Anda harus mengakses dari <a href='insertObat.php'>Form Insert</a></b>";
	}
?>