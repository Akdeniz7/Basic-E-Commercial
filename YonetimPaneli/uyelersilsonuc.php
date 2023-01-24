<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID	=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID	=	"";
	}
	
	if($GelenID!=""){
		$UyeSilmeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE uyeler SET SilinmeDurumu = ? WHERE id = ? LIMIT 1");
		$UyeSilmeSorgusu->execute([1, $GelenID]);
		$UyeSilmeKontrol	=	$UyeSilmeSorgusu->rowCount();

		if($UyeSilmeKontrol>0){
			$SepetSilmeSorgusu		=	$VeritabaniBaglantisi->prepare("DELETE FROM sepet WHERE UyeId = ?");
			$SepetSilmeSorgusu->execute([$GelenID]);
	
			$YorumlarSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM yorumlar WHERE UyeId = ?");
			$YorumlarSorgusu->execute([$GelenID]);
			$YorumlarSayisi		=	$YorumlarSorgusu->rowCount();
			$YorumlarKayitlari	=	$YorumlarSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
			if($YorumlarSayisi>0){
				foreach($YorumlarKayitlari as $YorumSatirlari){
					$YorumId							=	$YorumSatirlari["id"];
					$GuncellenecekUrununIdsi			=	$YorumSatirlari["UrunId"];
					$GuncellenecekUrununDusulecekPuani	=	$YorumSatirlari["Puan"];

					$UrunGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urunler SET YorumSayisi=YorumSayisi-1, ToplamYorumPuani=ToplamYorumPuani-? WHERE id = ? LIMIT 1");
					$UrunGuncellemeSorgusu->execute([$GuncellenecekUrununDusulecekPuani, $GuncellenecekUrununIdsi]);
					$UrunGuncellemeKontrol	=	$UrunGuncellemeSorgusu->rowCount();
					
					if($UrunGuncellemeKontrol<1){
						header("Location:index.php?SKD=0&SKI=86");
						exit();
					}
					
					$YorumSilmeSorgusu		=	$VeritabaniBaglantisi->prepare("DELETE FROM yorumlar WHERE id = ? LIMIT 1");
					$YorumSilmeSorgusu->execute([$YorumId]);
					$YorumSilmeKontrol		=	$YorumSilmeSorgusu->rowCount();
					
					if($YorumSilmeKontrol<1){
						header("Location:index.php?SKD=0&SKI=86");
						exit();
					}
				}
			}

			header("Location:index.php?SKD=0&SKI=85");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=86");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=86");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>