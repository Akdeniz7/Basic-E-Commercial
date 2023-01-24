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
?>
<form action="index.php?SK=99" method="post">
	<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="800" valign="top">
				<table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr height="40">
						<td colspan="2" style="color:#FF9900"><h3>Alışveriş Sepeti</h3></td>
					</tr>
					<tr height="30">
						<td colspan="2" valign="top" style="border-bottom: 1px dashed #CCCCCC;">Adres ve Kargo Seçimini Aşağıdan Belirtebilirsin.</td>
					</tr>
					<tr height="10">
						<td colspan="2" style="font-size: 10px;">&nbsp;</td>
					</tr>
					<tr height="40">
						<td align="left" style="background: #CCCCCC; font-weight: bold;">&nbsp;Adres Seçimi</td>
						<td align="right" style="background: #CCCCCC; font-weight: bold;"><a href="index.php?SK=70" style="color: #646464; text-decoration: none; font-weight: bold;">+ Yeni Adres Ekle&nbsp;</a></td>
					</tr>
					<?php
					$SepettekiUrunlerSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM sepet WHERE UyeId = ? ORDER BY id DESC");
					$SepettekiUrunlerSorgusu->execute([$KullaniciID]);
					$SepettekiUrunSayisi		=	$SepettekiUrunlerSorgusu->rowCount();
					$SepettiKayitlar			=	$SepettekiUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);

					if($SepettekiUrunSayisi>0){
						$SepettekiToplamUrunSayisi			=	0;
						$SepettekiToplamFiyat				=	0;
						$SepettekiToplamKargoFiyati			=	0;
						$SepettekiToplamKargoFiyatiHesapla	=	0;

						foreach($SepettiKayitlar as $SepetSatirlari){
							$SepetIdsi						=	$SepetSatirlari["id"];
							$SepettekiUrununIdsi			=	$SepetSatirlari["UrunId"];
							$SepettekiUrununVaryantIdsi		=	$SepetSatirlari["VaryantId"];
							$SepettekiUrununAdedi			=	$SepetSatirlari["UrunAdedi"];

							$UrunBilgileriSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
							$UrunBilgileriSorgusu->execute([$SepettekiUrununIdsi]);
							$UrunKaydi						=	$UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
								$UrununFiyati			=	$UrunKaydi["UrunFiyati"];
								$UrununParaBirimi		=	$UrunKaydi["ParaBirimi"];
								$UrununKargoUcreti		=	$UrunKaydi["KargoUcreti"];

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

							$UrunToplamFiyatiHesapla				=	($UrunFiyatiHesapla*$SepettekiUrununAdedi);
							$UrunToplamFiyatiBicimlendir			=	FiyatBicimlendir($UrunToplamFiyatiHesapla);

							$SepettekiToplamUrunSayisi				+=	$SepettekiUrununAdedi;
							$SepettekiToplamFiyat					+=	($UrunFiyatiHesapla*$SepettekiUrununAdedi);
							
							$SepettekiToplamKargoFiyatiHesapla		+=	($UrununKargoUcreti*$SepettekiUrununAdedi);
							$SepettekiToplamKargoFiyatiBicimlendir	=	FiyatBicimlendir($SepettekiToplamKargoFiyatiHesapla);
						}
						
						if($SepettekiToplamFiyat>=$UcretsizKargoBaraji){
							$SepettekiToplamKargoFiyatiHesapla		=	0;
							$SepettekiToplamKargoFiyatiBicimlendir	=	FiyatBicimlendir($SepettekiToplamKargoFiyatiHesapla);
							
							$OdenecekToplamTutariBicimlendir		=	FiyatBicimlendir($SepettekiToplamFiyat);
						}else{
							$OdenecekToplamTutariHesapla			=	($SepettekiToplamFiyat+$SepettekiToplamKargoFiyatiHesapla);
							$OdenecekToplamTutariBicimlendir		=	FiyatBicimlendir($OdenecekToplamTutariHesapla);
						}

					$AdreslerSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM adresler WHERE UyeId = ? ORDER BY id DESC");
					$AdreslerSorgusu->execute([$KullaniciID]);
					$AdresSayisi		=	$AdreslerSorgusu->rowCount();
					$AdresKayitlari		=	$AdreslerSorgusu->fetchAll(PDO::FETCH_ASSOC);

					if($AdresSayisi>0){		
						foreach($AdresKayitlari as $AdresSatirlari){
					?>
					<tr>
						<td colspan="2" align="left">
							<table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
								<tr height="50">
									<td width="25" style="border-bottom: 1px dashed #CCCCCC;" align="left"><input type="radio" name="AdresSecimi" checked="checked" value="<?php echo DonusumleriGeriDondur($AdresSatirlari["id"]); ?>"></td>
									<td width="775" style="border-bottom: 1px dashed #CCCCCC;" align="left"><?php echo DonusumleriGeriDondur($AdresSatirlari["AdiSoyadi"]); ?> - <?php echo DonusumleriGeriDondur($AdresSatirlari["Adres"]); ?> <?php echo DonusumleriGeriDondur($AdresSatirlari["Ilce"]); ?> / <?php echo DonusumleriGeriDondur($AdresSatirlari["Sehir"]); ?> - <?php echo DonusumleriGeriDondur($AdresSatirlari["TelefonNumarasi"]); ?></td>
								</tr>
							</table>
						</td>
					</tr>
					<?php
						}
					}else{
					?>
					<tr height="50">
						<td colspan="2" align="left">Sisteme kayıtlı adresiniz bulunmamaktadır. Lütfen öncelikle "Hesabım" alanından "Adres" ekleyiniz. Adres eklemek için lütfen <a href="index.php?SK=70" style="color: #646464; text-decoration: none; font-weight: bold;">buraya tıklayınız</a>.</td>
					</tr>
					<?php
					}
					?>
					<tr height="10">
						<td colspan="2" style="font-size: 10px;">&nbsp;</td>
					</tr>
					<tr height="40">
						<td colspan="2" align="left" style="background: #CCCCCC; font-weight: bold;">&nbsp;Kargo Firması Seçimi</td>
					</tr>
					<tr height="10">
						<td colspan="2" style="font-size: 10px;">&nbsp;</td>
					</tr>
					<tr height="40">
						<td colspan="2" align="left"><table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr><?php
								$KargolarSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM kargofirmalari");
								$KargolarSorgusu->execute();
								$KargoSayisi			=	$KargolarSorgusu->rowCount();
								$KargoKayitlari			=	$KargolarSorgusu->fetchAll(PDO::FETCH_ASSOC);

								$DonguSayisi			=	1;
								$SutunAdetSayisi		=	3;
								$SecimIcinSayi			=	1;

								foreach($KargoKayitlari as $KargoKaydi){
								?>
									<td width="260">
										<table width="260" align="center" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #CCCCCC; margin-bottom: 10px;">
											<tr>
												<td>&nbsp;</td>
											</tr>
											<tr height="40">
												<td align="center"><img src="Resimler/<?php echo DonusumleriGeriDondur($KargoKaydi["KargoFirmasiLogosu"]); ?>" border="0"></td>
											</tr>
											<tr>
												<td align="center"><input type="radio" name="KargoSecimi" <?php if($SecimIcinSayi==1){ ?>checked="checked" <?php } ?> value="<?php echo DonusumleriGeriDondur($KargoKaydi["id"]); ?>"></td>
											</tr>
											<tr>
												<td>&nbsp;</td>
											</tr>
										</table>
									</td>
									<?php
									$SecimIcinSayi++;
										
									if($DonguSayisi<$SutunAdetSayisi){
									?>
										<td width="10">&nbsp;</td>
									<?php
									}
									?>
								<?php
									$DonguSayisi++;

									if($DonguSayisi>$SutunAdetSayisi){
										echo "</tr><tr>";
										$DonguSayisi	=	1;
									}
								}
								?>
							</tr>
						</table></td>
					</tr>
					<?php
					}else{
						header("Location:index.php?SK=94");
						exit();
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
					<td align="right" style="font-size: 25px; font-weight: bold;"><?php echo $OdenecekToplamTutariBicimlendir; ?> TL</td>
				</tr>
				<tr height="10">
					<td style="font-size: 10px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="right">Ürünler Toplam Tutarı (KDV Dahil)</td>
				</tr>
				<tr>
					<td align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($SepettekiToplamFiyat); ?> TL</td>
				</tr>
				<tr height="10">
					<td style="font-size: 10px;">&nbsp;</td>
				</tr>				
				<tr>
					<td align="right">Kargo Tutarı (KDV Dahil)</td>
				</tr>
				<tr>
					<td align="right" style="font-size: 25px; font-weight: bold;"><?php echo $SepettekiToplamKargoFiyatiBicimlendir; ?> TL</td>
				</tr>
				<tr height="10">
					<td style="font-size: 10px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="right"><input type="submit" value="ÖDEME SEÇİMİ" class="AlisverisiTamamlaButonu"></td>
				</tr>
			</table></td>
		</tr>
	</table>
</form>
<?php
}else{
	header("Location:index.php");
	exit();
}
?>