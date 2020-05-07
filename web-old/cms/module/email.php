<?php
if ($tampil==1) {  

	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="admin"  && $_SESSION['kat']=="super"){ 
		if (empty($_POST['proses'])){?>
			<h2>Email</h2>
				<form method="post" action="">
					<input type="hidden" name="proses" value="simpan">
						<table cellpadding="0" cellspacing="0" width="100%" id="tabelview">
							<tr><td>Salam</td><td width="15">:</td><td><input type="text" name="salam" required  ></td></tr>
							<tr><td>Subject</td><td width="15">:</td><td><input type="text" name="subject" required  ></td></tr>
							<tr><td width="140">isi</td><td width="15">:</td><td style="text-transform:none;"><textarea name="isi"  id="editor" style="width:96%; max-width:505px; text-transform:none;" rows="20"></textarea></td></tr>
						</table>
						<br/>
						<input type="button" name="back" value="KEMBALI" onclick="history.go(-1);" class="button_back"/>&nbsp;&nbsp;
						<input type="submit" name="Simpan"  value="Simpan"  class="button_back"/>&nbsp;&nbsp;
					</form><?php
			}
			else if ($_POST['proses']=="simpan"){
				$subject=$_POST['subject'];
				$isi=$_POST['isi'];
				$salam=$_POST['salam'];
				include("lib/class.phpmailer.php");
				$isi='<html>' .
								' <head></head>' .
								' <body>' .
								' <label><img src=//buat.mysch.id/logo.png alt=logo></label>
								<br /><br>
								'.$salam.'
								<br />'.$isi.
								' </body>' .
								'</html>';	
				$mail = new PHPMailer();
				$body             = "$isi"; //isi dari email
				$mail->IsSMTP(); 
				$mail->SMTPDebug  = 1;                    
																		 
																		  
				$mail->SMTPAuth   = true;                  
				$mail->SMTPSecure = "ssl";                 
				$mail->Host       = "smtp.gmail.com";      
				$mail->Port       = "465";                 
				$mail->Username   = "wahyuandi840@gmail.com";  
				$mail->Password   = "31031997";           
				$mail->SetFrom('info@mysch.id', "Mysch.id"); 
				$mail->Subject    = "$subject";
				$mail->MsgHTML($body);	
				$sistem="myschid@gmail.com";
				$qcekemail=mysqli_query($koneksi, "select email from user order by no asc  ");
				$a=1;
				while ($data=mysqli_fetch_array($qcekemail)){
					$address.$a=$data['email'];
					if ( preg_match('/^[^\@]+@.*.[a-z]{2,15}$/i',$address.$a)){
						if (filter_var($address.$a, FILTER_VALIDATE_EMAIL)){
						 $mail->AddAddress($address.$a, "Klien");
						}
					}
					
				}
				$mail->addReplyTo($sistem,"Mysch");
				if(!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo; 
				} 
				?> <h3>Email Berhasil Dikirim</h3>Selamat, Email Berhasil Dikirim<br/>
				<a href="" onclick="history.go(-1);" title="Kembali">Kembali</a><?php
					
		}
	}
	else { 
		header("location:index.php"); 
	}
}
else { 
	header("location:index.php"); 
}