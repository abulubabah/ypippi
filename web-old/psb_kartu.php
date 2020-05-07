<?php

/**
 * Buat Id
 *
 * @param { integer } $no
 * @return { integer } id
 **/
function generateId($no){
    global $db;
    global $subdomain;
    
    // cek dari tabel tmp_kartu
    $cek=$db->query("SELECT kartu_id FROM tmp_kartu WHERE psb_member_id='".(int)$no."' AND subdomain='".$subdomain."'");
    
    if ($cek->num_rows < 1){
        $sql=" SELECT psb.no FROM psb_member psb WHERE psb.subdomain='".$subdomain."' ORDER BY psb.no ASC";
        
        $query=$db->query($sql);
        $i=1;
        $hasil=array();
        foreach ($query->rows as $data){
            $hasil[$data['no']]=$i;
            $i++;
        }
        
        $output=$hasil[$no];
        $db->query("INSERT INTO tmp_kartu SET subdomain='".$subdomain."',psb_member_id='".$no."',kartu_id='".$output."',tgl=now()");
        unset($hasil);
    } else {
        $output=$cek->row['kartu_id'];
    }
     
    return $output;
}
 
/**
 * Fungsi untuk membuat form kartu peserta ppdb
 * 
 * @param { string } $subdomain
 * @param { string } $domain
 * @param { string } $nisn
 * @param { string } $username
 **/
function formKartuPeserta($subdomain, $domain, $nisn) {
    // Get setting.judul with with $subdomain parameter in query
    $sqlSetting = "SELECT judul FROM setting WHERE subdomain = '" . $subdomain . "'";
    $querySetting = mysqli_query($koneksi, $sqlSetting);
    $dataSetting = mysqli_fetch_assoc($querySetting);
    
    $settingJudul = $dataSetting['judul'];
    
    // Get psb setting data with $subdomain parameter in query
    $sqlPsbSetting = "SELECT * FROM psb_setting WHERE subdomain = '" . $subdomain . "'";
    $queryPsbSetting = mysqli_query($koneksi, $sqlPsbSetting);
    $dataPsbSetting =  mysqli_fetch_assoc($queryPsbSetting);
    
    $psbSettingHead1 = $dataPsbSetting['head1'];
    $psbSettingHead2 = $dataPsbSetting['head2'];
    $psbSettingHead3 = $dataPsbSetting['head3'];
    $psbSettingAlamat = $dataPsbSetting['alamat'];
    $psbSettingLogo = $dataPsbSetting['logo'];
	$psbSettingLogo2 = $dataPsbSetting['logo2'];
	
    // Get psb member's data with $nisn and $subdomain parameter in query
    $sqlMember = "SELECT no, nama, nisn, asal_sekolah FROM psb_member WHERE nisn = '" . $nisn . "' AND subdomain = '" . $subdomain . "' LIMIT 1";
    $queryMember = mysqli_query($koneksi, $sqlMember);
    $dataMember = mysqli_fetch_assoc($queryMember);
    
    $memberNo = generateId($dataMember['no']);
    $memberNisn = $dataMember['nisn'];
    $memberNama = $dataMember['nama'];
    $memberAsalSekolah = $dataMember['asal_sekolah'];
    ?>
    <div class="kartu-ppdb__wrapper">
		<div class="kartu-ppdb">
			<div class="kartu-ppdb__header">
				<div class="kartu-ppdb__logo-wrapper">
					<img class="kartu-ppdb__logo" src="//<?php echo $domain . "/picture/" . $psbSettingLogo;?>" alt="">
				</div>
				<div class="kartu-ppdb__head-wrapper">
					<h5 class="kartu-ppdb__head"><?php echo $psbSettingHead1;?></h5>
					<h5 class="kartu-ppdb__head"><?php echo $psbSettingHead2;?></h5>
					<h5 class="kartu-ppdb__head"><?php echo $psbSettingHead3;?></h5>
					<h5 class="kartu-ppdb__head kartu-ppdb__head--thin kartu-ppdb__head--italic"><?php echo $psbSettingAlamat;?></h5>
				</div>
				<div class="kartu-ppdb__logo-wrapper">
					<img class="kartu-ppdb__logo" src="//<?php echo $domain . "/picture/" . $psbSettingLogo2;?>" alt="">
				</div>
			</div>
			<div class="kartu-ppdb__content">
				<h5 class="kartu-ppdb__content-header">KARTU PESERTA</h5>
				<div class="kartu-ppdb__form-wrapper">
					<div class="kartu-ppdb__form">
						<span class="kartu-ppdb__form-title">Nomor</span>
						<span class="kartu-ppdb__form-divider">:</span>
						<span class="kartu-ppdb__form-content"><?php echo $memberNo;?></span>
					</div>
					<div class="kartu-ppdb__form">
						<span class="kartu-ppdb__form-title">NISN</span>
						<span class="kartu-ppdb__form-divider">:</span>
						<span class="kartu-ppdb__form-content"><?php echo $memberNisn;?></span>
					</div>
					<div class="kartu-ppdb__form">
						<span class="kartu-ppdb__form-title">Nama</span>
						<span class="kartu-ppdb__form-divider">:</span>
						<span class="kartu-ppdb__form-content"><?php echo $memberNama;?></span>
					</div>
					<div class="kartu-ppdb__form">
						<span class="kartu-ppdb__form-title">Asal Sekolah</span>
						<span class="kartu-ppdb__form-divider">:</span>
						<span class="kartu-ppdb__form-content"><?php echo $memberAsalSekolah;?></span>
					</div>
				</div>
			</div>
		</div>
	</div>
    <?php
}