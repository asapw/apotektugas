<?php 
	include ('connection.php');
	if(isset($_POST['update'])){
		$id		= $_POST['id'];
		$oldimg	= $_POST['old'];
		$newimg	= $_FILES['foto']['name'];
		$nm		= $_POST['nama'];
		$kg		= $_POST['kd_gol'];
		$ks		= $_POST['kd_sed'];
		$hrg	= $_POST['harga'];
		$expire	= $_POST['expire'];
		
		if($newimg==""){
			$sql 	= "UPDATE dtobat SET 
						nama_obat='$nm', 
						kd_golongan='$kg',
						kd_sediaan='$ks',
						harga='$hrg',
						expire_date='$expire'
						WHERE id_obat='$id'";
			$result = mysqli_query($con,$sql);
		}
		else{
			unlink('image/'.$oldimg);
			$loc 	= $_FILES['foto']['tmp_name'];
			$filenm = $nm.'-'.uniqid().'.png';
			move_uploaded_file($loc, 'image/'.$filenm);
			$sql 	= "UPDATE dtobat SET 
						image='$filenm',
						nama_obat='$nm', 
						kd_golongan='$kg',
						kd_sediaan='$ks',
						harga='$hrg',
						expire_date='$expire'
						WHERE id_obat='$id'";
			$result = mysqli_query($con,$sql);
		}
		if($result) {
			header("location:selectObat.php");
		}
		else{
			echo "Query Error : ".mysqli_error($con);
		}
	}
	else{
		echo "<b>Anda harus mengakses dari <a href='updateObat.php'>Form Update</a></b>";
	}
?>