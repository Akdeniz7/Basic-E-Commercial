<?php
if(isset($_SESSION["Yonetici"])){
	$SayfalamaIcinSolVeSagButonSayisi		=	2;
	$SayfaBasinaGosterilecekKayitSayisi		=	10;
	$ToplamKayitSayisiSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT * FROM yorumlar ORDER BY id DESC");
	$ToplamKayitSayisiSorgusu->execute([0]);
	$ToplamKayitSayisiSorgusu				=	$ToplamKayitSayisiSorgusu->rowCount();
	$SayfalamayaBaslanacakKayitSayisi		=	($Sayfalama*$SayfaBasinaGosterilecekKayitSayisi)-$SayfaBasinaGosterilecekKayitSayisi;
	$BulunanSayfaSayisi						=	ceil($ToplamKayitSayisiSorgusu/$SayfaBasinaGosterilecekKayitSayisi);
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;YORUMLAR</h3></td>
	</tr>
	<tr height="10">
		<td style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$YorumlarSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM yorumlar ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi, $SayfaBasinaGosterilecekKayitSayisi");
	$YorumlarSorgusu->execute([0]);
	$YorumlarSayisi		=	$YorumlarSorgusu->rowCount();
	$YorumlarKayitlari	=	$YorumlarSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
	if($YorumlarSayisi>0){
		foreach($YorumlarKayitlari as $Yorumlar){
			if(DonusumleriGeriDondur($Yorumlar["Puan"]) == "1"){
				$PuanResmi	=	"YildizBirDolu.png";
			}elseif(DonusumleriGeriDondur($Yorumlar["Puan"]) == "2"){
				$PuanResmi	=	"YildizIkiDolu.png";
			}elseif(DonusumleriGeriDondur($Yorumlar["Puan"]) == "3"){
				$PuanResmi	=	"YildizUcDolu.png";
			}elseif(DonusumleriGeriDondur($Yorumlar["Puan"]) == "4"){
				$PuanResmi	=	"YildizDortDolu.png";
			}elseif(DonusumleriGeriDondur($Yorumlar["Puan"]) == "5"){
				$PuanResmi	=	"YildizBesDolu.png";
			}
	?>	
			<tr>
				<td style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="3"><?php echo DonusumleriGeriDondur($Yorumlar["YorumMetni"]); ?></td>
					</tr>
					<tr>
						<td width="685"><img src="../Resimler/<?php echo $PuanResmi ?>" border="0"></td>
						<td width="10">&nbsp;</td>
						<td width="55"><table width="55" align="right" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=91&ID=<?php echo DonusumleriGeriDondur($Yorumlar["id"]); ?>"><img src="../Resimler/Sil20x20.png" border="0" style="margin-top: 5px;"></a></td>
								<td width="30" align="left"><a href="index.php?SKD=0&SKI=91&ID=<?php echo DonusumleriGeriDondur($Yorumlar["id"]); ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
			<td>&nbsp;</td>
		</tr>

		<tr height="50">
			<td align="center"><div class="SayfalamaAlaniKapsayicisi">
				<div class="SayfalamaAlaniIciMetinAlaniKapsayicisi">
					Toplam <?php echo $BulunanSayfaSayisi; ?> sayfada, <?php echo $ToplamKayitSayisiSorgusu; ?> adet kayıt bulunmaktadır.
				</div>

				<div class="SayfalamaAlaniIciNumaraAlaniKapsayicisi">
					<?php
					if($Sayfalama>1){
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=90&SYF=1'><<</a></span>";
						$SayfalamaIcinSayfaDegeriniBirGeriAl	=	$Sayfalama-1;
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=90&SYF=" . $SayfalamaIcinSayfaDegeriniBirGeriAl . "'><</a></span>";
					}

					for($SayfalamaIcinSayfaIndexDegeri=$Sayfalama-$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri<=$Sayfalama+$SayfalamaIcinSolVeSagButonSayisi; $SayfalamaIcinSayfaIndexDegeri++){
						if(($SayfalamaIcinSayfaIndexDegeri>0) and ($SayfalamaIcinSayfaIndexDegeri<=$BulunanSayfaSayisi)){
							if($Sayfalama==$SayfalamaIcinSayfaIndexDegeri){
								echo "<span class='SayfalamaAktif'>" . $SayfalamaIcinSayfaIndexDegeri . "</span>";
							}else{
								echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=90&SYF=" . $SayfalamaIcinSayfaIndexDegeri . "'> " . $SayfalamaIcinSayfaIndexDegeri . "</a></span>";
							}
						}
					}

					if($Sayfalama!=$BulunanSayfaSayisi){
						$SayfalamaIcinSayfaDegeriniBirIleriAl	=	$Sayfalama+1;
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=90&SYF=" . $SayfalamaIcinSayfaDegeriniBirIleriAl . "'>></a></span>";
						echo "<span class='SayfalamaPasif'><a href='index.php?SKD=0&SKI=90&SYF=" . $BulunanSayfaSayisi . "'>>></a></span>";
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
			<td><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td width="750">Kayıtlı yorum bulunmamaktadır.</td>
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