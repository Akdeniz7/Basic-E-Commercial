<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_POST["BannerAlani"])){
		$GelenBannerAlani		=	Guvenlik($_POST["BannerAlani"]);
	}else{
		$GelenBannerAlani		=	"";
	}
	$GelenBannerResmi			=	$_FILES["BannerResmi"];
	if(isset($_POST["BannerAdi"])){
		$GelenBannerAdi			=	Guvenlik($_POST["BannerAdi"]);
	}else{
		$GelenBannerAdi			=	"";
	}
	
	if(($GelenBannerAlani!="") and ($GelenBannerResmi["name"]!="") and ($GelenBannerResmi["type"]!="") and ($GelenBannerResmi["tmp_name"]!="") and ($GelenBannerResmi["error"]==0) and ($GelenBannerResmi["size"]>0) and ($GelenBannerAdi!="")){
		$ResimIcinDosyaAdi		=	ResimAdiOlustur();
		$GelenResminUzantisi	=	substr($GelenBannerResmi["name"], -4);
			if($GelenResminUzantisi=="jpeg"){
				$GelenResminUzantisi	=	".".$GelenResminUzantisi;
			}
		
		$ResimIcinYeniDosyaAdi		=	$ResimIcinDosyaAdi.$GelenResminUzantisi;
		
		$BannerEklemeSorgusu		=	$VeritabaniBaglantisi->prepare("INSERT INTO bannerlar (BannerAlani, BannerAdi, BannerResmi) values (?, ?, ?)");
		$BannerEklemeSorgusu->execute([$GelenBannerAlani, $GelenBannerAdi, $ResimIcinYeniDosyaAdi]);
		$BannerEklemeKontrol		=	$BannerEklemeSorgusu->rowCount();
		
		if($BannerEklemeKontrol>0){
			if($GelenBannerAlani == "Ana Sayfa"){
				$ResimGenislikOlcusu	=	1065;
				$ResimYukseklikOlcusu	=	186;
			}elseif($GelenBannerAlani == "Menu Altı"){
				$ResimGenislikOlcusu	=	250;
				$ResimYukseklikOlcusu	=	500;
			}elseif($GelenBannerAlani == "Ürün Detay"){
				$ResimGenislikOlcusu	=	350;
				$ResimYukseklikOlcusu	=	350;
			}
		
			$BannerYukle	=	new upload($GelenBannerResmi, "tr-TR");
				if($BannerYukle->uploaded){
				   $BannerYukle->mime_magic_check			=	true;
				   $BannerYukle->allowed					=	array("image/*");
				   $BannerYukle->file_new_name_body			=	$ResimIcinDosyaAdi;
				   $BannerYukle->file_overwrite				=	true;
				   //$BannerYukle->image_convert				=	"png";
				   $BannerYukle->image_quality				=	100;
				   $BannerYukle->image_background_color		=	"#FFFFFF";
				   $BannerYukle->image_resize				=	true;
				   $BannerYukle->image_x					=	$ResimGenislikOlcusu;
				   $BannerYukle->image_y					=	$ResimYukseklikOlcusu;
				   $BannerYukle->process($VerotIcinKlasorYolu);

					if($BannerYukle->processed){
						$BannerYukle->clean();

						header("Location:index.php?SKD=0&SKI=36");
						exit();
					}else{
						header("Location:index.php?SKD=0&SKI=37");
						exit();
					} 
				}
		}else{
			header("Location:index.php?SKD=0&SKI=37");
			exit();
		}
	}else{
		header("Location:index.php?SKD=0&SKI=37");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>