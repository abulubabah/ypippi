<style type="text/css">
#home { display:table; width:100%; }
.home_part  { display:table; float:left; width:48%; padding-right:1%; vertical-align:top; text-align:left;  }
@media only screen and (max-width:768px) {
	.home_part { float:none; width:100%; padding:0%; margin-bottom:10px; }
}
</style>
<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="publik"){  		
		$qsamb=mysqli_query($koneksi, "SELECT * FROM simpen_sambutan WHERE publish='1' AND subdomain='$subdomain' ORDER BY tgl DESC");
		$dsamb=mysqli_fetch_array($qsamb);
		$isisambutan=$dsamb['isi']; 
		$gambarsambutan=$dsamb['gambar'];?>		
		<h2>Sistem Informasi Pengumuman Online</h2>
		<div id="home">
			<div class="home_part">
				<img src="//<?php echo $domain."/picture/".$gambarsambutan;?>" alt="sambutan" class="gambarmember" align="left"><?php 
				echo $isisambutan;?>
			</div>
			<div class="home_part" style="text-align:center;background:#EAEAEA; border:2px solid #AAAAAA;padding:2% 0%;">
			<?php
				date_default_timezone_set('Asia/Jakarta'); $kodewaktu="WIB";
				//date_default_timezone_set('Asia/Brunei'); $kodewaktu="WITA";
				//date_default_timezone_set('Asia/Jayapura'); $kodewaktu="WIT";
				$qsetsim=mysqli_query($koneksi, "SELECT *,
					DATE_FORMAT(tanggal_buka,'%d') as tgl_buka, DATE_FORMAT(tanggal_buka,'%m') as bln_buka, DATE_FORMAT(tanggal_buka,'%Y') as thn_buka,
					TIME_FORMAT(jam_buka,'%H') as jam_buka, TIME_FORMAT(jam_buka,'%i') as mnt_buka, TIME_FORMAT(jam_buka,'%s') as dtk_buka
					FROM simpen_setting WHERE subdomain='$subdomain'");
				$dsetsim=mysqli_fetch_array($qsetsim);
				$tgl_buka=$dsetsim['tgl_buka'];  $bln_buka=$dsetsim['bln_buka']; $thn_buka=$dsetsim['thn_buka'];			
				$jam_buka=$dsetsim['jam_buka'];
				$mnt_buka=$dsetsim['mnt_buka'];
				$dtk_buka=$dsetsim['dtk_buka'];
				//format bulan javascript di kurangi satu
				if ($bln_buka==1){
					$bln_javascript_jadi=0;
				} else if ($bln_buka==2){
					$bln_javascript_jadi=1;
				} else if ($bln_buka==3){
					$bln_javascript_jadi=2;
				} else if ($bln_buka==4){
					$bln_javascript_jadi=3;
				} else if ($bln_buka==5){
					$bln_javascript_jadi=4;
				} else if ($bln_buka==6){
					$bln_javascript_jadi=5;
				} else if ($bln_buka==7){
					$bln_javascript_jadi=6;
				} else if ($bln_buka==8){
					$bln_javascript_jadi=7;
				} else if ($bln_buka==9){
					$bln_javascript_jadi=8;
				} else if ($bln_buka==10){
					$bln_javascript_jadi=9;
				} else if ($bln_buka==11){
					$bln_javascript_jadi=10;
				} else if ($bln_buka==12){
					$bln_javascript_jadi=11;
				} else {
					$bln_javascript_jadi=0;
				}
				?>
				<script>
				$(function(){
					var note = $('#note'),
					ts = new Date("<?php echo $thn_buka;?>", "<?php echo $bln_javascript_jadi;?>", "<?php echo $tgl_buka;?>","<?php echo $jam_buka;?>","<?php echo $mnt_buka;?>","<?php echo $dtk_buka;?>");
					$('#countdown').countdown({
						timestamp	: ts,
						callback	: function(days, hours, minutes, seconds){
							
							var message = "Tersisa ";
							
							message += days + " Hari" + ", ";
							message += hours + " Jam" +", ";
							message += minutes + " Menit" +  " Dan ";
							message += seconds + " Detik" +  " <br />";
							
							message += "Untuk Dapat Login!";
							if ((hours==0) && (days==0) && (minutes==0) && (seconds==0)){
								$("#timer").hide();
								$("#formlogin").show();
							}
							else{
								$("#timer").show();
								$("#formlogin").hide();
							}
							note.html(message);
						}
					});
					
				});
				</script>
				<div id="timer">
				<h3><b>LOGIN SISWA</b></h3>
				<br/>
				<div id="countdown"></div>
				<br/>
				<div id="note"></div></div>
				<div id="formlogin">
					<h3><b>LOGIN SISWA</b></h3>
					Untuk melihat hasil ujian nasional<br/>Silahkan login dengan menggunakan NISN Anda<br/>					
					<form action="" method="post" id="form1" autocomplete="off">
						<input type="hidden" name="proses" value="simpan">
						<b>Username</b><br/><input type="text" required="required" placeholder="NISN Anda" name="username" id="username" style="width:94%; max-width:200px;margin-bottom:10px;text-align:center;border:1px solid #AAAAAA;" maxlength="50"><br/>
						<b>Password</b><br/><input type="password" required="required" placeholder="Contoh : 30-12-2001" name="password" id="password" style="width:94%; max-width:200px;margin-bottom:10px;text-align:center;border:1px solid #AAAAAA;" maxlength="50"><br/><span style="font-size:12px;">Format : Tanggal-Bulan-Tahun</span><br/>
						<input type="submit" value="LOGIN" id="submit"  class="button">
					</form><?php
					if (empty($_POST['proses'])){  }
					elseif($_POST['proses']=="simpan"){
						if (empty($_POST['username']) or empty($_POST['password'])) { ?><script type="text/javascript"> alert('Silahkan Login Terlebih Dahulu!');</script><?php  } 
						else {	
							$uname=strip_tags($_POST['username']); $uname=str_replace('"','',$uname); $uname=str_replace("'","",$uname);
							$pword=strip_tags($_POST['password']); $pword=str_replace('"','',$pword); $pword=str_replace("'","",$pword);
							$pass=explode("-",$pword);
							$password=$pass[2]."-".$pass[1]."-".$pass[0];
							$login=sprintf("SELECT no,nama,nisn,tanggal_lahir FROM simpen_siswa WHERE nisn='$uname' AND tanggal_lahir='$password' AND subdomain='$subdomain' AND publish='1'", mysqli_real_escape_string($uname), mysqli_real_escape_string($pass));
							$query=mysqli_query($koneksi, $login);
							$jumlah=mysqli_num_rows($query);
							$data=mysqli_fetch_array($query);
							$no=$data['no'];
							$nama=$data['nama'];
							$username=$data['nisn'];
							$password=$data['tanggal_lahir'];
							if ($jumlah==1) {
								$_SESSION['nama']=$nama;
								$_SESSION['uname']=$username;
								$_SESSION['pword']=$password;
								$_SESSION['kat']="siswa";
								$ipaddress=$_SERVER['REMOTE_ADDR']; ?>
								<meta http-equiv="refresh" content="0; url=//<?php echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"><?php
							}
							else { ?><script type="text/javascript"> alert('Username dan Password Salah !');</script><?php }
						}
					} 
				?>
				</div>
			</div>
		</div><?php 					
	}
	elseif($akses=="member"){ 
		$nisn=$_SESSION['uname'];
		$query=mysqli_query($koneksi, "SELECT * FROM simpen_siswa WHERE nisn='$nisn' AND subdomain='$subdomain'");
		$data=mysqli_fetch_array($query);
		$nama=$data['nama'];
		$nisn=$data['nisn'];
		$nomor_ujian=$data['nomor_ujian'];
		$jenis_kelamin=$data['jenis_kelamin'];	if ($jenis_kelamin=="P") { $kelamin="Perempuan"; } else { $kelamin="Laki-Laki"; }
		$kelas=$data['kelas'];
		$jurusan=$data['jurusan']; 
		?>
		<h2 style="text-transform:capitalize">Selamat Datang <?php echo $nama;?></h2>
		Silahkan gunakan layanan yang ada pada area ini dengan meng-klik tombol menu pada bagian atas halaman ini.<br/>
		Berikut adalah data profil Anda :<br/>
		<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
			<tr><td width="100">Nama</td><td width="10">:</td><td><?php echo $nama;?></td></tr>
			<tr><td>No. Peserta</td><td>:</td><td><?php echo $nomor_ujian;?></td></tr>
			<tr><td>Jenis Kelamin</td><td>:</td><td><?php echo $kelamin;?></td></tr>
			<tr><td>Kelas</td><td>:</td><td><?php echo $kelas;?></td></tr>
			<tr><td>Jurusan</td><td>:</td><td><?php echo $jurusan;?></td></tr>
		</table>
		Jangan lupa untuk selalu <b>Keluar</b> setelah Anda selesai menggunakan fasilitas ini.<br/>
		<?php
	}
	else {
		header("location:index.php"); 
	}
}
else {
	header("location:index.php"); 
}
?>