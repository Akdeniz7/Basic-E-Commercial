<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID	=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID	=	"";
	}

	if($GelenID!=""){
		$BildirimSilmeSorgusu	=	$VeritabaniBaglantisi->prepare("DELETE FROM havalebildirimleri WHERE id = ? LIMIT 1");
		$BildirimSilmeSorgusu->execute([$GelenID]);
		$SilmeKontrol			=	$BildirimSilmeSorgusu->rowCount();

		if($SilmeKontrol>0){
			header("Location:index.php?SKD=0&SKI=118");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=119");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=119");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>