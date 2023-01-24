<?php
if(isset($_SESSION["Yonetici"])){
?>
<form action="index.php?SKD=0&SKI=35" method="post" enctype="multipart/form-data">
	<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr height="70">
			<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;BANNER AYARLARI</h3></td>
			<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=34" style="color: #FFFFFF; text-decoration: none;">Yeni Banner Ekle&nbsp;</a></td>
		</tr>
		<tr height="10">
			<td colspan="2" style="font-size: 10px;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
				<tr height="40">
					<td width="230">Banner Alanı</td>
					<td width="20">:</td>
					<td width="500"><select name="BannerAlani" class="SelectAlanlari">
						<option value="">Lütfen Seçiniz</option>
						<option value="Ana Sayfa">Ana Sayfa</option>
						<option value="Menu Altı">Menu Altı</option>
						<option value="Ürün Detay">Ürün Detay</option>
					</select></td>
				</tr>
				<tr height="40">
					<td>Banner Resmi</td>
					<td>:</td>
					<td><input type="file" name="BannerResmi"></td>
				</tr>
				<tr height="40">
					<td width="230">Banner Adı</td>
					<td width="20">:</td>
					<td width="500"><input type="text" name="BannerAdi" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" value="Banner Kaydet" class="YesilButon"></td>
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