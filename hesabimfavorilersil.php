<?php
if(isset($_SESSION["Kullanici"])){
	if(isset($_GET["ID"])){
		$GelenID		=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID		=	"";
	}

	if($GelenID!=""){
		$FavoriSilmeSorgusu		=	$VeritabaniBaglantisi->prepare("DELETE FROM favoriler WHERE id = ? AND UyeId = ? LIMIT 1");
		$FavoriSilmeSorgusu->execute([$GelenID, $KullaniciID]);
		$FavoriSilmeSayisi		=	$FavoriSilmeSorgusu->rowCount();

		if($FavoriSilmeSayisi>0){
			header("Location:index.php?SK=59");
			exit();
		}else{
			header("Location:index.php?SK=82");
			exit();
		}
	}else{
		header("Location:index.php?SK=82");
		exit();
	}
}else{
	header("Location:index.php");
	exit();
}
?>