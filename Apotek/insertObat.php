<!DOCTYPE HTML>
<html>
   <head>
	  <title>Apotek - Obat</title>
   </head>
   <body>
		<h1>Insert Obat</h1><hr/><br/>
		<form action="insertObatAction.php" method="POST" enctype="multipart/form-data">
			<table border ="0" cellspacing="5">
				<tr>
					<td><input type="file" accept=".png, .jpg, .jpeg, .jfif, .gif" name="foto" required /></td>
				</tr>
				<tr>
					<td><input type="text" name="nama" placeholder="Nama" required /></td>
				</tr>
				<tr>
					<td>
						<select name="kd_gol">
						<?php 
							include 'connection.php';
							$sql = "SELECT * FROM golongan";
							$result = mysqli_query($con,$sql) or die(mysqli_error($sql));
							while($data = mysqli_fetch_array($result)){	
						?>
							<option value="<?= $data['kode']; ?>"><?= $data['kode']." - ".$data['nama']; ?></option>	
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
							include 'Connection.php';
							$sql = "SELECT * FROM sediaan";
							$result = mysqli_query($con,$sql) or die(mysqli_error($sql));
							while($data = mysqli_fetch_array($result)){	
						?>
							<option value="<?= $data['kode']; ?>"><?= $data['kode']." - ".$data['nama']; ?></option>	
						<?php
							}
						?>
						</select>
					</td>
				</tr>
				<tr>
					<td><input type="number" name="harga" min="0" placeholder="Harga" required /></td>
				</tr>
				<tr>
					<td><input type="date" name="expire" required /></td>
				</tr>
				<tr>
					<td> 
						<input type="submit" name="insert" value="Insert"/>
						<input type="reset" value="Clear" />
						<input type="button" value="Cancel" onclick="window.location.href='selectObat.php'">
					</td>
				</tr>
			</table>
		</form>
   </body>
</html>