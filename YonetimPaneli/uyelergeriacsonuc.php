<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID	=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID	=	"";
	}
	
	if($GelenID!=""){
		$UyeGeriAcSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE uyeler SET SilinmeDurumu = ? WHERE id = ? LIMIT 1");
		$UyeGeriAcSorgusu->execute([0, $GelenID]);
		$Kontrol			=	$UyeGeriAcSorgusu->rowCount();

		if($Kontrol>0){
			header("Location:index.php?SKD=0&SKI=88");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=89");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=89");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>