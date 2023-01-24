<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID	=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID	=	"";
	}
	
	if($GelenID!=""){
		$UrunlerSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE id = ?");
		$UrunlerSorgusu->execute([$GelenID]);
		$UrunlerSorgusuKontrol	=	$UrunlerSorgusu->rowCount();
		$UrunlerSorgusuKaydi	=	$UrunlerSorgusu->fetch(PDO::FETCH_ASSOC);

		if($UrunlerSorgusuKontrol>0){
			$SilinecekUrununMenuIDsi	=	$UrunlerSorgusuKaydi["MenuId"];

			$UrunSilmeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urunler SET Durumu = ? WHERE id = ? LIMIT 1");
			$UrunSilmeSorgusu->execute([0, $GelenID]);
			$UrunSilmeKontrol	=	$UrunSilmeSorgusu->rowCount();

			if($UrunSilmeKontrol>0){
				$SepetSilmeSorgusu		=	$VeritabaniBaglantisi->prepare("DELETE FROM sepet WHERE UrunId = ?");
				$SepetSilmeSorgusu->execute([$GelenID]);

				$FavorilerSilmeSorgusu	=	$VeritabaniBaglantisi->prepare("DELETE FROM favoriler WHERE UrunId = ?");
				$FavorilerSilmeSorgusu->execute([$GelenID]);

				$MenuGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE menuler SET UrunSayisi=UrunSayisi-1 WHERE id = ?");
				$MenuGuncellemeSorgusu->execute([$SilinecekUrununMenuIDsi]);

				header("Location:index.php?SKD=0&SKI=104");
				exit();
			}else{
				header("Location:index.php?SKD=0&SKI=105");
				exit();
			}
		}else{
			header("Location:index.php?SKD=0&SKI=105");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=105");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>