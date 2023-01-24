<?php
if(isset($_SESSION["Kullanici"])){
	if(isset($_GET["ID"])){
		$GelenID		=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID		=	"";
	}

	if($GelenID!=""){
		$SepetSilSorgusu		=	$VeritabaniBaglantisi->prepare("DELETE FROM sepet WHERE id = ? AND UyeId = ? LIMIT 1");
		$SepetSilSorgusu->execute([$GelenID, $KullaniciID]);
		$SepetSilmeSayisi		=	$SepetSilSorgusu->rowCount();

		if($SepetSilmeSayisi>0){
			header("Location:index.php?SK=94");
			exit();
		}else{
			header("Location:index.php?SK=94");
			exit();
		}
	}else{
		header("Location:index.php?SK=94");
		exit();
	}
}else{
	header("Location:index.php");
	exit();
}
?>