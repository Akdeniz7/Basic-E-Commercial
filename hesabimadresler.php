<?php
if(isset($_SESSION["Kullanici"])){
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
					<td colspan="5" style="color:#FF9900"><h3>Hesabım > Adresler</h3></td>
				</tr>
				<tr height="30">
					<td colspan="5" valign="top" style="border-bottom: 1px dashed #CCCCCC;">Tüm Adreslerini görüntüleyebilir veya güncelleyebilirsin.</td>
				</tr>
				<tr height="50">
					<td colspan="1" style="background: #f8ffa7; color: black; font-weight: bold;" align="left">&nbsp;Adresler</td>
					<td colspan="4" style="background: #f8ffa7; color: black; font-weight: bold;" align="right"><a href="index.php?SK=70" style="text-decoration: none; color: #000000;">+ Yeni Adres Ekle</a>&nbsp;</td>
				</tr>
				<?php
				$AdreslerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM adresler WHERE UyeId = ?");
				$AdreslerSorgusu->execute([$KullaniciID]);
				$AdreslerSayisi			=	$AdreslerSorgusu->rowCount();
				$AdreslerKayitlari		=	$AdreslerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
				$BirinciRenk			=	"#FFFFFF";
				$IkinciRenk				=	"#F1F1F1";
				$RenkSayisi				=	1;
				
				if($AdreslerSayisi>0){
					foreach($AdreslerKayitlari as $Satirlar){
						if($RenkSayisi % 2){
							$ArkaplanRengi	=	$BirinciRenk;
						}else{
							$ArkaplanRengi	=	$IkinciRenk;
						}
				?>
					<tr height="50" bgcolor="<?php echo $ArkaplanRengi; ?>">
						<td align="left"><?php echo $Satirlar["AdiSoyadi"]; ?> - <?php echo $Satirlar["Adres"]; ?> <?php echo $Satirlar["Ilce"]; ?> / <?php echo $Satirlar["Sehir"]; ?> - <?php echo $Satirlar["TelefonNumarasi"]; ?></td>
						<td width="25"><img src="Resimler/Guncelleme20x20.png" border="0" style="margin-top: 5px;"></td>
						<td width="70"><a href="index.php?SK=62&ID=<?php echo $Satirlar["id"]; ?>" style="text-decoration: none; color: #646464;">Güncelle</a></td>
						<td width="25"><img src="Resimler/Sil20x20.png" border="0" style="margin-top: 5px;"></td>
						<td width="25"><a href="index.php?SK=67&ID=<?php echo $Satirlar["id"]; ?>" style="text-decoration: none; color: #646464;">Sil</a></td>
					</tr>
				<?php	
						$RenkSayisi++;
					}
				}else{
				?>
					<tr height="50">
						<td colspan="5" align="left">Sisteme Kayıtlı Adresiniz Bulunmamaktadır.</td>
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