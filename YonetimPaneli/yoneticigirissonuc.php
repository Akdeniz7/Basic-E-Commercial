<?php
if(empty($_SESSION["Yonetici"])){
	
	if(isset($_POST["YKullanici"])){
		$GelenYKullanici		=	Guvenlik($_POST["YKullanici"]);
	}else{
		$GelenYKullanici		=	"";
	}
	if(isset($_POST["YSifre"])){
		$GelenYSifre			=	Guvenlik($_POST["YSifre"]);
	}else{
		$GelenYSifre			=	"";
	}

	$MD5liSifre					=	md5($GelenYSifre);

	if(($GelenYKullanici!="") and ($GelenYSifre!="")){
		$KontrolSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM yoneticiler WHERE KullaniciAdi = ? AND Sifre = ?");
		$KontrolSorgusu->execute([$GelenYKullanici, $MD5liSifre]);
		$KullaniciSayisi	=	$KontrolSorgusu->rowCount();
		$KullaniciKaydi		=	$KontrolSorgusu->fetch(PDO::FETCH_ASSOC);

		if($KullaniciSayisi>0){
			$_SESSION["Yonetici"]	=	$GelenYKullanici;
				
			header("Location:index.php?SKD=0&SKI=0");
			exit();
		}else{
			header("Location:index.php?SKD=3");
			exit();
		}
	}else{
		header("Location:index.php?SKD=1");
		exit();
	}
}else{
	header("Location:index.php?SKD=0");
	exit();
}
?>