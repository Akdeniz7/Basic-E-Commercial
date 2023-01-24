<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID					=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID					=	"";
	}
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
	
	if(($GelenID!="") and ($GelenBannerAlani!="") and ($GelenBannerAdi!="")){
		$BannerResmiSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM bannerlar WHERE id = ? LIMIT 1");
		$BannerResmiSorgusu->execute([$GelenID]);
		$BannerKontrol			=	$BannerResmiSorgusu->rowCount();
		$BannerBilgisi			=	$BannerResmiSorgusu->fetch(PDO::FETCH_ASSOC);
		
		if($GelenBannerAlani==$BannerBilgisi["BannerAlani"]){		
			$BannerGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE bannerlar SET BannerAlani = ?, BannerAdi = ? WHERE id = ? LIMIT 1");
			$BannerGuncellemeSorgusu->execute([$GelenBannerAlani, $GelenBannerAdi, $GelenID]);
			$BannerGuncellemeKontrol		=	$BannerGuncellemeSorgusu->rowCount();

			if(($GelenBannerResmi["name"]!="") and ($GelenBannerResmi["type"]!="") and ($GelenBannerResmi["tmp_name"]!="") and ($GelenBannerResmi["error"]==0) and ($GelenBannerResmi["size"]>0)){
				$SilinecekDosyaYolu		=	"../Resimler/".$BannerBilgisi["BannerResmi"];
				unlink($SilinecekDosyaYolu);

				$ResimIcinDosyaAdi		=	ResimAdiOlustur();
				$GelenResminUzantisi	=	substr($GelenBannerResmi["name"], -4);
					if($GelenResminUzantisi=="jpeg"){
						$GelenResminUzantisi	=	".".$GelenResminUzantisi;
					}

				$ResimIcinYeniDosyaAdi		=	$ResimIcinDosyaAdi.$GelenResminUzantisi; // Eğer Convert Kullanılacaksa $ResimIcinYeniDosyaAdi = $ResimIcinDosyaAdi.".png"; şeklinde kullanınız.

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
					   $BannerYukle->file_new_name_body		=	$ResimIcinDosyaAdi;
					   $BannerYukle->file_overwrite			=	true;
					   //$BannerYukle->image_convert			=	"png";
					   $BannerYukle->image_quality			=	100;
					   $BannerYukle->image_background_color	=	"#FFFFFF";
					   $BannerYukle->image_resize				=	true;
					   $BannerYukle->image_x					=	$ResimGenislikOlcusu;
					   $BannerYukle->image_y					=	$ResimYukseklikOlcusu;
					   $BannerYukle->process($VerotIcinKlasorYolu);

						if($BannerYukle->processed){
							$BannerResmiGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE bannerlar SET BannerResmi = ? WHERE id = ? LIMIT 1");
							$BannerResmiGuncellemeSorgusu->execute([$ResimIcinYeniDosyaAdi, $GelenID]);
							$BannerResmiGuncellemeKontrol	=	$BannerResmiGuncellemeSorgusu->rowCount();

							if($BannerResmiGuncellemeKontrol<1){
								header("Location:index.php?SKD=0&SKI=41");
								exit();
							}
							$BannerYukle->clean();
						}else{
							header("Location:index.php?SKD=0&SKI=41");
							exit();
						} 
					}
			}
			if(($BannerGuncellemeKontrol>0) or ($BannerResmiGuncellemeKontrol>0)){
				header("Location:index.php?SKD=0&SKI=40");
				exit();
			}else{
				header("Location:index.php?SKD=0&SKI=41");
				exit();
			}
		}else{
			if(($GelenBannerResmi["name"]!="") and ($GelenBannerResmi["type"]!="") and ($GelenBannerResmi["tmp_name"]!="") and ($GelenBannerResmi["error"]==0) and ($GelenBannerResmi["size"]>0)){
				$SilinecekDosyaYolu		=	"../Resimler/".$BannerBilgisi["BannerResmi"];
				unlink($SilinecekDosyaYolu);

				$ResimIcinDosyaAdi		=	ResimAdiOlustur();
				$GelenResminUzantisi	=	substr($GelenBannerResmi["name"], -4);
					if($GelenResminUzantisi=="jpeg"){
						$GelenResminUzantisi	=	".".$GelenResminUzantisi;
					}

				$ResimIcinYeniDosyaAdi		=	$ResimIcinDosyaAdi.$GelenResminUzantisi; // Eğer Convert Kullanılacaksa $ResimIcinYeniDosyaAdi = $ResimIcinDosyaAdi.".png"; şeklinde kullanınız.

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
					   $BannerYukle->file_new_name_body		=	$ResimIcinDosyaAdi;
					   $BannerYukle->file_overwrite			=	true;
					   //$BannerYukle->image_convert			=	"png";
					   $BannerYukle->image_quality			=	100;
					   $BannerYukle->image_background_color	=	"#FFFFFF";
					   $BannerYukle->image_resize				=	true;
					   $BannerYukle->image_x					=	$ResimGenislikOlcusu;
					   $BannerYukle->image_y					=	$ResimYukseklikOlcusu;
					   $BannerYukle->process($VerotIcinKlasorYolu);

						if($BannerYukle->processed){
							$BannerResmiGuncellemeSorgusu	=	$VeritabaniBaglantisi->prepare("UPDATE bannerlar SET BannerAlani = ?, BannerAdi = ?, BannerResmi = ? WHERE id = ? LIMIT 1");
							$BannerResmiGuncellemeSorgusu->execute([$GelenBannerAlani, $GelenBannerAdi, $ResimIcinYeniDosyaAdi, $GelenID]);
							$BannerResmiGuncellemeKontrol	=	$BannerResmiGuncellemeSorgusu->rowCount();


							header("Location:index.php?SKD=0&SKI=40");
							exit();

							if($BannerResmiGuncellemeKontrol<1){
								header("Location:index.php?SKD=0&SKI=41");
								exit();
							}
							$BannerYukle->clean();
						}else{
							header("Location:index.php?SKD=0&SKI=41");
							exit();
						} 
					}
			}else{
				header("Location:index.php?SKD=0&SKI=41");
				exit();
			}
		}
	}else{
		header("Location:index.php?SKD=0&SKI=41");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>