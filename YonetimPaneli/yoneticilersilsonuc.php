<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID	=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID	=	"";
	}

	if($GelenID!=""){
		$YoneticiSilmeSorgusu	=	$VeritabaniBaglantisi->prepare("DELETE FROM yoneticiler WHERE id = ? AND KullaniciAdi != ? AND SilinemeyecekYoneticiDurumu = ? LIMIT 1");
		$YoneticiSilmeSorgusu->execute([$GelenID, $YoneticiKullaniciAdi, 0]);
		$YoeticiSilmeKontrol	=	$YoneticiSilmeSorgusu->rowCount();

		if($YoeticiSilmeKontrol>0){
			header("Location:index.php?SKD=0&SKI=80");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=81");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=81");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>