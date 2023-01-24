<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["SiparisNo"])){
		$GelenSiparisNo		=	Guvenlik($_GET["SiparisNo"]);
	}else{
		$GelenSiparisNo		=	"";
	}
	
	if($GelenSiparisNo!=""){
		$SiparislerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM siparisler WHERE SiparisNumarasi = ?");
		$SiparislerSorgusu->execute([$GelenSiparisNo]);
		$SiparisKayitlari		=	$SiparislerSorgusu->fetchAll(PDO::FETCH_ASSOC);
		$SiparisKontrol			=	$SiparislerSorgusu->rowCount();
		
		if($SiparisKontrol>0){
			foreach($SiparisKayitlari as $Satirlar){
				$SiparistekiId				=	$Satirlar["id"];
				$SiparistekiUrununIDsi		=	$Satirlar["UrunId"];
				$SiparistekiUrununAdedi		=	$Satirlar["UrunAdedi"];
				$SiparistekiUrununVaryanti	=	$Satirlar["VaryantSecimi"];
		
				$SiparisSilmeSorgusu	=	$VeritabaniBaglantisi->prepare("DELETE FROM siparisler WHERE id = ? LIMIT 1");
				$SiparisSilmeSorgusu->execute([$SiparistekiId]);
				$SilmeKontrol			=	$SiparisSilmeSorgusu->rowCount();

				if($SilmeKontrol>0){
					$UrunGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urunler SET ToplamSatisSayisi=ToplamSatisSayisi+? WHERE id = ? LIMIT 1");
					$UrunGuncellemeSorgusu->execute([$SiparistekiUrununAdedi, $SiparistekiUrununIDsi]);
					$UrunGuncellemeKontrol	=	$UrunGuncellemeSorgusu->rowCount();

					if($UrunGuncellemeKontrol>0){
						$VaryantGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urunvaryantlari SET StokAdedi=StokAdedi+? WHERE VaryantAdi = ? AND UrunId = ? LIMIT 1");
						$VaryantGuncellemeSorgusu->execute([$SiparistekiUrununAdedi, DonusumleriGeriDondur($SiparistekiUrununVaryanti), $SiparistekiUrununIDsi]);
						$VaryantGuncellemeKontrol	=	$VaryantGuncellemeSorgusu->rowCount();
						
						if($VaryantGuncellemeKontrol<1){
							header("Location:index.php?SKD=0&SKI=115");
							exit();
						}
					}else{
						header("Location:index.php?SKD=0&SKI=115");
						exit();
					}
				}else{
					header("Location:index.php?SKD=0&SKI=115");
					exit();
				}
			}
			
			header("Location:index.php?SKD=0&SKI=114");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=115");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=115");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>