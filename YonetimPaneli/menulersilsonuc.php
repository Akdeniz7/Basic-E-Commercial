<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID	=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID	=	"";
	}

	if($GelenID!=""){
		$MenuSilmeSorgusu		=	$VeritabaniBaglantisi->prepare("DELETE FROM menuler WHERE id = ? LIMIT 1");
		$MenuSilmeSorgusu->execute([$GelenID]);
		$MenuSilmeKontrol		=	$MenuSilmeSorgusu->rowCount();

		if($MenuSilmeKontrol>0){
			$UrunlerSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE MenuId = ?");
			$UrunlerSorgusu->execute([$GelenID]);
			$UrunlerSorgusuKontrol	=	$UrunlerSorgusu->rowCount();
			$UrunlerKayitlari		=	$UrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
			
			if($UrunlerSorgusuKontrol>0){
				foreach($UrunlerKayitlari as $UrunKaydi){
					$SilinecekUrununIDsi	=	$UrunKaydi["id"];
				
					$UrunlerGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urunler SET Durumu = ? WHERE id = ? AND MenuId = ?");
					$UrunlerGuncellemeSorgusu->execute([0, $SilinecekUrununIDsi, $GelenID]);
			
					$SepetSilmeSorgusu			=	$VeritabaniBaglantisi->prepare("DELETE FROM sepet WHERE UrunId = ?");
					$SepetSilmeSorgusu->execute([$SilinecekUrununIDsi]);
			
					$FavorilerSilmeSorgusu		=	$VeritabaniBaglantisi->prepare("DELETE FROM favoriler WHERE UrunId = ?");
					$FavorilerSilmeSorgusu->execute([$SilinecekUrununIDsi]);
				}
			}
			
			header("Location:index.php?SKD=0&SKI=67");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=68");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=68");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>