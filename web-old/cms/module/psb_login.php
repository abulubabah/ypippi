<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	} 
	elseif($akses=="publik"){  
	    if ($subdomain == 'sman3tambunselatan.sch.id') {
	        ?>
            <h3>Pendaftaran Peserta Didik Baru Telah Ditutup</h3>
            <p>Pendaftaran Peserta Didik Baru Online SMAN 3 Tambun Selatan Tahun Ajaran 2018/2019 Telah Ditutup. Saat Ini Pendaftaran Dilaksanakan Secara Offline (Datang Langsung Menuju SMA N 3 Tambun Selatan).</p>
            <p>Terimakasih.</p>
	        <?php
	    } elseif ($subdomain == 'sman2tualang.sch.id') {
    	    $tanggalHariIni = date("Y-m-d");
    	    $waktuTanggalHariIni = strtotime($tanggalHariIni);
    	    $tanggalBuka = "2018-07-02";
    	    $waktuTanggalBuka = strtotime($tanggalBuka);
    	    
    	    if ($waktuTanggalBuka > $waktuTanggalHariIni) {
    	        ?>
    	        <h3>Pendaftaran Peserta Didik Baru SMA N 2 Tualang Dimulai Tanggal 3 Juli 2018</h3>
    	        <p>Pendaftaran Peserta Didik Baru SMA N 2 Tualang Dimulai Tanggal 3 Juli 2018. Terimakasih</p>
    	        <?php
    	    } else {
    	        if (empty($_POST['proses']) && empty($_SESSION['uname'])){?>
        			<style type="text/css">
        				#view { display:table; width:100%; border-bottom:1px solid #EAEAEA; padding:5px 0px; }
        				.view_label { float:left; width:15%; text-transform:capitalize; vertical-align:top; text-align:left;  }
        				.view_dot { float:left; width:2%; vertical-align:top; text-align:left; }
        				.view_content { float:left; width:83%; vertical-align:top; text-align:left; }
        				@media only screen and (max-width:768px) {
        				.view_label { width:23%; }
        				.view_dot { display:3%; }
        				.view_content { width:74%; }
        				}
        				@media only screen and (max-width:480px) {
        				.view_label { float:none; width:100%; font-weight:bold; }
        				.view_dot { float:none; display:none; }
        				.view_content { float:none; width:100%; }
        				.button_add { background:#CCCCCC; color:#FFFFFF;	font-weight:bold; padding:2px 4px; cursor:pointer; border:1px solid #AAAAAA; }
        				}
        			</style>
        			<h3>Form Login</h3>
        			<form action="" method="post" id="form1" autocomplete="off">
        				<input type="hidden" name="proses" value="simpan">
        				<div id="view"><div class="view_label">Username</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" placeholder="<?php echo ($subdomain != "sdnporisgaga2.sch.id") ? "Isi Dengan Email / NISN" : "Isi Dengan Nomor Formulir"?>" name="username" id="username" style="width:94%; max-width:200px;" maxlength="50"></div></div>
        				<div id="view"><div class="view_label">Password</div><div class="view_dot">:</div><div class="view_content"><input type="password" required="required" name="password" id="password" style="width:94%; max-width:200px;" maxlength="50"></div></div>
        				
        				<div id="view"><div class="view_label">&nbsp;</div><div class="view_dot">&nbsp;</div><div class="view_content"><input type="submit" value="LOGIN" id="submit"  class="button"> &nbsp; <a href="//<?php echo $linksub;?>/lupapassword/" title="Lupa Password">Lupa Password?</a></div></div>
        			</form><?php 
        			$randkode=rand(111111,999999); 
        			$_SESSION['kode']=$randkode;
        		}
        		elseif($_POST['proses']=="simpan"){
        			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
        			if (empty($_POST['username']) or empty($_POST['password'])) { header ("location://".$domain."/adm/");  } 
        			else {
        				$username=mysql_escape_string(strip_tags($_POST['username'])); $username=str_replace('"','',$username); $username=str_replace("'","",$username);
        				$password=mysql_escape_string(strip_tags($_POST['password'])); $password=str_replace('"','',$password); $password=str_replace("'","",$password);
        				$pass= ($subdomain == "smkn1rasaujaya.sch.id") ? $password : md5($password);
        				$sqlLogin = "SELECT no,nama,email,nisn,password FROM psb_member WHERE (email='$username' or nisn='$username') AND password='$pass' AND subdomain='$subdomain' AND publish='1'";
        				$login = sprintf($sqlLogin, mysqli_real_escape_string($username),mysqli_real_escape_string($pass));
        				$query=mysqli_query($koneksi, $login);
        				$jumlah=mysqli_num_rows($query);
        				$data=mysqli_fetch_array($query);
        				$no=$data['no'];
        				$nama=$data['nama'];
        				$email=$data['email'];
        				$nisn=$data['nisn'];
        				$password=$data['password'];
        				if ($jumlah>=1){
        					$_SESSION['nama']=$nama;
        					$_SESSION['uname']=$email;
        					$_SESSION['pword']=$pass;
        					$_SESSION['nisn']=$nisn;
        					$_SESSION['subdomain']=$subdomain;
        					echo "<script>document.location='//$linksub';</script>";
        		
        				}
        				else {   ?><script type="text/javascript"> alert('Usename / Password Salah !');</script><?php }
        			}
        		}
    	    }
	    } else {
    		if (empty($_POST['proses']) && empty($_SESSION['uname'])){?>
    			<style type="text/css">
    				#view { display:table; width:100%; border-bottom:1px solid #EAEAEA; padding:5px 0px; }
    				.view_label { float:left; width:15%; text-transform:capitalize; vertical-align:top; text-align:left;  }
    				.view_dot { float:left; width:2%; vertical-align:top; text-align:left; }
    				.view_content { float:left; width:83%; vertical-align:top; text-align:left; }
    				@media only screen and (max-width:768px) {
    				.view_label { width:23%; }
    				.view_dot { display:3%; }
    				.view_content { width:74%; }
    				}
    				@media only screen and (max-width:480px) {
    				.view_label { float:none; width:100%; font-weight:bold; }
    				.view_dot { float:none; display:none; }
    				.view_content { float:none; width:100%; }
    				.button_add { background:#CCCCCC; color:#FFFFFF;	font-weight:bold; padding:2px 4px; cursor:pointer; border:1px solid #AAAAAA; }
    				}
    			</style>
    			<?php 
    			if ($subdomain == "sdnporisgaga2.sch.id") {
    			    $usernamePlaceholder = "Isi Dengan Nomor Formulir";
    			} elseif ($subdomain == "smkn2tangerang.sch.id") {
    			    $usernamePlaceholder = "Isi Dengan Nomor Pendaftaran / Email / NISN";
    			} else {
    			    $usernamePlaceholder = "Isi Dengan Email / NISN";
    			} ?>
    			<h3>Form Login</h3>
    			<form action="" method="post" id="form1" autocomplete="off">
    				<input type="hidden" name="proses" value="simpan">
    				<div id="view"><div class="view_label">Username</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" placeholder="<?php echo $usernamePlaceholder;?>" name="username" id="username" style="width:94%; max-width:200px;" maxlength="50"></div></div>
    				<div id="view"><div class="view_label">Password</div><div class="view_dot">:</div><div class="view_content"><input type="password" required="required" name="password" id="password" style="width:94%; max-width:200px;" maxlength="50"></div></div>
    				
    				<div id="view"><div class="view_label">&nbsp;</div><div class="view_dot">&nbsp;</div><div class="view_content"><input type="submit" value="LOGIN" id="submit"  class="button"> &nbsp; <a href="//<?php echo $linksub;?>/lupapassword/" title="Lupa Password">Lupa Password?</a></div></div>
    			</form><?php 
    			$randkode=rand(111111,999999); 
    			$_SESSION['kode']=$randkode;
    		}
    		elseif($_POST['proses']=="simpan"){
    			if (empty($_SESSION['kode'])) { } else { unset($_SESSION['kode']); }
    			if (empty($_POST['username']) or empty($_POST['password'])) { header ("location://".$domain."/adm/");  } 
    			else {
    				$username=mysql_escape_string(strip_tags($_POST['username'])); $username=str_replace('"','',$username); $username=str_replace("'","",$username);
    				$password=mysql_escape_string(strip_tags($_POST['password'])); $password=str_replace('"','',$password); $password=str_replace("'","",$password);
    				$pass= ($subdomain == "smkn1rasaujaya.sch.id") ? $password : md5($password);
    				if ($subdomain == "smkn2tangerang.sch.id") {
    				    $sqlLogin = "SELECT no,username,nama,email,nisn,password FROM psb_member WHERE (username = '$username' or email='$username' or nisn='$username') AND password='$pass' AND subdomain='$subdomain' AND publish='1'";
    				} else {
    				    $sqlLogin = "SELECT no,nama,email,nisn,password FROM psb_member WHERE (email='$username' or nisn='$username') AND password='$pass' AND subdomain='$subdomain' AND publish='1'";
    				}
    				$login = sprintf($sqlLogin, mysqli_real_escape_string($username),mysqli_real_escape_string($pass));
    				$query=mysqli_query($koneksi, $login);
    				$jumlah=mysqli_num_rows($query);
    				$data=mysqli_fetch_array($query);
    				$no=$data['no'];
    				$nama=$data['nama'];
    				$username = $data['username'];
    				$email=$data['email'];
    				$nisn=$data['nisn'];
    				$password=$data['password'];
    				if ($jumlah>=1){
    					$_SESSION['nama']=$nama;
    					
    					if ($subdomain == "smkn2tangerang.sch.id") {
    					    $_SESSION['uname']=$username;    
    					} else {
    					    $_SESSION['uname']=$email;
    					}
    					$_SESSION['pword']=$pass;
    					$_SESSION['nisn']=$nisn;
    					$_SESSION['subdomain']=$subdomain;
    					echo "<script>document.location='//$linksub';</script>";
    		
    				}
    				else {   ?><script type="text/javascript"> alert('Usename / Password Salah !');</script><?php }
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