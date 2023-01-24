<?php
if(isset($_SESSION["Kullanici"])){
	if(isset($_GET["ID"])){
		$GelenID		=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID		=	"";
	}
	
	if(isset($_POST["Varyant"])){
		$GelenVaryantID	=	Guvenlik($_POST["Varyant"]);
	}else{
		$GelenVaryantID	=	"";
	}
	
	if(($GelenID!="") and ($GelenVaryantID!="")){
		$KullanicininSepetKontrolSorgu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM sepet WHERE UyeId = ? ORDER BY id DESC LIMIT 1");
		$KullanicininSepetKontrolSorgu->execute([$KullaniciID]);
		$KullanicininSepetSayisi		=	$KullanicininSepetKontrolSorgu->rowCount();

		if($KullanicininSepetSayisi>0){
			$UrunSepetKontrolSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM sepet WHERE UyeId = ? AND UrunId = ? AND VaryantId = ? LIMIT 1");
			$UrunSepetKontrolSorgusu->execute([$KullaniciID, $GelenID, $GelenVaryantID]);
			$UrunSepetSayisi			=	$UrunSepetKontrolSorgusu->rowCount();
			$UrunSepetKaydi				=	$UrunSepetKontrolSorgusu->fetch(PDO::FETCH_ASSOC);

			if($UrunSepetSayisi>0){
				$UrununIDsi						=	$UrunSepetKaydi["id"];
				$UrununSepettekiMevcutAdedi		=	$UrunSepetKaydi["UrunAdedi"];
				$UrununYeniAdedi				=	$UrununSepettekiMevcutAdedi+1;

				$UrunGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE sepet SET UrunAdedi = ? WHERE id = ? AND UyeId = ? AND UrunId = ? LIMIT 1");
				$UrunGuncellemeSorgusu->execute([$UrununYeniAdedi, $UrununIDsi, $KullaniciID, $GelenID]);
				$UrunGuncellemeSayisi		=	$UrunGuncellemeSorgusu->rowCount();

					if($UrunGuncellemeSayisi>0){
						header("Location:index.php?SK=94");
						exit();
					}else{
						header("Location:index.php?SK=92");
						exit();
					}
			}else{
				$UrunEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO sepet (UyeId, UrunId, VaryantId, UrunAdedi) values (?, ?, ?, ?)");
				$UrunEklemeSorgusu->execute([$KullaniciID, $GelenID, $GelenVaryantID, 1]);
				$UrunEklemeSayisi		=	$UrunEklemeSorgusu->rowCount();
				$SonIdDegeri			=	$VeritabaniBaglantisi->lastInsertId();

					if($UrunEklemeSayisi>0){
						$SiparisNumarasiniGuncelleSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE sepet SET SepetNumarasi = ? WHERE UyeId = ?");
						$SiparisNumarasiniGuncelleSorgusu->execute([$SonIdDegeri, $KullaniciID]);
						$SiparisNumarasiniGuncelleSayisi		=	$SiparisNumarasiniGuncelleSorgusu->rowCount();
							if($SiparisNumarasiniGuncelleSayisi>0){
								header("Location:index.php?SK=94");
								exit();
							}else{
								header("Location:index.php?SK=92");
								exit();
							}
					}else{
						header("Location:index.php?SK=92");
						exit();
					}
			}
		}else{
			$UrunEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO sepet (UyeId, UrunId, VaryantId, UrunAdedi) values (?, ?, ?, ?)");
			$UrunEklemeSorgusu->execute([$KullaniciID, $GelenID, $GelenVaryantID, 1]);
			$UrunEklemeSayisi		=	$UrunEklemeSorgusu->rowCount();
			$SonIdDegeri			=	$VeritabaniBaglantisi->lastInsertId();

				if($UrunEklemeSayisi>0){
					$SiparisNumarasiniGuncelleSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE sepet SET SepetNumarasi = ? WHERE UyeId = ?");
					$SiparisNumarasiniGuncelleSorgusu->execute([$SonIdDegeri, $KullaniciID]);
					$SiparisNumarasiniGuncelleSayisi		=	$SiparisNumarasiniGuncelleSorgusu->rowCount();
						if($SiparisNumarasiniGuncelleSayisi>0){
							header("Location:index.php?SK=94");
							exit();
						}else{
							header("Location:index.php?SK=92");
							exit();
						}
				}else{
					header("Location:index.php?SK=92");
					exit();
				}
		}
	}else{
		header("Location:index.php");
		exit();
	}
}else{
	header("Location:index.php?SK=93");
	exit();
}
?>