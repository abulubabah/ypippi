<?php 
function upgrade($subdomain,$linksub,$folder){
	$module=new admin();
	$module->get_variable();
	$module->setLinkSub($linksub);
	if (empty($_POST['paket'])){?>
	<style type="text/css">
		.divpaket { float:left; width:49%; color:#FFFFFF; display:table;  font-size:32px; line-height:40px; text-align:left; -moz-border-radius:10px 10px 0px 0px; border-radius:10px 10px 0px 0px; -webkit-border-radius:10px 10px 0px 0px; margin-top:10px; }
		@media only screen and (max-width:480px) {
		.divpaket { float:left; width:100%; color:#FFFFFF; display:table;  font-size:32px; line-height:40px; text-align:left; -moz-border-radius:10px 10px 0px 0px; border-radius:10px 10px 0px 0px; -webkit-border-radius:10px 10px 0px 0px; margin-top:10px; }
		}
		.tabelpaket { text-align:left; color:#444444; background:#F0F0F0; }
		.tabelpaket tr:hover{ background:#DADADA; color:#444444; vertical-align:middle; }
		.tabelpaket th{ font-weight:bold; padding:5px; text-align:left; vertical-align:middle; }
		.tabelpaket td{ font-weight:normal; padding:5px; text-align:left; vertical-align:middle; }
		</style>
	<div style="display:table; width:100%">
	<div class="divpaket" style="background:#00AAFF;margin-right:2%; ">
		<div style="display:table; width:100%"><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/basic.png" alt="basic" style="margin:15px;margin-bottom:0px;" align="left"/><div style="margin-top:15px;">Paket<br/>Basic</div></div>
		<div style="font-size:14px;line-height:22px;padding:0px 15px 5px 15px;">Anda dapat membuat website sekolah dengan domain resmi sch.id</div>
		<form method="post" action="">
		<input type="hidden" name="paket" value="basic">
		<table class="tabelpaket" cellpadding="0" cellspacing="0" width="100%">
			<tbody><tr bgcolor="#FAFAFA"><th colspan="2" style="padding-left:10%">DOMAIN DAN EMAIL</th></tr>
			<tr><td width="15%"><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td width="85%">Domain Resmi .sch.id</td></tr>
			<tr><td bgcolor="#FAFAFA"><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td bgcolor="#FAFAFA">Akun Email @namadomain.sch.id</td></tr>
			<tr><th colspan="2" style="padding-left:10%">FITUR STANDAR</th></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Akses Admin Panel (CMS)</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Customisasi Tampilan</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Mobile Version</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Unlimited Menu</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Unlimited Berita</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Unlimited Foto</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Unlimited Tema Desain</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/no.png" alt="no" align="right"/></td><td>Garansi Error</td></tr>
			<tr bgcolor="#FAFAFA"><th colspan="2" style="padding-left:10%">FITUR AKADEMIK</th></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Kalender Akademik</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Jadwal Ujian</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Silabus</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/no.png" alt="no" align="right"/></td><td>Download Materi</td></tr>
			<tr><th colspan="2" style="padding-left:10%">FITUR DATA</th></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Data Guru &amp; Staff</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/no.png" alt="no" align="right"/></td><td>Data Alumni</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/no.png" alt="no" align="right"/></td><td>Data Siswa</td></tr>
			<tr><th colspan="2" style="padding-left:10%">LAIN-LAIN</th></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Buku Panduan</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Konsultasi Gratis</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/no.png" alt="no" align="right"/></td><td>Tidak Ada Iklan Dari Mysch.id</td></tr>
			<tr bgcolor="#FAFAFA"><td>Pembayaran</td><td>
			            <select name="pid"  id="pilih-paket">
				                <?php foreach ($hasilbasic as $data){ ?>
				                <option value="<?php echo $data['pid'];?>" data-harga="<?php echo $data['pricing'];?>"><?php echo $data['name'];?></option>
				                <?php } ?>
				            </select></td></tr>
			<tr bgcolor="#FAFAFA"><td colspan="2" style="text-align:center;padding:12px;"><h4 id="harga"></h4></td></tr>
			<tr><td colspan="2" style="text-align:center;padding:12px;"><input type="submit" style="background:#00AAFF; color:#FFFFFF; padding:10px 30px; font-size:16px;" title="Upgrade Sekarang" value="Upgrade Sekarang"><br/><a href="//mysch.id/persyaratan-dokumen-schid/" title="Syarat Dokumen sch.id">Syarat Dokumen sch.id</a></td></tr>
		</tbody></table>
		<input type="hidden" name="harga" id="harga-hidden-basic">
		</form>
		<script>
		    $(function(){
		        
		        $("#pilih-paket").change(function(){
		            
		            var harga= $("#pilih-paket :selected").attr('data-harga')+",-";
		            $("#harga").html(harga);
		            $("#harga-hidden-basic").val($("#pilih-paket :selected").attr('data-harga'));
		            
		        });
		        
		        $("#pilih-paket").trigger('change');
		    });
		</script>
	</div>
	<div class="divpaket" style="background:#FF2200;">
		<div style="display:table; width:100%"><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/premium.png" alt="profesional" style="margin:15px;margin-bottom:0px" align="left"/><div style="margin-top:15px;margin-bottom:0px;">Paket<br/>Profesional</div></div>
		<div style="font-size:14px;line-height:22px;padding:0px 15px 5px 15px;">Anda dapat membuat website sekolah dengan domain resmi sch.id</div>
		<form method="post" action="">
		<input type="hidden" name="paket" value="profesional">
		<table class="tabelpaket" cellpadding="0" cellspacing="0" width="100%">
			<tbody><tr bgcolor="#FAFAFA"><th colspan="2" style="padding-left:10%">DOMAIN DAN EMAIL</th></tr>
			<tr><td width="15%"><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td width="85%">Domain Resmi .sch.id</td></tr>
			<tr><td bgcolor="#FAFAFA"><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td bgcolor="#FAFAFA">Akun Email @namadomain.sch.id</td></tr>
			<tr><th colspan="2" style="padding-left:10%">FITUR STANDAR</th></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Akses Admin Panel (CMS)</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Customisasi Tampilan</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Mobile Version</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Unlimited Menu</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Unlimited Berita</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Unlimited Foto</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Unlimited Tema Desain</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/no.png" alt="no" align="right"/></td><td>Garansi Error</td></tr>
			<tr bgcolor="#FAFAFA"><th colspan="2" style="padding-left:10%">FITUR AKADEMIK</th></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Kalender Akademik</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Jadwal Ujian</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Silabus</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Download Materi</td></tr>
			<tr><th colspan="2" style="padding-left:10%">FITUR DATA</th></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Data Guru &amp; Staff</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Data Alumni</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Data Siswa</td></tr>				
			<tr><th colspan="2" style="padding-left:10%">LAIN-LAIN</th></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Buku Panduan</td></tr>
			<tr><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/yes.png" alt="yes" align="right"/></td><td>Konsultasi Gratis</td></tr>
			<tr bgcolor="#FAFAFA"><td><img src="<?php echo $module->getHttp();?>://mysch.id/cms/image/no.png" alt="no" align="right"/></td><td>Tidak Ada Iklan Dari Mysch.id</td></tr>
			<tr bgcolor="#FAFAFA"><td>Pembayaran</td><td  ><select name="pid"  id="pilih-paket-pro">
				                <?php foreach ($hasilpro as $data){ ?>
				                <option value="<?php echo $data['pid'];?>" data-harga="<?php echo $data['pricing'];?>"><?php echo $data['name'];?></option>
				                <?php } ?>
				            </select></td></tr>
			<tr bgcolor="#FAFAFA"><td colspan="2" style="text-align:center;padding:12px;"><h4 id="harga-pro"></h4></td></tr>
			<tr><td colspan="2" style="text-align:center;padding:12px;"><input type="submit" style="background:#FF2200; color:#FFFFFF; padding:10px 30px; font-size:16px;" title="Upgrade Sekarang" value="Upgrade Sekarang"><br/><a href="//mysch.id/persyaratan-dokumen-schid/" title="Syarat Dokumen sch.id">Syarat Dokumen sch.id</a></td></tr>
		</tbody></table>
		<input type="hidden" name="harga" id="harga-hidden-pro">
		</form>
		<script>
		    $(function(){
		        
		        $("#pilih-paket-pro").change(function(){
		            
		            var harga= $("#pilih-paket-pro :selected").attr('data-harga')+",-";
		            $("#harga-pro").html(harga);
		            $("#harga-hidden-pro").val($("#pilih-paket-pro :selected").attr('data-harga'));
		            
		        });
		        
		        $("#pilih-paket-pro").trigger('change');
		    });
		</script>
	</div>
</div>
<?php 
	}
	elseif($_POST['paket']!=""){
		$paket=mysql_escape_string($_POST['paket']);
		$qcekemail=mysqli_query($koneksi, "select nama,email,telepon from user where subdomain='$subdomain'");
		$data=mysqli_fetch_array($qcekemail);
		$nama=$data['nama'];
		$email=$data['email'];
		$teleponadmin=$data['telepon'];
		
		$harga=$_POST['harga'];
		
		$pid=(int)$_POST['pid'];
		
		$qceksseting=mysqli_query($koneksi, "select * from setting where subdomain='$subdomain'");
		$dsetting=mysqli_fetch_array($qceksseting);
		$idsponsor=$dsetting['idsponsor'];
		$judul=$dsetting['judul'];
		$tema=$dsetting['theme'];
		$telepon=$dsetting['telepon'];
		$emailsetting=$dsetting['email'];
		$alamat=$dsetting['alamat'];
		$kodepos=$dsetting['kodepos'];
		$kot=$dsetting['kota'];
		$prov=$dsetting['provinsi'];
		$setting_id=$dsetting['no'];
		$client_id=$dsetting['clientid'];
		
		$domain=$subdomain.".sch.id";
		

		function getClientId($email){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, URL_API_WHMCS);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                http_build_query(
                    array(
                        'action' => 'GetClients',
                        'identifier' => USERNAME_WHMCS,
                        'secret' => PASSWORD_WHMCS,
                        'search' => $email,
                        'responsetype' => 'json',
                    )
                )
            );
            $response = curl_exec($ch);
            curl_close($ch);
            $hasil=json_decode($response,true);
            if($hasil['totalresults'] < 1){
                return 0;
            }
            
            return $hasil['clients']['client'][0]['id'];
            
        }
	    
		$ex=explode(" ",$nama);
		$first_name=$ex[0];
		$last_name=end($ex);
		
        
		$qcekjumpesanan=mysqli_query($koneksi, "select domain from pesanan where domain='$domain'");
		$jum=mysqli_num_rows($qcekjumpesanan);
		if ($jum<1){
            if(!$client_id){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, URL_API_WHMCS);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS,
                    http_build_query(
                        array(
                            'action' => 'AddClient',
                            'identifier' => USERNAME_WHMCS,
                            'secret' => PASSWORD_WHMCS,
                            'firstname' => $first_name,
                            'lastname' => $last_name,
                            'email' => $email,
                            'address1' => $alamat,
                            'city' => $kot,
                            'state' => $prov,
                            'postcode' => $kodepos,
                            'country' => 'ID',
                            'phonenumber' => $teleponadmin,
                            'password2' => "myadmin123",
                            'responsetype' => 'json',
                        )
                    )
                );
                $response = curl_exec($ch);
                curl_close($ch);
                $result=json_decode($response,true);
                $client_id=$result['clientid'];
            }
		    
		    //add order
    							
			$ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, URL_API_WHMCS);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                http_build_query(
                    array(
                        'action' => 'AddOrder',
                        // See https://developers.whmcs.com/api/authentication
                        'identifier' => USERNAME_WHMCS,
                        'secret' => PASSWORD_WHMCS,
                        'clientid' => $client_id,
                        'pid' => array($pid),
                        //'priceoverride'=>array(str_replace(".","",$harga).".00"),
                        'domain' => array($domain),
                        'domaintype' => array('register'),
                        'paymentmethod' => 'banktransfer',
                        'responsetype' => 'json',
                    )
                )
            );
            $response = curl_exec($ch);
            curl_close($ch);
            
            $invoice=json_decode($response,true);
            $invoice_id=$invoice['invoiceid'];
            
            /*
             * get invoice
             */
             
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, URL_API_WHMCS);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,
                http_build_query(
                    array(
                        'action' => 'GetInvoice',
                        'identifier' => USERNAME_WHMCS,
                        'secret' => PASSWORD_WHMCS,
                        'invoiceid' => $invoice_id,
                        'responsetype' => 'json',
                    )
                )
            );
            $response = curl_exec($ch);
            curl_close($ch);
            mysqli_query($koneksi, "UPDATE setting set paket='$paket',whmcs='1',pid='".$pid."' where subdomain='$subdomain'");
            $inv=json_decode($response,true);
            $harga=$inv['total'];
			$qcekemailsponsor=mysqli_query($koneksi, "select email,nama,telepon from member where username='$idsponsor'");
			$demail=mysqli_fetch_array($qcekemailsponsor);
			$nama_spon=$demail['nama'];
			$email_spon=$demail['email'];
			$telepon_spon=$demail['telepon'];
			mysqli_query($koneksi, "INSERT INTO pesanan (nama,domain,paket,idsponsor,nilai,judul,tema,telepon,email,teleponadmin,emailadmin) VALUE('$nama','$domain','$paket','$idsponsor','$harga','$judul','$tema','$telepon','$emailsetting','$teleponadmin','$email')");
			include("$folder/function/class.phpmailer.php");
			$isi='<html>' .
							' <head></head>' .
							' <body>' .
							' <label><img src=//buat.mysch.id/logo.png alt=logo></label>
							<br /><br>
							Salam,'.$judul.'
							<br />
							Selamat,&nbsp;Website&nbsp;'.$judul.' telah diupgrade
							<br />
							<br/>
							Silahkan Lakukan Pembayaran Sebesar Rp.'.$harga.',- untuk mengaktifkan Website'.$domain.'<br>
							Pembayaran Dapat Dilakukan Melalui ATM Transfer, Internet Banking, SMS Banking, Setoran Tunai ke Rekening Dibawah Ini :<br>
							- BANK MANDIRI No. Rek. 1360010201660 A.N. Tri Astuti<br>
							- BANK BCA No. Rek. 8030112343 A.N. Tri Astuti<br>
							- BANK BRI No. Rek. 144701001148505 A.N. Tri Astuti<br><br>
							Setelah Melakukan Pembayaran, Segera Melakukan Konfirmasi Pada Halaman <b><a href="//mysch.id/admin/adm/konfirmasi" value="Konfirmasi">KLIK DISINI</a></b><br>
							Demikian informasi mengenai pendaftaran Anda.<br>
							Informasi lebih lanjut mengenai layanan mysch.id, silahkan menghubungi Customer Service kami.<br>
							Semoga kesuksesan senantiasa menyertai daya upaya kita bersama.<br>
							Best Regards<br/>
							mysch.id' .
							' </body>' .
							'</html>';
			$isi1='<html>' .
							' <head></head>' .
							' <body>' .
							' <label><img src=//buat.mysch.id/logo.png alt=logo></label>
							<br /><br>
							Salam,'.$nama_spon.'
							<br />
							Selamat,&nbsp;Website&nbsp;'.$judul.' telah melakukan upgrade
							<br />
							Demikian informasi mengenai pendaftaran Anda.<br>
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
							
			$address = "$emailsetting";
			$address1="$email";
			$address2="myschid@gmail.com";
			if ($address==$address1){
				$mail->AddAddress($address1, "Admin");
			}
			else {
				$mail->AddAddress($address, "Klien");
				$mail->AddAddress($address1, "Admin");
			}
			$mail->AddAddress($address2, "Sistem");
			$mail->addReplyTo($address2,"Mysch");
			$isipesan1="Mysch.id: Prospek Klien Website Sekolah $subdomain. Telah Melakukan Upgrade ke Paket $paket. Hubungi $nama ($teleponadmin).";
			mysqli_query($koneksi, "INSERT INTO outbox (tujuan, pesan, tgl) VALUES ('085740000146', '$isipesan1', sysdate())");
			if(!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo; 
				} else {
					//echo "Sukses";
					 //jika pesan terkirim
				}
			if (mysqli_num_rows($qcekemailsponsor)>=1){/*
				$mail1 = new PHPMailer();
				$body1             = "$isi1"; //isi dari email
				$mail1->IsSMTP(); 
				$mail1->SMTPDebug  = 1;                    
																	 
																	  
				$mail1->SMTPAuth   = true;                  
				$mail1->SMTPSecure = "ssl";                 
				$mail1->Host       = "smtp.gmail.com";      
				$mail1->Port       = "465";                 
				$mail1->Username   = "wahyuandi840@gmail.com";  
				$mail1->Password   = "31031997";           
				$mail1->SetFrom('info@mysch.id', "Mysch.id"); 
				$mail1->Subject    = "mysch";
				$mail1->MsgHTML($body1);
								
				
				$addresspon="$email_spon";
				$mail1->AddAddress($addresspon, "Affiliate");
				$mail1->addReplyTo($address2,"Mysch");

				if(!$mail1->Send()) {
					echo "Mailer Error: " . $mail1->ErrorInfo; 
				} else {
					//echo "Sukses";
					 //jika pesan terkirim
				}*/
			}
				$isipesan2="Mysch.id: Permintaan Upgrade $subdomain.mysch.id telah masuk ke database kami. Segera lakukan pembayaran untuk mengaktifkan paketnya.";
				mysqli_query($koneksi, "INSERT INTO outbox (tujuan, pesan, tgl) VALUES ('$teleponadmin', '$isipesan2', sysdate())");
				$isipesan3="Mysch.id: Rekening Mysch BCA No. 8030112343 a.n. Tri Astuti, MANDIRI No. 1360010201660 a.n. Tri Astuti, BRI No. 144701001148505 a.n. Tri Astuti.";
				mysqli_query($koneksi, "INSERT INTO outbox (tujuan, pesan, tgl) VALUES ('$teleponadmin', '$isipesan3', sysdate())"); 
			
			?>
			<h3>Selamat, Website <?php echo $subdomain;?>.mysch.id Telah Diupgrade</h3>
			Informasi Lebih Detail, Silahkan Cek Email Anda.<?php
			
		}
		else{?>
		<h3>Nama Domain Tersebut Sudah Dipakai</h3><?php
		
		}
	}
}


if ($tampil==1) {  

	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif ($akses=="admin" && $_SESSION['kat']=="admin"){
		if (empty($act)){
			upgrade($subdomain,$linksub,$folder);
		}
		elseif($act=="upgrade"){
			upgrade($subdomain,$linksub,$folder);
		}
		else{
			upgrade($subdomain,$linksub,$folder);
		}
	}
	elseif($akses=="admin"  && $_SESSION['kat']=="super"){		
		
		$judulmod="Pesanan";
		$tabel="pesanan"; 
		$batas=30;
		$kolom="judul,paket,telepon,email";
		$lebar="200,100,100,150";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="detail";
		$jumdetail="single";
		$tipedetail="link";
		$isidetail="subdomain,idsponsor,paket,username,judul,alamat,kota,provinsi,email,aktif";
		$tipedelete="";
		$jenisinput="";
		$onclick="cekJudul";
		$tipeinput="module";
		$forminput="judul,url";
		$jenisinputrinci="";
		$onclickrinci="cekhtml";
		$tipeinputrinci="module";
		$forminputrinci="judul,url,target";
		$formeditrinci="judul,url,target,publish,tgl";
		$module=new admin();
		$module->get_variable();
		$module->setLinkSub($linksub);
		function detail($linksub,$judulmod,$isidetail){
			$module=new admin();
			$module->get_variable();
			$module->setLinkSub($linksub);
			$domain=$module->domain;
			$mod=$module->mod;
			$act=$module->act;
			$no=$module->no;
			$tabel="setting";
			if (empty ($no)) {  $module->notify("mysch.id",$linksub,"empty");}
			else {
			$cekdomain=mysqli_query($koneksi, "SELECT no,domain,emailadmin,paket from pesanan where no='$no'");
			$ddomain=mysqli_fetch_array($cekdomain);
			$domain=$ddomain['domain'];
			$emailadmin=$ddomain['emailadmin'];
			$paket=$ddomain['paket'];
			$nopesanan=$ddomain['no'];
			$qcekdomainasal=mysqli_query($koneksi, "select subdomain from user where email='$emailadmin'");
			$dsubdomain=mysqli_fetch_array($qcekdomainasal);
			$subdomain=$dsubdomain['subdomain'];
			$cekaktif=mysqli_query($koneksi, "select aktif from setting where subdomain='$subdomain'");
			$daktif=mysqli_fetch_array($cekaktif);
			$aktif=$daktif['aktif'];
			$query=mysqli_query($koneksi, "SELECT no FROM $tabel WHERE subdomain='$subdomain'");
			$data=mysqli_fetch_array($query);
			$no=$data['no'];
			if ($no=="") { $module->notify("mysch.id",$linksub,"empty"); } 
			else { 
				if (empty($_POST['proses'])){?>
				<h2>Detail <?php echo $judulmod;?></h2>
				<script type="text/javascript">
				$(document).ready(function() {
					var aktif=$("#cekaktif").val();
					if (aktif===1){
						$("#upgrade").hide();
					}
					else{
						$("#upgrade").show();
					}
					$("#upgrade").click(function(){
					confirm("Apakah benar akan mengupgrade ini?");
					});
				});
				</script>
				<form method="post" action="">
				<input type="hidden" name="proses" value="simpan">
				<input type="hidden" name="aktif" id="cekaktif" value="<?php echo $aktif;?>">
					<table cellpadding="0" cellspacing="0" width="100%" id="tabelview"><?php
						$isidetail=explode(",",$isidetail);
						$jumisi=count($isidetail);
						for($i=0;$i<$jumisi;$i++){ ?>
						<tr>
							<td width="140"><?php $module->label($isidetail[$i]); echo $module->labelisi; ?></td>
							<td width="15">:</td>
							<td><?php $module->data($tabel,$isidetail[$i],$no); echo $module->dataisi; ?></td>
						</tr><?php 
						} ?>
					</table>
					<br/>
					<input type="button" name="back" value="KEMBALI" onclick="history.go(-1);" class="button_back"/>&nbsp;&nbsp;
					<input type="submit" name="simpan" id="upgrade" value="UPGRADE"  class="button_back"/>
				</form><?php
					}
					elseif ($_POST['proses']=="simpan"){					
						if ($aktif==1){
							mysqli_query($koneksi, "UPDATE alumni set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE berita set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE berita_kategori set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE contact set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE contact_isi set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE galeri set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE galeri_kategori set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE guru set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE halaman set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE html set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE jurusan set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE kelas set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE kalender set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE kelompok set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE link set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE materi set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE module set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE polling set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE sambutan set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE setting set subdomain='$domain', paket='$paket' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE silabus set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE siswa set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE slideshow set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE teks set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE user set subdomain='$domain' where subdomain='$subdomain'");
							mysqli_query($koneksi, "UPDATE pesanan SET aktif='1' WHERE no='$nopesanan'");?>
							<h3>Data Berhasil Diupgrade</h3>Selamat, Data Berhasil Diupgrade<br/><a href="" onclick="history.go(-1);" title="Kembali">Kembali</a><?php
							
						}
						else{ ?>
							<h3>Data Gagal Diupgrade</h3>Maaf, Data Gagal Diupgrade<br/><a href="" onclick="history.go(-1);" title="Kembali">Kembali</a><?php
						}
					}
				}
				
			}
		}
		if (empty ($act)) {
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		} 
		elseif($act=="semua"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif($act=="urut"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif($act=="detail"){
			detail($linksub,$judulmod,$isidetail);
		}
		else {
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
	}
	else { 
		header("location:index.php"); 
	}
}
else { 
	header("location:index.php"); 
}