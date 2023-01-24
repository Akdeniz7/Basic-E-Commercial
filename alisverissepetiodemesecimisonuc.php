<?php
if(isset($_SESSION["Kullanici"])){
	if(isset($_POST["OdemeTuruSecimi"])){
		$GelenOdemeTuruSecimi		=	Guvenlik($_POST["OdemeTuruSecimi"]);
	}else{
		$GelenOdemeTuruSecimi		=	"";
	}
	if(isset($_POST["TaksitSecimi"])){
		$GelenTaksitSecimi		=	Guvenlik($_POST["TaksitSecimi"]);
	}else{
		$GelenTaksitSecimi		=	"";
	}

	if($GelenOdemeTuruSecimi!=""){
		if($GelenOdemeTuruSecimi=="Banka Havalesi"){
			$AlisverisSepetiSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM sepet WHERE UyeId = ?");
			$AlisverisSepetiSorgusu->execute([$KullaniciID]);
			$SepetSayisi				=	$AlisverisSepetiSorgusu->rowCount();
			$SepetUrunleri				=	$AlisverisSepetiSorgusu->fetchAll(PDO::FETCH_ASSOC);

			if($SepetSayisi>0){
				foreach($SepetUrunleri as $SepetSatirlari){
					$SepetIdsi					=	$SepetSatirlari["id"];
					$SepetSepetNumarasi			=	$SepetSatirlari["SepetNumarasi"];
					$SepettekiUyeId				=	$SepetSatirlari["UyeId"];
					$SepettekiUrunId			=	$SepetSatirlari["UrunId"];
					$SepettekiAdresId			=	$SepetSatirlari["AdresId"];
					$SepettekiVaryantId			=	$SepetSatirlari["VaryantId"];
					$SepettekiKargoId			=	$SepetSatirlari["KargoId"];
					$SepettekiUrunAdedi			=	$SepetSatirlari["UrunAdedi"];
					$SepettekiOdemeSecimi		=	$SepetSatirlari["OdemeSecimi"];
					$SepettekiTaksitSecimi		=	$SepetSatirlari["TaksitSecimi"];
					
					
					$UrunBilgileriSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
					$UrunBilgileriSorgusu->execute([$SepettekiUrunId]);
					$UrunKaydi					=	$UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
						$UrununTuru				=	$UrunKaydi["UrunTuru"];
						$UrununAdi				=	$UrunKaydi["UrunAdi"];
						$UrununFiyati			=	$UrunKaydi["UrunFiyati"];
						$UrununParaBirimi		=	$UrunKaydi["ParaBirimi"];
						$UrununKdvOrani			=	$UrunKaydi["KdvOrani"];
						$UrununKargoUcreti		=	$UrunKaydi["KargoUcreti"];
						$UrununResmi			=	$UrunKaydi["UrunResmiBir"];
						$UrununVaryantBasligi	=	$UrunKaydi["VaryantBasligi"];

					$UrunVaryantBilgileriSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunvaryantlari WHERE id = ? LIMIT 1");
					$UrunVaryantBilgileriSorgusu->execute([$SepettekiVaryantId]);
					$VaryantKaydi					=	$UrunVaryantBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
						$VaryantAdi			=	$VaryantKaydi["VaryantAdi"];

					$KargoBilgileriSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM kargofirmalari WHERE id = ? LIMIT 1");
					$KargoBilgileriSorgusu->execute([$SepettekiKargoId]);
					$KargoKaydi					=	$KargoBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
						$KargonunAdi			=	$KargoKaydi["KargoFirmasiAdi"];
					
					$AdresBilgileriSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM adresler WHERE id = ? LIMIT 1");
					$AdresBilgileriSorgusu->execute([$SepettekiAdresId]);
					$AdresKaydi					=	$AdresBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
						$AdresAdiSoyadi			=	$AdresKaydi["AdiSoyadi"];
						$AdresAdres				=	$AdresKaydi["Adres"];
						$AdresIlce				=	$AdresKaydi["Ilce"];
						$AdresSehir				=	$AdresKaydi["Sehir"];
						$AdresToparla			=	$AdresAdres . " " . $AdresIlce . " " . $AdresSehir;
						$AdresTelefonNumarasi	=	$AdresKaydi["TelefonNumarasi"];
					
					if($UrununParaBirimi=="USD"){
						$UrunFiyatiHesapla				=	$UrununFiyati*$DolarKuru;
					}elseif($UrununParaBirimi=="EUR"){
						$UrunFiyatiHesapla				=	$UrununFiyati*$EuroKuru;
					}else{
						$UrunFiyatiHesapla				=	$UrununFiyati;
					}
					
					$UrununToplamFiyati			=	($UrunFiyatiHesapla*$SepettekiUrunAdedi);
					$UrununToplamKargoFiyati	=	($UrununKargoUcreti*$SepettekiUrunAdedi);
					
					$SiparisEkle	=	$VeritabaniBaglantisi->prepare("INSERT INTO siparisler (UyeId, SiparisNumarasi, UrunId, UrunTuru, UrunAdi, UrunFiyati, KdvOrani, UrunAdedi, ToplamUrunFiyati, KargoFirmasiSecimi, KargoUcreti, UrunResmiBir, VaryantBasligi, VaryantSecimi, AdresAdiSoyadi, AdresDetay, AdresTelefon, OdemeSecimi, TaksitSecimi, SiparisTarihi, SiparisIpAdresi) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
					$SiparisEkle->execute([$SepettekiUyeId, $SepetSepetNumarasi, $SepettekiUrunId, $UrununTuru, $UrununAdi, $UrunFiyatiHesapla, $UrununKdvOrani, $SepettekiUrunAdedi, $UrununToplamFiyati, $KargonunAdi, $UrununToplamKargoFiyati, $UrununResmi, $UrununVaryantBasligi, $VaryantAdi, $AdresAdiSoyadi, $AdresToparla, $AdresTelefonNumarasi, $GelenOdemeTuruSecimi, 0, $ZamanDamgasi, $IPAdresi]);
					$EklemeKontrol	=	$SiparisEkle->rowCount();
					
					if($EklemeKontrol>0){
						$SepettenSilmeSorgusu	=	$VeritabaniBaglantisi->prepare("DELETE FROM sepet WHERE id = ? AND UyeId = ? LIMIT 1");
						$SepettenSilmeSorgusu->execute([$SepetIdsi, $SepettekiUyeId]);
						
						$UrunSatisiArttirmaSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urunler SET ToplamSatisSayisi=ToplamSatisSayisi + ? WHERE id = ?");
						$UrunSatisiArttirmaSorgusu->execute([$SepettekiUrunAdedi, $SepettekiUrunId]);	
						
						$StokGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE urunvaryantlari SET StokAdedi=StokAdedi - ? WHERE id = ? LIMIT 1");
						$StokGuncellemeSorgusu->execute([$SepettekiUrunAdedi, $SepettekiVaryantId]);	
					}else{
						header("Location:index.php?SK=102");
						exit();
					}
				}
				
				$KargoFiyatiIcinSiparislerSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT SUM(ToplamUrunFiyati) AS ToplamUcret FROM siparisler WHERE UyeId = ? AND SiparisNumarasi = ?");
				$KargoFiyatiIcinSiparislerSorgusu->execute([$KullaniciID, $SepetSepetNumarasi]);
				$KargoFiyatiKaydi					=	$KargoFiyatiIcinSiparislerSorgusu->fetch(PDO::FETCH_ASSOC);
					$ToplamUcretimiz	=	$KargoFiyatiKaydi["ToplamUcret"];
				
					if($ToplamUcretimiz>=$UcretsizKargoBaraji){
						$SiparisiGuncelle	=	$VeritabaniBaglantisi->prepare("UPDATE siparisler SET KargoUcreti = ? WHERE UyeId = ? AND SiparisNumarasi = ?");
						$SiparisiGuncelle->execute([0, $SepettekiUyeId, $SepetSepetNumarasi]);
					}
					
				header("Location:index.php?SK=101");
				exit();
			}else{
				header("Location:index.php");
				exit();
			}
		}else{
			if($GelenTaksitSecimi!=""){
				$SepetiGuncelle		=	$VeritabaniBaglantisi->prepare("UPDATE sepet SET OdemeSecimi = ?, TaksitSecimi = ? WHERE UyeId = ?");
				$SepetiGuncelle->execute([$GelenOdemeTuruSecimi, $GelenTaksitSecimi, $KullaniciID]);
				$SepetKontrol		=	$SepetiGuncelle->rowCount();
				
				if($SepetKontrol>0){
					header("Location:index.php?SK=103");
					exit();
				}else{
					header("Location:index.php");
					exit();
				}
			}else{
				header("Location:index.php");
				exit();
			}
			
		}
	}else{
		header("Location:index.php");
		exit();
	}
}else{
	header("Location:index.php");
	exit();
}
?>