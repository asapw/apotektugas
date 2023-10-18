<!DOCTYPE HTML>
<html>
   <head>
	  <title>Apotek - Obat</title>
   </head>
   <body>
		<h1>Data Obat</h1><hr/>
		<a href='index.php' style='text-decoration:none'>
		<img src='icon/back.ico' width='20' height='20' title='Back to Home' align='top'/>
		<font color='brown'>Back to Home</font></a>
		<br/><br/>
		<a href='insertObat.php' style='text-decoration:none'>
		<img src='icon/add.ico' width='20' height='20' title='Insert' align='top'/>
		<font color='brown'>Insert</font></a>
		<br/><br/>
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
				include 'Connection.php';
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
									"<a href='updateObat.php?id=".$data['id_obat']."'>
									 <img src='icon/edit.ico' width='20' height='20' title='edit'/></a>
									 <a href='deleteObat.php?id=".$data['id_obat']."&img=".$data['image']."'>
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
   </body>
</html>