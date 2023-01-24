<?php
if(isset($_SESSION["Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;HAVALE BİLDİRİMLERİ</h3></td>
	</tr>
	<tr height="10">
		<td style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$BildirimSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM havalebildirimleri ORDER BY IslemTarihi ASC");
	$BildirimSorgusu->execute();
	$BildirimSayisi		=	$BildirimSorgusu->rowCount();
	$BildirimKayitlari	=	$BildirimSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
	if($BildirimSayisi>0){
		foreach($BildirimKayitlari as $Bildirimler){
			$BankaSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM bankahesaplarimiz WHERE id = ? LIMIT 1");
			$BankaSorgusu->execute([$Bildirimler["BankaId"]]);
			$BankaKayitlari		=	$BankaSorgusu->fetch(PDO::FETCH_ASSOC);
	?>	
	<tr>
		<td style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr height="30">
				<td colspan="2" align="left" width="400"><b><?php echo DonusumleriGeriDondur($Bildirimler["AdiSoyadi"]); ?></b></td>
				<td align="right" width="350"><?php echo TarihBul($Bildirimler["IslemTarihi"]); ?></td>
			</tr>
			<tr>
				<td align="left" width="200">Banka : <?php echo DonusumleriGeriDondur($BankaKayitlari["BankaAdi"]); ?></td>
				<td align="left" width="200">Telefon : <?php echo DonusumleriGeriDondur($Bildirimler["TelefonNumarasi"]); ?></td>
				<td align="left" width="350">E-Mail : <?php echo DonusumleriGeriDondur($Bildirimler["EmailAdresi"]); ?></td>
			</tr>
			<tr>
				<td colspan="3" align="left">Açıklama Notu : <?php echo DonusumleriGeriDondur($Bildirimler["Aciklama"]); ?></td>
			</tr>
			<tr height="20">
				<td colspan="3" align="right"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr height="20">
						<td width="695">&nbsp;</td>
						<td width="25" valign="top" align="left"><a href="index.php?SKD=0&SKI=117&ID=<?php echo DonusumleriGeriDondur($Bildirimler["id"]); ?>"><img src="../Resimler/Sil20x20.png" border="0" style="margin-top: 5px;"></a></td>
						<td width="30" align="left"><a href="index.php?SKD=0&SKI=117&ID=<?php echo DonusumleriGeriDondur($Bildirimler["id"]); ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
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
				<td width="750">Kayıtlı havale bildirimi bulunmamaktadır.</td>
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