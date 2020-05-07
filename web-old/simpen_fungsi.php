<?php
function simpen_hasil($subdomain,$domain,$nisn,$uname) {
	$qsetting=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");	
	$dsetting=mysqli_fetch_array($qsetting);
	$namaweb=$dsetting['judul'];
	$qsett=mysqli_query($koneksi, "SELECT * FROM simpen_setting WHERE subdomain='$subdomain'");
	$dsett=mysqli_fetch_array($qsett);
	$head1=$dsett['head1'];
	$head2=$dsett['head2'];
	$head3=$dsett['head3'];
	$alamat=$dsett['alamat'];
	$tingkat=$dsett['tingkat'];
	$tahun_ajaran=$dsett['tahun_ajaran'];
	$logo=$dsett['logo'];
	$logo2=$dsett['logo2'];		
	$tempat_keputusan=$dsett['tempat_keputusan'];
	$tanggal_keputusan=$dsett['tanggal_keputusan'];
	$nama_kepsek=$dsett['nama_kepsek'];
	$nip_kepsek=$dsett['nip_kepsek'];
	$ttd_kepsek=$dsett['ttd_kepsek'];
	$stempel=$dsett['stempel'];	
	$query=mysqli_query($koneksi, "SELECT * FROM simpen_siswa WHERE nisn='$nisn' AND subdomain='$subdomain'");
	$data=mysqli_fetch_array($query);
	$nama=$data['nama'];
	$nis = $data['nis'];
	$nisn=$data['nisn'];
	$nomor_ujian=$data['nomor_ujian'];
	$jenis_kelamin=$data['jenis_kelamin'];	if ($jenis_kelamin=="P") { $kelamin="Perempuan"; } else { $kelamin="Laki-Laki"; }
	$kelas=$data['kelas'];
	$jurusan=$data['jurusan'];
	$tanggal_lahir = $data['tanggal_lahir'];
	$tempat_lahir = $data['tempat_lahir'];
	$nama_orang_tua = $data['nama_orang_tua'];
	$pengembangan_pembiasaan = $data['pengembangan_pembiasaan'];
	$pengembangan_kemampuan_dasar = $data['pengembangan_kemampuan_dasar'];
	$pendidikan_religiositas = $data['pendidikan_religiositas'];
	$nilai_periodik_dalam_angka = $data['nilai_periodik_dalam_angka'];
	$nilai_periodik_dalam_huruf = $data['nilai_periodik_dalam_huruf'];
	$nilai_akhir_siswa = $data['nilai_akhir_siswa'];
	$keputusan=$data['keputusan'];
	?>
	<center>
	<div style="width:100%; max-width:800px;">
		<div style="display:table; width:100%; text-align:center;border-bottom:3px solid #333333;font-size:15px; font-weight:bold; line-height:22px;">
			<img src="//<?php echo $domain."/picture/".$logo;?>" align="left" height="90" alt="Logo1"/>
			<img src="//<?php echo $domain."/picture/".$logo2;?>" align="right" height="90" alt="Logo2"/>
			<?php echo $head1;?><br/>
			<?php echo $head2;?><br/>
			<?php echo $head3;?><br/>
			<h5><i><?php echo $alamat;?></i></h5>
		</div>
		<br/>
		<h3><b><u>KETERANGAN TAMAT BELAJAR <br> TAMAN KANAK-KANAK</u></b></h3>
		<br/>
		<div style="text-align:left;">
			Yang bertanda tangan dibawah ini Kepala Taman Kanak-Kanak Boncel menerangkan peserta didik yang bernama:
			<div style="display: block; margin: 6px auto; text-transform: uppercase; font-weight: 700; font-size: 24px"><?php echo $nama;?></div><br>
			Lahir pada tanggal: <?php echo $tanggal_lahir;?> di <?php echo $tempat_lahir;?> anak dari Bapak/Ibu <?php echo $nama_orang_tua;?> telah mengikuti pendidikan sampai akhir Tingkat B di TKK Boncel dengan nomor daftar induk <?php echo $nis;?>. <br>
			Dengan hasil sebagai berikut:
			<ol>
			    <li>
			        <strong style="text-transform: uppercase;">Bidang Pengembangan Pembiasaan</strong>
			        <p><?php echo $pengembangan_pembiasaan;?></p>
			    </li>
			    <li>
			        <strong style="text-transform: uppercase;">Bidang Pengembangan Kemampuan Dasar</strong>
			        <p><?php echo $pengembangan_kemampuan_dasar;?></p>
			    </li>
			    <li>
			        <strong>Pendidikan Religiositas</strong>
			        <p><?php echo $pendidikan_religiositas;?></p>
			    </li>
			</ol>
			<ul>
			    <li>Nilai Periodik Dalam Angka: <?php echo $nilai_periodik_dalam_angka;?></li>
			    <li>Nilai Dalam Huruf: <?php echo $nilai_periodik_dalam_huruf;?></li>
			    <li>Nilai Akhir: <?php echo $nilai_akhir_siswa?></li>
			</ul>
		</div>
		<br/>
		<div style="float:left; width:60%; display:table; text-align:right;">
		<br/><br/><img src="//<?php echo $domain."/picture/".$stempel;?>" align="right" height="100" alt=""/>
		</div>
		<div style="float:left; width:40%; display:table; text-align:left;">
			<?php echo $tempat_keputusan.", ".$tanggal_keputusan;?><br/>
			Kepala Sekolah,<br/>
			<img src="//<?php echo $domain."/picture/".$ttd_kepsek;?>" height="80" alt=""/><br/>
			<b><u><?php echo $nama_kepsek;?></u><br/>NIP. <?php echo $nip_kepsek;?></b>
		</div>
		<br/>
	</div>
	</center><?php	
}
?>