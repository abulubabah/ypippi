<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="publik"){  
		if (empty($_POST['proses']) && empty($_SESSION['uname'])){?>
		<h3>Form Reset</h3>
			<form action="" method="post" id="form1" autocomplete="off">
				<div id="view"><div class="view_label">Email</div><div class="view_dot">:</div><div class="view_content"><input type="email" required="required" name="email" id="email" style="width:94%; max-width:400px;" maxlength="50"></div></div>
				<input type="hidden" name="proses" value="simpan">
				<div id="view"><div class="view_label">&nbsp;</div><div class="view_dot">&nbsp;</div><div class="view_content"><input type="submit" value="Reset" id="submit"  class="button_add"></div></div>
			</form><?php 
			}
			elseif($_POST['proses']=="simpan"){
					$email=mysql_escape_string(strip_tags($_POST['email']));
					$qcekemail=mysqli_query($koneksi, "select email from psb_member where email='$email'AND subdomain='$subdomain'");
					if (mysqli_num_rows($qcekemail)>=1){
						$password=rand(7456454485,476374873845);
						$pword=md5($password);
						mysqli_query($koneksi, "update psb_member set password='$pword' WHERE subdomain='$subdomain' And email='$email'");
						include ("$folder/function/class.phpmailer.php");
						$isi='<html>' .
    							' <head></head>' .
    							' <body>' .
    							' <label><img src=//'.$domain.'/picture/'.$logo.' alt=logo></label>
    							<br /><br>
    							Salam,'.$email.'
    							<br />
    							Password Berhasil Dirubah Silahkan Login Dengan  Username = '.$email.' Password = '.$password.'
    							<br />
    							Demikian informasi mengenai Perubahan Password Anda.<br>
    							Informasi lebih lanjut mengenai layanan '.$subdomain.', silahkan menghubungi Customer Service kami.<br>
    							Semoga kesuksesan senantiasa menyertai daya upaya kita bersama.<br>
    							Best Regards<br/>
    							'.$subdomain.' </body>' .
							'</html>';	
						$mail = new PHPMailer();
						$body             = "$isi"; //isi dari email  
						$mail->SetFrom($smtp_emailsistem, "$subdomain"); 
						$mail->Subject    = "Reset Password";
						$mail->MsgHTML($body);
						$address = "$email";
						$address2= $smtp_emailsistem;
						$mail->AddAddress($address, "Peserta");
						$mail->addReplyTo($address2,"$subdomain");
						if(!$mail->Send()) {
							echo "Mailer Error: " . $mail->ErrorInfo; 
						} else {
						    ?>
							<h3>Password Berhasil Diganti</h3>
							<p>Password berhasil diganti silahkan cek email Anda untuk detail pergantian password Anda. Terimakasih</p>
					        <input type="button" name="back" value="KEMBALI" onclick="history.go(-1);" class="button_back"/>
					        <?php
						}
			
					}
					else {
					    ?>
    					<h3>Email Tidak Ada</h3>
    					<input type="button" name="back" value="KEMBALI" onclick="history.go(-1);" class="button_back"/>
    					<?php
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