<?php
if(isset($_SESSION["Yonetici"])){
?>
<form action="index.php?SKD=0&SKI=96" method="post" enctype="multipart/form-data">
	<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr height="70">
			<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;ÜRÜNLER</h3></td>
			<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=95" style="color: #FFFFFF; text-decoration: none;">Yeni Ürün Ekle&nbsp;</a></td>
		</tr>
		<tr height="10">
			<td colspan="2" style="font-size: 10px;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
				<tr height="40">
					<td width="230">Ürün Menüsü</td>
					<td width="20">:</td>
					<td width="500"><select name="UrunMenusu" class="SelectAlanlari">
						<option value="">Lütfen Seçiniz</option>
						
						<?php
						$MenulerSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT * FROM menuler ORDER BY UrunTuru ASC, MenuAdi ASC");
						$MenulerSorgusu->execute();
						$MenuSayisi			=	$MenulerSorgusu->rowCount();
						$MenuKayitlari		=	$MenulerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
						foreach($MenuKayitlari as $MenuKaydi){
						?>
							<option value="<?php echo  DonusumleriGeriDondur($MenuKaydi["id"]); ?>">(<?php echo  DonusumleriGeriDondur($MenuKaydi["UrunTuru"]); ?>) <?php echo  DonusumleriGeriDondur($MenuKaydi["MenuAdi"]); ?></option>
						<?php
						}
						?>
					</select></td>
				</tr>
				<tr height="40">
					<td width="230">Ürün Adı</td>
					<td width="20">:</td>
					<td width="500"><input type="text" name="UrunAdi" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td width="230">Ürün Fiyatı</td>
					<td width="20">:</td>
					<td width="500"><input type="text" name="UrunFiyati" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td width="230">Para Birimi</td>
					<td width="20">:</td>
					<td width="500"><select name="ParaBirimi" class="SelectAlanlari">
						<option value="">Lütfen Seçiniz</option>
						<option value="TRY">Türk Lirası</option>
						<option value="USD">Amerikan Doları</option>
						<option value="EUR">Euro</option>
					</select></td>
				</tr>
				<tr height="40">
					<td width="230">KDV Oranı</td>
					<td width="20">:</td>
					<td width="500"><input type="text" name="KdvOrani" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td width="230">Kargo Ücreti</td>
					<td width="20">:</td>
					<td width="500"><input type="text" name="KargoUcreti" class="InputAlanlari"></td>
				</tr>
				<tr>
					<td width="230" valign="top">Ürün Açıklaması</td>
					<td width="20" valign="top">:</td>
					<td width="500"><textarea name="UrunAciklamasi" class="TextAreaAlanlari"></textarea></td>
				</tr>
				<tr height="40">
					<td>Ürün Resmi 1</td>
					<td>:</td>
					<td><input type="file" name="Resim1"></td>
				</tr>
				<tr height="40">
					<td>Ürün Resmi 2</td>
					<td>:</td>
					<td><input type="file" name="Resim2"></td>
				</tr>
				<tr height="40">
					<td>Ürün Resmi 3</td>
					<td>:</td>
					<td><input type="file" name="Resim3"></td>
				</tr>
				<tr height="40">
					<td>Ürün Resmi 4</td>
					<td>:</td>
					<td><input type="file" name="Resim4"></td>
				</tr>
				<tr height="40">
					<td width="230">Varyant Başlığı</td>
					<td width="20">:</td>
					<td width="500"><input type="text" name="VaryantBasligi" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">1. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi1" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">1. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi1" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">2. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi2" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">2. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi2" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">3. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi3" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">3. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi3" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">4. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi4" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">4. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi4" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">5. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi5" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">5. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi5" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">6. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi6" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">6. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi6" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">7. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi7" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">7. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi7" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">8. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi8" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">8. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi8" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">9. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi9" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">9. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi9" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td colspan="3" align="left"><table width="728" align="left" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td width="230">9. Varyant Adı</td>
							<td width="20">:</td>
							<td width="200"><input type="text" name="VaryantAdi10" class="InputAlanlari"></td>
							<td width="20">&nbsp;</td>
							<td width="178">9. Varyant Stok Adedi</td>
							<td width="20">:</td>
							<td width="60"><input type="text" name="StokAdedi10" class="InputAlanlari"></td>
						</tr>
					</table></td>
				</tr>
				<tr height="40">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" value="Ürün Kaydet" class="YesilButon"></td>
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