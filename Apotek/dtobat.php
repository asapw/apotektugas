<!DOCTYPE HTML>
<html>
   <head>
	  <title>Apotek-Sediaan</title>
   </head>
   <body>
   <h1>Data Sediaan</h1><hr/>
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
					<th>Nama</th>
					<th>Image</th>
					<th>Golongan</th>
					<th>Obat</th>
					<th>Harga</th>
					<th>Expire Date</th>
					<th>Aksi</th>
				</tr>
				<?php
					$sql = "SELECT * FROM dtobat";
					$result = mysqli_query($con,$sql) or die(mysqli_error($sql));
					if(mysqli_num_rows($result)>0){
						while($data = mysqli_fetch_array($result)){	
				?>
							<tr>
								<td><?= $data['nama_obat']; ?></td>
								<td><?= "<img src='image/".$data['image']."' width='100' height='100' title='".$data['nama_obat']."'/>"; ?></td>
								<td><?= $data['kd_golongan']; ?></td>
								<td><?= $data['kd_sediaan']; ?></td>
								<td><?= $data['harga']; ?></td>
								<td><?= date("d M Y",strtotime($data['expire_date'])); ?></td>
								<td align="center"> 
									<?=
										"<a href='dtobat.php?id=".$data['id_obat']."'>
										<img src='icon/edit.ico' width='20' height='20' title='edit'/></a>
										<a href='dtobat.php?id=".$data['id_obat']."&img=".$data['image']."'>
										<img src='icon/delete.ico' width='20' height='20' title='delete'/></a>";
									?>
								</td>
							</tr>
					<?php 
							} 
						}
						else{
					?>
							<tr>
								<td colspan="7" align="center"><i>Data Belum Ada</i></td>
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
			<form action="" method="POST" enctype="multipart/form-data">
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
								include 'connection.php';
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
							<input type="button" value="Cancel" onclick="window.location.href='dtobat.php'">
						</td>
					</tr>
				</table>
			</form>
		<?php
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
						header("location:dtobat.php");
					}
					else{
						echo "Query Error : ".mysqli_error($con);
					}
				}
				else{
					echo "<b>Anda harus mengakses dari <a href='dtobat.php'>Form Insert</a></b>";
				}
			}
		
			//Close Function add (INSERT)
			
			//Function edit (UPDATE)
			function edit($con){
				$id 	= $_GET['id'];
				$sql 	= "SELECT * FROM dtobat WHERE id_obat='$id'";
				$result = mysqli_query($con,$sql);
				while($data = mysqli_fetch_array($result)){
			?>
				<form action="" method="POST" enctype="multipart/form-data">
					<table border ="0" cellspacing="5">
						<tr>
							<td><input type="hidden" name="id" value="<?= $id ?>"></td>
						</tr>
						<tr>
							<td><input type="hidden" name="old" value="<?= $data['image']; ?>"/></td>
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
								<input type="button" value="Cancel" onclick="window.location.href='dtobat.php'">
							</td>
						</tr>
					</table>
				</form>
		<?php
				}
				
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
						header("location:dtobat.php");
					}
					else{
						echo"Error updating record" . mysqli_error($con);
			}
			}
			//Close Function edit (UPDATE)
			
			//Function hapus (DELETE)
			function hapus($con){
				if(isset($_GET['id'])){
					$id		= $_GET['id'];
					$img 	= $_GET['img'];
					unlink('image/'.$img);
					$sql	=  "DELETE FROM dtobat WHERE id_obat='$id'";
					$result = mysqli_query($con,$sql);				
					if($result){
						header('location: dtobat.php');
					}
				}
			}
			//Close Function hapus (DELETE)
		}
		?>		
   </body>
</html>