<?php
if(isset($_SESSION["Yonetici"])){
	$BekleyenSiparislerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler WHERE OnayDurumu = ? AND KargoDurumu = ?");
	$BekleyenSiparislerSorgusu->execute([0, 0]);
	$BekleyenSiparislerSayisi		=	$BekleyenSiparislerSorgusu->rowCount();
	
	$TamamlananSiparislerSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler WHERE OnayDurumu = ? AND KargoDurumu = ?");
	$TamamlananSiparislerSorgusu->execute([1, 1]);
	$TamamlananSiparislerSayisi		=	$TamamlananSiparislerSorgusu->rowCount();
	
	$TumSiparislerSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler");
	$TumSiparislerSorgusu->execute();
	$TumSiparislerSayisi			=	$TumSiparislerSorgusu->rowCount();
	
	$HavaleBildirimSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT * FROM havalebildirimleri");
	$HavaleBildirimSorgusu->execute();
	$HavaleBildirimSayisi			=	$HavaleBildirimSorgusu->rowCount();
	
	$BankalarSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT * FROM bankahesaplarimiz");
	$BankalarSorgusu->execute();
	$BankalarSayisi					=	$BankalarSorgusu->rowCount();
	
	$MenulerSorgusu					=	$VeritabaniBaglantisi->prepare("SELECT * FROM menuler");
	$MenulerSorgusu->execute();
	$MenulerSayisi					=	$MenulerSorgusu->rowCount();
	
	$UrunlerSorgusu					=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler");
	$UrunlerSorgusu->execute();
	$UrunlerSayisi					=	$UrunlerSorgusu->rowCount();
	
	$UyelerSorgusu					=	$VeritabaniBaglantisi->prepare("SELECT * FROM uyeler");
	$UyelerSorgusu->execute();
	$UyelerSayisi					=	$UyelerSorgusu->rowCount();
	
	$YoneticilerSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT * FROM yoneticiler");
	$YoneticilerSorgusu->execute();
	$YoneticilerSayisi				=	$YoneticilerSorgusu->rowCount();
	
	$KargolarSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT * FROM kargofirmalari");
	$KargolarSorgusu->execute();
	$KargolarSayisi					=	$KargolarSorgusu->rowCount();
	
	$BannerlarSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT * FROM bannerlar");
	$BannerlarSorgusu->execute();
	$BannerlarSayisi				=	$BannerlarSorgusu->rowCount();
	
	$YorumlarSorgusu				=	$VeritabaniBaglantisi->prepare("SELECT * FROM yorumlar");
	$YorumlarSorgusu->execute();
	$YorumlarSayisi					=	$YorumlarSorgusu->rowCount();
	
	$SorularSorgusu					=	$VeritabaniBaglantisi->prepare("SELECT * FROM sorular");
	$SorularSorgusu->execute();
	$SorularSayisi					=	$SorularSorgusu->rowCount();
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;PADO</h3></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Bekleyen Siparişler</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $BekleyenSiparislerSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
				<td width="10">&nbsp;</td>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Tamamlanan Siparişler</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $TamamlananSiparislerSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
				<td width="10">&nbsp;</td>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Tüm Siparişler</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $TumSiparislerSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
	<tr height="10">
		<td style="font-size: 10px;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Havale Bildirimleri</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $HavaleBildirimSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
				<td width="10">&nbsp;</td>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Banka Hesapları</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $BankalarSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
				<td width="10">&nbsp;</td>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Menü Sayısı</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $MenulerSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
	<tr height="10">
		<td style="font-size: 10px;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Ürünler</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $UrunlerSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
				<td width="10">&nbsp;</td>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Üyeler</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $UyelerSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
				<td width="10">&nbsp;</td>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Yöneticiler</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $YoneticilerSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
	<tr height="10">
		<td style="font-size: 10px;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Kargolar</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $KargolarSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
				<td width="10">&nbsp;</td>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Bannerlar</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $BannerlarSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
				<td width="10">&nbsp;</td>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Yorumlar</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $YorumlarSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
	<tr height="10">
		<td style="font-size: 10px;">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><table width="749" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="243" style="border: 1px solid #CCCCCC;"><table width="243" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 18px;">Destek İçerikleri</td>
					</tr>
					<tr height="30">
						<td align="center" style="font-size: 25px; font-weight: bold;"><?php echo $SorularSayisi; ?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>
				</table></td>
				<td width="10">&nbsp;</td>
				<td width="243">&nbsp;</td>
				<td width="10">&nbsp;</td>
				<td width="243">&nbsp;</td>
			</tr>
		</table></td>
	</tr>
</table>
<?php
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>