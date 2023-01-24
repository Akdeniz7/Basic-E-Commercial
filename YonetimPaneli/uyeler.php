<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_REQUEST["AramaIcerigi"])){
		$GelenAramaIcerigi	=	Guvenlik($_REQUEST["AramaIcerigi"]);
		$AramaKosulu		=	 " AND (EmailAdresi LIKE '%" . $GelenAramaIcerigi . "%' OR IsimSoyisim LIKE '%" . $GelenAramaIcerigi . "%' OR TelefonNumarasi LIKE '%" . $GelenAramaIcerigi . "%' ) ";
		$SayfalamaKosulu	=	"&AramaIcerigi=" . $GelenAramaIcerigi;
	}else{
		$AramaKosulu		=	"";
		$SayfalamaKosulu	=	"";
	}

	$SayfalamaIcinSolVeSagButonSayisi		=	2;
	$SayfaBasinaGosterilecekKayitSayisi		=	10;
	$ToplamKayitSayisiSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT * FROM uyeler WHERE SilinmeDurumu = ? $AramaKosulu ORDER BY id DESC");
	$ToplamKayitSayisiSorgusu->execute([0]);
	$ToplamKayitSayisiSorgusu				=	$ToplamKayitSayisiSorgusu->rowCount();
	$SayfalamayaBaslanacakKayitSayisi		=	($Sayfalama*$SayfaBasinaGosterilecekKayitSayisi)-$SayfaBasinaGosterilecekKayitSayisi;
	$BulunanSayfaSayisi						=	ceil($ToplamKayitSayisiSorgusu/$SayfaBasinaGosterilecekKayitSayisi);
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;ÜYELER</h3></td>
		<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=83" style="color: #FFFFFF; text-decoration: none;">Silinmiş Üyeler&nbsp;</a></td>
	</tr>
	<tr height="10">
		<td colspan="2" style="font-size: 10px;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td><div class="AramaAlani"><form action="index.php?SKD=0&SKI=82" method="post">
					<div class="AramaAlaniButonKapsamaAlani">
						<input type="submit" value="" class="AramaAlaniButonu">
					</div>
					<div class="AramaAlaniInputKapsamaAlani">
						<input type="text" name="AramaIcerigi" class="AramaAlaniInputu">
					</div>
				</form></div></td>
			</tr>
		</table></td>
	</tr>
	<tr height="10">
		<td colspan="2" style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$UyelerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM uyeler WHERE SilinmeDurumu = ? $AramaKosulu ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi, $SayfaBasinaGosterilecekKayitSayisi");
	$UyelerSorgusu->execute([0]);
	$UyelerSayisi		=	$UyelerSorgusu->rowCount();
	$UyelerKayitlari	=	$UyelerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
	if($UyelerSayisi>0){
		foreach($UyelerKayitlari as $Uyeler){
	?>	
			<tr height="80">
				<td colspan="2" style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr height="30">
						<td width="85"><b>Adı Soyadı</b></td>
						<td width="10"><b>:</b></td>
						<td width="150"><?php echo DonusumleriGeriDondur($Uyeler["IsimSoyisim"]); ?></td>
						<td width="90"><b>E-Mail</b></td>
						<td width="10"><b>:</b></td>
						<td width="200"><?php echo DonusumleriGeriDondur($Uyeler["EmailAdresi"]); ?></td>
						<td width="70"><b>Telefon</b></td>
						<td width="10"><b>:</b></td>
						<td width="95"><?php echo DonusumleriGeriDondur($Uyeler["TelefonNumarasi"]); ?></td>
					</tr>
					<tr height="30">
						<td><b>Cinsiyet</b></td>
						<td><b>:</b></td>
						<td><?php echo DonusumleriGeriDondur($Uyeler["Cinsiyet"]); ?></td>
						<td><b>Kayıt Tarihi</b></td>
						<td><b>:</b></td>
						<td><?php echo  TarihBul(DonusumleriGeriDondur($Uyeler["KayitTarihi"])); ?></td>
						<td><b>Kayıt IP</b></td>
						<td><b>:</b></td>
						<td><?php echo DonusumleriGeriDondur($Uyeler["KayitIpAdresi"]); ?></td>
					</tr>
					<tr>
						<td colspan="9" align="right"><table width="95" align="right" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="40">&nbsp;</td>
								<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=84&ID=<?php echo DonusumleriGeriDondur($Uyeler["id"]); ?>"><img src="../Resimler/Sil20x20.png" border="0" style="margin-top: 5px;"></a></td>
								<td width="30" align="left"><a href="index.php?SKD=0&SKI=84&ID=<?php echo DonusumleriGeriDondur($Uyeler["id"]); ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
							</tr>
						</table></td>
					</tr>
				</table></td>
			</tr>
	<?php
		}
		
		if($BulunanSayfaSayisi>1){
		?>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>

		<tr height="50">
			<td colspan="2" align="center"><div class="SayfalamaAlaniKapsayicisi">
				<div class="SayfalamaAlaniIciMetinAlaniKapsayicisi">
					Toplam <?php echo $BulunanSayfaSayisi; ?> sayfada, <?php echo $ToplamKayitSayisiSorgusu; ?> adet kayıt bulunmaktadır.
				</div>

				<div class="SayfalamaAlaniIciNumaraAlaniKapsayicisi">
					<?php
					if($Sayfalama>1){
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=82" . $SayfalamaKosulu . "&SYF=1'><<</a></span>";
						$SayfalamaIcinSayfaDegeriniBirGeriAl	=	$Sayfalama-1;
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=82" . $SayfalamaKosulu . "&SYF=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "'><</a></span>";
					}

					for($SayfalamaIcinSayfaIndexDegeri=$Sayfalama-$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri<=$Sayfalama+$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++){
						if(($SayfalamaIcinSayfaIndexDegeri>0) and ($SayfalamaIcinSayfaIndexDegeri<=$BulunanSayfaSayisi)){
							if($Sayfalama==$SayfalamaIcinSayfaIndexDegeri){
								echo "<span class='SayfalamaAktif'>" . $SayfalamaIcinSayfaIndexDegeri . "</span>";
							}else{
								echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=82" . $SayfalamaKosulu . "&SYF=" . $SayfalamaIcinSayfaIndexDegeri . "'> " . $SayfalamaIcinSayfaIndexDegeri . "</a></span>";
							}
						}
					}

					if($Sayfalama!=$BulunanSayfaSayisi){
						$SayfalamaIcinSayfaDegeriniBirIleriAl	=	$Sayfalama+1;
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=82" . $SayfalamaKosulu . "&SYF=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "'>></a></span>";
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=82" . $SayfalamaKosulu . "&SYF=" . $BulunanSayfaSayisi . "'>>></a></span>";
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
					<td width="750">Kayıtlı üye bulunmamaktadır.</td>
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