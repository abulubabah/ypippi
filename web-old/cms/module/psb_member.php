<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="member"){ 

		if (empty($_POST['process'])) {
			$uname=$_SESSION['uname'];
			$nisn=$_SESSION['nisn'];
			$qcekmember=mysqli_query($koneksi, "SELECT * FROM psb_member WHERE nisn='$nisn' AND subdomain='$subdomain'");
			$data=mysqli_fetch_array($qcekmember);
			$nama=$data['nama'];
			$nik=$data['nik']; $nisn=$data['nisn']; $nis=$data['nis'];
			$tempat_lahir=$data['tempat_lahir'];
			$tanggal=explode("-",$data['tanggal_lahir']);
			$lahirtgl=$tanggal[2];
			$lahirbln=$tanggal[1];
			$lahirthn=$tanggal[0];			 
			$kelamin_jenis=$data['kelamin_jenis'];	
			$agama=$data['agama'];
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
				
			?>
		<h2>Formulir Pendaftaran</h2>
		<script type="text/javascript">	
				$(document).ready(function() {
					var cekangka = /^[0-9]+$/;
					var cekhuruf = /^[A-Za-z .,]+$/;
					function camelcase(str) {
						return str.replace(/(?:^|\s)\w/g, function(match) {
							return match.toUpperCase();
						});
					}
					$(".val1").hide();
					$(".val2").hide();
					$(".val3").hide();
					$("#ya").click(function(){
						$(".val1").show();
						$(".val2").show();
						$(".val3").show();
					});
					$("#tidak").click(function(){
						$(".val1").hide();
						$(".val2").hide();
						$(".val3").hide();
						$(".val1").val('');
						$(".val2").val('');
						$(".val3").val('');
					});
					$("#formdfatar").on("keypress", function(e) {
					return e.keyCode != 13;
					});
				});
			</script>
			<form action="" method="post" id="formdfatar">
				<input type="hidden" name="process" value="check">
				<div id="view"><div class="view_label"><b>BIODATA</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						<div id="view"><div class="view_label">Nama Lengkap</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nama" id="nama" value="<?php echo $nama;?>" style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">N I K</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nik" id="nik" value="<?php echo $nik;?>" style="width:94%; max-width:400px;" maxlength="50"></div></div>
<div id="view"><div class="view_label">N I S N</div><div class="view_dot">:</div><div class="view_content"><input type="number" required="required" name="nisn" readonly id="nisn" value="<?php echo $nisn;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>

						<div id="view"><div class="view_label">Tempat Lahir</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="tempat_lahir" required="required" id="tempat_lahir" value="<?php echo $tempat_lahir;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Tanggal Lahir</div><div class="view_dot">:</div>
							<div class="view_content">
								<select name="lahirtgl" style="padding:0px; width:60px;"><?php 
									for ($tgl=1; $tgl<=31; $tgl++) { if ($tgl<10) { $tgljadi="0$tgl"; } else { $tgljadi=$tgl;  } if ($tgl==$lahirtgl){ $tambahan="selected"; } else { $tambahan=""; } ?><option value="<?php echo $tgljadi;?>" style="padding:3px 4px;" <?php echo $tambahan;?>><?php echo $tgljadi;?></option><?php }?></select> &nbsp; 
								<select name="lahirbln" style="padding:0px; width:60px;"><?php 
									for ($bln=1; $bln<=12; $bln++) { if ($bln<10) { $blnjadi="0$bln"; }else { $blnjadi=$bln;} if ($bln==$lahirbln){ $tambahan="selected"; } else { $tambahan=""; }?><option value="<?php echo $blnjadi;?>" style="padding:3px 4px;" <?php echo $tambahan;?>><?php echo $blnjadi;?></option><?php }?></select> &nbsp; 
								<select name="lahirthn" style="padding:0px; width:100px;"><?php 
									for ($thn=1950; $thn<=2010; $thn++) { if ($thn==$lahirthn){ $tambahan="selected"; } else { $tambahan=""; }?><option value="<?php echo $thn;?>" style="padding:3px 4px;" <?php echo $tambahan;?>><?php echo $thn;?></option><?php }?></select>
							</div>
						</div>
						<div id="view"><div class="view_label">Jenis Kelamin</div><div class="view_dot">:</div>
						<div class="view_content">
						<?php if ($kelamin_jenis=="P"){ $atribut="selected"; } else { $atribut="";}?>
								<select name="kelamin_jenis" style="width:98%; max-width:415px; padding:0px;">
									<option value="L" id="cekl" style="padding:3px 4px;">Laki-Laki</option><option value="P" id="cekp" style="padding:3px 4px;" <?php echo $atribut;?>>Perempuan</option>
								</select>
							</div>
						</div>
						<div id="view"><div class="view_label">Agama</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="agama" required="required" id="agama" value="<?php echo $agama;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Status Anak</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="status_anak" required="required" id="status_anak" value="<?php echo $status_anak;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Anak Ke</div><div class="view_dot">:</div><div class="view_content"><input type="number" name="anak_ke" required="required" id="anak_ke" value="<?php echo $anak_ke;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Jumlah Saudara</div><div class="view_dot">:</div><div class="view_content"><input type="number" name="jumlah_saudara" required="required" id="jumlah_saudara" value="<?php echo $jumlah_saudara;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Tinggi Badan</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="tinggi_badan" required="required" id="tinggi_badan"  value="<?php echo $tinggi_badan;?>" style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Berat Badan</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="berat_badan" required="required" id="berat_badan" value="<?php echo $berat_badan;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view" ><div class="view_label">Cacat Badan</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="cacat_badan" required="required" id="cacat_badan" value="<?php echo $cacat_badan;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Pernah Sakit</div><div class="view_dot">:</div><div class="view_content"><?php if ($pernah_sakit=="Ya"){ ?><input type="radio" name="pernah_sakit" value="Ya" checked  id="ya">Ya&nbsp;&nbsp;<?php } else {?><input type="radio" name="pernah_sakit" value="Ya"   id="ya">Ya&nbsp;&nbsp;<?php } if ($pernah_sakit=="Tidak"){?><input type="radio" name="pernah_sakit" value="Tidak" checked id="tidak">Tidak <?php } else { ?> <input type="radio" name="pernah_sakit" value="Tidak"  id="tidak">Tidak <?php } ?></div></div>
						<div id="view" class="val1"><div class="view_label">Nama Penyakit</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="nama_penyakit"  id="nama_penyakit" value="<?php echo $nama_penyakit;?>" style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view" class="val2"><div class="view_label" >Tanggal Sakit</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="tanggal_sakit" id="tanggal_sakit" value="<?php echo $tanggal_sakit;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view" class="val3"><div class="view_label">Lama Sakit</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="lama_sakit"  value="<?php echo $lama_sakit;?>" id="lama_sakit"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label"><b>KONTAK</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						<div id="view"><div class="view_label">Alamat</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="alamat" id="alamat" value="<?php echo $alamat;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Kota</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="kota" id="kota" value="<?php echo $kota;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Provinsi</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="provinsi" id="provinsi" value="<?php echo $provinsi;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Telepon</div><div class="view_dot">:</div><div class="view_content"><input type="phone" required="required" name="telepon" id="telepon" value="<?php echo $telepon;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Email</div><div class="view_dot">:</div><div class="view_content"><input type="email" placeholder="Jika Ada"  name="email" id="email" value="<?php echo $email;?>"   style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Asal Sekolah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="asal_sekolah" value="<?php echo $asal_sekolah;?>" id="asal_sekolah"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						
						<div id="view"><div class="view_label"><b>Data Orangtua</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						<div id="view"><div class="view_label">Nama Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nama_ayah" id="nama_ayah" value="<?php echo $nama_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Alamat Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="alamat_ayah" id="alamat_ayah" value="<?php echo $alamat_ayah;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Usia Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="number" required="required" name="usia_ayah" id="usia_ayah" value="<?php echo $usia_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Agama Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="agama_ayah" id="agama_ayah" value="<?php echo $agama_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Pendidikan Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="pendidikan_ayah" id="pendidikan_ayah" value="<?php echo $pendidikan_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Pekerjaan Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="pekerjaan_ayah" id="pekerjaan_ayah" value="<?php echo $pekerjaan_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Penghasilan Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="penghasilan_ayah" id="penghasilan_ayah" value="<?php echo $penghasilan_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Nama Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nama_ibu" id="nama_ibu" value="<?php echo $nama_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Alamat Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="alamat_ibu" id="alamat_ibu" value="<?php echo $alamat_ibu;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Usia Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="number" required="required" name="usia_ibu" id="usia_ibu" value="<?php echo $usia_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Agama Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="agama_ibu" id="agama_ibu" value="<?php echo $agama_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Pendidikan Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="pendidikan_ibu" value="<?php echo $pendidikan_ibu;?>" id="pendidikan_ibu"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Pekerjaan Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="pekerjaan_ibu" id="pekerjaan_ibu" value="<?php echo $pekerjaan_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Penghasilan Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="penghasilan_ibu" id="penghasilan_ibu" value="<?php echo $penghasilan_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
				<input type="submit" value="LANJUTKAN" id="submit" class="button" style="margin-top:10px;">
			</form><?php
		}
		elseif ($_POST['process']=="check") {
			
				$nama=strip_tags($_POST['nama']); $nama=str_replace('"','',$nama); $nama=str_replace("'","",$nama);
				$nik=strip_tags($_POST['nik']); $nik=str_replace('"','',$nik); $nik=str_replace("'","",$nik);
				$tempat_lahir=strip_tags($_POST['tempat_lahir']); $tempat_lahir=str_replace('"','',$tempat_lahir); $tempat_lahir=str_replace("'","",$tempat_lahir);
				$lahirtgl=strip_tags($_POST['lahirtgl']);  $lahirtgl=str_replace('"','',$lahirtgl); $lahirtgl=str_replace("'","",$lahirtgl);
				$lahirbln=strip_tags($_POST['lahirbln']);  $lahirbln=str_replace('"','',$lahirbln); $lahirbln=str_replace("'","",$lahirbln);
				$lahirthn=strip_tags($_POST['lahirthn']);  $lahirthn=str_replace('"','',$lahirthn); $lahirthn=str_replace("'","",$lahirthn);			 
				$kelamin_jenis=strip_tags($_POST['kelamin_jenis']); $kelamin_jenis=str_replace('"','',$kelamin_jenis); $kelamin_jenis=str_replace("'","",$kelamin_jenis);	
				//if ($kelamin_jenis=="L") { $kelamin="Laki-Laki"; } else { $kelamin="Perempuan"; }
				$agama=strip_tags($_POST['agama']); $agama=str_replace('"','',$agama); $agama=str_replace("'","",$agama);
				$status_anak=strip_tags($_POST['status_anak']); $status_anak=str_replace('"','',$status_anak); $status_anak=str_replace("'","",$status_anak);
				$anak_ke=strip_tags($_POST['anak_ke']); $anak_ke=str_replace('"','',$anak_ke); $anak_ke=str_replace("'","",$anak_ke);
				$jumlah_saudara=strip_tags($_POST['jumlah_saudara']); $jumlah_saudara=str_replace('"','',$jumlah_saudara); $jumlah_saudara=str_replace("'","",$jumlah_saudara);
				$tinggi_badan=strip_tags($_POST['tinggi_badan']); $tinggi_badan=str_replace('"','',$tinggi_badan); $tinggi_badan=str_replace("'","",$tinggi_badan);
				$berat_badan=strip_tags($_POST['berat_badan']); $berat_badan=str_replace('"','',$berat_badan); $berat_badan=str_replace("'","",$berat_badan);
				$cacat_badan=strip_tags($_POST['cacat_badan']); $cacat_badan=str_replace('"','',$cacat_badan); $cacat_badan=str_replace("'","",$cacat_badan);
				$pernah_sakit=strip_tags($_POST['pernah_sakit']); $pernah_sakit=str_replace('"','',$pernah_sakit); $pernah_sakit=str_replace("'","",$pernah_sakit);
				$nama_penyakit=strip_tags($_POST['nama_penyakit']); $nama_penyakit=str_replace('"','',$nama_penyakit); $nama_penyakit=str_replace("'","",$nama_penyakit);
				$lama_sakit=strip_tags($_POST['lama_sakit']); $lama_sakit=str_replace('"','',$lama_sakit); $lama_sakit=str_replace("'","",$lama_sakit);
				$tanggal_sakit=strip_tags($_POST['tanggal_sakit']); $tanggal_sakit=str_replace('"','',$tanggal_sakit); $tanggal_sakit=str_replace("'","",$tanggal_sakit);
				$alamat=strip_tags($_POST['alamat']); $alamat=str_replace('"','',$alamat); $alamat=str_replace("'","",$alamat);
				$kota=strip_tags($_POST['kota']); $kota=str_replace('"','',$kota); $kota=str_replace("'","",$kota);
				$provinsi=strip_tags($_POST['provinsi']); $provinsi=str_replace('"','',$provinsi); $provinsi=str_replace("'","",$provinsi);
				$telepon=strip_tags($_POST['telepon']); $telepon=str_replace('"','',$telepon); $telepon=str_replace("'","",$telepon);
				$email=strip_tags($_POST['email']);	 $email=str_replace('"','',$email); $email=str_replace("'","",$email);
				$asal_sekolah=strip_tags($_POST['asal_sekolah']); $asal_sekolah=str_replace('"','',$asal_sekolah); $asal_sekolah=str_replace("'","",$asal_sekolah);
				$nisn=strip_tags($_POST['nisn']); $nisn=str_replace('"','',$nisn); $nisn=str_replace("'","",$nisn);
				$nama_ayah=strip_tags($_POST['nama_ayah']); $nama_ayah=str_replace('"','',$nama_ayah); $nama_ayah=str_replace("'","",$nama_ayah);
				$alamat_ayah=strip_tags($_POST['alamat_ayah']); $alamat_ayah=str_replace('"','',$alamat_ayah); $alamat_ayah=str_replace("'","",$alamat_ayah);
				$usia_ayah=strip_tags($_POST['usia_ayah']); $usia_ayah=str_replace('"','',$usia_ayah); $usia_ayah=str_replace("'","",$usia_ayah);
				$agama_ayah=strip_tags($_POST['agama_ayah']); $agama_ayah=str_replace('"','',$agama_ayah); $agama_ayah=str_replace("'","",$agama_ayah);
				$pendidikan_ayah=strip_tags($_POST['pendidikan_ayah']); $pendidikan_ayah=str_replace('"','',$pendidikan_ayah); $pendidikan_ayah=str_replace("'","",$pendidikan_ayah);
				$pekerjaan_ayah=strip_tags($_POST['pekerjaan_ayah']); $pekerjaan_ayah=str_replace('"','',$pekerjaan_ayah); $pekerjaan_ayah=str_replace("'","",$pekerjaan_ayah);
				$penghasilan_ayah=strip_tags($_POST['penghasilan_ayah']); $penghasilan_ayah=str_replace('"','',$penghasilan_ayah); $penghasilan_ayah=str_replace("'","",$penghasilan_ayah);
				$nama_ibu=strip_tags($_POST['nama_ibu']); $nama_ibu=str_replace('"','',$nama_ibu); $nama_ibu=str_replace("'","",$nama_ibu);
				$alamat_ibu=strip_tags($_POST['alamat_ibu']); $alamat_ibu=str_replace('"','',$alamat_ibu); $alamat_ibu=str_replace("'","",$alamat_ibu);
				$usia_ibu=strip_tags($_POST['usia_ibu']); $usia_ibu=str_replace('"','',$usia_ibu); $usia_ibu=str_replace("'","",$usia_ibu);
				$agama_ibu=strip_tags($_POST['agama_ibu']); $agama_ibu=str_replace('"','',$agama_ibu); $agama_ibu=str_replace("'","",$agama_ibu);
				$pendidikan_ibu=strip_tags($_POST['pendidikan_ibu']); $pendidikan_ibu=str_replace('"','',$pendidikan_ibu); $pendidikan_ibu=str_replace("'","",$pendidikan_ibu);
				$pekerjaan_ibu=strip_tags($_POST['pekerjaan_ibu']); $pekerjaan_ibu=str_replace('"','',$pekerjaan_ibu); $pekerjaan_ibu=str_replace("'","",$pekerjaan_ibu);
				$penghasilan_ibu=strip_tags($_POST['penghasilan_ibu']); $penghasilan_ibu=str_replace('"','',$penghasilan_ibu); $penghasilan_ibu=str_replace("'","",$penghasilan_ibu);
				
				if ($nama=="") { ?><h3>Nama Masih Kosong</h3>Nama Harus Diisi. Silahkan Ulangi lagi<?php	}
				elseif ($kota=="") { ?><h3>Kota Masih Kosong</h3>Kota Harus Diisi. Silahkan Ulangi lagi<?php	}
				else { ?>
				<script type="text/javascript">	
				$(document).ready(function() {
					var cekangka = /^[0-9]+$/;
					var cekhuruf = /^[A-Za-z .,]+$/;
					function camelcase(str) {
						return str.replace(/(?:^|\s)\w/g, function(match) {
							return match.toUpperCase();
						});
					}
				
					$("#ya").click(function(){
						$(".val1").show();
						$(".val2").show();
						$(".val3").show();
					});
					$("#tidak").click(function(){
						$(".val1").hide();
						$(".val2").hide();
						$(".val3").hide();
						$(".val1").val('');
						$(".val2").val('');
						$(".val3").val('');
					});
					var cekkelamin=$("#cekkelamin").val();
					if (cekkelamin=="L"){
						$("#cekl").arrt('selected','selected');
					}
					else {
						$("#cek").arrt('selected','selected');
					}
					$("#formdfatar").on("keypress", function(e) {
					return e.keyCode != 13;
					});
				});
			</script>
				<h2>Cek Pendaftaran</h2>
					<form action="" method="post">
						<input type="hidden" name="process" value="save">
						<input type="hidden"  name="nama" value="<?php echo $nama;?>">
						<input type="hidden"  name="nik" value="<?php echo $nik;?>">
						<input type="hidden" name="tempat_lahir" value="<?php echo $tempat_lahir;?>">
						<input type="hidden" name="lahirtgl" value="<?php echo $lahirtgl;?>">
						<input type="hidden" name="lahirbln" value="<?php echo $lahirbln;?>">
						<input type="hidden" name="lahirbln" value="<?php echo $lahirthn;?>">
						<input type="hidden" name="kelamin_jenis" value="<?php echo $kelamin_jenis;?>" id="cekkelamin">
						<input type="hidden" name="agama" value="<?php echo $agama;?>">
						<input type="hidden" name="status_anak" value="<?php echo $status_anak;?>">
						<input type="hidden" name="anak_ke" value="<?php echo $anak_ke;?>">
						<input type="hidden" name="jumlah_saudara" value="<?php echo $jumlah_saudara;?>">
						<input type="hidden" name="tinggi_badan" value="<?php echo $tinggi_badan;?>">
						<input type="hidden" name="berat_badan" value="<?php echo $berat_badan;?>">
						<input type="hidden" name="cacat_badan" value="<?php echo $cacat_badan;?>">
						<input type="hidden" name="pernah_sakit" value="<?php echo $pernah_sakit;?>" id="cekpernahsakit">
						<input type="hidden" name="nama_penyakit" value="<?php echo $nama_penyakit;?>">
						<input type="hidden" name="tanggal_sakit" value="<?php echo $tanggal_sakit;?>">
						<input type="hidden" name="alamat" value="<?php echo $alamat;?>">
						<input type="hidden" name="kota" value="<?php echo $kota;?>">
						<input type="hidden" name="provinsi" value="<?php echo $provinsi;?>">
						<input type="hidden" name="telepon" value="<?php echo $telepon;?>">
						<input type="hidden" name="email" value="<?php echo $email;?>">
						<input type="hidden" name="asal_sekolah" value="<?php echo $asal_sekolah;?>">
						<input type="hidden" name="nisn" value="<?php echo $nisn;?>">
						<input type="hidden" name="nama_ayah" value="<?php echo $nama_ayah;?>">
						<input type="hidden" name="alamat_ayah" value="<?php echo $alamat_ayah;?>">
						<input type="hidden" name="usia_ayah" value="<?php echo $usia_ayah;?>">
						<input type="hidden" name="agama_ayah" value="<?php echo $agama_ayah;?>">
						<input type="hidden" name="pendidikan_ayah" value="<?php echo $pendidikan_ayah;?>">
						<input type="hidden" name="pekerjaan_ayah" value="<?php echo $pekerjaan_ayah;?>">
						<input type="hidden" name="penghasilan_ayah" value="<?php echo $penghasilan_ayah;?>">
						<input type="hidden" name="nama_ibu" value="<?php echo $nama_ibu;?>">
						<input type="hidden" name="alamat_ibu" value="<?php echo $alamat_ibu;?>">
						<input type="hidden" name="usia_ibu" value="<?php echo $usia_ibu;?>">
						<input type="hidden" name="agama_ibu" value="<?php echo $agama_ibu;?>">
						<input type="hidden" name="pendidikan_ibu" value="<?php echo $pendidikan_ibu;?>">
						<input type="hidden" name="pekerjaan_ibu" value="<?php echo $pekerjaan_ibu;?>">
						<input type="hidden" name="penghasilan_ibu" value="<?php echo $penghasilan_ibu;?>">
				
						<div id="view"><div class="view_label"><b>BIODATA</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						<div id="view"><div class="view_label">Nama Lengkap</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nama" id="nama" value="<?php echo $nama;?>" style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Nik</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nik" id="nik" value="<?php echo $nik;?>" style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Tempat Lahir</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="tempat_lahir" required="required" id="tempat_lahir" value="<?php echo $tempat_lahir;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Tanggal Lahir</div><div class="view_dot">:</div>
							<div class="view_content">
								<select name="lahirtgl" style="padding:0px; width:60px;"><?php 
									for ($tgl=1; $tgl<=31; $tgl++) { if ($tgl<10) { $tgljadi="0$tgl"; } else { $tgljadi=$tgl;  } if ($tgl==$lahirtgl){ $tambahan="selected"; } else { $tambahan=""; } ?><option value="<?php echo $tgljadi;?>" style="padding:3px 4px;" <?php echo $tambahan;?>><?php echo $tgljadi;?></option><?php }?></select> &nbsp; 
								<select name="lahirbln" style="padding:0px; width:60px;"><?php 
									for ($bln=1; $bln<=12; $bln++) { if ($bln<10) { $blnjadi="0$bln"; }else { $blnjadi=$bln;} if ($bln==$lahirbln){ $tambahan="selected"; } else { $tambahan=""; }?><option value="<?php echo $blnjadi;?>" style="padding:3px 4px;" <?php echo $tambahan;?>><?php echo $blnjadi;?></option><?php }?></select> &nbsp; 
								<select name="lahirthn" style="padding:0px; width:100px;"><?php 
									for ($thn=1950; $thn<=2010; $thn++) { if ($thn==$lahirthn){ $tambahan="selected"; } else { $tambahan=""; }?><option value="<?php echo $thn;?>" style="padding:3px 4px;" <?php echo $tambahan;?>><?php echo $thn;?></option><?php }?></select>
							</div>
						</div>
						<div id="view"><div class="view_label">Jenis Kelamin</div><div class="view_dot">:</div>
						<div class="view_content">
						<?php if ($kelamin_jenis=="P"){ $atribut="selected"; } else { $atribut="";}?>
								<select name="kelamin_jenis" style="width:98%; max-width:415px; padding:0px;">
									<option value="L" id="cekl" style="padding:3px 4px;">Laki-Laki</option><option value="P" id="cekp" style="padding:3px 4px;" <?php echo $atribut;?>>Perempuan</option>
								</select>
							</div>
						</div>
						<div id="view"><div class="view_label">Agama</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="agama" required="required" id="agama" value="<?php echo $agama;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Status Anak</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="status_anak" required="required" id="status_anak" value="<?php echo $status_anak;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Anak Ke</div><div class="view_dot">:</div><div class="view_content"><input type="number" name="anak_ke" required="required" id="anak_ke" value="<?php echo $anak_ke;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Jumlah Saudara</div><div class="view_dot">:</div><div class="view_content"><input type="number" name="jumlah_saudara" required="required" id="jumlah_saudara" value="<?php echo $jumlah_saudara;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Tinggi Badan</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="tinggi_badan" required="required" id="tinggi_badan"  value="<?php echo $tinggi_badan;?>" style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Berat Badan</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="berat_badan" required="required" id="berat_badan" value="<?php echo $berat_badan;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view" ><div class="view_label">Cacat Badan</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="cacat_badan" required="required" id="cacat_badan" value="<?php echo $cacat_badan;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Pernah Sakit</div><div class="view_dot">:</div><div class="view_content"><?php if ($pernah_sakit=="Ya"){ ?><input type="radio" name="pernah_sakit" value="Ya" checked  id="ya">Ya&nbsp;&nbsp;<?php } else {?><input type="radio" name="pernah_sakit" value="Ya"   id="ya">Ya&nbsp;&nbsp;<?php } if ($pernah_sakit=="Tidak"){?><input type="radio" name="pernah_sakit" value="Tidak" checked id="tidak">Tidak <?php } else { ?> <input type="radio" name="pernah_sakit" value="Tidak"  id="tidak">Tidak <?php } ?></div></div>
						<div id="view" class="val1"><div class="view_label">Nama Penyakit</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="nama_penyakit"  id="nama_penyakit" value="<?php echo $nama_penyakit;?>" style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view" class="val2"><div class="view_label" >Tanggal Sakit</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="tanggal_sakit" id="tanggal_sakit" value="<?php echo $tanggal_sakit;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view" class="val3"><div class="view_label">Lama Sakit</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="lama_sakit"  value="<?php echo $lama_sakit;?>" id="lama_sakit"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label"><b>KONTAK</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						<div id="view"><div class="view_label">Alamat</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="alamat" id="alamat" value="<?php echo $alamat;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Kota</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="kota" id="kota" value="<?php echo $kota;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Provinsi</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="provinsi" id="provinsi" value="<?php echo $provinsi;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Telepon</div><div class="view_dot">:</div><div class="view_content"><input type="phone" required="required" name="telepon" id="telepon" value="<?php echo $telepon;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Email</div><div class="view_dot">:</div><div class="view_content"><input type="email" placeholder="Jika Ada"  name="email" id="email" value="<?php echo $email;?>"   style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Asal Sekolah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="asal_sekolah" value="<?php echo $asal_sekolah;?>" id="asal_sekolah"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Nisn</div><div class="view_dot">:</div><div class="view_content"><input type="number" required="required" name="nisn" id="nisn" value="<?php echo $nisn;?>" readonly  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label"><b>Data Orangtua</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						<div id="view"><div class="view_label">Nama Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nama_ayah" id="nama_ayah" value="<?php echo $nama_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Alamat Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="alamat_ayah" id="alamat_ayah" value="<?php echo $alamat_ayah;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Usia Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="number" required="required" name="usia_ayah" id="usia_ayah" value="<?php echo $usia_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Agama Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="agama_ayah" id="agama_ayah" value="<?php echo $agama_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Pendidikan Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="pendidikan_ayah" id="pendidikan_ayah" value="<?php echo $pendidikan_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Pekerjaan Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="pekerjaan_ayah" id="pekerjaan_ayah" value="<?php echo $pekerjaan_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Penghasilan Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="penghasilan_ayah" id="penghasilan_ayah" value="<?php echo $penghasilan_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Nama Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nama_ibu" id="nama_ibu" value="<?php echo $nama_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Alamat Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="alamat_ibu" id="alamat_ibu" value="<?php echo $alamat_ibu;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Usia Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="number" required="required" name="usia_ibu" id="usia_ibu" value="<?php echo $usia_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Agama Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="agama_ibu" id="agama_ibu" value="<?php echo $agama_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Pendidikan Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="pendidikan_ibu" value="<?php echo $pendidikan_ibu;?>" id="pendidikan_ibu"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Pekerjaan Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="pekerjaan_ibu" id="pekerjaan_ibu" value="<?php echo $pekerjaan_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Penghasilan Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="penghasilan_ibu" id="penghasilan_ibu" value="<?php echo $penghasilan_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<input type="submit" value="SIMPAN" class="button" onclick="return confirm ('Yakin Sudah Benar ?')" style="margin-top:10px;">
					</form><?php
					
				}
		}
		elseif ($_POST['process']=="save") {
			
				$nama=strip_tags($_POST['nama']); $nama=str_replace('"','',$nama); $nama=str_replace("'","",$nama);
				$nik=strip_tags($_POST['nik']); $nik=str_replace('"','',$nik); $nik=str_replace("'","",$nik);
				$tempat_lahir=strip_tags($_POST['tempat_lahir']); $tempat_lahir=str_replace('"','',$tempat_lahir); $tempat_lahir=str_replace("'","",$tempat_lahir);
				$lahirtgl=strip_tags($_POST['lahirtgl']);  $lahirtgl=str_replace('"','',$lahirtgl); $lahirtgl=str_replace("'","",$lahirtgl);
				$lahirbln=strip_tags($_POST['lahirbln']);  $lahirbln=str_replace('"','',$lahirbln); $lahirbln=str_replace("'","",$lahirbln);
				$lahirthn=strip_tags($_POST['lahirthn']);  $lahirthn=str_replace('"','',$lahirthn); $lahirthn=str_replace("'","",$lahirthn);			 
				$tanggaljadi="$lahirthn-$lahirbln-$lahirtgl";
				$kelamin_jenis=strip_tags($_POST['kelamin_jenis']); $kelamin_jenis=str_replace('"','',$kelamin_jenis); $kelamin_jenis=str_replace("'","",$kelamin_jenis);	
				$agama=strip_tags($_POST['agama']); $agama=str_replace('"','',$agama); $agama=str_replace("'","",$agama);
				$status_anak=strip_tags($_POST['status_anak']); $status_anak=str_replace('"','',$status_anak); $status_anak=str_replace("'","",$status_anak);
				$anak_ke=strip_tags($_POST['anak_ke']); $anak_ke=str_replace('"','',$anak_ke); $anak_ke=str_replace("'","",$anak_ke);
				$jumlah_saudara=strip_tags($_POST['jumlah_saudara']); $jumlah_saudara=str_replace('"','',$jumlah_saudara); $jumlah_saudara=str_replace("'","",$jumlah_saudara);
				$tinggi_badan=strip_tags($_POST['tinggi_badan']); $tinggi_badan=str_replace('"','',$tinggi_badan); $tinggi_badan=str_replace("'","",$tinggi_badan);
				$berat_badan=strip_tags($_POST['berat_badan']); $berat_badan=str_replace('"','',$berat_badan); $berat_badan=str_replace("'","",$berat_badan);
				$cacat_badan=strip_tags($_POST['cacat_badan']); $cacat_badan=str_replace('"','',$cacat_badan); $cacat_badan=str_replace("'","",$cacat_badan);
				$pernah_sakit=strip_tags($_POST['pernah_sakit']); $pernah_sakit=str_replace('"','',$pernah_sakit); $pernah_sakit=str_replace("'","",$pernah_sakit);
				$nama_penyakit=strip_tags($_POST['nama_penyakit']); $nama_penyakit=str_replace('"','',$nama_penyakit); $nama_penyakit=str_replace("'","",$nama_penyakit);
				$lama_sakit=strip_tags($_POST['lama_sakit']); $lama_sakit=str_replace('"','',$lama_sakit); $lama_sakit=str_replace("'","",$lama_sakit);
				$tanggal_sakit=strip_tags($_POST['tanggal_sakit']); $tanggal_sakit=str_replace('"','',$tanggal_sakit); $tanggal_sakit=str_replace("'","",$tanggal_sakit);
				$alamat=strip_tags($_POST['alamat']); $alamat=str_replace('"','',$alamat); $alamat=str_replace("'","",$alamat);
				$kota=strip_tags($_POST['kota']); $kota=str_replace('"','',$kota); $kota=str_replace("'","",$kota);
				$provinsi=strip_tags($_POST['provinsi']); $provinsi=str_replace('"','',$provinsi); $provinsi=str_replace("'","",$provinsi);
				$telepon=strip_tags($_POST['telepon']); $telepon=str_replace('"','',$telepon); $telepon=str_replace("'","",$telepon);
				$email=strip_tags($_POST['email']);	 $email=str_replace('"','',$email); $email=str_replace("'","",$email);
				$asal_sekolah=strip_tags($_POST['asal_sekolah']); $asal_sekolah=str_replace('"','',$asal_sekolah); $asal_sekolah=str_replace("'","",$asal_sekolah);
				$nisn=strip_tags($_POST['nisn']); $nisn=str_replace('"','',$nisn); $nisn=str_replace("'","",$nisn);
				$nama_ayah=strip_tags($_POST['nama_ayah']); $nama_ayah=str_replace('"','',$nama_ayah); $nama_ayah=str_replace("'","",$nama_ayah);
				$alamat_ayah=strip_tags($_POST['alamat_ayah']); $alamat_ayah=str_replace('"','',$alamat_ayah); $alamat_ayah=str_replace("'","",$alamat_ayah);
				$usia_ayah=strip_tags($_POST['usia_ayah']); $usia_ayah=str_replace('"','',$usia_ayah); $usia_ayah=str_replace("'","",$usia_ayah);
				$agama_ayah=strip_tags($_POST['agama_ayah']); $agama_ayah=str_replace('"','',$agama_ayah); $agama_ayah=str_replace("'","",$agama_ayah);
				$pendidikan_ayah=strip_tags($_POST['pendidikan_ayah']); $pendidikan_ayah=str_replace('"','',$pendidikan_ayah); $pendidikan_ayah=str_replace("'","",$pendidikan_ayah);
				$pekerjaan_ayah=strip_tags($_POST['pekerjaan_ayah']); $pekerjaan_ayah=str_replace('"','',$pekerjaan_ayah); $pekerjaan_ayah=str_replace("'","",$pekerjaan_ayah);
				$penghasilan_ayah=strip_tags($_POST['penghasilan_ayah']); $penghasilan_ayah=str_replace('"','',$penghasilan_ayah); $penghasilan_ayah=str_replace("'","",$penghasilan_ayah);
				$nama_ibu=strip_tags($_POST['nama_ibu']); $nama_ibu=str_replace('"','',$nama_ibu); $nama_ibu=str_replace("'","",$nama_ibu);
				$alamat_ibu=strip_tags($_POST['alamat_ibu']); $alamat_ibu=str_replace('"','',$alamat_ibu); $alamat_ibu=str_replace("'","",$alamat_ibu);
				$usia_ibu=strip_tags($_POST['usia_ibu']); $usia_ibu=str_replace('"','',$usia_ibu); $usia_ibu=str_replace("'","",$usia_ibu);
				$agama_ibu=strip_tags($_POST['agama_ibu']); $agama_ibu=str_replace('"','',$agama_ibu); $agama_ibu=str_replace("'","",$agama_ibu);
				$pendidikan_ibu=strip_tags($_POST['pendidikan_ibu']); $pendidikan_ibu=str_replace('"','',$pendidikan_ibu); $pendidikan_ibu=str_replace("'","",$pendidikan_ibu);
				$pekerjaan_ibu=strip_tags($_POST['pekerjaan_ibu']); $pekerjaan_ibu=str_replace('"','',$pekerjaan_ibu); $pekerjaan_ibu=str_replace("'","",$pekerjaan_ibu);
				$penghasilan_ibu=strip_tags($_POST['penghasilan_ibu']); $penghasilan_ibu=str_replace('"','',$penghasilan_ibu); $penghasilan_ibu=str_replace("'","",$penghasilan_ibu);			
				mysqli_query($koneksi, "UPDATE psb_member SET nama='$nama',nik='$nik', tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggaljadi', kelamin_jenis='$kelamin_jenis',
					agama='$agama', status_anak='$status_anak', anak_ke='$anak_ke', jumlah_saudara='$jumlah_saudara', tinggi_badan='$tinggi_badan',berat_badan='$berat_badan',cacat_badan='$cacat_badan',
					pernah_sakit='$pernah_sakit',nama_penyakit='$nama_penyakit', lama_sakit='$lama_sakit',tanggal_sakit='$tanggal_sakit',alamat='$alamat',kota='$kota',provinsi='$provinsi',telepon='$telepon',email='$email',
					asal_sekolah='$asal_sekolah',nisn='$nisn',nama_ayah='$nama_ayah',alamat_ayah='$alamat_ayah',usia_ayah='$usia_ayah',agama_ayah='$agama_ayah',pendidikan_ayah='$pendidikan_ayah',pekerjaan_ayah='$pekerjaan_ayah',penghasilan_ayah='$penghasilan_ayah',
					nama_ibu='$nama_ibu',alamat_ibu='$alamat_ibu',usia_ibu='$usia_ibu',agama_ibu='$agama_ibu',pendidikan_ibu='$pendidikan_ibu',pekerjaan_ibu='$pekerjaan_ibu',penghasilan_ibu='$penghasilan_ibu' WHERE  nisn='$nisn' AND subdomain='$subdomain'"); ?>
				<h3>Data Berhasil Disimpan</h3>Selamat, Data Berhasilh Disimpan<?php
		}
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$qset=mysqli_query($koneksi, "SELECT paket,aktif FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket']; $aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket basic dan profesional.<?php
		}
		else {
			if ($aktif==0) { ?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php }
			else {
				$judulmod="Calon Siswa";
				$tabel="psb_member";
				$batas=30;
				$kolom="nama,telepon,email";
				$lebar="200,100,150";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus,password";
				// Lihat
				$jumdetail="multi";
				$tipedetail="table";
				$isidetail="nama,nik,tempat_lahir,tanggal_lahir,kelamin_jenis,agama,status_anak,anak_ke,jumlah_saudara,tinggi_badan,berat_badan,cacat_badan,pernah_sakit,nama_penyakit,tanggal_sakit,lama_sakit,alamat,kecamatan,kota,provinsi,kodepos,telepon,asal_sekolah,nisn,nama_ayah,alamat_ayah,usia_ayah,agama_ayah,pendidikan_ayah,pekerjaan_ayah,penghasilan_ayah,nama_ibu,alamat_ibu,usia_ibu,agama_ibu,pendidikan_ibu,pekerjaan_ibu,penghasilan_ibu";
				// Delete
				$tipedelete="";
				// Tambah
				$jenisinput="";
				$onclick="cekNama";
				$tipeinput="";
				$forminput="nama,nik,tempat_lahir,tanggal_lahir,kelamin_jenis,agama,status_anak,anak_ke,jumlah_saudara,tinggi_badan,berat_badan,cacat_badan,pernah_sakit,nama_penyakit,tanggal_sakit,lama_sakit,alamat,kecamatan,kota,provinsi,kodepos,telepon,asal_sekolah,nisn,nama_ayah,alamat_ayah,usia_ayah,agama_ayah,pendidikan_ayah,pekerjaan_ayah,penghasilan_ayah,nama_ibu,alamat_ibu,usia_ibu,agama_ibu,pendidikan_ibu,pekerjaan_ibu,penghasilan_ibu";
				// Tambah & Edit Rinci
				$jenisinputrinci="";
				$onclickrinci="cekNama";
				$tipeinputrinci="";
				$forminputrinci="nama,nik,tempat_lahir,tanggal_lahir,kelamin_jenis,agama,status_anak,anak_ke,jumlah_saudara,tinggi_badan,berat_badan,cacat_badan,pernah_sakit,nama_penyakit,tanggal_sakit,lama_sakit,alamat,kecamatan,kota,provinsi,kodepos,telepon,asal_sekolah,nisn,nama_ayah,alamat_ayah,usia_ayah,agama_ayah,pendidikan_ayah,pekerjaan_ayah,penghasilan_ayah,nama_ibu,alamat_ibu,usia_ibu,agama_ibu,pendidikan_ibu,pekerjaan_ibu,penghasilan_ibu";
				$formeditrinci="nama,nik,tempat_lahir,tanggal_lahir,kelamin_jenis,agama,status_anak,anak_ke,jumlah_saudara,tinggi_badan,berat_badan,cacat_badan,pernah_sakit,nama_penyakit,tanggal_sakit,lama_sakit,alamat,kecamatan,kota,provinsi,kodepos,telepon,asal_sekolah,nisn,nama_ayah,alamat_ayah,usia_ayah,agama_ayah,pendidikan_ayah,pekerjaan_ayah,penghasilan_ayah,nama_ibu,alamat_ibu,usia_ibu,agama_ibu,pendidikan_ibu,pekerjaan_ibu,penghasilan_ibu";
				$module=new admin();
				$module->get_variable();
				$module->setLinkSub($linksub);
				if (empty ($act)) {
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				} 
				elseif($act=="semua"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif($act=="urut"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif($act=="cari"){
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
				}
				elseif ($act=="lihat") {
					$module->detail($subdomain,$linksub,$judulmod,$tabel,$jumdetail,$tipedetail,$isidetail);
				} 
				elseif ($act=="hapus") {
					$module->hapus($subdomain,$linksub,$tabel,$tipedelete,$folder);
				} 
				elseif ($act=="hapusmulti") {
					$module->hapusmulti($subdomain,$linksub,$tabel,$tipedelete,$folder);
				} 
				elseif ($act=="tambah") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
elseif ($act=="password") {
$jenisinput="";
$onclick="";
$tipeinput="";
$forminput="password";
$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
				elseif ($act=="tambahrinci") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
				} 
				elseif ($act=="ubah") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
				elseif ($act=="ubahrinci") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
				} 
				else {
					$module->tabel($subdomain,$linksub,$judulmod,$tabel,$batas,$act,$kolom,$kolomtgl,$kolomvisit,$kolomkomen,$lebar,$tombolact);
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