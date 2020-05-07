<?php     
if ($tampil==1) {  
	if(empty($akses)){  
		header("location:index.php");  
	}
	elseif($akses=="member"){ 
		$uname=$_SESSION['uname'];
		$nisn=$_SESSION['nisn'];
		$qcekmember=mysqli_query($koneksi, "SELECT * FROM psb_member WHERE nisn='$nisn' AND subdomain='$subdomain'");
		$data=mysqli_fetch_array($qcekmember);
		$nomem=$data['no']; ?>
<script type="text/javascript" src="//storage.googleapis.com/s.mysch.id/js/zebra_datepicker.src.js"></script>
	<script type="text/javascript">bkLib.onDomLoaded(function() { new nicEditor({fullPanel : true}).panelInstance('editor');});</script><?php
		if (empty($_POST['process'])) {
			
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
			$alamat=$data['alamat']; $dusun=$data['dusun']; $kelurahan=$data['kelurahan']; $rt=$data['rt']; $rw=$data['rw'];
			$kota=$data['kota']; $kecamatan=$data['kecamatan'];
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
			$nama_wali=$data['nama_wali'];
			$alamat_wali=$data['alamat_wali'];
			$usia_wali=$data['usia_wali'];
			$agama_wali=$data['agama_wali'];
			$pendidikan_wali=$data['pendidikan_wali'];
			$pekerjaan_wali=$data['pekerjaan_wali'];
			$penghasilan_wali=$data['penghasilan_wali'];
			$prestasi=$data['prestasi'];
			$beasiswa=$data['beasiswa']; ?>
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
				<input type="hidden" name="process" value="save">
				<div id="view"><div class="view_label"><b>BIODATA</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						<div id="view"><div class="view_label">Nama Lengkap</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="nama" id="nama" value="<?php echo $nama;?>" style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">N I K</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="nik" id="nik" value="<?php echo $nik;?>" style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">N I S N</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="nisn" id="nisn" value="<?php echo $nisn;?>" readonly  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">N I S</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="nis" id="nis" value="<?php echo $nis;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
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
                        <div id="view">
                            <div class="view_label">Jenis Kelamin</div>
                            <div class="view_dot">:</div>
                            <div class="view_content">
                                <?php 
                                if ($kelamin_jenis=="P") {
                                    $atribut="selected"; 
                                } else {
                                    $atribut="";
                                }
                                ?>
                                <select name="kelamin_jenis" style="width:98%; max-width:415px; padding:0px;">
                                    <?php
                                    if ($kelamin_jenis=="P") { 
                                        ?>
                                        <option value="P" id="cekp" style="padding:3px 4px;">Perempuan</option>
                                        <option value="L" id="cekl" style="padding:3px 4px;">Laki-Laki</option>
                                        <?php
                                    } else {
                                        ?>
                                        <option value="L" id="cekl" style="padding:3px 4px;">Laki-Laki</option>
                                        <option value="P" id="cekp" style="padding:3px 4px;">Perempuan</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
						<div id="view"><div class="view_label">Agama</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="agama" required="required" id="agama" value="<?php echo $agama;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Status Anak</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="status_anak" required="required" id="status_anak" value="<?php echo $status_anak;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Anak Ke</div><div class="view_dot">:</div><div class="view_content"><input type="number" name="anak_ke" required="required" id="anak_ke" value="<?php echo $anak_ke;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Jumlah Saudara</div><div class="view_dot">:</div><div class="view_content"><input type="number" name="jumlah_saudara" required="required" id="jumlah_saudara" value="<?php echo $jumlah_saudara;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Tinggi Badan</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="tinggi_badan" required="required" id="tinggi_badan"  value="<?php echo $tinggi_badan;?>" style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Berat Badan</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="berat_badan" required="required" id="berat_badan" value="<?php echo $berat_badan;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view" ><div class="view_label">Cacat Badan</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="cacat_badan" id="cacat_badan" value="<?php echo $cacat_badan;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Pernah Sakit</div><div class="view_dot">:</div><div class="view_content"><?php if ($pernah_sakit=="Ya"){ ?><input type="radio" name="pernah_sakit" value="Ya" checked  id="ya">Ya&nbsp;&nbsp;<?php } else {?><input type="radio" name="pernah_sakit" value="Ya"   id="ya">Ya&nbsp;&nbsp;<?php } if ($pernah_sakit=="Tidak"){?><input type="radio" name="pernah_sakit" value="Tidak" checked id="tidak">Tidak <?php } else { ?> <input type="radio" name="pernah_sakit" value="Tidak"  id="tidak">Tidak <?php } ?></div></div>
						<div id="view" class="val1"><div class="view_label">Nama Penyakit</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="nama_penyakit"  id="nama_penyakit" value="<?php echo $nama_penyakit;?>" style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view" class="val2"><div class="view_label" >Tanggal Sakit</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="tanggal_sakit" id="tanggal_sakit" value="<?php echo $tanggal_sakit;?>"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view" class="val3"><div class="view_label">Lama Sakit</div><div class="view_dot">:</div><div class="view_content"><input type="text" name="lama_sakit"  value="<?php echo $lama_sakit;?>" id="lama_sakit"  style="width:94%; max-width:400px;" maxlength="20"></div></div>
						<div id="view"><div class="view_label">Asal Sekolah</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="asal_sekolah" value="<?php echo $asal_sekolah;?>" id="asal_sekolah"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label"><b>ALAMAT</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						<div id="view"><div class="view_label">Alamat Tinggal</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="alamat" id="alamat" value="<?php echo $alamat;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Dusun</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="dusun" id="dusun" value="<?php echo $dusun;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">RT / RW</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="rt" id="rt" value="<?php echo $rt;?>"  style="width:94%; max-width:100px;" maxlength="100"> / <input type="text" required="required" name="rw" id="rw" value="<?php echo $rw;?>"  style="width:94%; max-width:100px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Kelurahan</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="kelurahan" id="kelurahan" value="<?php echo $kelurahan;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Kecamatan</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="kecamatan" id="kecamatan" value="<?php echo $kecamatan;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">Kab / Kota</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="kota" id="kota" value="<?php echo $kota;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Provinsi</div><div class="view_dot">:</div><div class="view_content"><input type="text" required="required" name="provinsi" id="provinsi" value="<?php echo $provinsi;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Telepon</div><div class="view_dot">:</div><div class="view_content"><input type="phone" name="telepon" id="telepon" value="<?php echo $telepon;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Email</div><div class="view_dot">:</div><div class="view_content"><input type="email" placeholder="Jika Ada"  name="email" id="email" value="<?php echo $email;?>"   style="width:94%; max-width:400px;" maxlength="50"></div></div>							
						<div id="view"><div class="view_label"><b>ORANG TUA / WALI</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						<div id="view"><div class="view_label">Nama Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="nama_ayah" id="nama_ayah" value="<?php echo $nama_ayah;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Alamat Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="alamat_ayah" id="alamat_ayah" value="<?php echo $alamat_ayah;?>"  style="width:94%; max-width:400px;" maxlength="200"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Usia Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="number"  name="usia_ayah" id="usia_ayah" value="<?php echo $usia_ayah;?>"  style="width:94%; max-width:200px;" maxlength="50"> Tahun</div></div>
						<div id="view"><div class="view_label">- &nbsp;Agama Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="agama_ayah" id="agama_ayah" value="<?php echo $agama_ayah;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Pendidikan Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="pendidikan_ayah" id="pendidikan_ayah" value="<?php echo $pendidikan_ayah;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Pekerjaan Ayah</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="pekerjaan_ayah" id="pekerjaan_ayah" value="<?php echo $pekerjaan_ayah;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Penghasilan Ayah</div><div class="view_dot">:</div><div class="view_content">Rp. <input type="number"  name="penghasilan_ayah" id="penghasilan_ayah" value="<?php echo $penghasilan_ayah;?>"  style="width:94%; max-width:200px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Nama Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="nama_ibu" id="nama_ibu" value="<?php echo $nama_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Alamat Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="alamat_ibu" id="alamat_ibu" value="<?php echo $alamat_ibu;?>"  style="width:94%; max-width:400px;" maxlength="200"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Usia Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="number"  name="usia_ibu" id="usia_ibu" value="<?php echo $usia_ibu;?>"  style="width:94%; max-width:200px;" maxlength="50"> Tahun</div></div>
						<div id="view"><div class="view_label">- &nbsp;Agama Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="agama_ibu" id="agama_ibu" value="<?php echo $agama_ibu;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Pendidikan Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="pendidikan_ibu" value="<?php echo $pendidikan_ibu;?>" id="pendidikan_ibu"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Pekerjaan Ibu</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="pekerjaan_ibu" id="pekerjaan_ibu" value="<?php echo $pekerjaan_ibu;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Penghasilan Ibu</div><div class="view_dot">:</div><div class="view_content">Rp. <input type="number"  name="penghasilan_ibu" id="penghasilan_ibu" value="<?php echo $penghasilan_ibu;?>"  style="width:94%; max-width:200px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">Nama Wali</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="nama_wali" id="nama_wali" value="<?php echo $nama_wali;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Alamat Wali</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="alamat_wali" id="alamat_wali" value="<?php echo $alamat_wali;?>"  style="width:94%; max-width:400px;" maxlength="200"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Usia Wali</div><div class="view_dot">:</div><div class="view_content"><input type="number"  name="usia_wali" id="usia_wali" value="<?php echo $usia_wali;?>"  style="width:94%; max-width:200px;" maxlength="50"> Tahun</div></div>
						<div id="view"><div class="view_label">- &nbsp;Agama Wali</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="agama_wali" id="agama_wali" value="<?php echo $agama_wali;?>"  style="width:94%; max-width:400px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Pendidikan Wali</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="pendidikan_wali" value="<?php echo $pendidikan_wali;?>" id="pendidikan_wali"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Pekerjaan Wali</div><div class="view_dot">:</div><div class="view_content"><input type="text"  name="pekerjaan_wali" id="pekerjaan_wali" value="<?php echo $pekerjaan_wali;?>"  style="width:94%; max-width:400px;" maxlength="100"></div></div>
						<div id="view"><div class="view_label">- &nbsp;Penghasilan Wali</div><div class="view_dot">:</div><div class="view_content">Rp. <input type="number"  name="penghasilan_wali" id="penghasilan_wali" value="<?php echo $penghasilan_wali;?>"  style="width:94%; max-width:200px;" maxlength="50"></div></div>
						<div id="view"><div class="view_label"><b>PRESTASI</b></div><div class="view_dot"></div><div class="view_content"></div></div>
						Tulis Prestasi Anda<br/><textarea name="prestasi" id="editor"  style="width:94%; max-width:550px; height:150px;"><?php echo $prestasi;?></textarea>
				<input type="submit" value="SIMPAN" id="submit" class="button" style="margin-top:10px;">
			</form><?php
		}
		elseif ($_POST['process']=="save") {
			
				$nama=strip_tags($_POST['nama']); $nama=str_replace('"','',$nama); $nama=str_replace("'","",$nama);
				$nik=strip_tags($_POST['nik']); $nik=str_replace('"','',$nik); $nik=str_replace("'","",$nik);
				$nisn=strip_tags($_POST['nisn']); $nisn=str_replace('"','',$nisn); $nisn=str_replace("'","",$nisn);
				$nis=strip_tags($_POST['nis']); $nis=str_replace('"','',$nis); $nis=str_replace("'","",$nis);
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
				$asal_sekolah=strip_tags($_POST['asal_sekolah']); $asal_sekolah=str_replace('"','',$asal_sekolah); $asal_sekolah=str_replace("'","",$asal_sekolah);
				$alamat=strip_tags($_POST['alamat']); $alamat=str_replace('"','',$alamat); $alamat=str_replace("'","",$alamat);
				$dusun=strip_tags($_POST['dusun']); $dusun=str_replace('"','',$dusun); $dusun=str_replace("'","",$dusun);
				$rt=strip_tags($_POST['rt']); $rt=str_replace('"','',$rt); $rt=str_replace("'","",$rt);
				$rw=strip_tags($_POST['rw']); $rw=str_replace('"','',$rw); $rw=str_replace("'","",$rw);
				$kelurahan=strip_tags($_POST['kelurahan']); $kelurahan=str_replace('"','',$kelurahan); $kelurahan=str_replace("'","",$kelurahan);
				$kecamatan=strip_tags($_POST['kecamatan']); $kecamatan=str_replace('"','',$kecamatan); $kecamatan=str_replace("'","",$kecamatan);
				$kota=strip_tags($_POST['kota']); $kota=str_replace('"','',$kota); $kota=str_replace("'","",$kota);
				$provinsi=strip_tags($_POST['provinsi']); $provinsi=str_replace('"','',$provinsi); $provinsi=str_replace("'","",$provinsi);
				$telepon=strip_tags($_POST['telepon']); $telepon=str_replace('"','',$telepon); $telepon=str_replace("'","",$telepon);
				$email=strip_tags($_POST['email']);	 $email=str_replace('"','',$email); $email=str_replace("'","",$email);
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
				$nama_wali=strip_tags($_POST['nama_wali']); $nama_wali=str_replace('"','',$nama_wali); $nama_wali=str_replace("'","",$nama_wali);
				$alamat_wali=strip_tags($_POST['alamat_wali']); $alamat_wali=str_replace('"','',$alamat_wali); $alamat_wali=str_replace("'","",$alamat_wali);
				$usia_wali=strip_tags($_POST['usia_wali']); $usia_wali=str_replace('"','',$usia_wali); $usia_wali=str_replace("'","",$usia_wali);
				$agama_wali=strip_tags($_POST['agama_wali']); $agama_wali=str_replace('"','',$agama_wali); $agama_wali=str_replace("'","",$agama_wali);
				$pendidikan_wali=strip_tags($_POST['pendidikan_wali']); $pendidikan_wali=str_replace('"','',$pendidikan_wali); $pendidikan_wali=str_replace("'","",$pendidikan_wali);
				$pekerjaan_wali=strip_tags($_POST['pekerjaan_wali']); $pekerjaan_wali=str_replace('"','',$pekerjaan_wali); $pekerjaan_wali=str_replace("'","",$pekerjaan_wali);
				$penghasilan_wali=strip_tags($_POST['penghasilan_wali']); $penghasilan_wali=str_replace('"','',$penghasilan_wali); $penghasilan_wali=str_replace("'","",$penghasilan_wali);
				$prestasi=$_POST['prestasi']; $prestasi=str_replace('"','',$prestasi); $prestasi=str_replace("'","",$prestasi);

				
				mysqli_query($koneksi, "UPDATE psb_member SET nama='$nama',nik='$nik',nisn='$nisn',nis='$nis',tempat_lahir='$tempat_lahir', tanggal_lahir='$tanggaljadi', kelamin_jenis='$kelamin_jenis',
					agama='$agama', status_anak='$status_anak', anak_ke='$anak_ke', jumlah_saudara='$jumlah_saudara', tinggi_badan='$tinggi_badan',berat_badan='$berat_badan',cacat_badan='$cacat_badan',
					pernah_sakit='$pernah_sakit',nama_penyakit='$nama_penyakit', lama_sakit='$lama_sakit',tanggal_sakit='$tanggal_sakit',alamat='$alamat',dusun='$dusun',rt='$rt',rw='$rw',kelurahan='$kelurahan',kecamatan='$kecamatan',kota='$kota',provinsi='$provinsi',telepon='$telepon',email='$email',
					asal_sekolah='$asal_sekolah',nama_ayah='$nama_ayah',alamat_ayah='$alamat_ayah',usia_ayah='$usia_ayah',agama_ayah='$agama_ayah',pendidikan_ayah='$pendidikan_ayah',pekerjaan_ayah='$pekerjaan_ayah',penghasilan_ayah='$penghasilan_ayah',
					nama_ibu='$nama_ibu',alamat_ibu='$alamat_ibu',usia_ibu='$usia_ibu',agama_ibu='$agama_ibu',pendidikan_ibu='$pendidikan_ibu',pekerjaan_ibu='$pekerjaan_ibu',penghasilan_ibu='$penghasilan_ibu',
					nama_wali='$nama_wali',alamat_wali='$alamat_wali',usia_wali='$usia_wali',agama_wali='$agama_wali',pendidikan_wali='$pendidikan_wali',pekerjaan_wali='$pekerjaan_wali',penghasilan_wali='$penghasilan_wali',prestasi='$prestasi' 
					WHERE  no='$nomem' AND subdomain='$subdomain'"); ?>
				<h3>Data Berhasil Disimpan</h3>Selamat, Data Berhasilh Disimpan<?php
		}
	}
	elseif($akses=="admin" or $akses=="super"){ 
		$qset=mysqli_query($koneksi, "SELECT * FROM setting WHERE subdomain='$subdomain'");
		$dset=mysqli_fetch_array($qset);
		$paket=$dset['paket']; $aktif=$dset['aktif'];
		if ($paket=="") { $paket="free"; } 
		if ($paket=="free") { ?>
			<h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini hanya untuk website paket basic dan premium.<?php
		}
		else {
			if ($aktif==0) { ?><h3>Fitur Tidak Aktif</h3>Maaf, Fitur ini belum aktif, karena Anda belum melakukan Pembayaran.<?php }
			else {
				function lihat_dokumen($subdomain,$linksub){?>
					<style type="text/css">
					.halfbar { width:54%; display:table; float:left; margin-left:23%; text-align:left; }
					.gambargaleri { width:94%; border:1px solid #EAEAEA; padding:3%; -moz-box-shadow:0 2px 5px #E4E4E4;-webkit-box-shadow:0 2px 5px #E4E4E4;box-shadow:0 2px 5px #E4E4E4;  }
					</style>
					<h2>Dokumen Siswa</h2><?php
					$admin=new admin();
					$admin->get_variable();
					$domain=$admin->domain;
					$mod=$admin->mod;
					$no=$admin->no;
					$base_folder=$admin->base_folder;
					$ceksiswa=mysqli_query($koneksi, " select nisn,nama from psb_member where no='$no' AND subdomain='$subdomain' AND publish='1'");
					$jumlah=mysqli_num_rows($ceksiswa);
					$data=mysqli_fetch_array($ceksiswa);
					$nisn=$data['nisn'];
					$nama=$data['nama'];
					if ($jumlah<1){ $admin->notify ($subdomain,$linksub,"empty");}
					else{
						$cekdokumen=mysqli_query($koneksi, "select * from psb_dokumen where nisn='$nisn' AND subdomain='$subdomain' AND publish='1'");
						$jumdok=mysqli_num_rows($cekdokumen);
						if ($jumdok<1){ $admin->notify($subdomain,$linksub,"empty");}
						else {?>
								<div class="halfbar">
									<table width="100%">
									<tr valign="top"><?php
									while($data=mysqli_fetch_array($cekdokumen)){
										$gambar=$data['gambar'];
										$judul=$data['judul'];?>
										<td align="center" width="25%" style="padding:10px;">
										<img src="//<?php echo $domain;?>/image.php/<?php echo $gambar;?>?width=480&nocache&quality=100&image=<?php echo $base_folder;?>/cms/picture/<?php echo $gambar;?>" alt="<?php echo $judul;?>" title="<?php echo $judul;?>" width="100%" class="gambargaleri"/><br/><?php echo $judul;?>
										</td><?php
										
									}?>
									</tr>
									</table>
									</div><?php
						}
					}
				}
				$judulmod="Calon Siswa";
				$tabel="psb_member";
				$batas=30;
				$kolom="nama,telepon,email";
				$lebar="200,100,150";
				$kolomtgl=1;
				$kolomvisit=0;
				$kolomkomen=0;
				$tombolact="ubah,lihat,hapus,dokumen";
				// Lihat
				$jumdetail="multi";
				$tipedetail="table";
				$isidetail="nama,nik,nisn,nis,tempat_lahir,tanggal_lahir,kelamin_jenis,agama,status_anak,anak_ke,jumlah_saudara,tinggi_badan,berat_badan,cacat_badan,pernah_sakit,nama_penyakit,tanggal_sakit,lama_sakit,alamat,dusun,rt,rw,kelurahan,kecamatan,kota,provinsi,kodepos,telepon,email,asal_sekolah,nama_ayah,alamat_ayah,usia_ayah,agama_ayah,pendidikan_ayah,pekerjaan_ayah,penghasilan_ayah,nama_ibu,alamat_ibu,usia_ibu,agama_ibu,pendidikan_ibu,pekerjaan_ibu,penghasilan_ibu,nama_wali,alamat_wali,usia_wali,agama_wali,pendidikan_wali,pekerjaan_wali,penghasilan_wali,prestasi,keputusan";
				// Delete
				$tipedelete="";
				// Tambah
				$jenisinput="";
				$onclick="cekNama";
				$tipeinput="";
				$forminput="nama,nik,nisn,nis,tempat_lahir,tanggal_lahir,kelamin_jenis,agama,status_anak,anak_ke,jumlah_saudara,tinggi_badan,berat_badan,cacat_badan,pernah_sakit,nama_penyakit,tanggal_sakit,lama_sakit,alamat,dusun,rt,rw,kelurahan,kecamatan,kota,provinsi,kodepos,telepon,email,asal_sekolah,nama_ayah,alamat_ayah,usia_ayah,agama_ayah,pendidikan_ayah,pekerjaan_ayah,penghasilan_ayah,nama_ibu,alamat_ibu,usia_ibu,agama_ibu,pendidikan_ibu,pekerjaan_ibu,penghasilan_ibu,nama_wali,alamat_wali,usia_wali,agama_wali,pendidikan_wali,pekerjaan_wali,penghasilan_wali,prestasi,keputusan";
				// Tambah & Edit Rinci
				$jenisinputrinci="";
				$onclickrinci="cekNama";
				$tipeinputrinci="";
				$forminputrinci="nama,nik,nisn,nis,tempat_lahir,tanggal_lahir,kelamin_jenis,agama,status_anak,anak_ke,jumlah_saudara,tinggi_badan,berat_badan,cacat_badan,pernah_sakit,nama_penyakit,tanggal_sakit,lama_sakit,alamat,dusun,rt,rw,kelurahan,kecamatan,kota,provinsi,kodepos,telepon,email,asal_sekolah,nama_ayah,alamat_ayah,usia_ayah,agama_ayah,pendidikan_ayah,pekerjaan_ayah,penghasilan_ayah,nama_ibu,alamat_ibu,usia_ibu,agama_ibu,pendidikan_ibu,pekerjaan_ibu,penghasilan_ibu,nama_wali,alamat_wali,usia_wali,agama_wali,pendidikan_wali,pekerjaan_wali,penghasilan_wali,prestasi,keputusan";
				$formeditrinci="nama,nik,nisn,nis,tempat_lahir,tanggal_lahir,kelamin_jenis,agama,status_anak,anak_ke,jumlah_saudara,tinggi_badan,berat_badan,cacat_badan,pernah_sakit,nama_penyakit,tanggal_sakit,lama_sakit,alamat,dusun,rt,rw,kelurahan,kecamatan,kota,provinsi,kodepos,telepon,email,asal_sekolah,nama_ayah,alamat_ayah,usia_ayah,agama_ayah,pendidikan_ayah,pekerjaan_ayah,penghasilan_ayah,nama_ibu,alamat_ibu,usia_ibu,agama_ibu,pendidikan_ibu,pekerjaan_ibu,penghasilan_ibu,nama_wali,alamat_wali,usia_wali,agama_wali,pendidikan_wali,pekerjaan_wali,penghasilan_wali,prestasi,keputusan";
			
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
				elseif ($act=="tambahrinci") {
					$module->input($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$forminputrinci,$folder);
				} 
				elseif ($act=="ubah") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinput,$tipeinput,$onclick,$forminput,$folder);
				} 
				elseif ($act=="ubahrinci") {
					$module->edit($subdomain,$linksub,$judulmod,$tabel,$jenisinputrinci,$tipeinputrinci,$onclickrinci,$formeditrinci,$folder);
				}
				elseif ($act=="dokumen"){
					lihat_dokumen($subdomain,$linksub);
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