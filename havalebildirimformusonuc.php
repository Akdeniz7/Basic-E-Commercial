<?php

if(isset($_POST["IsimSoyisim"])){
	$GelenIsimSoyisim		=	Guvenlik($_POST["IsimSoyisim"]);
}else{
	$GelenIsimSoyisim		=	"";
}

if(isset($_POST["EmailAdresi"])){
	$GelenEmailAdresi		=	Guvenlik($_POST["EmailAdresi"]);
}else{
	$GelenEmailAdresi		=	"";
}

if(isset($_POST["TelefonNumarasi"])){
	$GelenTelefonNumarasi	=	Guvenlik($_POST["TelefonNumarasi"]);
}else{
	$GelenTelefonNumarasi	=	"";
}

if(isset($_POST["BankaSecimi"])){
	$GelenBankaSecimi		=	Guvenlik($_POST["BankaSecimi"]);
}else{
	$GelenBankaSecimi		=	"";
}

if(isset($_POST["Aciklama"])){
	$GelenAciklama			=	Guvenlik($_POST["Aciklama"]);
}else{
	$GelenAciklama			=	"";
}

if(($GelenIsimSoyisim!="") and ($GelenEmailAdresi!="") and ($GelenTelefonNumarasi!="") and ($GelenBankaSecimi!="")){
	$HavaleBildirimiKaydet			=	$VeritabaniBaglantisi->prepare("INSERT INTO havalebildirimleri (BankaId, AdiSoyadi, EmailAdresi, TelefonNumarasi, Aciklama, IslemTarihi, Durum) values (?, ?, ?, ?, ?, ?, ?)");
	$HavaleBildirimiKaydet->execute([$GelenBankaSecimi, $GelenIsimSoyisim, $GelenEmailAdresi, $GelenTelefonNumarasi, $GelenAciklama, $ZamanDamgasi, 0]);
	$HavaleBildirimiKaydetKontrol	=	$HavaleBildirimiKaydet->rowCount();
	
	if($HavaleBildirimiKaydetKontrol>0){
		header("Location:index.php?SK=11");
		exit();
	}else{
		header("Location:index.php?SK=12");
		exit();
	}
}else{
	header("Location:index.php?SK=13");
	exit();
}
?>