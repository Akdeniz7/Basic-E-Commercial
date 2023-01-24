<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["SiparisNo"])){
		$GelenSiparisNo		=	Guvenlik($_GET["SiparisNo"]);
	}else{
		$GelenSiparisNo		=	"";
	}
	if(isset($_POST["GonderiKodu"])){
		$GelenGonderiKodu	=	Guvenlik($_POST["GonderiKodu"]);
	}else{
		$GelenGonderiKodu	=	"";
	}
	
	if(($GelenSiparisNo!="") and ($GelenGonderiKodu!="")){	
		$SiparisGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE siparisler SET OnayDurumu = ?, KargoDurumu = ?, KargoGonderiKodu = ? WHERE SiparisNumarasi = ?");
		$SiparisGuncellemeSorgusu->execute([1, 1, $GelenGonderiKodu, $GelenSiparisNo]);
		$GuncellemeKontrol			=	$SiparisGuncellemeSorgusu->rowCount();
		
		if($GuncellemeKontrol>0){
			header("Location:index.php?SKD=0&SKI=111");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=112");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=112");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>