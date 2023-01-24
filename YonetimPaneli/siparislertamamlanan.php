<?php
if(isset($_SESSION["Yonetici"])){
$SayfalamaIcinSolVeSagButonSayisi		=	2;
$SayfaBasinaGosterilecekKayitSayisi		=	10;
$ToplamKayitSayisiSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler WHERE OnayDurumu = ? AND KargoDurumu = ? ORDER BY id DESC");
$ToplamKayitSayisiSorgusu->execute([1, 1]);
$ToplamKayitSayisiSorgusu				=	$ToplamKayitSayisiSorgusu->rowCount();
$SayfalamayaBaslanacakKayitSayisi		=	($Sayfalama*$SayfaBasinaGosterilecekKayitSayisi)-$SayfaBasinaGosterilecekKayitSayisi;
$BulunanSayfaSayisi						=	ceil($ToplamKayitSayisiSorgusu/$SayfaBasinaGosterilecekKayitSayisi);
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;SİPARİŞLER (TAMAMLANAN)</h3></td>
		<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=106" style="color: #FFFFFF; text-decoration: none;">Bekleyen Siparişler&nbsp;</a></td>
	</tr>
	<tr height="10">
		<td colspan="2" style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$SiparisNumaralariSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler WHERE OnayDurumu = ? AND KargoDurumu = ? ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi, $SayfaBasinaGosterilecekKayitSayisi");
	$SiparisNumaralariSorgusu->execute([1, 1]);
	$SiparisNumaralariSayisi		=	$SiparisNumaralariSorgusu->rowCount();
	$SiparisNumaralariKayitlari		=	$SiparisNumaralariSorgusu->fetchAll(PDO::FETCH_ASSOC);

	if($SiparisNumaralariSayisi>0){
		foreach($SiparisNumaralariKayitlari as $SiparisNumaralariSatirlar){
			$SiparislerSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM siparisler WHERE SiparisNumarasi = ? AND OnayDurumu = ? AND KargoDurumu = ?");
			$SiparislerSorgusu->execute([$SiparisNumaralariSatirlar["SiparisNumarasi"], 1, 1]);
			$SiparisSayisi		=	$SiparislerSorgusu->rowCount();
			$SiparisKayitlari	=	$SiparislerSorgusu->fetchAll(PDO::FETCH_ASSOC);

			if($SiparisSayisi>0){
				$ToplamFiyat		=	0;
				foreach($SiparisKayitlari as $Siparisler){
					$SiparisTarihi			=	 TarihBul($Siparisler["SiparisTarihi"]);
					$UrunToplamFiyati		=	$Siparisler["ToplamUrunFiyati"];
					
					$ToplamFiyat			+=	$UrunToplamFiyati;
				}
			?>	
			<tr>
				<td colspan="2" style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr height="30">
						<td align="left" width="120"><b>Sipariş Tarihi</b></td>
						<td align="left" width="20"><b>:</b></td>
						<td align="left" width="225"><?php echo $SiparisTarihi; ?></td>
						<td align="left" width="120"><b>Sipariş Tutarı</b></td>
						<td align="left" width="20"><b>:</b></td>
						<td align="left" width="170"><?php echo FiyatBicimlendir($ToplamFiyat); ?> TL</td>
						<td align="left" width="75"><table width="75" align="right" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="25"><a href="index.php?SKD=0&SKI=109&SiparisNo=<?php echo DonusumleriGeriDondur($SiparisNumaralariSatirlar["SiparisNumarasi"]); ?>"><img src="../Resimler/DokumanKirmiziKalemli20x20.png" border="0" style="margin-top: 5px;"></a></td>
								<td width="50"><a href="index.php?SKD=0&SKI=109&SiparisNo=<?php echo DonusumleriGeriDondur($SiparisNumaralariSatirlar["SiparisNumarasi"]); ?>" style="color: #0000FF; text-decoration: none;">Detay</a></td>
							</tr>
						</table></td>
					</tr>
				</table></td>
			</tr>
			<?php
				
			}else{
				header("Location:index.php?SKD=0&SKI=0");
				exit();
			}
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
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=108&SYF=1'><<</a></span>";
						$SayfalamaIcinSayfaDegeriniBirGeriAl	=	$Sayfalama-1;
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=108&SYF=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "'><</a></span>";
					}

					for($SayfalamaIcinSayfaIndexDegeri=$Sayfalama-$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri<=$Sayfalama+$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++){
						if(($SayfalamaIcinSayfaIndexDegeri>0) and ($SayfalamaIcinSayfaIndexDegeri<=$BulunanSayfaSayisi)){
							if($Sayfalama==$SayfalamaIcinSayfaIndexDegeri){
								echo "<span class='SayfalamaAktif'>" . $SayfalamaIcinSayfaIndexDegeri . "</span>";
							}else{
								echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=108&SYF=" . $SayfalamaIcinSayfaIndexDegeri . "'> " . $SayfalamaIcinSayfaIndexDegeri . "</a></span>";
							}
						}
					}

					if($Sayfalama!=$BulunanSayfaSayisi){
						$SayfalamaIcinSayfaDegeriniBirIleriAl	=	$Sayfalama+1;
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=108&SYF=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "'>></a></span>";
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=108&SYF=" . $BulunanSayfaSayisi . "'>>></a></span>";
					}
					?>
				</div>
			</div></td>
		</tr>
	<?php	
		}		
	}else{
	?>
	<tr>
		<td colspan="2"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="750">Kayıtlı tamamlanan sipariş bulunmamaktadır.</td>
			</tr>
		</table></td>
	</tr>
	<?php
	}
	?>
</table>
<?php
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>