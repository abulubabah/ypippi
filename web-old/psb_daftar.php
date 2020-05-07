<?php

if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="publik"){
		if (empty($_POST['proses'])){?>
			<h3>Form Pendaftaran</h3>
			<form action="" method="post" id="form1" autocomplete="off">
				<input type="hidden" name="proses" value="simpan">
				<div id="view"><div class="view_label">Nama Lengkap</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nama" id="nama" style="width:94%; max-width:400px;" maxlength="50"></div></div>
				<div id="view"><div class="view_label">Alamat</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="alamat" id="alamat" style="width:94%; max-width:400px;" maxlength="150"></div></div>					
				<div id="view"><div class="view_label">No. Telp  /HP</div><div class="view_dot">:</div><div class="view_content"><input type="number" required="required" name="telepon" id="telepon" style="width:94%; max-width:400px;" maxlength="15"></div></div>
				<div id="view"><div class="view_label">Nisn</div><div class="view_dot">:</div><div class="view_content"><input type="number" placeholder="Teliti Nisn Tidak Bisa Diganti !" required="required" name="nisn" id="nisn" style="width:94%; max-width:400px;" maxlength="15"></div></div>
				<div id="view"><div class="view_label">Email</div><div class="view_dot">:</div><div class="view_content"><input type="email"  name="email" id="email" placeholder="Jika Ada" style="width:94%; max-width:400px;" maxlength="50"></div></div>
				<div id="view"><div class="view_label">Password</div><div class="view_dot">:</div><div class="view_content"><input type="password" required="required" name="password" id="password" style="width:94%; max-width:400px;" maxlength="50"></div></div>				
				<div id="view"><div class="view_label">&nbsp;</div><div class="view_dot">&nbsp;</div><div class="view_content"><input type="submit" value="DAFTAR" id="submit"  class="button"></div></div>
			</form><?php 
			$kode=rand(9079878,834756348);
			$_SESSION['kode']=$kode;
			}
			elseif($_POST['proses']=="simpan"){
				if (!empty($_SESSION['kode'])){
					$nama=mysql_escape_string(strip_tags($_POST['nama']));
					$nisn=mysql_escape_string(strip_tags($_POST['nisn']));
					$alamat=mysql_escape_string(strip_tags($_POST['alamat']));
					$telepon=mysql_escape_string(strip_tags($_POST['telepon']));
					$email=mysql_escape_string(strip_tags($_POST['email']));
					$password=mysql_escape_string(strip_tags($_POST['password']));
					$link=str_replace(' ','-',$nama);
					$passwordbaru=md5($password);
					$qcekemail=mysqli_query($koneksi, "select email,nisn from psb_member where nisn='$nisn' AND subdomain='$subdomain'");
					if (mysqli_num_rows($qcekemail)<1){
						$berhasil=mysqli_query($koneksi, "INSERT INTO psb_member (subdomain,link,nama,nisn,alamat,telepon,email,password,tgl)VALUES('$subdomain','$link','$nama','$nisn','$alamat','$telepon','$email','$passwordbaru',now())");
						if ($berhasil){
							if ($email!=""){
									include ("$folder/function/class.phpmailer.php");
									$isi='<html>' .
													' <head></head>' .
													' <body>' .
													' <label><img src=//'.$domain.'/picture/'.$logo.' alt=logo></label>
													<br /><br>
													Salam,'.$nama.'
													<br />
													Pendaftaran Berhasil Username = '.$email.' Password = '.$password.'
													<br />
													Demikian informasi mengenai Pendaftaran Anda.<br>
													Informasi lebih lanjut mengenai layanan '.$subdomain.', silahkan menghubungi Customer Service kami.<br>
													Semoga kesuksesan senantiasa menyertai daya upaya kita bersama.<br>
													Best Regards<br/>
													'.$subdomain.' </body>' .
													'</html>';	
									$mail = new PHPMailer();
									$body             = "$isi"; //isi dari email
									          
									$mail->SetFrom($smtp_emailsistem, "$subdomain"); 
									$mail->Subject    = "Register";
									$mail->MsgHTML($body);
									$address = "$email";
									$address2= $smtp_emailsistem;
									$mail->AddAddress($address, "Peserta");
									$mail->addReplyTo($address2,"$subdomain");
									if(!$mail->Send()) {
										echo "Mailer Error: " . $mail->ErrorInfo; 
									} else {
										//echo "Sukses";
										//jika pesan terkirim
									}
							}
							
						
						$_SESSION['nama']=$nama;
						$_SESSION['uname']=$email;
						$_SESSION['nisn']=$nisn;
						$_SESSION['pword']=$passwordbaru;
						$_SESSION['subdomain']=$subdomain;
					echo "<script>document.location='//$linksub';</script>";
						}
						
					}
					else {?>
					<h3> Data Tersebut Sudah Ada</h3>
					<input type="button" name="back" value="KEMBALI" onclick="history.go(-1);" class="button_back"/><?php
					}
					
				}
				
			}
	}
	else {
		header("location:index.php"); 
	}
}
else {
	header("location:index.php"); 
}
?>