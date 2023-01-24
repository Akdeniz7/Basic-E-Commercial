<?php
if(isset($_SESSION["Yonetici"])){
?>
<table width="760" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr height="70">
		<td width="560" bgcolor="#FF9900" style="color: #FFFFFF;" align="left"><h3>&nbsp;SİPARİŞLER (BEKLEYEN)</h3></td>
		<td width="200" bgcolor="#FF9900" align="right"><a href="index.php?SKD=0&SKI=108" style="color: #FFFFFF; text-decoration: none;">Tamamlanan Siparişler&nbsp;</a></td>
	</tr>
	<tr height="10">
		<td colspan="2" style="font-size: 10px;">&nbsp;</td>
	</tr>
	<?php
	$SiparisNumaralariSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT DISTINCT SiparisNumarasi FROM siparisler WHERE OnayDurumu = ? AND KargoDurumu = ? ORDER BY id ASC");
	$SiparisNumaralariSorgusu->execute([0, 0]);
	$SiparisNumaralariSayisi		=	$SiparisNumaralariSorgusu->rowCount();
	$SiparisNumaralariKayitlari		=	$SiparisNumaralariSorgusu->fetchAll(PDO::FETCH_ASSOC);

	if($SiparisNumaralariSayisi>0){
		foreach($SiparisNumaralariKayitlari as $SiparisNumaralariSatirlar){
			$SiparislerSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM siparisler WHERE SiparisNumarasi = ? AND OnayDurumu = ? AND KargoDurumu = ?");
			$SiparislerSorgusu->execute([$SiparisNumaralariSatirlar["SiparisNumarasi"], 0, 0]);
			$SiparisSayisi		=	$SiparislerSorgusu->rowCount();
			$SiparisKayitlari	=	$SiparislerSorgusu->fetchAll(PDO::FETCH_ASSOC);

			if($SiparisSayisi>0){
				$ToplamFiyat		=	0;
				foreach($SiparisKayitlari as $Siparisler){
					$SiparisTarihi			=	 TarihBul($Siparisler["SiparisTarihi"]);
					$UrunToplamFiyati		=	$Siparisler["ToplamUrunFiyati"];
					
					$ToplamFiyat			+=	$UrunToplamFiyati;
				}
			?>	
			<tr>
				<td colspan="2" style="border-bottom: 1px dashed #CCCCCC;" valign="top"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
					<tr height="30">
						<td align="left" width="120"><b>Sipariş Tarihi</b></td>
						<td align="left" width="20"><b>:</b></td>
						<td align="left" width="200"><?php echo $SiparisTarihi; ?></td>
						<td align="left" width="120"><b>Sipariş Tutarı</b></td>
						<td align="left" width="20"><b>:</b></td>
						<td align="left" width="140"><?php echo FiyatBicimlendir($ToplamFiyat); ?> TL</td>
						<td align="left" width="130"><table width="130" align="right" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="25"><a href="index.php?SKD=0&SKI=113&SiparisNo=<?php echo DonusumleriGeriDondur($SiparisNumaralariSatirlar["SiparisNumarasi"]); ?>"><img src="../Resimler/Sil20x20.png" border="0" style="margin-top: 5px;"></a></td>
								<td width="30"><a href="index.php?SKD=0&SKI=113&SiparisNo=<?php echo DonusumleriGeriDondur($SiparisNumaralariSatirlar["SiparisNumarasi"]); ?>" style="color: #FF0000; text-decoration: none;">Sil</a></td>
								<td width="25"><a href="index.php?SKD=0&SKI=107&SiparisNo=<?php echo DonusumleriGeriDondur($SiparisNumaralariSatirlar["SiparisNumarasi"]); ?>"><img src="../Resimler/DokumanKirmiziKalemli20x20.png" border="0" style="margin-top: 5px;"></a></td>
								<td width="50"><a href="index.php?SKD=0&SKI=107&SiparisNo=<?php echo DonusumleriGeriDondur($SiparisNumaralariSatirlar["SiparisNumarasi"]); ?>" style="color: #0000FF; text-decoration: none;">Detay</a></td>
							</tr>
						</table></td>
					</tr>
				</table></td>
			</tr>
			<?php
				
			}else{
				header("Location:index.php?SKD=0&SKI=0");
				exit();
			}
		}
	}else{
	?>
	<tr>
		<td colspan="2"><table width="750" align="right" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="750">Kayıtlı yeni sipariş bulunmamaktadır.</td>
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