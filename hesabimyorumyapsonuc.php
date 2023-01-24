<?php
if(isset($_SESSION["Kullanici"])){
	if(isset($_GET["UrunID"])){
		$GelenUrunID	=	Guvenlik($_GET["UrunID"]);
	}else{
		$GelenUrunID	=	"";
	}
	if(isset($_POST["Puan"])){
		$GelenPuan		=	Guvenlik($_POST["Puan"]);
	}else{
		$GelenPuan		=	"";
	}
	if(isset($_POST["Yorum"])){
		$GelenYorum		=	Guvenlik($_POST["Yorum"]);
	}else{
		$GelenYorum		=	"";
	}

	if(($GelenUrunID!="") and ($GelenPuan!="") and ($GelenYorum!="")){
		$YorumKayitSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO yorumlar (UrunId, UyeId, Puan, YorumMetni, YorumTarihi, YorumIpAdresi) values (?, ?, ?, ?, ?, ?)");
		$YorumKayitSorgusu->execute([$GelenUrunID, $KullaniciID, $GelenPuan, $GelenYorum, $ZamanDamgasi, $IPAdresi]);
		$YorumKayitKontrol		=	$YorumKayitSorgusu->rowCount();
		
		if($YorumKayitKontrol>0){
			$UrunGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE urunler SET YorumSayisi=YorumSayisi+1, ToplamYorumPuani=ToplamYorumPuani+? WHERE id = ? LIMIT 1");
			$UrunGuncellemeSorgusu->execute([$GelenPuan, $GelenUrunID]);
			$UrunGuncellemeKontrol		=	$UrunGuncellemeSorgusu->rowCount();
			
			if($UrunGuncellemeKontrol>0){
				header("Location:index.php?SK=77");
				exit();
			}else{
				header("Location:index.php?SK=78");
				exit();
			}
		}else{
			header("Location:index.php?SK=78");
			exit();
		}
	}else{
		header("Location:index.php?SK=79");
		exit();
	}
}else{
	header("Location:index.php");
	exit();
}
?>