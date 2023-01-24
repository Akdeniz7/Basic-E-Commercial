<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_POST["UrunTuru"])){
		$GelenUrunTuru		=	Guvenlik($_POST["UrunTuru"]);
	}else{
		$GelenUrunTuru		=	"";
	}
	if(isset($_POST["MenuAdi"])){
		$GelenMenuAdi		=	Guvenlik($_POST["MenuAdi"]);
	}else{
		$GelenMenuAdi		=	"";
	}
	
	if(($GelenUrunTuru!="") and ($GelenMenuAdi!="")){	
		$MenuEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO menuler (UrunTuru, MenuAdi) values (?, ?)");
		$MenuEklemeSorgusu->execute([$GelenUrunTuru, $GelenMenuAdi]);
		$MenuEklemeKontrol		=	$MenuEklemeSorgusu->rowCount();

		if($MenuEklemeKontrol>0){
			header("Location:index.php?SKD=0&SKI=60");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=61");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=61");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>