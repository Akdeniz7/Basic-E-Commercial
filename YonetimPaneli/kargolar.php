<?php
if(isset($_SESSION["Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;KARGO AYARLARI</h3></td>
		<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=22" style="color: #FFFFFF; text-decoration: none;">Yeni Kargo Firması Ekle&nbsp;</a></td>
	</tr>
	<tr height="10">
		<td colspan="2" style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$KargolarSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM kargofirmalari ORDER BY KargoFirmasiAdi ASC");
	$KargolarSorgusu->execute();
	$KargolarSayisi			=	$KargolarSorgusu->rowCount();
	$KargolarKayitlari		=	$KargolarSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
	if($KargolarSayisi>0){
		foreach($KargolarKayitlari as $Kargolar){
	?>	
	<tr height="50">
		<td colspan="2" style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr height="50">
				<td width="200" align="left"><img src="../Resimler/<?php echo DonusumleriGeriDondur($Kargolar["KargoFirmasiLogosu"]); ?>" border="0"></td>
				<td width="10" align="left">&nbsp;</td>
				<td width="150" align="left"><b>Kargo Firması Adı</b></td>
				<td width="20" align="left"><b>:</b></td>
				<td width="210" align="left"><?php echo DonusumleriGeriDondur($Kargolar["KargoFirmasiAdi"]); ?></td>
				<td width="10" align="left">&nbsp;</td>
				<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=26&ID=<?php echo DonusumleriGeriDondur($Kargolar["id"]); ?>"><img src="../Resimler/Guncelleme20x20.png" border="0" style="margin-top: 15px;"></a></td>
				<td width="70" align="left"><a href="index.php?SKD=0&SKI=26&ID=<?php echo DonusumleriGeriDondur($Kargolar["id"]); ?>" style="color: #0000FF; text-decoration: none;">Güncelle</a></td>
				<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=30&ID=<?php echo DonusumleriGeriDondur($Kargolar["id"]); ?>"><img src="../Resimler/Sil20x20.png" border="0" style="margin-top: 15px;"></a></td>
				<td width="30" align="left"><a href="index.php?SKD=0&SKI=30&ID=<?php echo DonusumleriGeriDondur($Kargolar["id"]); ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
				<td width="750">Kayıtlı kargo firması bulunmamaktadır.</td>
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