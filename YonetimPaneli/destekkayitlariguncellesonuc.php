<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID		=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID		=	"";
	}
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
	
	if(($GelenID!="") and ($GelenSoru!="") and ($GelenCevap!="")){	
		$IcerikGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE sorular SET soru = ?, cevap = ? WHERE id = ? LIMIT 1");
		$IcerikGuncellemeSorgusu->execute([$GelenSoru, $GelenCevap, $GelenID]);
		$IcerikGuncellemeKontrol	=	$IcerikGuncellemeSorgusu->rowCount();
		
		if($IcerikGuncellemeKontrol>0){
			header("Location:index.php?SKD=0&SKI=52");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=53");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=53");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>