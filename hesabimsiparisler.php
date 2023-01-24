<?php
if(isset($_SESSION["Kullanici"])){
	
$SayfalamaIcinSolVeSagButonSayisi		=	2;
$SayfaBasinaGosterilecekKayitSayisi		=	10;
$ToplamKayitSayisiSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler WHERE UyeId = ? ORDER BY SiparisNumarasi DESC");
$ToplamKayitSayisiSorgusu->execute([$KullaniciID]);
$ToplamKayitSayisiSorgusu				=	$ToplamKayitSayisiSorgusu->rowCount();
$SayfalamayaBaslanacakKayitSayisi		=	($Sayfalama*$SayfaBasinaGosterilecekKayitSayisi)-$SayfaBasinaGosterilecekKayitSayisi;
$BulunanSayfaSayisi						=	ceil($ToplamKayitSayisiSorgusu/$SayfaBasinaGosterilecekKayitSayisi);
?>
<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><hr /></td>
	</tr>
	<tr>
		<td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?SK=50" style="text-decoration: none; color: black;">Üyelik Bilgileri</a></td>
		<td width="10">&nbsp;</td>
		<td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?SK=58" style="text-decoration: none; color: black;">Adresler</a></td>
		<td width="10">&nbsp;</td>
		<td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?SK=59" style="text-decoration: none; color: black;">Favoriler</a></td>
		<td width="10">&nbsp;</td>
		<td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?SK=60" style="text-decoration: none; color: black;">Yorumlar</a></td>
		<td width="10">&nbsp;</td>
		<td width="203" style="border: 1px solid black; text-align: center; padding: 10px 0; font-weight: bold;"><a href="index.php?SK=61" style="text-decoration: none; color: black;">Siparişler</a></td>
	</tr>
		</table></td>
	</tr>
	<tr>
		<td><hr /></td>
	</tr>
	<tr>
		<td width="1065" valign="top">
			<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
				<tr height="40">
					<td colspan="8" style="color:#FF9900"><h3>Hesabım > Siparişler</h3></td>
				</tr>
				<tr height="30">
					<td colspan="8" valign="top" style="border-bottom: 1px dashed #CCCCCC;">Tüm Siparişlerinizi Bu Alandan Görüntüleyebilirsiniz.</td>
				</tr>
				<tr height="50">
					<td width="125" style="background: #f8ffa7; color: black;" align="left">&nbsp;Sipariş Numarası</td>
					<td width="75" style="background: #f8ffa7; color: black;" align="left">Resim</td>
					<td width="50" style="background: #f8ffa7; color: black;" align="left">Yorum</td>
					<td width="415" style="background: #f8ffa7; color: black;" align="left">Adı</td>
					<td width="100" style="background: #f8ffa7; color: black;" align="left">Fiyatı</td>
					<td width="50" style="background: #f8ffa7; color: black;" align="left">Adet</td>
					<td width="100" style="background: #f8ffa7; color: black;" align="left">Toplam Fiyat</td>
					<td width="150" style="background: #f8ffa7; color: black;" align="left">Kargo Durumu / Takip</td>
				</tr>
				<?php
				$SiparisNumaralariSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler WHERE UyeId = ? ORDER BY SiparisNumarasi DESC LIMIT $SayfalamayaBaslanacakKayitSayisi, $SayfaBasinaGosterilecekKayitSayisi");
				$SiparisNumaralariSorgusu->execute([$KullaniciID]);
				$SiparisNumaralariSayisi		=	$SiparisNumaralariSorgusu->rowCount();
				$SiparisNumaralariKayitlari		=	$SiparisNumaralariSorgusu->fetchAll(PDO::FETCH_ASSOC);
				
				if($SiparisNumaralariSayisi>0){
					foreach($SiparisNumaralariKayitlari as $SiparisNumaralariSatirlar){
						$SiparisNo		=	DonusumleriGeriDondur($SiparisNumaralariSatirlar["SiparisNumarasi"]);
						
						$SiparisSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT * FROM siparisler WHERE UyeId = ? AND SiparisNumarasi = ? ORDER BY id ASC");
						$SiparisSorgusu->execute([$KullaniciID, $SiparisNo]);
						$SiparisSorgusuKayitlari	=	$SiparisSorgusu->fetchAll(PDO::FETCH_ASSOC);
						
						foreach($SiparisSorgusuKayitlari as $SiparisSatirlar){
							$UrunTuru		=	DonusumleriGeriDondur($SiparisSatirlar["UrunTuru"]);
								if($UrunTuru == "Erkek Ayakkabısı"){
									$ResimKlasoruAdi	=	"Erkek";
								}elseif($UrunTuru == "Kadın Ayakkabısı"){
									$ResimKlasoruAdi	=	"Kadin";
								}else{
									$ResimKlasoruAdi	=	"Cocuk";
								}
								
								$KargoDurumu		=	DonusumleriGeriDondur($SiparisSatirlar["KargoDurumu"]);
									if($KargoDurumu == 0){
										$KargoDurumuYazdir	=	"Beklemede";
									}else{
										$KargoDurumuYazdir	=	DonusumleriGeriDondur($SiparisSatirlar["KargoGonderiKodu"]);
									}
				?>
							<tr height="30">
								<td width="125" align="left">&nbsp;#<?php echo DonusumleriGeriDondur($SiparisSatirlar["SiparisNumarasi"]); ?></td>
								<td width="75" align="left"><img src="Resimler/UrunResimleri/<?php echo $ResimKlasoruAdi; ?>/<?php echo DonusumleriGeriDondur($SiparisSatirlar["UrunResmiBir"]); ?>" border="0" width="60" height="80"></td>
								<td width="50" align="left"><a href="index.php?SK=75&UrunID=<?php echo DonusumleriGeriDondur($SiparisSatirlar["UrunId"]); ?>"><img src="Resimler/DokumanKirmiziKalemli20x20.png" border="0"></a></td>
								<td width="415" align="left"><?php echo DonusumleriGeriDondur($SiparisSatirlar["UrunAdi"]); ?></td>
								<td width="100" align="left"><?php echo FiyatBicimlendir(DonusumleriGeriDondur($SiparisSatirlar["UrunFiyati"])); ?> TL</td>
								<td width="50" align="left"><?php echo DonusumleriGeriDondur($SiparisSatirlar["UrunAdedi"]); ?></td>
								<td width="100" align="left"><?php echo FiyatBicimlendir(DonusumleriGeriDondur($SiparisSatirlar["ToplamUrunFiyati"])); ?> TL</td>
								<td width="150" align="left"><?php echo $KargoDurumuYazdir; ?></td>
							</tr>
				<?php	
						}
				?>
						<tr height="30">
							<td colspan="8"><hr /></td>
						</tr>
				<?php
					}
					
					if($BulunanSayfaSayisi>1){
				?>
					<tr height="50">
						<td colspan="8" align="center"><div class="SayfalamaAlaniKapsayicisi">
							<div class="SayfalamaAlaniIciMetinAlaniKapsayicisi">
								Toplam <?php echo $BulunanSayfaSayisi; ?> sayfada, <?php echo $ToplamKayitSayisiSorgusu; ?> adet kayıt bulunmaktadır.
							</div>
							
							<div class="SayfalamaAlaniIciNumaraAlaniKapsayicisi">
								<?php
								if($Sayfalama>1){
									echo "<span class='SayfalamaPasif'><a href='index.php?SK=61&SYF=1'><<</a></span>";
									$SayfalamaIcinSayfaDegeriniBirGeriAl	=	$Sayfalama-1;
									echo "<span class='SayfalamaPasif'><a href='index.php?SK=61&SYF=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "'><</a></span>";
								}
								
								for($SayfalamaIcinSayfaIndexDegeri=$Sayfalama-$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri<=$Sayfalama+$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++){
									if(($SayfalamaIcinSayfaIndexDegeri>0) and ($SayfalamaIcinSayfaIndexDegeri<=$BulunanSayfaSayisi)){
										if($Sayfalama==$SayfalamaIcinSayfaIndexDegeri){
											echo "<span class='SayfalamaAktif'>" . $SayfalamaIcinSayfaIndexDegeri . "</span>";
										}else{
											echo "<span class='SayfalamaPasif'><a href='index.php?SK=61&SYF=" . $SayfalamaIcinSayfaIndexDegeri . "'> " . $SayfalamaIcinSayfaIndexDegeri . "</a></span>";
										}
									}
								}
								
								if($Sayfalama!=$BulunanSayfaSayisi){
									$SayfalamaIcinSayfaDegeriniBirIleriAl	=	$Sayfalama+1;
									echo "<span class='SayfalamaPasif'><a href='index.php?SK=61&SYF=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "'>></a></span>";
									echo "<span class='SayfalamaPasif'><a href='index.php?SK=61&SYF=" . $BulunanSayfaSayisi . "'>>></a></span>";
								}
								?>
							</div>
						</div></td>
					</tr>
				<?php	
					}
				}else{
				?>
					<tr height="50">
						<td colspan="8" align="left">Sisteme Kayıtlı Siparişiniz Bulunmamaktadır.</td>
					</tr>
				<?php
				}
				?>
			</table>
		</td>
	</tr>
</table>	
<?php
}else{
	header("Location:index.php");
	exit();
}
?>