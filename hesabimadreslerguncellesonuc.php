<?php
if(isset($_SESSION["Kullanici"])){
	if(isset($_GET["ID"])){
		$GelenID		=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID		=	"";
	}
	if(isset($_POST["IsimSoyisim"])){
		$GelenIsimSoyisim		=	Guvenlik($_POST["IsimSoyisim"]);
	}else{
		$GelenIsimSoyisim		=	"";
	}
	if(isset($_POST["Adres"])){
		$GelenAdres				=	Guvenlik($_POST["Adres"]);
	}else{
		$GelenAdres				=	"";
	}
	if(isset($_POST["Ilce"])){
		$GelenIlce				=	Guvenlik($_POST["Ilce"]);
	}else{
		$GelenIlce				=	"";
	}
	if(isset($_POST["Sehir"])){
		$GelenSehir				=	Guvenlik($_POST["Sehir"]);
	}else{
		$GelenSehir				=	"";
	}
	if(isset($_POST["TelefonNumarasi"])){
		$GelenTelefonNumarasi	=	Guvenlik($_POST["TelefonNumarasi"]);
	}else{
		$GelenTelefonNumarasi	=	"";
	}

	if(($GelenID!="") and ($GelenIsimSoyisim!="") and ($GelenAdres!="") and ($GelenIlce!="") and ($GelenSehir!="") and ($GelenTelefonNumarasi!="")){
		$AdresGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE adresler SET AdiSoyadi = ?, Adres = ?, Ilce = ?, Sehir = ?, TelefonNumarasi = ?  WHERE id = ? AND UyeId = ? LIMIT 1");
		$AdresGuncellemeSorgusu->execute([$GelenIsimSoyisim, $GelenAdres, $GelenIlce, $GelenSehir, $GelenTelefonNumarasi, $GelenID, $KullaniciID]);
		$GuncellemeKontrol			=	$AdresGuncellemeSorgusu->rowCount();
		
		if($GuncellemeKontrol>0){
			header("Location:index.php?SK=64");
			exit();
		}else{
			header("Location:index.php?SK=65");
			exit();
		}
	}else{
		header("Location:index.php?SK=66");
		exit();
	}
}else{
	header("Location:index.php");
	exit();
}
?>