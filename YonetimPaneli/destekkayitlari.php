<?php
if(isset($_SESSION["Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;DESTEK İÇERİKLERİ</h3></td>
		<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=46" style="color: #FFFFFF; text-decoration: none;">Yeni Destek İçeriği Ekle&nbsp;</a></td>
	</tr>
	<tr height="10">
		<td colspan="2" style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$DestekSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM sorular ORDER BY soru ASC");
	$DestekSorgusu->execute();
	$DestekSayisi		=	$DestekSorgusu->rowCount();
	$DestekKayitlari	=	$DestekSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
	if($DestekSayisi>0){
		foreach($DestekKayitlari as $Destek){
	?>	
	<tr>
		<td colspan="2" style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr height="30">
				<td align="left"><b><?php echo $Destek["soru"]; ?></b></td>
			</tr>
			<tr>
				<td align="left"><?php echo $Destek["cevap"]; ?></td>
			</tr>
			<tr height="20">
				<td align="right"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr height="20">
						<td width="600">&nbsp;</td>
						<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=50&ID=<?php echo DonusumleriGeriDondur($Destek["id"]); ?>"><img src="../Resimler/Guncelleme20x20.png" border="0" style="margin-top: 5px;"></a></td>
						<td width="70" align="left"><a href="index.php?SKD=0&SKI=50&ID=<?php echo DonusumleriGeriDondur($Destek["id"]); ?>" style="color: #0000FF; text-decoration: none;">Güncelle</a></td>
						<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=54&ID=<?php echo DonusumleriGeriDondur($Destek["id"]); ?>"><img src="../Resimler/Sil20x20.png" border="0" style="margin-top: 5px;"></a></td>
						<td width="30" align="left"><a href="index.php?SKD=0&SKI=54&ID=<?php echo DonusumleriGeriDondur($Destek["id"]); ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
	<?php
		}
	}else{
	?>
	<tr>
		<td colspan="2"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="750">Kayıtlı destek içeriği bulunmamaktadır.</td>
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