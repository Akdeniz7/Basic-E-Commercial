<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID			=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID			=	"";
	}
	$GelenBankaLogosu			=	$_FILES["BankaLogosu"];
	if(isset($_POST["BankaAdi"])){
		$GelenBankaAdi			=	Guvenlik($_POST["BankaAdi"]);
	}else{
		$GelenBankaAdi			=	"";
	}
	if(isset($_POST["SubeAdi"])){
		$GelenSubeAdi			=	Guvenlik($_POST["SubeAdi"]);
	}else{
		$GelenSubeAdi			=	"";
	}
	if(isset($_POST["SubeKodu"])){
		$GelenSubeKodu			=	Guvenlik($_POST["SubeKodu"]);
	}else{
		$GelenSubeKodu			=	"";
	}
	if(isset($_POST["KonumSehir"])){
		$GelenKonumSehir		=	Guvenlik($_POST["KonumSehir"]);
	}else{
		$GelenKonumSehir		=	"";
	}
	if(isset($_POST["KonumUlke"])){
		$GelenKonumUlke			=	Guvenlik($_POST["KonumUlke"]);
	}else{
		$GelenKonumUlke			=	"";
	}
	if(isset($_POST["ParaBirimi"])){
		$GelenParaBirimi		=	Guvenlik($_POST["ParaBirimi"]);
	}else{
		$GelenParaBirimi		=	"";
	}
	if(isset($_POST["HesapSahibi"])){
		$GelenHesapSahibi		=	Guvenlik($_POST["HesapSahibi"]);
	}else{
		$GelenHesapSahibi		=	"";
	}
	if(isset($_POST["HesapNumarasi"])){
		$GelenHesapNumarasi		=	Guvenlik($_POST["HesapNumarasi"]);
	}else{
		$GelenHesapNumarasi		=	"";
	}
	if(isset($_POST["IbanNumarasi"])){
		$GelenIbanNumarasi		=	Guvenlik($_POST["IbanNumarasi"]);
	}else{
		$GelenIbanNumarasi		=	"";
	}
		
	if(($GelenID!="") and ($GelenBankaAdi!="") and ($GelenSubeAdi!="") and ($GelenSubeKodu!="") and ($GelenKonumSehir!="") and ($GelenKonumUlke!="") and ($GelenParaBirimi!="") and ($GelenHesapSahibi!="") and ($GelenHesapNumarasi!="") and ($GelenIbanNumarasi!="")){
	
		$HesapGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE bankahesaplarimiz SET BankaAdi = ?, KonumSehir = ?, KonumUlke = ?, SubeAdi = ?, SubeKodu = ?, ParaBirimi = ?, HesapSahibi = ?, HesapNumarasi = ?, IbanNumarasi = ? WHERE id = ? LIMIT 1");
		$HesapGuncellemeSorgusu->execute([$GelenBankaAdi, $GelenKonumSehir, $GelenKonumUlke, $GelenSubeAdi, $GelenSubeKodu, $GelenParaBirimi, $GelenHesapSahibi, $GelenHesapNumarasi, $GelenIbanNumarasi, $GelenID]);
		$HesapGuncellemeKontrol		=	$HesapGuncellemeSorgusu->rowCount();
	
		if(($GelenBankaLogosu["name"]!="") and ($GelenBankaLogosu["type"]!="") and ($GelenBankaLogosu["tmp_name"]!="") and ($GelenBankaLogosu["error"]==0) and ($GelenBankaLogosu["size"]>0)){
			$BankaResmiSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM bankahesaplarimiz WHERE id = ? LIMIT 1");
			$BankaResmiSorgusu->execute([$GelenID]);
			$ResimKontrol			=	$BankaResmiSorgusu->rowCount();
			$ResimBilgisi			=	$BankaResmiSorgusu->fetch(PDO::FETCH_ASSOC);
			
			$SilinecekDosyaYolu		=	"../Resimler/".$ResimBilgisi["BankaLogosu"];
			unlink($SilinecekDosyaYolu);
			
			$ResimIcinDosyaAdi		=	ResimAdiOlustur();
			$GelenResminUzantisi	=	substr($GelenBankaLogosu["name"], -4);
				if($GelenResminUzantisi=="jpeg"){
					$GelenResminUzantisi	=	".".$GelenResminUzantisi;
				}

			$ResimIcinYeniDosyaAdi		=	$ResimIcinDosyaAdi.$GelenResminUzantisi;

			$BankaLogosuYukle	=	new upload($GelenBankaLogosu, "tr-TR");
				if($BankaLogosuYukle->uploaded){
				   $BankaLogosuYukle->mime_magic_check			=	true;
				   $BankaLogosuYukle->allowed					=	array("image/*");
				   $BankaLogosuYukle->file_new_name_body		=	$ResimIcinDosyaAdi;
				   $BankaLogosuYukle->file_overwrite			=	true;
				   //$BankaLogosuYukle->image_convert				=	"png";
				   $BankaLogosuYukle->image_quality				=	100;
				   $BankaLogosuYukle->image_background_color	=	"#FFFFFF";
				   $BankaLogosuYukle->image_resize				=	true;
				   $BankaLogosuYukle->image_ratio				=	true;
				   $BankaLogosuYukle->image_y					=	30;
				   $BankaLogosuYukle->process($VerotIcinKlasorYolu);

					if($BankaLogosuYukle->processed){
						$HesapResmiGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE bankahesaplarimiz SET BankaLogosu = ? WHERE id = ? LIMIT 1");
						$HesapResmiGuncellemeSorgusu->execute([$ResimIcinYeniDosyaAdi, $GelenID]);
						$HesapResmiGuncellemeKontrol	=	$HesapResmiGuncellemeSorgusu->rowCount();
						
						if($HesapResmiGuncellemeKontrol<1){
							header("Location:index.php?SKD=0&SKI=17");
							exit();
						}
						$BankaLogosuYukle->clean();
					}else{
						header("Location:index.php?SKD=0&SKI=17");
						exit();
					} 
				}
		}
		
		if(($HesapGuncellemeKontrol>0) or ($HesapResmiGuncellemeKontrol>0)){
			header("Location:index.php?SKD=0&SKI=16");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=17");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=17");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>