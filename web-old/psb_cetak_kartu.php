<?php
session_start();
$cmsFolder = "cms/";
$domain = "www.ypippijkt.localhost/cms";
$subdomain = 'www.ypippijkt.localhost';
$nisn = $_SESSION['nisn'];

include_once($cmsFolder . "conn.php");
include_once("psb_kartu.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cetak Kartu Peserta</title>
	<meta charset="utf-8">
	<style type="text/css">
		.kartu-ppdb,.kartu-ppdb__header{display:-webkit-box;display:-ms-flexbox;-webkit-box-direction:normal}*{margin:0;padding:0;box-sizing:border-box}.kartu-ppdb{display:flex;-webkit-box-orient:vertical;-ms-flex-direction:column;flex-direction:column;-ms-flex-wrap:nowrap;flex-wrap:nowrap;position:relative;width:367px;border:2px solid #000;font-family:Helvetica,sans-serif}.kartu-ppdb__wrapper{display:inline-block;border:1px dashed #000;margin:20px;padding:5px}.kartu-ppdb__header{display:flex;-webkit-box-orient:horizontal;-ms-flex-direction:row;flex-direction:row;-ms-flex-wrap:nowrap;flex-wrap:nowrap;padding:6px 10px;width:100%;border-bottom:2px solid #000}.kartu-ppdb__logo-wrapper{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:no-wrap;flex-wrap:no-wrap;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-ms-flex-line-pack:center;align-content:center;width:50px;height:50px;padding:1px}.kartu-ppdb__logo{display:block;position:relative;width:100%;height:100%}.kartu-ppdb__head-wrapper{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-flow:column wrap;flex-flow:column wrap;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-ms-flex-line-pack:center;align-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;width:calc(100% - 100px);height:100%;padding:1px}.kartu-ppdb__head{display:-webkit-box;display:-ms-flexbox;display:flex;font-weight:700;font-size:8.7px;position:relative;text-align:center}.kartu-ppdb__head--thin{font-weight:500}.kartu-ppdb__head--italic{font-style:italic}.kartu-ppdb__head:last-child{margin-top:5px}.kartu-ppdb__content{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-flow:column nowrap;flex-flow:column nowrap;width:100%;height:100%;padding:3px 30px}.kartu-ppdb__content-header{position:relative;padding:0 0 3px;font-size:12.5px;text-align:center;border-bottom:1px solid #000;border-width:10%}.kartu-ppdb__form-wrapper{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-flow:column nowrap;flex-flow:column nowrap;margin:12px 0 16px}.kartu-ppdb__form{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;width:100%;font-size:13px}.kartu-ppdb__form-title{display:block;width:27%}.kartu-ppdb__form-divider{display:block;width:6px}.kartu-ppdb__form-content{display:block;width:calc(73% - 6px);padding-left:5px}.kartu-ppdb__footer{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-flow:column nowrap;flex-flow:column nowrap;justify-self:flex-end;-webkit-box-pack:center;-ms-flex-pack:center;justify-content:center;-ms-flex-line-pack:center;align-content:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;width:100%;height:100%;padding:10px 30px;border-top:2px solid #000}.kartu-ppdb__footer-item{display:block;font-size:12px;text-align:center}
	</style>
</head>
<body>
    <?php
        formKartuPeserta($subdomain, $domain, $nisn);
    ?>
    
    <script>
        (function() {
            'use strict';
            
            document.body.onload = printKartu();
            
            function printKartu() {
                window.print();
            }
        })();
    </script>
</body>
</html>