<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_POST["Soru"])){
		$GelenSoru		=	Guvenlik($_POST["Soru"]);
	}else{
		$GelenSoru		=	"";
	}
	if(isset($_POST["Cevap"])){
		$GelenCevap		=	Guvenlik($_POST["Cevap"]);
	}else{
		$GelenCevap		=	"";
	}
	
	if(($GelenSoru!="") and ($GelenCevap!="")){	
		$IcerikEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO sorular (soru, cevap) values (?, ?)");
		$IcerikEklemeSorgusu->execute([$GelenSoru, $GelenCevap]);
		$IcerikEklemeKontrol		=	$IcerikEklemeSorgusu->rowCount();

		if($IcerikEklemeKontrol>0){
			header("Location:index.php?SKD=0&SKI=48");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=49");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=49");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>