<?php
if(isset($_SESSION["Kullanici"])){
	
$SayfalamaIcinSolVeSagButonSayisi		=	2;
$SayfaBasinaGosterilecekKayitSayisi		=	10;
$ToplamKayitSayisiSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT * FROM favoriler WHERE UyeId = ? ORDER BY id DESC");
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
					<td colspan="4" style="color:#FF9900"><h3>Hesabım > Favoriler</h3></td>
				</tr>
				<tr height="30">
					<td colspan="4" valign="top" style="border-bottom: 1px dashed #CCCCCC;">Favorilerinize Eklediğiniz Tüm Ürünleri Bu Alandan Görüntüleyebilirsiniz.</td>
				</tr>
				<tr height="50">
					<td width="75" style="background: #f8ffa7; color: black;" align="left">&nbsp;Resim</td>
					<td width="25" style="background: #f8ffa7; color: black;" align="left">Sil</td>
					<td width="865" style="background: #f8ffa7; color: black;" align="left">Adı</td>
					<td width="100" style="background: #f8ffa7; color: black;" align="left">Fiyatı</td>
				</tr>
				<?php
				$FavorilerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM favoriler WHERE UyeId = ? ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi, $SayfaBasinaGosterilecekKayitSayisi");
				$FavorilerSorgusu->execute([$KullaniciID]);
				$FavoriSayisi			=	$FavorilerSorgusu->rowCount();
				$FavoriKayitlari		=	$FavorilerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
				if($FavoriSayisi>0){
					foreach($FavoriKayitlari as $FavoriSatirlar){
						$UrunlerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
						$UrunlerSorgusu->execute([$FavoriSatirlar["UrunId"]]);
						$UrunKaydi			=	$UrunlerSorgusu->fetch(PDO::FETCH_ASSOC);
							
						$UrununAdi			=	$UrunKaydi["UrunAdi"];
						$UrununUrunTuru		=	$UrunKaydi["UrunTuru"];
						$UrununResmi		=	$UrunKaydi["UrunResmiBir"];
						$UrununUrunFiyati	=	$UrunKaydi["UrunFiyati"];
						$UrununParaBirimi	=	$UrunKaydi["ParaBirimi"];
						
						if($UrununUrunTuru == "Erkek Ayakkabısı"){
							$ResimKlasoruAdi	=	"Erkek";
						}elseif($UrununUrunTuru == "Kadın Ayakkabısı"){
							$ResimKlasoruAdi	=	"Kadin";
						}else{
							$ResimKlasoruAdi	=	"Cocuk";
						}
								
				?>
						<tr height="30">
							<td width="75" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($UrunKaydi["id"]); ?>"><img src="Resimler/UrunResimleri/<?php echo $ResimKlasoruAdi; ?>/<?php echo DonusumleriGeriDondur($UrununResmi); ?>" border="0" width="60" height="80"></a></td>
							<td width="50" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a href="index.php?SK=81&ID=<?php echo DonusumleriGeriDondur($FavoriSatirlar["id"]); ?>"><img src="Resimler/Sil20x20.png" border="0"></a></td>
							<td width="415" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($UrunKaydi["id"]); ?>" style="color: #646464; text-decoration: none;"><?php echo DonusumleriGeriDondur($UrununAdi); ?></a></td>
							<td width="100" align="left" style="border-bottom: 1px dashed #CCCCCC;"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($UrunKaydi["id"]); ?>" style="color: #646464; text-decoration: none;"><?php echo FiyatBicimlendir(DonusumleriGeriDondur($UrununUrunFiyati)); ?> <?php echo DonusumleriGeriDondur($UrununParaBirimi); ?></a></td>
						</tr>
				<?php	
					}
					if($BulunanSayfaSayisi>1){
				?>
					<tr height="50">
						<td colspan="4" align="center"><div class="SayfalamaAlaniKapsayicisi">
							<div class="SayfalamaAlaniIciMetinAlaniKapsayicisi">
								Toplam <?php echo $BulunanSayfaSayisi; ?> sayfada, <?php echo $ToplamKayitSayisiSorgusu; ?> adet kayıt bulunmaktadır.
							</div>
							
							<div class="SayfalamaAlaniIciNumaraAlaniKapsayicisi">
								<?php
								if($Sayfalama>1){
									echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=1'><<</a></span>";
									$SayfalamaIcinSayfaDegeriniBirGeriAl	=	$Sayfalama-1;
									echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "'><</a></span>";
								}
								
								for($SayfalamaIcinSayfaIndexDegeri=$Sayfalama-$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri<=$Sayfalama+$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++){
									if(($SayfalamaIcinSayfaIndexDegeri>0) and ($SayfalamaIcinSayfaIndexDegeri<=$BulunanSayfaSayisi)){
										if($Sayfalama==$SayfalamaIcinSayfaIndexDegeri){
											echo "<span class='SayfalamaAktif'>" . $SayfalamaIcinSayfaIndexDegeri . "</span>";
										}else{
											echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=" . $SayfalamaIcinSayfaIndexDegeri . "'> " . $SayfalamaIcinSayfaIndexDegeri . "</a></span>";
										}
									}
								}
								
								if($Sayfalama!=$BulunanSayfaSayisi){
									$SayfalamaIcinSayfaDegeriniBirIleriAl	=	$Sayfalama+1;
									echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "'>></a></span>";
									echo "<span class='SayfalamaPasif'><a href='index.php?SK=59&SYF=" . $BulunanSayfaSayisi . "'>>></a></span>";
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
						<td colspan="4" align="left">Sisteme Kayıtlı Favori Ürününüz Bulunmamaktadır.</td>
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