<h2>Lupa Password</h2><?php
if (empty($_POST['proses'])){?>
    <form action="" method="post">
		<input type="hidden" name="proses" value="lupapassword"/>
		<p><label>Email<br/><input type="email" name="email" required maxlength="50" style="width:95%; max-width:400px; margin:5px 0px;" required/></label></p>
		<p><input type="submit" value="KIRIM"  class="button" style="margin:5px 0px;"/></p>
	</form><?php
	$_SESSION['kode']=rand(34343434,34343434);
} else if ($_POST['proses']=='lupapassword'){
    $username=$_POST['email'];
    if(!empty($_SESSION['kode'])){
        $cek=mysqli_query($koneksi, "SELECT email FROM user WHERE username='".mysqli_real_escape_string($username)."' AND subdomain='".$subdomain."'");
        $jum=mysqli_num_rows($cek);
        if ($jum>=1){
            $data=mysqli_fetch_assoc($cek);
            $email=$data['email'];
            $pass=rand(23234334,343434434);
            $enpass=md5($pass);
            mysqli_query($koneksi, "UPDATE user SET password='".$enpass."' WHERE  email='".mysqli_real_escape_string($email)."' AND subdomain='".$subdomain."'");
            include_once("$folder/function/class.phpmailer.php");
            $isi='<html>' .
				' <head></head>' .
				' <body>' .
				' <label><img src="//https://buat.mysch.id/logo.png" alt=logo></label>
				<br /><br>
				Salam,'.$subdomain.'
				<br />
				Selamat password berhasil di reset, password baru anda '.$pass.'
				<br />
				<br/>
				Demikian informasi mengenai reset password Anda.<br>
				Informasi lebih lanjut mengenai layanan mysch.id, silahkan menghubungi Customer Service kami.<br>
				Semoga kesuksesan senantiasa menyertai daya upaya kita bersama.<br>
				Best Regards<br/>
				mysch.id' .
				' </body>' .
				'</html>';
	
			$mail = new PHPMailer();
			$body             = "$isi"; //isi dari email
			$mail->isHTML(true);           
			$mail->SetFrom('info@mysch.id', "Mysch.id"); 
			$mail->Subject    = "mysch";
			$mail->MsgHTML($body);
							
			$address1="$email";
			$mail->AddAddress($address1, "Admin ".$subdomain);
			$mail->addReplyTo('myschid@gmail.com',"Mysch");
			if(!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo; 
			} else {
				//echo "Sukses";
				 //jika pesan terkirim
			} ?>
			<h3>Selamat password berhasil di reset.</h3><?php
			unset($_SESSION['kode']);
        } else { ?>
            <h3>Email tidak ada di dalam database</h3><?php
        }
        
    } else { ?>
        <h3>Silahkan Buka Halaman Ini Beberapa Saat Lagi</h3><?php
    }
    
}