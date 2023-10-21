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

    <title>Apotek-Golongan</title>
  </head>
  <body>
    
    <!-- Header Start -->
    <?php
      require 'Require/Header.php';
    ?>
    <!-- Header End -->


    <h1 align=center style="margin-top:30px;">Data Golongan</h1>
		<br/>
		<?php 
			//Connection
			$con = mysqli_connect("localhost","root","","apotek");
			
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
				<table border="2" class="table table-bordered w-75 align-middle" style="margin-left: auto; margin-right:auto; margin-bottom:50px; margin-top:30px; text-align:center;">
					<tr>
						<th class="table-active">Kode</th>
						<th class="table-active">Nama</th>
						<th class="table-active w-25">Aksi</th>
					</tr>
					<?php 
						$sql = "SELECT * FROM golongan";
						$result = mysqli_query($con,$sql);
						if(mysqli_num_rows($result)>0){
							while($data = mysqli_fetch_array($result)){	
					?>
								<tr>
									<td><?= $data['kode']; ?></td>
									<td><?= $data['nama']; ?></td>
									<td align="center"> 
										<a href="golongan.php?aksi=edit&kd=<?= $data['kode']; ?>"><img src="icon/edit.ico" width=10% alt="edit" border="0" /></a> |
										<a href="golongan.php?aksi=hapus&kd=<?= $data['kode']; ?>" onclick="return confirm('Yakin Hapus?')"><img src="icon/delete.ico" width=10% alt="delete" border="0" /></a>
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
					<table border ="0" cellspacing="" class="container">
						<tr>
							<td><input 	type="text" 
										size="30" 
										name="kode" 
										placeholder="Kode" 
										required
										class="mb-3
											   custom-Input
										"/></td>
						</tr>
						<tr>
							<td><input 	type="text" 
										size="30" 
										name="nama" 
										placeholder="Nama" 
										required
										class="mb-3
											   custom-Input
										"/></td>
						</tr>
						<tr>
							<td> 
								<input class="btn custom-btn me-4" type="submit" name="insert" value="Insert" />
								<input class="btn btn-outline-danger" type="reset" value="Clear" />
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
						<table border ="0" cellspacing="5"class="container">
							<tr>
								<td><input type="text" 
										   size="50" 
										   name="kode" 
									 	   placeholder="Kode" 
										   value="<?= $data['kode']; ?>" 
										   readonly 
										   class="mb-3
										   		  custom-Input
										   " /></td>
							</tr>
							<tr>
								<td><input type="text" 
										   size="50" 
										   name="nama"
									 	   placeholder="Nama" 
										   value="<?= $data['nama']; ?>" 
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
										   class="btn custom-btn me-4
										   "/>
									<input type="reset" 
										   value="Clear"
										   class="btn custom-btn me-4
										   "/>
									<input type="button" 
										   value="Cancel" 
										   onclick="window.location.href='golongan.php'"
										   class="btn btn-outline-danger
										   "/>
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