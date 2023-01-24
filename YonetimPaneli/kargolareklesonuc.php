<?php
if(isset($_SESSION["Yonetici"])){
	$GelenKargoFirmasiLogosu			=	$_FILES["KargoFirmasiLogosu"];
	if(isset($_POST["KargoFirmasiAdi"])){
		$GelenKargoFirmasiAdi			=	Guvenlik($_POST["KargoFirmasiAdi"]);
	}else{
		$GelenKargoFirmasiAdi			=	"";
	}
		
	if(($GelenKargoFirmasiLogosu["name"]!="") and ($GelenKargoFirmasiLogosu["type"]!="") and ($GelenKargoFirmasiLogosu["tmp_name"]!="") and ($GelenKargoFirmasiLogosu["error"]==0) and ($GelenKargoFirmasiLogosu["size"]>0) and ($GelenKargoFirmasiAdi!="")){
			
		
		$ResimIcinDosyaAdi		=	ResimAdiOlustur();
		$GelenResminUzantisi	=	substr($GelenKargoFirmasiLogosu["name"], -4);
			if($GelenResminUzantisi=="jpeg"){
				$GelenResminUzantisi	=	".".$GelenResminUzantisi;
			}
		
		$ResimIcinYeniDosyaAdi		=	$ResimIcinDosyaAdi.$GelenResminUzantisi;
		
		$KargoEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO kargofirmalari (KargoFirmasiLogosu, KargoFirmasiAdi) values (?, ?)");
		$KargoEklemeSorgusu->execute([$ResimIcinYeniDosyaAdi, $GelenKargoFirmasiAdi]);
		$KargoEklemeKontrol		=	$KargoEklemeSorgusu->rowCount();
		
		if($KargoEklemeKontrol>0){
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
						$KargoLogosuYukle->clean();

						header("Location:index.php?SKD=0&SKI=24");
						exit();
					}else{
						header("Location:index.php?SKD=0&SKI=25");
						exit();
					} 
				}
		}else{
			header("Location:index.php?SKD=0&SKI=25");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=25");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>