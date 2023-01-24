<?php
if(isset($_SESSION["Yonetici"])){
?>
<form action="index.php?SKD=0&SKI=2" method="post" enctype="multipart/form-data">
	<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr height="70">
			<td bgcolor="#FF9900" style="color: #FFFFFF;"><h3>&nbsp;SİTE AYARLARI</h3></td>
		</tr>
		<tr height="10">
			<td style="font-size: 10px;">&nbsp;</td>
		</tr>
		<tr>
			<td><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
				<tr height="40">
					<td width="230">Site Adı</td>
					<td width="20">:</td>
					<td width="500"><input type="text" name="SiteAdi" value="<?php echo DonusumleriGeriDondur($SiteAdi); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Site Title</td>
					<td>:</td>
					<td><input type="text" name="SiteTitle" value="<?php echo DonusumleriGeriDondur($SiteTitle); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Site Description</td>
					<td>:</td>
					<td><input type="text" name="SiteDescription" value="<?php echo DonusumleriGeriDondur($SiteDescription); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Site Keywords</td>
					<td>:</td>
					<td><input type="text" name="SiteKeywords" value="<?php echo DonusumleriGeriDondur($SiteKeywords); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Site Copyright Metni</td>
					<td>:</td>
					<td><input type="text" name="SiteCopyrightMetni" value="<?php echo DonusumleriGeriDondur($SiteCopyrightMetni); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Site Logosu</td>
					<td>:</td>
					<td><input type="file" name="SiteLogosu"></td>
				</tr>
				<tr height="40">
					<td>Site Linki</td>
					<td>:</td>
					<td><input type="text" name="SiteLinki" value="<?php echo DonusumleriGeriDondur($SiteLinki); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Site Email Adresi</td>
					<td>:</td>
					<td><input type="text" name="SiteEmailAdresi" value="<?php echo DonusumleriGeriDondur($SiteEmailAdresi); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Site Email Şifresi</td>
					<td>:</td>
					<td><input type="text" name="SiteEmailSifresi" value="<?php echo DonusumleriGeriDondur($SiteEmailSifresi); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Site Email Host Adresi</td>
					<td>:</td>
					<td><input type="text" name="SiteEmailHostAdresi" value="<?php echo DonusumleriGeriDondur($SiteEmailHostAdresi); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Facebook Linki</td>
					<td>:</td>
					<td><input type="text" name="SosyalLinkFacebook" value="<?php echo DonusumleriGeriDondur($SosyalLinkFacebook); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Twitter Linki</td>
					<td>:</td>
					<td><input type="text" name="SosyalLinkTwitter" value="<?php echo DonusumleriGeriDondur($SosyalLinkTwitter); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>LinkedIn Linki</td>
					<td>:</td>
					<td><input type="text" name="SosyalLinkLinkedin" value="<?php echo DonusumleriGeriDondur($SosyalLinkLinkedin); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Instagram Linki</td>
					<td>:</td>
					<td><input type="text" name="SosyalLinkInstagram" value="<?php echo DonusumleriGeriDondur($SosyalLinkInstagram); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Pinterest Linki</td>
					<td>:</td>
					<td><input type="text" name="SosyalLinkPinterest" value="<?php echo DonusumleriGeriDondur($SosyalLinkPinterest); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Youtube Linki</td>
					<td>:</td>
					<td><input type="text" name="SosyalLinkYouTube" value="<?php echo DonusumleriGeriDondur($SosyalLinkYouTube); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Dolar Kuru</td>
					<td>:</td>
					<td><input type="text" name="DolarKuru" value="<?php echo DonusumleriGeriDondur($DolarKuru); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Euro Kuru</td>
					<td>:</td>
					<td><input type="text" name="EuroKuru" value="<?php echo DonusumleriGeriDondur($EuroKuru); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Ücretsiz Kargo Barajı</td>
					<td>:</td>
					<td><input type="text" name="UcretsizKargoBaraji" value="<?php echo DonusumleriGeriDondur($UcretsizKargoBaraji); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Sanal Pos ClientID</td>
					<td>:</td>
					<td><input type="text" name="ClientID" value="<?php echo DonusumleriGeriDondur($ClientID); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Sanal Pos StoreKey</td>
					<td>:</td>
					<td><input type="text" name="StoreKey" value="<?php echo DonusumleriGeriDondur($StoreKey); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Sanal Pos API Adı</td>
					<td>:</td>
					<td><input type="text" name="ApiKullanicisi" value="<?php echo DonusumleriGeriDondur($ApiKullanicisi); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>Sanal Pos API Şifresi</td>
					<td>:</td>
					<td><input type="text" name="ApiSifresi" value="<?php echo DonusumleriGeriDondur($ApiSifresi); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" value="Ayarları Kaydet" class="YesilButon"></td>
				</tr>
			</table></td>
		</tr>
	</table>
</form>
<?php
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>