	var xmlHttp = buatObjekXmlHttp ();
	
	function buatObjekXmlHttp () {
		var obj=null;
		if (window.ActiveXObject)
			obj=new ActiveXObject("Microsoft.XMLHTTP");
		else
			if (window.XMLHttpRequest)
				obj=new XMLHttpRequest();
		
		if (obj==null) 
			document.write("Browser tidak mendukung XMLHttpRequest");
		return obj;
	}
	
	function ambilData (sumber_data, id_elemen) {
		if (xmlHttp!=null) {
			var obj=document.getElementById(id_elemen);
			xmlHttp.open("GET", sumber_data);
			xmlHttp.onreadystatechange=function () {
				if (xmlHttp.readyState==4 && xmlHttp.status==200) {
					obj.innerHTML=xmlHttp.responseText;
				}
			}
			xmlHttp.send(null);
		}
	}
	
	/* Cek Box Tabel */
	function checkAll(){
		var frm = document.form_tabel;
		for (var i=0; i < frm.elements.length;i++){ frm.elements[i].checked = true;	}						
	}
	
	function uncheckAll(){
		var frm = document.form_tabel;
		for (var i=0; i < frm.elements.length;i++){ frm.elements[i].checked = false; }						
	}

	/* Konfirm Hapus */
	function konfirmHapus(){
		var frm = document.form_tabel;
		var status=0;
		for(var i=0;i < frm.elements.length;i++){ if(frm.elements[i].checked==true){ status++; } }
		if(status == frm.elements.length){ if(confirm("Apakah Anda ingin menghapus semua data ?")){ frm.submit(); } }
		else if(status == 0){ alert("Silahkan pilih data yang akan dihapus terlebih dahulu"); }
		else if(status < frm.elements.length){ if(confirm("Apakah Anda ingin menghapus data yang dipilih ?")){ frm.submit(); } }
	}


	/* Cari */
	function cekkeyword() {
		var keyword=document.getElementById('keyword').value;
		if(keyword==''){ alert('Masukan Keyword Pencarian!'); return false; } 
		else if(keyword=='Pencarian'){ alert('Masukan Keyword Pencarian!'); return false; } 
	}

	/* Validasi Email */
	function cekEmail (text) {
		if ((text.indexOf('@')==-1)||(text.indexOf('.')==-1)) { return false; }
	}

	/* Kategori */
	function cekkategori() {
		var judul=document.getElementById('judul').value;
		var deskripsi=document.getElementById('deskripsi').value;
		if(judul==''){ alert('Masukan Judul Kategori !'); return false; } 
		if(deskripsi==''){ alert('Masukan Deskripsi Kategori !'); return false; } 
	}

	/* Cek Judul */
	function cekJudul() {
		var judul=document.getElementById('judul').value;
		if(judul==''){ alert('Masukkan Judul !'); return false; } 
	}

	/* Cek Nama */
	function cekNama() {
		var nama=document.getElementById('nama').value;
		if(nama==''){ alert('Masukkan Nama !'); return false; } 
	}

	/* Artikel */
	function cekartikel() {
		var judul=document.getElementById('judul').value;
		var kata_kunci=document.getElementById('kata_kunci').value;
		if(judul==''){ alert('Masukkan Judul Artikel !'); return false; } 
		else if(kata_kunci==''){ alert('Masukkan Kata Kunci Artikel !'); return false; } 
	}
	
	/* Halaman */
	function cekhalaman() {
		var judul=document.getElementById('judul').value;
		if(judul==''){ alert('Masukkan Judul Halaman !'); return false; } 
	}

	/* Login */
	function cekLogin() {
		var username=document.getElementById('username').value;
		var password=document.getElementById('password').value;
		if(username==''){ alert('Masukan Username !'); return false; } 
		else if(password==''){ alert('Masukkan Password !'); return false; } 
	}

	function cekfavicon() {
		var favicon=document.getElementById('favicon').value;
		if(favicon==''){ alert('Masukan Gambar Icon !'); return false; } 
	}
	
	function cekprofil() { 
		var nama=document.getElementById('nama').value;
		var telepon=document.getElementById('telepon').value;
		var email=document.getElementById('email').value;
		if(nama==''){ alert('Masukan Nama Anda !'); return false; } 
		else if(telepon==''){ alert('Masukan Nomor Telepon / Handphone Anda !'); return false; } 
		else if(email==''){ alert('Masukan Alamat Email Anda !'); return false; } 
	}
	
	function cekpassword() {
		var oldpassword=document.getElementById('oldpassword').value;
		var newpassword=document.getElementById('newpassword').value;
		var newpassword2=document.getElementById('newpassword2').value;
		if(oldpassword==''){ alert('Masukkan Password Lama Anda !'); return false; } 
		else if(newpassword==''){ alert('Masukkan Password Baru Anda !'); return false; } 
		else if(newpassword2==''){ alert('Masukkan Password Baru Anda, Sekali Lagi !'); return false; } 
		else if(newpassword!=newpassword2){ alert('Password baru anda tidak cocok!'); return false; } 
	}
	
	function cekfoto() {
		var gambar=document.getElementById('gambar').value;
		if(gambar==''){ alert('Masukkan Gambar / Foto !'); return false; } 
	}
	
	/* HTML */
	function cekhtml() {
		var judul=document.getElementById('judul').value;
		var kode_html=document.getElementById('kode_html').value;
		if(judul==''){ alert('Masukkan Judul !'); return false; } 
		else if(kode_html==''){ alert('Masukkan Kode HMTL !'); return false; } 
	}
	
	/* Komentar */
	function cekbalasan() { 
		var balasan=document.getElementById('balasan').value;
		if(balasan==''){ alert('Masukan Balasan Komentar Anda !'); return false; } 
	}
			
	function cekkomentar() {
		var judul=document.getElementById('judul').value;
		var email=document.getElementById('email').value;
		var komentar=document.getElementById('komentar').value;
		if(judul==''){ alert('Masukkan Judul Pengirim !'); return false; } 
		else if(email==''){ alert('Masukkan Email Pengirim !'); return false; } 
		else if(komentar==''){ alert('Masukkan Komentar !'); return false; } 
	}
	
	function ceklogo() {
		var tinggi_logo=document.getElementById('tinggi_logo').value;
		if (tinggi_logo=='') { alert('Memasukkan Tinggi Logo !'); return false; }
	}
	
	function cekseo() { 
		var judul=document.getElementById('judul').value;
		var deskripsi=document.getElementById('deskripsi').value;
		var kata_kunci=document.getElementById('kata_kunci').value;
		var footer=document.getElementById('footer').value;
		if (judul==''){ alert('Masukan Judul Website !'); return false; } 
		else if (deskripsi==''){ alert('Masukan Deskripsi Website !'); return false; } 
		else if (kata_kunci==''){ alert('Masukan Kata Kunci Website !'); return false; } 
		else if (footer==''){ alert('Masukan Footer Website !'); return false; } 
	}