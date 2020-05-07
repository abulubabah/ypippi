	/* Ajak Default */
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
	
	/* Cari */
	function cekKeyword() {
		var keyword=document.getElementById('keyword').value;
		if(keyword=='Search'){ alert('Masukan Keyword Pencarian!'); return false; } 
	}
	
	/* Cek Komentar Artikel */
	function cekkomentar() {
		var nama=document.getElementById('nama').value;
		var komentar=document.getElementById('komentar').value;
		if(nama==''){ alert('Masukan Nama Lengkap Anda !'); return false; }
		else if(komentar==''){ alert('Masukan Komentar Anda !'); return false; }
	}

	/* Cek Login */
	function ceklogin() {
		var username=document.getElementById('username').value;
		var password=document.getElementById('password').value;
		if(username==''){ alert('Masukan Username !'); return false; } 
		else if(password==''){ alert('Masukkan Password !'); return false; }
	}

	/* Lupa Password */
	function ceklupapassword() {
		var email=document.getElementById('email').value;
		if(email==''){ alert('Masukan Alamat Email Anda !'); return false; } 
	}

	/* Foto */
	function cekfoto() {
		var gambar=document.getElementById('gambar').value;
		if(gambar==''){ alert('Anda Belum Memilih Gambar !'); return false; } 
	}
	
	/* Password */
	function cekpassword() {
		var oldpassword=document.getElementById('oldpassword').value;
		var newpassword=document.getElementById('newpassword').value;
		var newpassword2=document.getElementById('newpassword2').value;
		if(oldpassword==''){ alert('Masukkan Password Lama Anda !'); return false; } 
		else if(newpassword==''){ alert('Masukkan Password Baru Anda !'); return false; } 
		else if(newpassword2==''){ alert('Masukkan Password Baru Anda, Sekali Lagi !'); return false; } 
		else if(newpassword!=newpassword2){ alert('Password baru anda tidak cocok!'); return false; } 
	}
	
	/* Profil */
	function cekprofil() { 
		var nama=document.getElementById('nama').value;
		var telepon=document.getElementById('telepon').value;
		var email=document.getElementById('email').value;
		if(nama==''){ alert('Masukan Nama Anda !'); return false; } 
		else if(telepon==''){ alert('Masukan Telepon Anda !'); return false; } 
		else if(email==''){ alert('Masukan Email Anda !'); return false; } 
	}
	

    //lazi loading gambar
    $(window).on("load",function(){
        setTimeout(function(){
            $('img').each(function(){
                var $this=$(this);
                var src=$this.attr('data-src');
                
                $this.attr('src',src);
               // alert($this.attr('src'));
            })
        },1500);
    });

