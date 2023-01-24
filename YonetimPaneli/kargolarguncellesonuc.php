<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID					=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID					=	"";
	}
	$GelenKargoFirmasiLogosu		=	$_FILES["KargoFirmasiLogosu"];
	if(isset($_POST["KargoFirmasiAdi"])){
		$GelenKargoFirmasiAdi		=	Guvenlik($_POST["KargoFirmasiAdi"]);
	}else{
		$GelenKargoFirmasiAdi		=	"";
	}
	
	if(($GelenID!="") and ($GelenKargoFirmasiAdi!="")){
		$KargoGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE kargofirmalari SET KargoFirmasiAdi = ? WHERE id = ? LIMIT 1");
		$KargoGuncellemeSorgusu->execute([$GelenKargoFirmasiAdi, $GelenID]);
		$KargoGuncellemeKontrol		=	$KargoGuncellemeSorgusu->rowCount();
	
		if(($GelenKargoFirmasiLogosu["name"]!="") and ($GelenKargoFirmasiLogosu["type"]!="") and ($GelenKargoFirmasiLogosu["tmp_name"]!="") and ($GelenKargoFirmasiLogosu["error"]==0) and ($GelenKargoFirmasiLogosu["size"]>0)){
			$KargoResmiSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM kargofirmalari WHERE id = ? LIMIT 1");
			$KargoResmiSorgusu->execute([$GelenID]);
			$ResimKontrol			=	$KargoResmiSorgusu->rowCount();
			$ResimBilgisi			=	$KargoResmiSorgusu->fetch(PDO::FETCH_ASSOC);
	
			$SilinecekDosyaYolu		=	"../Resimler/".$ResimBilgisi["KargoFirmasiLogosu"];
			unlink($SilinecekDosyaYolu);
	
			$ResimIcinDosyaAdi		=	ResimAdiOlustur();
			$GelenResminUzantisi	=	substr($GelenKargoFirmasiLogosu["name"], -4);
				if($GelenResminUzantisi=="jpeg"){
					$GelenResminUzantisi	=	".".$GelenResminUzantisi;
				}
			
			$ResimIcinYeniDosyaAdi		=	$ResimIcinDosyaAdi.$GelenResminUzantisi; // Eğer Convert Kullanılacaksa $ResimIcinYeniDosyaAdi = $ResimIcinDosyaAdi.".png"; şeklinde kullanınız.

			$KargoLogosuYukle	=	new upload($GelenKargoFirmasiLogosu, "tr-TR");
				if($KargoLogosuYukle->uploaded){
				   $KargoLogosuYukle->mime_magic_check			=	true;
				   $KargoLogosuYukle->allowed					=	array("image/*");
				   $KargoLogosuYukle->file_new_name_body		=	$ResimIcinDosyaAdi;
				   $KargoLogosuYukle->file_overwrite			=	true;
				   //$KargoLogosuYukle->image_convert				=	"png";
				   $KargoLogosuYukle->image_quality				=	100;
				   $KargoLogosuYukle->image_background_color	=	"#FFFFFF";
				   $KargoLogosuYukle->image_resize				=	true;
				   $KargoLogosuYukle->image_ratio				=	true;
				   $KargoLogosuYukle->image_y					=	30;
				   $KargoLogosuYukle->process($VerotIcinKlasorYolu);
					

					if($KargoLogosuYukle->processed){
						$KargoResmiGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE kargofirmalari SET KargoFirmasiLogosu = ? WHERE id = ? LIMIT 1");
						$KargoResmiGuncellemeSorgusu->execute([$ResimIcinYeniDosyaAdi, $GelenID]);
						$KargoResmiGuncellemeKontrol	=	$KargoResmiGuncellemeSorgusu->rowCount();
						
						if($KargoResmiGuncellemeKontrol<1){
							header("Location:index.php?SKD=0&SKI=29");
							exit();
						}
						$KargoLogosuYukle->clean();
					}else{
						header("Location:index.php?SKD=0&SKI=29");
						exit();
					} 
				}
		}
		
		if(($KargoGuncellemeKontrol>0) or ($KargoResmiGuncellemeKontrol>0)){
			header("Location:index.php?SKD=0&SKI=28");
			exit();
		}else{
			header("Location:index.php?SKD=0&SKI=29");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=29");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>