<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Apotek-DataObat</title>
  </head>
  <body>
    
    <!-- Header Start -->
    <?php
      require 'Require/Header.php';
    ?>
    <!-- Header End -->

    <h1 align=center style="margin-top:30px;">Data Obat</h1>
		<br/>
		<?php 
			//Connection
			$con = mysqli_connect("localhost","root","","apotek");
			//hapus function
			
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
				<table border="2" class="table table-bordered w-75 align-middle" style="margin-left: auto; margin-right:auto; margin-bottom:50px; margin-top:30px; text-align:center;" >
					<tr>
					<th class="table-active">Nama</th>
					<th class="table-active">Image</th>
					<th class="table-active">Golongan</th>
					<th class="table-active">Obat</th>
					<th class="table-active">Harga</th>
					<th class="table-active">Expire Date</th>
					<th class="table-active w-25">Aksi</th>
				</tr>
				<?php
					$sql = "SELECT * FROM dtobat";
					$result = mysqli_query($con,$sql);
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
								<td> 
								<a href="dtobat.php?aksi=edit&id=<?= $data['id_obat']; ?>"><img src="icon/edit.ico" width=10% alt="edit" border="0" /></a> |
								<a href="dtobat.php?aksi=hapus&id=<?= $data['id_obat']; ?>&img=<?= $data['image']; ?>" onclick="return confirm('Yakin Hapus?')"><img src="icon/delete.ico" width=10% alt="delete" border="0" /></a>
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
				<table border ="0" cellspacing="5" class="container">
					<tr>
						<td><input type="file" 
								   accept=".png, .jpg, .jpeg, .jfif, .gif" 
								   name="foto"  
								   required 
								   class="mb-3
								   		  custom-Input
								   "/></td>
					</tr>
					<tr>
						<td><input type="text" 
								   name="nama" 
								   placeholder="Nama"  
								   required 
								   class="mb-3
								   		  custom-Input
								   "/></td>
					</tr>
					<tr>
						<td>
							<select name="kd_gol" class="mb-3 custom-Input">
							<?php 
								include 'connection.php';
								$sql = "SELECT * FROM golongan";
								$result = mysqli_query($con,$sql);
								while($data = mysqli_fetch_array($result)){	
							?>
							    <option value="<?= $data['kode']; ?>">
											   <?= $data['kode']." - ".$data['nama']; ?></option>	
							<?php
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<select name="kd_sed" class="mb-3 custom-Input">
							<?php 
								include 'connection.php';
								$sql = "SELECT * FROM sediaan";
								$result = mysqli_query($con,$sql);
								while($data = mysqli_fetch_array($result)){	
							?>
							    <option value="<?= $data['kode']; ?>">
											   <?= $data['kode']." - ".$data['nama']; ?></option>
							<?php
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td><input type="number" 
								   name="harga" 
								   min="0" 
								   placeholder="Harga" 
								   required
								   class="mb-3
								   		  custom-Input
								   "/></td>
					</tr>
					<tr>
						<td><input type="date" 
								   name="expire" 
								   required
								   class="mb-3
								   		  custom-Input
								   "/></td>
					</tr>
					<tr>
						<td> 
							<input type="submit" 
								   name="insert" 
								   value="Insert" 
								   class="btn custom-btn me-4"/>
							<input type="reset" 
								   value="Clear"
								   class="btn custom-btn me-4"/>
							<input type="button" 
								   value="Cancel" 
								   onclick="window.location.href='dtobat.php'"
								   class="btn btn-outline-danger">
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
					<table border ="0" cellspacing="5" class="container">
						<tr>
							<td><input type="hidden" 
									   name="id" 
									   value="<?= $id ?>"></td>
						</tr>
						<tr>
							<td><input type="hidden" 
									   name="old"
									   value="<?= $data['image']; ?>"/></td>
						</tr>
						<tr>
							<td><?= "<img src='image/".$data['image']."' width='100' height='100' title='".$data['nama_obat']."'/>"; ?></td>
						</tr>
						<tr>
							<td><input type="file" 
									   accept=".png, .jpg, .jpeg, .jfif, .gif" 
									   name="foto" 
									   class="mb-3
									   		  custom-Input
									   "/></td>
						</tr>
						<tr>
							<td><input type="text"
									   name="nama" 
								       placeholder="Nama" 
									   value="<?= $data['nama_obat']; ?>" 
									   required 
									   class="mb-3
									   		  custom-Input
									   "/></td>
						</tr>
						<tr>
							<td>
								<select name="kd_gol" class="mb-3 custom-Input">
								<?php 
									include 'connection.php';
									$sql1 = "SELECT * FROM golongan";
									$result1 = mysqli_query($con,$sql1);
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
								<select name="kd_sed" class="mb-3 custom-Input">
								<?php 
									include 'connection.php';
									$sql1 = "SELECT * FROM sediaan";
									$result1 = mysqli_query($con,$sql1);
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
							<td><input type="number" 
									   name="harga" 
									   min="0" 
								 	   placeholder="Harga" 
									   value="<?= $data['harga']; ?>" 
									   required 
									   class="mb-3 
									  		  custom-Input
										"/></td>
						</tr>
						<tr>
							<td><input type="date" 
									   name="expire"
									   value="<?= $data['expire_date']; ?>" 
									   required
									   class="mb-3 
									  		  custom-Input
										"/></td>
						</tr>
						<tr>
							<td> 
								<input type="submit" 
									   name="update" 
									   value="Update"
									   class="btn custom-btn me-4"/>
								<input type="reset"
								       value="Clear"
									   class="btn custom-btn me-4"/>
								<input type="button" 
									   value="Cancel" 
									   onclick="window.location.href='dtobat.php'"
									   class="btn btn-outline-danger"/>
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
			}
			//Close Function edit (UPDATE)
			
			
		}
		//Function hapus (DELETE)
		function hapus($con){
			
			$id		= $_GET['id'];
			$img 	= $_GET['img'];
			unlink('image/'.$img);
			$sql	=  "DELETE FROM dtobat WHERE id_obat='$id'";
			$result = mysqli_query($con,$sql);

			if($result) {
				header("location:dtobat.php");
				
			}
			else{
				echo "Query Error : ".mysqli_error($con);
			
		}
	}
		//Close Function hapus (DELETE)
		?>

    <!-- Footer Start -->
    <?php
    require 'Require/Footer.php';
    ?>
    <!-- Footer End -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>