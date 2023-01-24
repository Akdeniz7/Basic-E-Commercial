<?php
if(isset($_SESSION["Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;BANNER AYARLARI</h3></td>
		<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=34" style="color: #FFFFFF; text-decoration: none;">Yeni Banner Ekle&nbsp;</a></td>
	</tr>
	<tr height="10">
		<td colspan="2" style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$BannerlarSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM bannerlar ORDER BY id DESC");
	$BannerlarSorgusu->execute();
	$BannerlarSayisi		=	$BannerlarSorgusu->rowCount();
	$BannerlarKayitlari		=	$BannerlarSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
	if($BannerlarSayisi>0){
		foreach($BannerlarKayitlari as $Bannerlar){
	?>	
	<tr height="40">
		<td colspan="2" style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr height="40">
				<td width="175" align="left"><img src="../Resimler/<?php echo DonusumleriGeriDondur($Bannerlar["BannerResmi"]); ?>" border="0" height="30"></td>
				
				<td width="575" align="left"><table width="575" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr height="20">
						<td width="50" align="left"><b>Adı</b></td>
						<td width="10" align="left"><b>:</b></td>
						<td width="150" align="left"><?php echo DonusumleriGeriDondur($Bannerlar["BannerAdi"]); ?></td>
						<td width="50" align="left"><b>Yeri</b></td>
						<td width="10" align="left"><b>:</b></td>
						<td width="125" align="left"><?php echo DonusumleriGeriDondur($Bannerlar["BannerAlani"]); ?></td>
						<td width="50" align="left"><b>Hit</b></td>
						<td width="10" align="left"><b>:</b></td>
						<td width="50" align="left"><?php echo DonusumleriGeriDondur($Bannerlar["GosterimSayisi"]); ?></td>
					</tr>
					<tr height="20">
						<td colspan="9"><table width="575" align="right" border="0" cellpadding="0" cellspacing="0">
							<tr height="20">
								<td width="425">&nbsp;</td>
								<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=38&ID=<?php echo DonusumleriGeriDondur($Bannerlar["id"]); ?>"><img src="../Resimler/Guncelleme20x20.png" border="0" style="margin-top: 5px;"></a></td>
								<td width="70" align="left"><a href="index.php?SKD=0&SKI=38&ID=<?php echo DonusumleriGeriDondur($Bannerlar["id"]); ?>" style="color: #0000FF; text-decoration: none;">Güncelle</a></td>
								<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=42&ID=<?php echo DonusumleriGeriDondur($Bannerlar["id"]); ?>"><img src="../Resimler/Sil20x20.png" border="0" style="margin-top: 5px;"></a></td>
								<td width="30" align="left"><a href="index.php?SKD=0&SKI=42&ID=<?php echo DonusumleriGeriDondur($Bannerlar["id"]); ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
							</tr>
						</table></td>
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
				<td width="750">Kayıtlı banner bulunmamaktadır.</td>
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