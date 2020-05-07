<?php
function ppdb_formulir($subdomain,$domain,$nisn,$uname) {
	$qsetting=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");	
	$dsetting=mysqli_fetch_array($qsetting);
	$namaweb=$dsetting['judul'];
	$qsett=mysqli_query($koneksi, "SELECT * FROM psb_setting WHERE subdomain='$subdomain'");
	$dsett=mysqli_fetch_array($qsett);
	$head1=$dsett['head1'];
	$head2=$dsett['head2'];
	$head3=$dsett['head3'];
	$alamatsek=$dsett['alamat'];
	$logo=$dsett['logo'];
	$logo2=$dsett['logo2'];
	
	$query=mysqli_query($koneksi, "SELECT * FROM psb_member WHERE nisn='$nisn' AND subdomain='$subdomain'");
	$data=mysqli_fetch_array($query);
	
	$nama=$data['nama'];
	$nik=$data['nik'];
	$nisn=$data['nisn'];
	$nis=$data['nis'];
	$agama=$data['agama'];
	$tempat_lahir=$data['tempat_lahir'];
	$tanggal_lahir=$data['tanggal_lahir'];
	list($thnlahir,$blnlahir,$tgllahir)= explode("-",$tanggal_lahir);
	$jenis_kelamin=$data['kelamin_jenis'];	if ($jenis_kelamin=="P") { $kelamin="Perempuan"; } else { $kelamin="Laki-Laki"; }
	$status_anak=$data['status_anak'];
	$anak_ke=$data['anak_ke'];
	$jumlah_saudara=$data['jumlah_saudara'];
	
	$tinggi_badan=$data['tinggi_badan'];
	$berat_badan=$data['berat_badan'];
	$cacat_badan=$data['cacat_badan'];
	$pernah_sakit=$data['pernah_sakit'];
	$nama_penyakit=$data['nama_penyakit'];
	$lama_sakit=$data['lama_sakit'];
	$tanggal_sakit=$data['tanggal_sakit'];
	
	$alamat=$data['alamat'];
	$dusun=$data['dusun'];
	$rt=$data['rt'];
	$rw=$data['rw'];
	$kelurahan=$data['kelurahan'];
	$kecamatan=$data['kecamatan'];
	$kota=$data['kota'];
	$provinsi=$data['provinsi'];
	$telepon=$data['telepon'];
	$email=$data['email'];
	$asal_sekolah=$data['asal_sekolah'];

	$nama_ayah=$data['nama_ayah'];
	$alamat_ayah=$data['alamat_ayah'];
	$usia_ayah=$data['usia_ayah'];
	$agama_ayah=$data['agama_ayah'];
	$pendidikan_ayah=$data['pendidikan_ayah'];
	$pekerjaan_ayah=$data['pekerjaan_ayah'];
	$penghasilan_ayah=$data['penghasilan_ayah'];
	
	$nama_ibu=$data['nama_ibu'];
	$alamat_ibu=$data['alamat_ibu'];
	$usia_ibu=$data['usia_ibu'];
	$agama_ibu=$data['agama_ibu'];
	$pendidikan_ibu=$data['pendidikan_ibu'];
	$pekerjaan_ibu=$data['pekerjaan_ibu'];
	$penghasilan_ibu=$data['penghasilan_ibu'];
	
	$nama_wali=$data['nama_wali'];
	$alamat_wali=$data['alamat_wali'];
	$usia_wali=$data['usia_wali'];
	$agama_wali=$data['agama_wali'];
	$pendidikan_wali=$data['pendidikan_wali'];
	$pekerjaan_wali=$data['pekerjaan_wali'];
	$penghasilan_wali=$data['penghasilan_wali'];
	
	$prestasi=$data['prestasi'];
	?>
	<center>
	<div style="width:100%; max-width:800px;">
		<div style="display:table; width:100%; text-align:center;border-bottom:3px solid #333333;font-size:15px; font-weight:bold; margin-bottom:15px; line-height:24px;">
			<img src="//<?php echo $domain."/picture/".$logo;?>" align="left" height="90" alt="Logo1"/>
			<img src="//<?php echo $domain."/picture/".$logo2;?>" align="right" height="90" alt="Logo2"/>
			<?php echo $head1;?><br/>
			<?php echo $head2;?><br/>
			<?php echo $head3;?><br/>
			<h5><i><?php echo $alamatsek;?></i></h5>
		</div>
		<h3><b><u>FORMULIR PENDAFTARAN</u></b></h3>
		<table width="100%" id="tabelcv" style="margin-top:10px;">
			<tr><td colspan="3"><b>BIODATA</b></td></tr>
			<tr><td width="190">Nama Lengkap</td><td width="20">:</td><td><?php echo $nama;?></td></tr>
			<tr><td>N I K</td><td>:</td><td><?php echo $nik;?></td></tr>
			<tr><td>N I S N</td><td>:</td><td><?php echo $nisn;?></td></tr>
			<tr><td>N I S</td><td>:</td><td><?php echo $nis;?></td></tr>
			<tr><td>Tempat, Tanggal Lahir</td><td>:</td><td><?php echo $tempat_lahir.", ".$tgllahir."-".$blnlahir."-".$thnlahir;?></td></tr>
			<tr><td>Jenis Kelamin</td><td>:</td><td><?php echo $kelamin;?></td></tr>
			<tr><td>Agama</td><td>:</td><td><?php echo $agama;?></td></tr>
			<tr><td>Status Anak</td><td>:</td><td><?php echo $status_anak;?></td></tr>
			<tr><td>Anak Ke</td><td>:</td><td><?php echo $anak_ke;?></td></tr>
			<tr><td>Jumlah Saudara</td><td>:</td><td><?php echo $jumlah_saudara;?></td></tr>
			<tr><td>Tinggi Badan</td><td>:</td><td><?php echo $tinggi_badan;?></td></tr>
			<tr><td>Berat Badan</td><td>:</td><td><?php echo $berat_badan;?></td></tr>
			<tr><td>Cacat Badan</td><td>:</td><td><?php echo $cacat_badan;?></td></tr>
			<tr><td>Pernah Sakit</td><td>:</td><td><?php echo $pernah_sakit;?></td></tr><?php
			if ($pernah_sakit=="Ya") { ?>
				<tr><td> - Nama Penyakit</td><td>:</td><td><?php echo $nama_penyakit;?></td></tr>
				<tr><td> - Tanggal Sakit</td><td>:</td><td><?php echo $tanggal_sakit;?></td></tr>
				<tr><td> - Lama Sakit</td><td>:</td><td><?php echo $lama_sakit;?></td></tr><?php
			} ?>
			<tr><td>Asal Sekolah</td><td>:</td><td><?php echo $asal_sekolah;?></td></tr>
			<tr><td colspan="3"><b>KONTAK</b></td></tr>
			<tr><td>Alamat</td><td>:</td><td><?php echo $alamat;?></td></tr>
			<tr><td>Dusun</td><td>:</td><td><?php echo $dusun;?></td></tr>
			<tr><td>RT / RW</td><td>:</td><td><?php echo $rt." / ".$rw;?></td></tr>
			<tr><td>Kelurahan</td><td>:</td><td><?php echo $kelurahan;?></td></tr>
			<tr><td>Kecamatan</td><td>:</td><td><?php echo $kecamatan;?></td></tr>
			<tr><td>Kota / Kab</td><td>:</td><td><?php echo $kota;?></td></tr>
			<tr><td>Provinsi</td><td>:</td><td><?php echo $provinsi;?></td></tr>
			<tr><td>Telepon</td><td>:</td><td><?php echo $telepon;?></td></tr>
			<tr><td>Email</td><td>:</td><td><?php echo $email;?></td></tr>
			<tr><td colspan="3"><b>ORANG TUA / WALI</b></td></tr>
			<tr><td>Nama Ayah</td><td>:</td><td><?php echo $nama_ayah;?></td></tr>
			<tr><td>- Alamat Ayah</td><td>:</td><td><?php echo $alamat_ayah;?></td></tr>
			<tr><td>- Usia Ayah</td><td>:</td><td><?php echo $usia_ayah;?> Tahun</td></tr>
			<tr><td>- Agama Ayah</td><td>:</td><td><?php echo $agama_ayah;?></td></tr>
			<tr><td>- Pendidikan Ayah</td><td>:</td><td><?php echo $pendidikan_ayah;?></td></tr>
			<tr><td>- Pekerjaan Ayah</td><td>:</td><td><?php echo $pekerjaan_ayah;?></td></tr>
			<tr><td>- Penghasilan Ayah</td><td>:</td><td>Rp. <?php echo $penghasilan_ayah;?></td></tr>
			<tr><td>Nama Ibu</td><td>:</td><td><?php echo $nama_ibu;?></td></tr>
			<tr><td>- Alamat Ibu</td><td>:</td><td><?php echo $alamat_ibu;?></td></tr>
			<tr><td>- Usia Ibu</td><td>:</td><td><?php echo $usia_ibu;?> Tahun</td></tr>
			<tr><td>- Agama Ibu</td><td>:</td><td><?php echo $agama_ibu;?></td></tr>
			<tr><td>- Pendidikan Ibu</td><td>:</td><td><?php echo $pendidikan_ibu;?></td></tr>
			<tr><td>- Pekerjaan Ibu</td><td>:</td><td><?php echo $pekerjaan_ibu;?></td></tr>
			<tr><td>- Penghasilan Ibu</td><td>:</td><td>Rp. <?php echo $penghasilan_ibu;?></td></tr>
			<tr><td>Nama Wali</td><td>:</td><td><?php echo $nama_wali;?></td></tr>
			<tr><td>- Alamat Wali</td><td>:</td><td><?php echo $alamat_wali;?></td></tr>
			<tr><td>- Usia Wali</td><td>:</td><td><?php echo $usia_wali;?> Tahun</td></tr>
			<tr><td>- Agama Wali</td><td>:</td><td><?php echo $agama_wali;?></td></tr>
			<tr><td>- Pendidikan Wali</td><td>:</td><td><?php echo $pendidikan_wali;?></td></tr>
			<tr><td>- Pekerjaan Wali</td><td>:</td><td><?php echo $pekerjaan_wali;?></td></tr>
			<tr><td>- Penghasilan Wali</td><td>:</td><td>Rp. <?php echo $penghasilan_wali;?></td></tr>
			<tr><td colspan="3"><b>PRESTASI</b></td></tr>
			<tr><td colspan="3"><?php echo $prestasi;?></td></tr>
		</table>
		<br/>
		<table width="100%" id="tabelcv" style="margin-top:10px;">
		<tr valign="top">
		<td width="60%" style="text-align:left;font-size:11px;"><i>
			Yang Bertanda tangan dibawah ini Orang Tua / Wali atau Siswa<br/>
			bertanggung jawab secara hukum terhadap kebenaran data yang tercantum.</i>
		</td>
		<td width="40%" style="text-align:right">
			...................................., ........................ <?php echo date("Y");?><br/><br/><br/><br/>(..........................................)
		</td>
	</div>
	</center><?php	
}
?>