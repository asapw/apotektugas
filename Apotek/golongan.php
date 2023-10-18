<!DOCTYPE HTML>
<html>
   <head>
	  <title>Apotek-Golongan</title>
   </head>
   <body>
   <h1>Data Golongan</h1><hr/>
   <a href='index.php' style='text-decoration:none'>
		<img src='icon/back.ico' width='20' height='20' title='Back to Home' align='top'/>
		<font color='brown'>Back to Home</font></a>
		<br/><br/>
		<?php 
			//Connection
			$con = mysqli_connect("localhost","root","","apotek") or die(mysqli_error());
			
			//Main
			if (isset($_GET['aksi'])){
				switch($_GET['aksi']){
					case "edit":
						edit($con);
						view($con);
						break;
					case "hapus":
						hapus($con);
						break;
					default:
						echo "<h3>Aksi <i>".$_GET['aksi']."</i> Belum Tersedia</h3>";
						add($con);
						view($con);
				}
			}
			else{
				add($con);
				view($con);
			}
			
			//Function view (SELECT)
			function view($con){
		?>
				<br/>
				<table border="1">
					<tr>
						<th>Kode</th>
						<th>Nama</th>
						<th>Aksi</th>
					</tr>
					<?php 
						$sql = "SELECT * FROM golongan";
						$result = mysqli_query($con,$sql) or die(mysqli_error($sql));
						if(mysqli_num_rows($result)>0){
							while($data = mysqli_fetch_array($result)){	
					?>
								<tr>
									<td><?= $data['kode']; ?></td>
									<td><?= $data['nama']; ?></td>
									<td align="center"> 
										<a href="golongan.php?aksi=edit&kd=<?= $data['kode']; ?>">Update</a> |
										<a href="golongan.php?aksi=hapus&kd=<?= $data['kode']; ?>" onclick="return confirm('Yakin Hapus?')">Delete</a>
									</td>
								</tr>
					<?php 
							} 
						}
						else{
					?>
							<tr>
								<td colspan="3" align="center"><i>Data Belum Ada</i></td>
							</tr>
					<?php
						}
					?>
				</table>
		<?php
			}
			//Close Function view (SELECT)
			
			//Function add (INSERT)
			function add($con){
		?>
				<form action="" method="POST">
					<table border ="0" cellspacing="5">
						<tr>
							<td><input type="text" size="50" name="kode" placeholder="Kode" required /></td>
						</tr>
						<tr>
							<td><input type="text" size="50" name="nama" placeholder="Nama" required/></td>
						</tr>
						<tr>
							<td> 
								<input type="submit" name="insert" value="Insert"/>
								<input type="reset" value="Clear" />
							</td>
						</tr>
					</table>
				</form>
		<?php
				if(isset($_POST['insert'])){
					// menangkap data yang di kirim dari form
					$kd		= $_POST['kode'];
					$nm		= $_POST['nama'];
					
					$sql 	= "INSERT INTO golongan (kode, nama) VALUES('$kd','$nm')";
					$result = mysqli_query($con,$sql);
					if($result) {
						header('location: golongan.php');
					}
				}	
			}
			//Close Function add (INSERT)
			
			//Function edit (UPDATE)
			function edit($con){
				$kd 	= $_GET['kd'];
				$sql 	= "SELECT * FROM golongan WHERE kode='$kd'";
				$result = mysqli_query($con,$sql);
				while($data = mysqli_fetch_array($result)){
		?>
					<form action="" method="POST">
						<table border ="0" cellspacing="5">
							<tr>
								<td><input type="text" size="50" name="kode" 
									 placeholder="Kode" value="<?= $data['kode']; ?>" readonly required /></td>
							</tr>
							<tr>
								<td><input type="text" size="50" name="nama"
									 placeholder="Nama" value="<?= $data['nama']; ?>" required /></td>
							</tr>
							<tr>
								<td> 
									<input type="submit" name="update" value="Update"/>
									<input type="reset" value="Clear" />
									<input type="button" value="Cancel" onclick="window.location.href='golongan.php'">
								</td>
							</tr>
						</table>
					</form>
		<?php
				}
				
				if(isset($_POST['update'])){
					$kd		= $_POST['kode'];
					$nm		= $_POST['nama'];
					
					$sql 	= "UPDATE golongan SET nama='$nm' WHERE kode='$kd'";
					$result = mysqli_query($con,$sql);
					if($result){
						header('location: golongan.php');
					}
					else{
						echo "Query Error : ".mysqli_error($con);
					}
				}
			}
			//Close Function edit (UPDATE)
			
			//Function hapus (DELETE)
			function hapus($con){
				if(isset($_GET['kd'])){
					$kd		= $_GET['kd'];
					$sql	=  "DELETE FROM golongan WHERE kode='$kd'";
					$result = mysqli_query($con,$sql);					
					if($result){
						header('location: golongan.php');
					}
				}
			}
			//Close Function hapus (DELETE)
		?>		
   </body>
</html>