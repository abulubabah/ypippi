<?php 
class validasistring{
	function validasi($parameter){ 
		$g1=str_replace("#","","$parameter");$g2=str_replace("~","","$g1");
		$g3=str_replace("'","","$g2");$g4=str_replace("!","","$g3");
		$g5=str_replace("@","","$g4");$g6=str_replace("#","","$g5");
		$g7=str_replace("$","","$g6");$g8=str_replace("%","","$g7");
		$g9=str_replace("^","","$g8");$g10=str_replace("&","","$g9");
		$g11=str_replace("*","","$g10");$g12=str_replace("(","","$g11");
		$g13=str_replace(")","","$g12");$g14=str_replace("_","","$g13");
		$g15=str_replace("+","","$g14");$g16=str_replace("=","","$g15");
		$g17=str_replace("|","","$g16");$g18=str_replace("{","","$g17");
		$g19=str_replace("}","","$g18");$g20=str_replace("[","","$g19");
		$g21=str_replace("]","","$g20");$g22=str_replace(":","","$g21");
		$g23=str_replace(";","","$g22");$g24=str_replace("'","","$g23");
		$g25=str_replace(">","","$g24");$g26=str_replace("<","","$g25");
		$g27=str_replace("?","","$g26");$g28=str_replace(",","","$g27");
		$g29=str_replace(".","","$g28");$g30=str_replace("/","","$g29");
		$this->hasilvalidasi=$g30;
	}
}