<html>
<head>
	<title>Apotek - Obat</title>
</head>
<body>
	<h1>Update Obat</h1><hr/><br/>
	<?php
		include ('connection.php');
		$id 	= $_GET['id'];
		$sql 	= "SELECT * FROM dtobat WHERE id_obat='$id'";
		$result = mysqli_query($con,$sql);
		while($data = mysqli_fetch_array($result)){
	?>
		<form action="updateObatAction.php" method="POST" enctype="multipart/form-data">
			<table border ="0" cellspacing="5">
				<tr>
					<td><input type="hidden" name="id" value="<?= $id ?>"></td>
				</tr>
				<tr>
					<input type="hidden" name="old" value="<?= $data['image']; ?>"/>
				</tr>
				<tr>
					<td><?= "<img src='image/".$data['image']."' width='100' height='100' title='".$data['nama_obat']."'/>"; ?></td>
				</tr>
				<tr>
					<td><input type="file" accept=".png, .jpg, .jpeg, .jfif, .gif" name="foto" /></td>
				</tr>
				<tr>
					<td><input type="text" name="nama" 
						 placeholder="Nama" value="<?= $data['nama_obat']; ?>" required /></td>
				</tr>
				<tr>
					<td>
						<select name="kd_gol">
						<?php 
							include 'connection.php';
							$sql1 = "SELECT * FROM golongan";
							$result1 = mysqli_query($con,$sql1) or die(mysqli_error($sql1));
							while($data1 = mysqli_fetch_array($result1)){	
						?>
							<option value="<?= $data1['kode']; ?>" <?= ($data1['kode']==$data['kd_golongan'])?'selected':''?> ><?= $data1['kode']." - ".$data1['nama']; ?></option>	
						<?php
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<select name="kd_sed">
						<?php 
							include 'connection.php';
							$sql1 = "SELECT * FROM sediaan";
							$result1 = mysqli_query($con,$sql1) or die(mysqli_error($sql1));
							while($data1 = mysqli_fetch_array($result1)){	
						?>
							<option value="<?= $data1['kode']; ?>" <?= ($data1['kode']==$data['kd_sediaan'])?'selected':''?> ><?= $data1['kode']." - ".$data1['nama']; ?></option>	
						<?php
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td><input type="number" name="harga" min="0" 
						 placeholder="Harga" value="<?= $data['harga']; ?>" required /></td>
				</tr>
				<tr>
					<td><input type="date" name="expire" value="<?= $data['expire_date']; ?>" required /></td>
				</tr>
				<tr>
					<td> 
						<input type="submit" name="update" value="Update"/>
						<input type="reset" value="Clear" />
						<input type="button" value="Cancel" onclick="window.location.href='selectObat.php'">
					</td>
				</tr>
			</table>
		</form>
	<?php } ?>
   </body>
</html>