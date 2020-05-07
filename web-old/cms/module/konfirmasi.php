<?php
function konfirmasi($subdomain,$linksub,$folder){
    global $uploader;
    global $resize;
	$email=$_SESSION['uname'];
	$qcekdomain=mysqli_query($koneksi, "select domain,emailadmin,teleponadmin from pesanan where email='$email'");
	$data=mysqli_fetch_array($qcekdomain);
	$domain=$data['domain'];
	$emailadmin=$data['emailadmin'];
	$teleponadmin=$data['teleponadmin'];
	if ($domain<1){
		$qcekkonfirmasi=mysqli_query($koneksi, "select * from konfirmasi where domain='$domain'");
	$jum=mysqli_num_rows($qcekkonfirmasi); ?>
<script type="text/javascript">	
				$(document).ready(function() {
					var cekangka = /^[0-9]+$/;
					var cekhuruf = /^[A-Za-z .,]+$/;
					function camelcase(str) {
						return str.replace(/(?:^|\s)\w/g, function(match) {
							return match.toUpperCase();
						});
					}
					$("#submit").hide();
					$("#bri").click(function(){
						$("#rekening_tujuan").val("144701001148505");
						$("#atasnama_tujuan").val("Tri Astuti");
						//$("#bank_tujuan").val("BRI");
					});
					$("#bca").click(function(){
						$("#rekening_tujuan").val("8030112343");
						$("#atasnama_tujuan").val("Tri Astuti");
						//$("#bank_tujuan").val("BCA");
					});
					$("#mandiri").click(function(){
						$("#rekening_tujuan").val("1360010201660");
						$("#atasnama_tujuan").val("Tri Astuti");
						//$("#bank_tujuan").val("MANDIRI");
					});
					$("#bank_pengirim").keyup(function(){
						var bank_pengirim=$("#bank_pengirim").val();
						$("#bank_pengirim").val(bank_pengirim.toUpperCase());
						if (!cekhuruf.test(bank_pengirim)){
							$("#sukses1").html("<label>Harus Berupa Huruf</label>");
							$("#submit").hide();
						}
						else {
							$("#submit").show();
							$("#sukses1").html("");
						}
					});
					$("#rekening_pengirim").keyup(function(){
						var rekening_pengirim=$("#rekening_pengirim").val();
						if (!cekangka.test(rekening_pengirim)){
							$("#sukses2").html("<label>Harus Berupa Angka</label>");
							$("#submit").hide();
						}
						else {
							$("#submit").show();
							$("#sukses2").html("");
						}
					});
					$("#atasnama_pengirim").keyup(function(){
						var atasnama_pengirim=$("#atasnama_pengirim").val();
						$("#atasnama_pengirim").val(camelcase(atasnama_pengirim));
						if (!cekhuruf.test(atasnama_pengirim)){
							$("#sukses3").html("<label>Harus Berupa Huruf</label>");
							$("#submit").hide();
						}
						else {
							$("#submit").show();
							$("#sukses3").html("");
						}
					});
					$("#nilai_transfer").keyup(function(){
						var nilai_transfer=$("#nilai_transfer").val();
						if (!cekangka.test(nilai_transfer)){
							$("#sukses4").html("<label>Harus Berupa Angka</label>");
							$("#submit").hide();
						}
						else {
							$("#submit").show();
							$("#sukses4").html("");
						}
					});
					$("#form1").on("keypress", function(e) {
					return e.keyCode != 13;
					});
				});
</script>
		<?php
		if (empty($_POST['proses'])){?>
			<h3>Formulir Konfirmasi Pembayaran</h3>
			<form action="" method="post" id="form1">
			<table width="100%" id="tabelview" cellspacing="0" cellpadding="0">
				<tr><th style="text-align:left;">Data Web</th></tr>
				<tr><td>Domain</td><td width="15">:</td><td><input type="text" name="domain" id="domain"  maxlength="50"></td></tr>
				<tr><th style="text-align:left;">Bank Tujuan</th></tr>
				<tr><td width="130">Nama Bank</td><td width="15">:</td><td><input type="radio" name="bank_tujuan" value="BRI"  id="bri">BRI&nbsp;&nbsp;<input type="radio" name="bank_tujuan" value="MANDIRI"  id="mandiri">MANDIRI&nbsp;&nbsp;<input type="radio" name="bank_tujuan" value="BCA"  id="bca">BCA</td></tr>
				<tr><th style="text-align:left;">Bank Pengirim</th></tr>
				<tr><td>Nama Bank</td><td width="15">:</td><td><input type="text" name="bank_pengirim" required id="bank_pengirim"  maxlength="50"><span id="sukses1"></span></td></tr>
				<tr><td>No. Rekening</td><td width="15">:</td><td><input type="text" name="rekening_pengirim" required id="rekening_pengirim"  maxlength="50"><span id="sukses2"></span></td></tr>
				<tr><td>Atas Nama</td><td width="15">:</td><td><input type="text" name="atasnama_pengirim" required id="atasnama_pengirim"  maxlength="50"><span id="sukses3"></span></td></tr>
				<tr><th style="text-align:left;">Transfer</th></tr>
				<tr><td>Nilai Transfer</td><td width="15">:</td><td><input type="text" name="nilai_transfer" required id="nilai_transfer"  maxlength="50"><span id="sukses4"></span></td></tr>
				<tr><td>Tanggal Transfer</td><td width="15">:</td><td><input type="text" required name="tanggal_transfer" id="tanggal"  ></td></tr>
				<tr><td>Metode Transfer</td><td width="15">:</td>
					<td>
					<select name="metode_transfer" id="metode_transfer">										
						<option value="atm transfer" style="padding:2px 4px;">ATM Transfer</option>
						<option value="internet banking" style="padding:2px 4px;">Internet Banking</option>
						<option value="sms banking" style="padding:2px 4px;">SMS Banking</option>
					</select>
					</td>
				</tr>
				<tr><td>Bukti Transfer</td><td width="15">:</td><td><input type="file" name="gambar" required id="gambar"  ></span></td></tr>				
				<tr><td>&nbsp;</td><td></td><td><input type="submit" value="SUBMIT" id="submit"  class="button_save"><input type="hidden" name="proses" value="simpan"></td></tr>
			</table>
		</form>
							
		<?php 
			}
			elseif($_POST['proses']=="simpan"){
				include ("$folder/function/function.validasistring.php");
				$domain=strip_tags($_POST['domain']);
				$validasibanktujuan=new validasistring();
				$validasibanktujuan->validasi(strip_tags($_POST['bank_tujuan']));
				$bank_tujuan=mysql_escape_string($validasibanktujuan->hasilvalidasi);
				$bankpengirim=new validasistring();
				$bankpengirim->validasi(strip_tags($_POST['bank_pengirim']));
				$bank_pengirim=mysql_escape_string($bankpengirim->hasilvalidasi);
				$rekeningpengirim=new validasistring();
				$rekeningpengirim->validasi(strip_tags($_POST['rekening_pengirim']));
				$rekening_pengirim=mysql_escape_string($rekeningpengirim->hasilvalidasi);
				$atasnamapengirim= new validasistring();
				$atasnamapengirim->validasi(strip_tags($_POST['atasnama_pengirim']));
				$atasnama_pengirim=mysql_escape_string($atasnamapengirim->hasilvalidasi);
				$nilaitransfer=new validasistring();
				$nilaitransfer->validasi(strip_tags($_POST['nilai_transfer']));
				$nilai_transfer=mysql_escape_string($nilaitransfer->hasilvalidasi);
				$tanggal_transfer=mysql_escape_string(strip_tags($_POST['tanggal_transfer']));
				$metode_transfer=mysql_escape_string(strip_tags($_POST['metode_transfer']));
				
				if (! empty($_FILES['gambar'] ['tmp_name'])){
						$gambar=$_FILES['gambar']['tmp_name'];
						$gambar_name=$_FILES['gambar']['name'];
						$gambar_size=$_FILES['gambar']['size'];
						$gambar_type=$_FILES['gambar']['type'];
						$acak=rand(00000000,99999999);
						$judul_baru=$acak.$gambar_name;
						$judul_baru=str_replace(" ","",$judul_baru);
						$gambar_dimensi=getimagesize($gambar);
						if ($gambar_type!="image/jpg" and $gambar_type!="image/png" and $gambar_type!="image/gif" and $gambar_type!="image/jpeg"){ echo "Gambar Tidak Valid"; }
						elseif ($gambar_dimensi['0']>"2000" or $gambar_dimensi['1']>"2000") { echo "Dimensi Terlalu Besar,Maksimal 2000"; } 
						elseif ($gambar_size>"1000000") { echo "Ukuran File Terlalu Besar,Maksimal 10MB"; } 
						else {
							include ($folder.'/function/validasiupload.php');
							$image=new ValidasiUpload($gambar,$judul_baru);
							$image->putGambarType($gambar_type);
							if (!$image->validGambar()){
								echo "Gambar Tidak Valid";
								exit;
							}
							mysqli_query($koneksi, "INSERT INTO konfirmasi (no,domain,judul,bank_tujuan,bank_pengirim,rekening_pengirim,atasnama_pengirim,nilai,tanggal_transfer,metode_transfer,teleponadmin,emailadmin,tgl)
							VALUES('','$domain','$domain','$bank_tujuan','$bank_pengirim','$rekening_pengirim','$atasnama_pengirim','$nilai_transfer','$tanggal_transfer','$metode_transfer',$teleponadmin','$emailadmin',now())");
							$id_konfirmasi=mysqli_insert_id();
							$judul_baru=mysql_escape_string($judul_baru);
							
							mysqli_query($koneksi, "UPDATE konfirmasi SET gambar='$judul_baru' WHERE no='$id_konfirmasi'");
							copy ($gambar, "$folder/picture/".$judul_baru);
							$uploader->uploadPicture($judul_baru);
							?><h3>Transaksi Berhasil Dilakukan</h3><?php
						}
					} else {
						?><h3>Mohon Periksa Inputan Data</h3><?php
					}
				
			}
	}
	else{?>
		<h3>Anda Tidak Diijinkan Mengakses halaman Ini</h3><?php
	}
}
if ($tampil==1) {  

	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif ($akses=="admin" && $_SESSION['kat']=="admin"){
		if (empty($act)){
			konfirmasi($subdomain,$linksub,$folder);
		}
		elseif($act=="konfirmasi"){
			konfirmasi($subdomain,$linksub,$folder);
		}
		else{
			konfirmasi($subdomain,$linksub,$folder);
		}
	}
	elseif($akses=="admin"  && $_SESSION['kat']=="super"){
		
		$judulmod="Konfirmasi";
		$tabel="konfirmasi"; 
		$batas=30;
		$kolom="judul,bank_pengirim,rekening_pengirim,atasnama_pengirim,nilai";
		$lebar="200,100,150,150,100";
		$kolomtgl=1;
		$kolomvisit=0;
		$kolomkomen=0;
		$tombolact="detail";
		$jumdetail="single";
		$tipedetail="link";
		$isidetail="domain,judul,bank_tujuan,rekening_tujuan,atasnama_tujuan,bank_pengirim,rekening_pengirim,atasnama_pengirim,nilai,metode_transfer,tanggal_transfer,emailadmin,teleponadmin,gambar";
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
		
		function konfirmasidata ($tabel,$linksub,$judulmod,$isidetail) {
		$module=new admin();
		$module->get_variable();$module->setLinkSub($linksub);		
		$domain=$module->domain;
		$mod=$module->mod;
		$act=$module->act;
		$no=$module->no;
		if (empty ($no)) { echo "Nomor Kosong"; }
		else {
			$no=$no/1;
			$query=mysqli_query($koneksi, "SELECT no,domain,aktif FROM $tabel WHERE no='$no'");
			$data=mysqli_fetch_array($query);
			$no=$data['no'];
			$domain=$data['domain'];
			$aktif=$data['aktif'];
			$qcekuser=mysqli_query($koneksi, "select emailadmin from pesanan where domain='$domain'");
			$ddomain=mysqli_fetch_array($qcekuser);
			$emailuser=$ddomain['emailadmin'];
			$qcekdomainawal=mysqli_query($koneksi, "select subdomain,nama from user where email='$emailuser'");
			$ddomainawal=mysqli_fetch_array($qcekdomainawal);
			$domainawal=$ddomainawal['subdomain'];
			$nama=$ddomainawal['nama'];
			if ($no=="") { echo "Nomor Tidak Valid"; }
			else { 
				if (empty($_POST['proses'])){?>
				<h2>Detail <?php echo $judulmod;?></h2>
				<script type="text/javascript">
				$(document).ready(function() {
					var aktif=$("#cekaktif").val();
						if (aktif==1){
							$("#konfirmasi").hide();
							$("#batal").hide();
						}
						else{
							$("#konfirmasi").show();
							$("#batal").show();
						}
					$("#konfirmasi").click(function(){
						if (confirm("Apakah benar akan mengkonfirmasi ini?")){
							$('#proses').attr('value', 'konfirmasi');
						}
					});
					
					$("#batal").click(function(){
						if (confirm("Apakah benar akan membatalkan konfirmasi ini?")){
							$('#proses').attr('value', 'batal');
						}
					});
				});
				</script>
				<form method="post" action="">
				<input type="hidden" name="proses" id="proses">
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
					<input type="submit" name="konfirmasi" id="konfirmasi" value="KONFIRMASI"  class="button_back"/>&nbsp;&nbsp;
					<input type="submit" name="batal" value="BATAL" id="batal"  class="button_back"/>
				</form><?php
					}
					elseif($_POST['proses']=="konfirmasi"){
						include("lib/class.phpmailer.php");
						$isi='<html>' .
										' <head></head>' .
										' <body>' .
										' <label><img src=//buat.mysch.id/logo.png alt=logo></label>
										<br /><br>
										Salam,'.$nama.'
										<br />
										Pembayaran anda sudah dikonfirmasi silahkan tunggu beberapa saat lagi web '.$domain.' akan segera aktif
										<br />
										Demikian informasi mengenai pembayaran Anda.<br>
										Informasi lebih lanjut mengenai layanan mysch.id, silahkan menghubungi Customer Service kami.<br>
										Semoga kesuksesan senantiasa menyertai daya upaya kita bersama.<br>
										Best Regards<br/>
										mysch.id' .
										' </body>' .
										'</html>';	
						$mail = new PHPMailer();
						$body             = "$isi"; //isi dari email
						        
						$mail->SetFrom('info@mysch.id', "Mysch.id"); 
						$mail->Subject    = "mysch";
						$mail->MsgHTML($body);
										
						$address = "$emailuser";
						$address2="myschid@gmail.com";
						$mail->AddAddress($address, "Klien");
						$mail->addReplyTo($address2,"Mysch");
						if(!$mail->Send()) {
							echo "Mailer Error: " . $mail->ErrorInfo; 
						} else {
							//echo "Sukses";
							//jika pesan terkirim
						}
						mysqli_query($koneksi, "UPDATE setting SET aktif='1' WHERE subdomain='$domainawal'"); 
						mysqli_query($koneksi, "UPDATE $tabel SET aktif='1' WHERE no='$no'");
						
						?> <h3>Data Berhasil Dikonfirmasi</h3>Selamat, Data Berhasil Dikonfirmasi<br/><a href="" onclick="history.go(-1);" title="Kembali">Kembali</a><?php
						
					}
					elseif($_POST['proses']=="batal"){
						include("lib/class.phpmailer.php");
						$isi='<html>' .
										' <head></head>' .
										' <body>' .
										' <label><img src=//buat.mysch.id/logo.png alt=logo></label>
										<br /><br>
										Salam,'.$nama.'
										<br />
										Mohon maaf kami tidak menerima transfer sebagaimana yang anda konfirmasikan silahkan ulangi lagi
										<br />
										Demikian informasi mengenai pembayaran Anda.<br>
										Informasi lebih lanjut mengenai layanan mysch.id, silahkan menghubungi Customer Service kami.<br>
										Semoga kesuksesan senantiasa menyertai daya upaya kita bersama.<br>
										Best Regards<br/>
										mysch.id' .
										' </body>' .
										'</html>';	
						$mail = new PHPMailer();
						$body             = "$isi"; //isi dari email
						
						$mail->SetFrom('info@mysch.id', "Mysch.id"); 
						$mail->Subject    = "mysch";
						$mail->MsgHTML($body);
										
						$address = "$emailuser";
						$address2="myschid@gmail.com";
						$mail->AddAddress($address, "Klien");
						$mail->addReplyTo($address2,"Mysch");
						if(!$mail->Send()) {
							echo "Mailer Error: " . $mail->ErrorInfo; 
						} else {
							//echo "Sukses";
							//jika pesan terkirim
						}
						mysqli_query($koneksi, "DELETE FROM $tabel WHERE no='$no'");
						?> <h3>Konfirmasi Dibatalkan</h3>Selamat, Konfirmasi Dibatalkan<br/><a href="" onclick="history.go(-1);" title="Kembali">Kembali</a><?php
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
		elseif($act=="cari"){
			$module->tabelall($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact,"");
		}
		elseif ($act=="detail"){
			konfirmasidata ($tabel,$linksub,$judulmod,$isidetail);
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