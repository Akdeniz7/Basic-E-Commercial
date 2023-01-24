<?php
if(isset($_SESSION["Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;MENÜLER</h3></td>
		<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=58" style="color: #FFFFFF; text-decoration: none;">Yeni Menü Ekle&nbsp;</a></td>
	</tr>
	<tr height="10">
		<td colspan="2" style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$MenulerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM menuler ORDER BY UrunTuru ASC");
	$MenulerSorgusu->execute();
	$MenulerSayisi		=	$MenulerSorgusu->rowCount();
	$MenulerKayitlari	=	$MenulerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
	if($MenulerSayisi>0){
		foreach($MenulerKayitlari as $Menu){
	?>	
	<tr>
		<td colspan="2" style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr height="30">
				<td align="left" width="200"><b><?php echo $Menu["UrunTuru"]; ?></b></td>
				<td align="left" width="400"><?php echo $Menu["MenuAdi"]; ?> (<?php echo $Menu["UrunSayisi"]; ?>)</td>
				<td align="right" width="150"><table width="150" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=62&ID=<?php echo DonusumleriGeriDondur($Menu["id"]); ?>"><img src="../Resimler/Guncelleme20x20.png" border="0" style="margin-top: 5px;"></a></td>
						<td width="70" align="left"><a href="index.php?SKD=0&SKI=62&ID=<?php echo DonusumleriGeriDondur($Menu["id"]); ?>" style="color: #0000FF; text-decoration: none;">Güncelle</a></td>
						<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=66&ID=<?php echo DonusumleriGeriDondur($Menu["id"]); ?>"><img src="../Resimler/Sil20x20.png" border="0" style="margin-top: 5px;"></a></td>
						<td width="30" align="left"><a href="index.php?SKD=0&SKI=66&ID=<?php echo DonusumleriGeriDondur($Menu["id"]); ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
				<td width="750">Kayıtlı menü bulunmamaktadır.</td>
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