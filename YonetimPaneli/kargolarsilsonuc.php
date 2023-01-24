<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID	=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID	=	"";
	}

	if($GelenID!=""){
		$KargoSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM kargofirmalari WHERE id = ?");
		$KargoSorgusu->execute([$GelenID]);
		$KargoSayisi	=	$KargoSorgusu->rowCount();
		$KargoKaydi		=	$KargoSorgusu->fetch(PDO::FETCH_ASSOC);

		$SilinecekDosyaYolu		=	"../Resimler/".$KargoKaydi["KargoFirmasiLogosu"];

		$KargoSilmeSorgusu	=	$VeritabaniBaglantisi->prepare("DELETE FROM kargofirmalari WHERE id = ? LIMIT 1");
		$KargoSilmeSorgusu->execute([$GelenID]);
		$KargoSilmeKontrol	=	$KargoSilmeSorgusu->rowCount();

		if($KargoSilmeKontrol>0){
			unlink($SilinecekDosyaYolu);

			header("Location:index.php?SKD=0&SKI=31");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=32");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=32");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>