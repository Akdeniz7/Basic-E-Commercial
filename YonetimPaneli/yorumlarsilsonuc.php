<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID	=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID	=	"";
	}
	
	if($GelenID!=""){
		$YorumlarSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM yorumlar WHERE id = ? LIMIT 1");
		$YorumlarSorgusu->execute([$GelenID]);
		$YorumlarSayisi		=	$YorumlarSorgusu->rowCount();
		$YorumlarKaydi		=	$YorumlarSorgusu->fetch(PDO::FETCH_ASSOC);
	
		if($YorumlarSayisi>0){
			$GuncellenecekUrununIdsi			=	$YorumlarKaydi["UrunId"];
			$GuncellenecekUrununDusulecekPuani	=	$YorumlarKaydi["Puan"];
	
			$YorumSilmeSorgusu		=	$VeritabaniBaglantisi->prepare("DELETE FROM yorumlar WHERE id = ? LIMIT 1");
			$YorumSilmeSorgusu->execute([$GelenID]);
			$YorumSilmeKontrol		=	$YorumSilmeSorgusu->rowCount();
			
			if($YorumSilmeKontrol>0){
				$UrunGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urunler SET YorumSayisi=YorumSayisi-1, ToplamYorumPuani=ToplamYorumPuani-? WHERE id = ? LIMIT 1");
				$UrunGuncellemeSorgusu->execute([$GuncellenecekUrununDusulecekPuani, $GuncellenecekUrununIdsi]);
				$UrunGuncellemeKontrol	=	$UrunGuncellemeSorgusu->rowCount();
				
				if($UrunGuncellemeKontrol>0){
					header("Location:index.php?SKD=0&SKI=92");
					exit();
				}else{
					header("Location:index.php?SKD=0&SKI=93");
					exit();
				}
			}else{
				header("Location:index.php?SKD=0&SKI=93");
				exit();
			}
		}else{
			header("Location:index.php?SKD=0&SKI=93");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=93");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>