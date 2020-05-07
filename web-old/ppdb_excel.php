<?php
session_start ();
$folder="cms";
$subdomain="www.ypippijkt.localhost";
include ("$folder/conn.php");
header("Content-type:application/vnd.ms-excel");
header("Content-disposition:attachment; filename=\"calon-siswa.xls\""); 
header("Pragma:no-cache");
header("Cache-Control:must-revalidate, post-check=\"0\", pre-check=\"0\"");
header("Expires:0");
?>
<h2>Daftar Calon Siswa</h2>
<table width="100%" border="1">
<tr>
	<th>No</th>
	<th>Nama</th>
	<th>NISN</th>
	<th>Asal Sekolah</th>
	<th>TTL</th>
	<th>Kelamin</th>
	<th>Agama</th>
	<th>Status Anak</th>
	<th>Anak Ke</th>
	<th>Jum Saudara</th>
	<th>Tinggi Badan</th>
	<th>Berat Badan</th>
	<th>Cacat Badan</th>
	<th>Alamat</th>
	<th>Kecamatan</th>
	<th>Kab / Kota</th>
	<th>Provinsi</th>
	<th>Telepon</th>
	<th>No. HP</th>	
	<th>Nama Ayah</th>
	<th>Alamat Ayah</th>
	<th>Usia Ayah</th>
	<th>Agama Ayah</th>
	<th>Pendidikan Ayah</th>
	<th>Pekerjaan Ayah</th>
	<th>Penghasilan Ayah</th>
	<th>Nama Ibu</th>
	<th>Alamat Ibu</th>
	<th>Usia Ibu</th>
	<th>Agama Ibu</th>
	<th>Pendidikan Ibu</th>
	<th>Pekerjaan Ibu</th>
	<th>Penghasilan Ibu</th>
	<th>Nama Wali</th>
	<th>Alamat Wali</th>
	<th>Usia Wali</th>
	<th>Agama Wali</th>
	<th>Pendidikan Wali</th>
	<th>Pekerjaan Wali</th>
	<th>Penghasilan Wali</th>
	<th>NILAI UN</th>
</tr><?php 
$nomor=1;
$query=mysqli_query($koneksi, "SELECT * FROM psb_member WHERE subdomain='$subdomain' ORDER BY nilai_un DESC");
while($data=mysqli_fetch_array($query)){ 
	$nama=$data['nama'];?>
	<tr>
		<td><?php echo $nomor;?></td>
		<td><?php echo $data['nama'];?></td>
		<td><?php echo $data['nisn'];?></td>
		<td><?php echo $data['asal_sekolah'];?></td>
		<td><?php echo $data['tempat_lahir'].", ".$data['tanggal_lahir'];?></td>
		<td><?php echo $data['kelamin_jenis'];?></td>
		<td><?php echo $data['agama'];?></td>
		<td><?php echo $data['status_anak'];?></td>
		<td><?php echo $data['anak_ke'];?></td>
		<td><?php echo $data['jumlah_saudara'];?></td>
		<td><?php echo $data['tinggi_badan'];?></td>
		<td><?php echo $data['berat_badan'];?></td>
		<td><?php echo $data['cacat_badan'];?></td>
		<td><?php echo $data['alamat']." ".$data['dusun']." RT:".$data['rt']." RW".$data['rw'].", ".$data['kelurahan'];?></td>
		<td><?php echo $data['kecamatan'];?></td>
		<td><?php echo $data['kota'];?></td>
		<td><?php echo $data['provinsi'];?></td>
		<td><?php echo $data['telepon'];?></td>
		<td><?php echo $data['handphone'];?></td>
		<td><?php echo $data['nama_ayah'];?></td>
		<td><?php echo $data['alamat_ayah'];?></td>
		<td><?php echo $data['usia_ayah'];?></td>
		<td><?php echo $data['agama_ayah'];?></td>
		<td><?php echo $data['pendidikan_ayah'];?></td>
		<td><?php echo $data['pekerjaan_ayah'];?></td>
		<td><?php echo $data['penghasilan_ayah'];?></td>
		<td><?php echo $data['nama_ibu'];?></td>
		<td><?php echo $data['alamat_ibu'];?></td>
		<td><?php echo $data['usia_ibu'];?></td>
		<td><?php echo $data['agama_ibu'];?></td>
		<td><?php echo $data['pendidikan_ibu'];?></td>
		<td><?php echo $data['pekerjaan_ibu'];?></td>
		<td><?php echo $data['penghasilan_ibu'];?></td>
		<td><?php echo $data['nama_wali'];?></td>
		<td><?php echo $data['alamat_wali'];?></td>
		<td><?php echo $data['usia_wali'];?></td>
		<td><?php echo $data['agama_wali'];?></td>
		<td><?php echo $data['pendidikan_wali'];?></td>
		<td><?php echo $data['pekerjaan_wali'];?></td>
		<td><?php echo $data['penghasilan_wali'];?></td>
		<td><?php echo $data['nilai_un'];?></td>
	</tr><?php
	$nomor++;
} ?>
</table>