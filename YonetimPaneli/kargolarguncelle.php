<?php
if(isset($_SESSION["Yonetici"])){
	if(isset($_GET["ID"])){
		$GelenID			=	Guvenlik($_GET["ID"]);
	}else{
		$GelenID			=	"";
	}
	
	$KargolarSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM kargofirmalari WHERE id = ? LIMIT 1");
	$KargolarSorgusu->execute([$GelenID]);
	$KargolarSayisi		=	$KargolarSorgusu->rowCount();
	$KargoBilgisi		=	$KargolarSorgusu->fetch(PDO::FETCH_ASSOC);
	
	if($KargolarSayisi>0){
?>
<form action="index.php?SKD=0&SKI=27&ID=<?php echo DonusumleriGeriDondur($GelenID); ?>" method="post" enctype="multipart/form-data">
	<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr height="70">
			<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;KARGO AYARLARI</h3></td>
			<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=22" style="color: #FFFFFF; text-decoration: none;">Yeni Kargo Firması Ekle&nbsp;</a></td>
		</tr>
		<tr height="10">
			<td colspan="2" style="font-size: 10px;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
				<tr height="40">
					<td>Kargo Firması Logosu</td>
					<td>:</td>
					<td><input type="file" name="KargoFirmasiLogosu"></td>
				</tr>
				<tr height="40">
					<td width="230">Kargo Firması Adı</td>
					<td width="20">:</td>
					<td width="500"><input type="text" name="KargoFirmasiAdi" value="<?php echo DonusumleriGeriDondur($KargoBilgisi["KargoFirmasiAdi"]); ?>" class="InputAlanlari"></td>
				</tr>
				<tr height="40">
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" value="Kargo Firması Güncelle Güncelle" class="YesilButon"></td>
				</tr>
			</table></td>
		</tr>
	</table>
</form>
<?php
	}else{
		header("Location:index.php?SKD=0&SKI=29");
		exit();
	}
}else{
	header("Location:index.php?SKD=1");
	exit();
}
?>