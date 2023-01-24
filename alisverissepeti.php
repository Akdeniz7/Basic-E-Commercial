<?php
if(isset($_SESSION["Kullanici"])){

$StokIcinSepettekiUrunlerSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM sepet WHERE UyeId = ?");
$StokIcinSepettekiUrunlerSorgusu->execute([$KullaniciID]);
$StokIcinSepettekiUrunSayisi		=	$StokIcinSepettekiUrunlerSorgusu->rowCount();
$StokIcinSepettiKayitlar			=	$StokIcinSepettekiUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);

if($StokIcinSepettekiUrunSayisi>0){
	foreach($StokIcinSepettiKayitlar as $StokIcinSepettekiSatirlar){
		$StokIcinSepetIdsi						=	$StokIcinSepettekiSatirlar["id"];
		$StokIcinSepettekiUrununVaryantIdsi		=	$StokIcinSepettekiSatirlar["VaryantId"];
		$StokIcinSepettekiUrununAdedi			=	$StokIcinSepettekiSatirlar["UrunAdedi"];
		
		$StokIcinUrunVaryantBilgileriSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunvaryantlari WHERE id = ? LIMIT 1");
		$StokIcinUrunVaryantBilgileriSorgusu->execute([$StokIcinSepettekiUrununVaryantIdsi]);
		$StokIcinVaryantKaydi					=	$StokIcinUrunVaryantBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
			$StokIcinUrununStokAdedi	=	$StokIcinVaryantKaydi["StokAdedi"];
	
		if($StokIcinUrununStokAdedi==0){
			$SepetSilSorgusu		=	$VeritabaniBaglantisi->prepare("DELETE FROM sepet WHERE id = ? AND UyeId = ? LIMIT 1");
			$SepetSilSorgusu->execute([$StokIcinSepetIdsi, $KullaniciID]);
		}elseif($StokIcinSepettekiUrununAdedi>$StokIcinUrununStokAdedi){
			$SepetGuncellemeSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE sepet SET UrunAdedi= ? WHERE id = ? AND UyeId = ? LIMIT 1");
			$SepetGuncellemeSorgusu->execute([$StokIcinUrununStokAdedi, $StokIcinSepetIdsi, $KullaniciID]);
		}
	}
}
	
$SepetSifirlamaSorgusu		=	$VeritabaniBaglantisi->prepare("UPDATE sepet SET AdresId= ?, KargoId = ?, OdemeSecimi = ?, TaksitSecimi = ? WHERE UyeId = ?");
$SepetSifirlamaSorgusu->execute([0, 0, "", 0, $KullaniciID]);
?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="800" valign="top">
			<table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
				<tr height="40">
					<td style="color:#FF9900"><h3>Alışveriş Sepeti</h3></td>
				</tr>
				<tr height="30">
					<td valign="top" style="border-bottom: 1px dashed #CCCCCC;">Alışveriş Sepetine Eklemiş Olduğunuz Ürünler Aşağıdadır.</td>
				</tr>
				<?php
				$SepettekiUrunlerSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM sepet WHERE UyeId = ? ORDER BY id DESC");
				$SepettekiUrunlerSorgusu->execute([$KullaniciID]);
				$SepettekiUrunSayisi		=	$SepettekiUrunlerSorgusu->rowCount();
				$SepettiKayitlar			=	$SepettekiUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
				if($SepettekiUrunSayisi>0){
					$SepettekiToplamUrunSayisi		=	0;
					$SepettekiToplamFiyat			=	0;
					
					foreach($SepettiKayitlar as $SepetSatirlari){
						$SepetIdsi						=	$SepetSatirlari["id"];
						$SepettekiUrununIdsi			=	$SepetSatirlari["UrunId"];
						$SepettekiUrununVaryantIdsi		=	$SepetSatirlari["VaryantId"];
						$SepettekiUrununAdedi			=	$SepetSatirlari["UrunAdedi"];
						
						$UrunBilgileriSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
						$UrunBilgileriSorgusu->execute([$SepettekiUrununIdsi]);
						$UrunKaydi						=	$UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
							$UrununTuru				=	$UrunKaydi["UrunTuru"];
							$UrununResmi			=	$UrunKaydi["UrunResmiBir"];
							$UrununAdi				=	$UrunKaydi["UrunAdi"];
							$UrununFiyati			=	$UrunKaydi["UrunFiyati"];
							$UrununParaBirimi		=	$UrunKaydi["ParaBirimi"];
							$UrununVaryantBasligi	=	$UrunKaydi["VaryantBasligi"];
						
						$UrunVaryantBilgileriSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunvaryantlari WHERE id = ? LIMIT 1");
						$UrunVaryantBilgileriSorgusu->execute([$SepettekiUrununVaryantIdsi]);
						$VaryantKaydi					=	$UrunVaryantBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
						
							$UrununVaryantAdi		=	$VaryantKaydi["VaryantAdi"];
							$UrununStokAdedi		=	$VaryantKaydi["StokAdedi"];
						
						if($UrununTuru=="Erkek Ayakkabısı"){
							$UrunResimleriKlasoru	=	"Erkek";
						}elseif($UrununTuru=="Kadın Ayakkabısı"){
							$UrunResimleriKlasoru	=	"Kadin";
						}elseif($UrununTuru=="Çocuk Ayakkabısı"){
							$UrunResimleriKlasoru	=	"Cocuk";
						}
						
						if($UrununParaBirimi=="USD"){
							$UrunFiyatiHesapla				=	$UrununFiyati*$DolarKuru;
							$UrunFiyatiBicimlendir			=	FiyatBicimlendir($UrunFiyatiHesapla);
						}elseif($UrununParaBirimi=="EUR"){
							$UrunFiyatiHesapla				=	$UrununFiyati*$EuroKuru;
							$UrunFiyatiBicimlendir			=	FiyatBicimlendir($UrunFiyatiHesapla);
						}else{
							$UrunFiyatiHesapla				=	$UrununFiyati;
							$UrunFiyatiBicimlendir			=	FiyatBicimlendir($UrununFiyati);
						}
						
						$UrunToplamFiyatiHesapla		=	($UrunFiyatiHesapla*$SepettekiUrununAdedi);
						$UrunToplamFiyatiBicimlendir	=	FiyatBicimlendir($UrunToplamFiyatiHesapla);
						
						$SepettekiToplamUrunSayisi		+=	$SepettekiUrununAdedi;
						$SepettekiToplamFiyat			+=	($UrunFiyatiHesapla*$SepettekiUrununAdedi);
				?>
				<tr height="100">
					<td valign="bottom" align="left"><table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="80" style="border-bottom: 1px dashed #CCCCCC;" align="left"><img src="Resimler/UrunResimleri/<?php echo $UrunResimleriKlasoru; ?>/<?php echo DonusumleriGeriDondur($UrununResmi); ?>" border="0" width="60" height="80"></td>
							<td width="40" style="border-bottom: 1px dashed #CCCCCC;" align="left"><a href="index.php?SK=95&ID=<?php echo DonusumleriGeriDondur($SepetIdsi); ?>"><img src="Resimler/SilDaireli20x20.png" border="0"></a></td>
							<td width="530" style="border-bottom: 1px dashed #CCCCCC;" align="left"><?php echo DonusumleriGeriDondur($UrununAdi); ?><br /><?php echo DonusumleriGeriDondur($UrununVaryantBasligi); ?> : <?php echo DonusumleriGeriDondur($UrununVaryantAdi); ?></td>
							<td width="90" style="border-bottom: 1px dashed #CCCCCC;" align="left"><table width="90" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="30" align="center"><?php if($SepettekiUrununAdedi>1){ ?><a href="index.php?SK=96&ID=<?php echo DonusumleriGeriDondur($SepetIdsi); ?>" style="text-decoration: none; color: #646464;"><img src="Resimler/AzaltDaireli20x20.png" border="0" style="margin-top: 5px;"></a><?php }else{ ?>&nbsp;<?php } ?></td>
									<td width="30" align="center" style="line-height: 20px;"><?php echo DonusumleriGeriDondur($SepettekiUrununAdedi); ?></td>
									<td width="30" align="center"><a href="index.php?SK=97&ID=<?php echo DonusumleriGeriDondur($SepetIdsi); ?>"><img src="Resimler/ArttirDaireli20x20.png" border="0" style="margin-top: 5px;"></a></td>
								</tr>
							</table></td>
							<td width="150" style="border-bottom: 1px dashed #CCCCCC;" align="right"><?php echo $UrunFiyatiBicimlendir; ?> TL<br /><?php echo $UrunToplamFiyatiBicimlendir; ?> TL</td>
						</tr>
					</table></td>
				</tr>
				<?php
					}
				}else{
					$SepettekiToplamUrunSayisi	=	0;
					$SepettekiToplamFiyat		=	0;
				?>
				<tr height="30">
					<td valign="bottom" align="left">Alışveriş sepetinizde ürün bulunmamaktadır.</td>
				</tr>
				<?php
				}
				?>
			</table>
		</td>
		
		<td width="15">&nbsp;</td>
		
		<td width="250" valign="top"><table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr height="40">
				<td  style="color:#FF9900" align="right"><h3>Sipariş Özeti</h3></td>
			</tr>
			<tr height="30">
				<td valign="top" style="border-bottom: 1px dashed #CCCCCC;" align="right">Toplam <b style="color: red;"><?php echo $SepettekiToplamUrunSayisi; ?></b> Adet Ürün</td>
			</tr>
			<tr height="5">
				<td height="5" style="font-size: 5px;">&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Ödenecek Tutar (KDV Dahil)</td>
			</tr>
			<tr>
				<td align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($SepettekiToplamFiyat); ?> TL</td>
			</tr>
			<tr height="10">
				<td style="font-size: 10px;">&nbsp;</td>
			</tr>
			<tr>
				<td align="right"><div class="SepetIciDevamEtVeAlisverisiTamamlaButonu"><a href="index.php?SK=98"><img src="Resimler/SepetBeyaz21x20.png" border="0"> <div>DEVAM ET</div></a></div></td>
			</tr>
		</table></td>
	</tr>
</table>	
<?php
}else{
	header("Location:index.php");
	exit();
}
?>