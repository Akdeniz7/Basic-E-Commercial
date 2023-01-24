<?php
if(isset($_SESSION["Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;YÖNETİCİLER</h3></td>
		<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=70" style="color: #FFFFFF; text-decoration: none;">Yeni Yönetici Ekle&nbsp;</a></td>
	</tr>
	<tr height="10">
		<td colspan="2" style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$YoneticilerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM yoneticiler ORDER BY IsimSoyisim ASC");
	$YoneticilerSorgusu->execute();
	$YoneticilerSayisi		=	$YoneticilerSorgusu->rowCount();
	$YoneticilerKayitlari	=	$YoneticilerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
	if($YoneticilerSayisi>0){
		foreach($YoneticilerKayitlari as $YoneticilerSatirlari){
	?>	
	<tr>
		<td colspan="2" style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr height="30">
				<td align="left" width="150"><?php echo $YoneticilerSatirlari["KullaniciAdi"]; ?></td>
				<td align="left" width="150"><?php echo $YoneticilerSatirlari["IsimSoyisim"]; ?></td>
				<td align="left" width="200"><?php echo $YoneticilerSatirlari["EmailAdresi"]; ?></td>
				<td align="left" width="100"><?php echo $YoneticilerSatirlari["TelefonNumarasi"]; ?></td>
				<td align="right" width="150"><table width="150" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=75&ID=<?php echo DonusumleriGeriDondur($YoneticilerSatirlari["id"]); ?>"><img src="../Resimler/Guncelleme20x20.png" border="0" style="margin-top: 5px;"></a></td>
						<td width="70" align="left"><a href="index.php?SKD=0&SKI=75&ID=<?php echo DonusumleriGeriDondur($YoneticilerSatirlari["id"]); ?>" style="color: #0000FF; text-decoration: none;">Güncelle</a></td>
						<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=79&ID=<?php echo DonusumleriGeriDondur($YoneticilerSatirlari["id"]); ?>"><img src="../Resimler/Sil20x20.png" border="0" style="margin-top: 5px;"></a></td>
						<td width="30" align="left"><a href="index.php?SKD=0&SKI=79&ID=<?php echo DonusumleriGeriDondur($YoneticilerSatirlari["id"]); ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
				<td width="750">Kayıtlı yönetici bulunmamaktadır.</td>
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