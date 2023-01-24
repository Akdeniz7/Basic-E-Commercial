<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
			<?php
			$BannerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM bannerlar WHERE BannerAlani = 'Ana Sayfa' ORDER BY GosterimSayisi ASC LIMIT 1");
			$BannerSorgusu->execute();
			$BannerSayisi		=	$BannerSorgusu->rowCount();
			$BannerKaydi		=	$BannerSorgusu->fetch(PDO::FETCH_ASSOC);
			?>
			<tr height="186">
				<td><img src="Resimler/<?php echo $BannerKaydi["BannerResmi"]; ?>" border="0"></td>
			</tr>
			<?php
			$BannerGuncelle		=	$VeritabaniBaglantisi->prepare("UPDATE bannerlar SET GosterimSayisi=GosterimSayisi+1 WHERE id = ? LIMIT 1");
			$BannerGuncelle->execute([$BannerKaydi["id"]]);
			?>
		</table></td>
	</tr>
	
	<tr height="35">
		<td bgcolor="#FF9900" style="color: #FFFFFF; font-weight: bold;">&nbsp;En Yeni Ürünler</td>
	</tr>
	
	<tr>
		<td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr><?php
				$EnYeniUrunlerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE Durumu = '1' ORDER BY id DESC LIMIT 5");
				$EnYeniUrunlerSorgusu->execute();
				$EnYeniUrunSayisi			=	$EnYeniUrunlerSorgusu->rowCount();
				$EnYeniUrunKayitlari		=	$EnYeniUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
				$EnYeniDonguSayisi			=	1;
	
				foreach($EnYeniUrunKayitlari as $EnYeniUrunSatirlari){
					$EnYeniUrununTuru		=	DonusumleriGeriDondur($EnYeniUrunSatirlari["UrunTuru"]);
					$EnYeniUrununFiyati		=	DonusumleriGeriDondur($EnYeniUrunSatirlari["UrunFiyati"]);
					$EnYeniUrununParaBirimi	=	DonusumleriGeriDondur($EnYeniUrunSatirlari["ParaBirimi"]);
	
					if($EnYeniUrununParaBirimi=="USD"){
						$EnYeniUrunFiyatiHesapla	=	$EnYeniUrununFiyati*$DolarKuru;
					}elseif($EnYeniUrununParaBirimi=="EUR"){
						$EnYeniUrunFiyatiHesapla	=	$EnYeniUrununFiyati*$EuroKuru;
					}else{
						$EnYeniUrunFiyatiHesapla	=	$EnYeniUrununFiyati;
					}
					
					if($EnYeniUrununTuru=="Erkek Ayakkabısı"){
						$EnYeniUrunResimKlasoru		=	"Erkek";
					}elseif($EnYeniUrununTuru=="Kadın Ayakkabısı"){
						$EnYeniUrunResimKlasoru		=	"Kadin";
					}elseif($EnYeniUrununTuru=="Çocuk Ayakkabısı"){
						$EnYeniUrunResimKlasoru		=	"Cocuk";
					}
					
					$EnYeniUrununToplamYorumSayisi	=	DonusumleriGeriDondur($EnYeniUrunSatirlari["YorumSayisi"]);
					$EnYeniUrununToplamYorumPuani	=	DonusumleriGeriDondur($EnYeniUrunSatirlari["ToplamYorumPuani"]);
	
					if($EnYeniUrununToplamYorumSayisi>0){
						$EnYeniPuanHesapla			=	number_format($EnYeniUrununToplamYorumPuani/$EnYeniUrununToplamYorumSayisi, 2, ".", "");
					}else{
						$EnYeniPuanHesapla			=	0;
					}

					if($EnYeniPuanHesapla==0){
						$EnYeniPuanResmi	=	"YildizCizgiliBos.png";
					}elseif(($EnYeniPuanHesapla>0) and ($EnYeniPuanHesapla<=1)){
						$EnYeniPuanResmi	=	"YildizCizgiliBirDolu.png";
					}elseif(($EnYeniPuanHesapla>1) and ($EnYeniPuanHesapla<=2)){
						$EnYeniPuanResmi	=	"YildizCizgiliIkiDolu.png";
					}elseif(($EnYeniPuanHesapla>2) and ($EnYeniPuanHesapla<=3)){
						$EnYeniPuanResmi	=	"YildizCizgiliUcDolu.png";
					}elseif(($EnYeniPuanHesapla>3) and ($EnYeniPuanHesapla<=4)){
						$EnYeniPuanResmi	=	"YildizCizgiliDortDolu.png";
					}elseif($EnYeniPuanHesapla>4){
						$EnYeniPuanResmi	=	"YildizCizgiliBesDolu.png";
					}
				?>
					<td width="205" valign="top">
						<table width="205" align="left" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 10px;">
							<tr height="40">
								<td align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]); ?>"><img src="Resimler/UrunResimleri/<?php echo $EnYeniUrunResimKlasoru; ?>/<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["UrunResmiBir"]); ?>" border="0" width="205" height="273"></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]); ?>" style="color: #FF9900; font-weight: bold; text-decoration: none;"><?php echo  DonusumleriGeriDondur($EnYeniUrununTuru); ?></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]); ?>" style="color: #646464; font-weight: bold; text-decoration: none;"><div style="width: 205px; max-width: 205px; height: 20px; overflow: hidden; line-height: 20px;"><?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["UrunAdi"]); ?></div></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]); ?>"><img src="Resimler/<?php echo $EnYeniPuanResmi; ?>" border="0"></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnYeniUrunSatirlari["id"]); ?>" style="color: #0000FF; font-weight: bold; text-decoration: none;"><?php echo FiyatBicimlendir($EnYeniUrunFiyatiHesapla); ?> TL</a></td>
							</tr>
						</table>
					</td>
					<?php
					if($EnYeniDonguSayisi<4){
					?>
						<td width="10">&nbsp;</td>
					<?php
					}
					?>
				<?php
					$EnYeniDonguSayisi++;
				}
			?></tr>
		</table></td>
	</tr>
	
	
	<tr height="35">
		<td bgcolor="#FF9900" style="color: #FFFFFF; font-weight: bold;">&nbsp;En Popüler Ürünler</td>
	</tr>
	
	<tr>
		<td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr><?php
				$EnPopulerUrunlerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE Durumu = '1' ORDER BY GoruntulenmeSayisi DESC LIMIT 5");
				$EnPopulerUrunlerSorgusu->execute();
				$EnPopulerUrunSayisi			=	$EnPopulerUrunlerSorgusu->rowCount();
				$EnPopulerUrunKayitlari			=	$EnPopulerUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
				$EnPopulerDonguSayisi			=	1;
	
				foreach($EnPopulerUrunKayitlari as $EnPopulerUrunSatirlari){
					$EnPopulerUrununTuru		=	DonusumleriGeriDondur($EnPopulerUrunSatirlari["UrunTuru"]);
					$EnPopulerUrununFiyati		=	DonusumleriGeriDondur($EnPopulerUrunSatirlari["UrunFiyati"]);
					$EnPopulerUrununParaBirimi	=	DonusumleriGeriDondur($EnPopulerUrunSatirlari["ParaBirimi"]);
	
					if($EnPopulerUrununParaBirimi=="USD"){
						$EnPopulerUrunFiyatiHesapla	=	$EnPopulerUrununFiyati*$DolarKuru;
					}elseif($EnPopulerUrununParaBirimi=="EUR"){
						$EnPopulerUrunFiyatiHesapla	=	$EnPopulerUrununFiyati*$EuroKuru;
					}else{
						$EnPopulerUrunFiyatiHesapla	=	$EnPopulerUrununFiyati;
					}
					
					if($EnPopulerUrununTuru=="Erkek Ayakkabısı"){
						$EnPopulerUrunResimKlasoru		=	"Erkek";
					}elseif($EnPopulerUrununTuru=="Kadın Ayakkabısı"){
						$EnPopulerUrunResimKlasoru		=	"Kadin";
					}elseif($EnPopulerUrununTuru=="Çocuk Ayakkabısı"){
						$EnPopulerUrunResimKlasoru		=	"Cocuk";
					}
					
					$EnPopulerUrununToplamYorumSayisi	=	DonusumleriGeriDondur($EnPopulerUrunSatirlari["YorumSayisi"]);
					$EnPopulerUrununToplamYorumPuani	=	DonusumleriGeriDondur($EnPopulerUrunSatirlari["ToplamYorumPuani"]);
	
					if($EnPopulerUrununToplamYorumSayisi>0){
						$EnPopulerPuanHesapla			=	number_format($EnPopulerUrununToplamYorumPuani/$EnPopulerUrununToplamYorumSayisi, 2, ".", "");
					}else{
						$EnPopulerPuanHesapla			=	0;
					}

					if($EnPopulerPuanHesapla==0){
						$EnPopulerPuanResmi	=	"YildizCizgiliBos.png";
					}elseif(($EnPopulerPuanHesapla>0) and ($EnPopulerPuanHesapla<=1)){
						$EnPopulerPuanResmi	=	"YildizCizgiliBirDolu.png";
					}elseif(($EnPopulerPuanHesapla>1) and ($EnPopulerPuanHesapla<=2)){
						$EnPopulerPuanResmi	=	"YildizCizgiliIkiDolu.png";
					}elseif(($EnPopulerPuanHesapla>2) and ($EnPopulerPuanHesapla<=3)){
						$EnPopulerPuanResmi	=	"YildizCizgiliUcDolu.png";
					}elseif(($EnPopulerPuanHesapla>3) and ($EnPopulerPuanHesapla<=4)){
						$EnPopulerPuanResmi	=	"YildizCizgiliDortDolu.png";
					}elseif($EnPopulerPuanHesapla>4){
						$EnPopulerPuanResmi	=	"YildizCizgiliBesDolu.png";
					}
				?>
					<td width="205" valign="top">
						<table width="205" align="left" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 10px;">
							<tr height="40">
								<td align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopulerUrunSatirlari["id"]); ?>"><img src="Resimler/UrunResimleri/<?php echo $EnPopulerUrunResimKlasoru; ?>/<?php echo DonusumleriGeriDondur($EnPopulerUrunSatirlari["UrunResmiBir"]); ?>" border="0" width="205" height="273"></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopulerUrunSatirlari["id"]); ?>" style="color: #FF9900; font-weight: bold; text-decoration: none;"><?php echo  DonusumleriGeriDondur($EnPopulerUrununTuru); ?></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopulerUrunSatirlari["id"]); ?>" style="color: #646464; font-weight: bold; text-decoration: none;"><div style="width: 205px; max-width: 205px; height: 20px; overflow: hidden; line-height: 20px;"><?php echo DonusumleriGeriDondur($EnPopulerUrunSatirlari["UrunAdi"]); ?></div></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopulerUrunSatirlari["id"]); ?>"><img src="Resimler/<?php echo $EnPopulerPuanResmi; ?>" border="0"></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnPopulerUrunSatirlari["id"]); ?>" style="color: #0000FF; font-weight: bold; text-decoration: none;"><?php echo FiyatBicimlendir($EnPopulerUrunFiyatiHesapla); ?> TL</a></td>
							</tr>
						</table>
					</td>
					<?php
					if($EnPopulerDonguSayisi<4){
					?>
						<td width="10">&nbsp;</td>
					<?php
					}
					?>
				<?php
					$EnPopulerDonguSayisi++;
				}
			?></tr>
		</table></td>
	</tr>
	
	<tr height="35">
		<td bgcolor="#FF9900" style="color: #FFFFFF; font-weight: bold;">&nbsp;En Çok Satan Ürünler</td>
	</tr>
	
	<tr>
		<td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr><?php
				$EnCokSatanUrunlerSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE Durumu = '1' ORDER BY ToplamSatisSayisi DESC LIMIT 5");
				$EnCokSatanUrunlerSorgusu->execute();
				$EnCokSatanUrunSayisi			=	$EnCokSatanUrunlerSorgusu->rowCount();
				$EnCokSatanUrunKayitlari		=	$EnCokSatanUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
	
				$EnCokSatanDonguSayisi			=	1;
	
				foreach($EnCokSatanUrunKayitlari as $EnCokSatanUrunSatirlari){
					$EnCokSatanUrununTuru		=	DonusumleriGeriDondur($EnCokSatanUrunSatirlari["UrunTuru"]);
					$EnCokSatanUrununFiyati		=	DonusumleriGeriDondur($EnCokSatanUrunSatirlari["UrunFiyati"]);
					$EnCokSatanUrununParaBirimi	=	DonusumleriGeriDondur($EnCokSatanUrunSatirlari["ParaBirimi"]);
	
					if($EnCokSatanUrununParaBirimi=="USD"){
						$EnCokSatanUrunFiyatiHesapla	=	$EnCokSatanUrununFiyati*$DolarKuru;
					}elseif($EnCokSatanUrununParaBirimi=="EUR"){
						$EnCokSatanUrunFiyatiHesapla	=	$EnCokSatanUrununFiyati*$EuroKuru;
					}else{
						$EnCokSatanUrunFiyatiHesapla	=	$EnCokSatanUrununFiyati;
					}
					
					if($EnCokSatanUrununTuru=="Erkek Ayakkabısı"){
						$EnCokSatanUrunResimKlasoru		=	"Erkek";
					}elseif($EnCokSatanUrununTuru=="Kadın Ayakkabısı"){
						$EnCokSatanUrunResimKlasoru		=	"Kadin";
					}elseif($EnCokSatanUrununTuru=="Çocuk Ayakkabısı"){
						$EnCokSatanUrunResimKlasoru		=	"Cocuk";
					}
					
					$EnCokSatanUrununToplamYorumSayisi	=	DonusumleriGeriDondur($EnCokSatanUrunSatirlari["YorumSayisi"]);
					$EnCokSatanUrununToplamYorumPuani	=	DonusumleriGeriDondur($EnCokSatanUrunSatirlari["ToplamYorumPuani"]);
	
					if($EnCokSatanUrununToplamYorumSayisi>0){
						$EnCokSatanPuanHesapla			=	number_format($EnCokSatanUrununToplamYorumPuani/$EnCokSatanUrununToplamYorumSayisi, 2, ".", "");
					}else{
						$EnCokSatanPuanHesapla			=	0;
					}

					if($EnCokSatanPuanHesapla==0){
						$EnCokSatanPuanResmi	=	"YildizCizgiliBos.png";
					}elseif(($EnCokSatanPuanHesapla>0) and ($EnCokSatanPuanHesapla<=1)){
						$EnCokSatanPuanResmi	=	"YildizCizgiliBirDolu.png";
					}elseif(($EnCokSatanPuanHesapla>1) and ($EnCokSatanPuanHesapla<=2)){
						$EnCokSatanPuanResmi	=	"YildizCizgiliIkiDolu.png";
					}elseif(($EnCokSatanPuanHesapla>2) and ($EnCokSatanPuanHesapla<=3)){
						$EnCokSatanPuanResmi	=	"YildizCizgiliUcDolu.png";
					}elseif(($EnCokSatanPuanHesapla>3) and ($EnCokSatanPuanHesapla<=4)){
						$EnCokSatanPuanResmi	=	"YildizCizgiliDortDolu.png";
					}elseif($EnCokSatanPuanHesapla>4){
						$EnCokSatanPuanResmi	=	"YildizCizgiliBesDolu.png";
					}
				?>
					<td width="205" valign="top">
						<table width="205" align="left" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 10px;">
							<tr height="40">
								<td align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]); ?>"><img src="Resimler/UrunResimleri/<?php echo $EnCokSatanUrunResimKlasoru; ?>/<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["UrunResmiBir"]); ?>" border="0" width="205" height="273"></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]); ?>" style="color: #FF9900; font-weight: bold; text-decoration: none;"><?php echo  DonusumleriGeriDondur($EnCokSatanUrununTuru); ?></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]); ?>" style="color: #646464; font-weight: bold; text-decoration: none;"><div style="width: 205px; max-width: 205px; height: 20px; overflow: hidden; line-height: 20px;"><?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["UrunAdi"]); ?></div></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]); ?>"><img src="Resimler/<?php echo $EnCokSatanPuanResmi; ?>" border="0"></a></td>
							</tr>
							<tr height="25">
								<td width="205" align="center"><a href="index.php?SK=83&ID=<?php echo DonusumleriGeriDondur($EnCokSatanUrunSatirlari["id"]); ?>" style="color: #0000FF; font-weight: bold; text-decoration: none;"><?php echo FiyatBicimlendir($EnCokSatanUrunFiyatiHesapla); ?> TL</a></td>
							</tr>
						</table>
					</td>
					<?php
					if($EnCokSatanDonguSayisi<4){
					?>
						<td width="10">&nbsp;</td>
					<?php
					}
					?>
				<?php
					$EnCokSatanDonguSayisi++;
				}
			?></tr>
		</table></td>
	</tr>
	
	<tr>
		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td><table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td width="258"><table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="Resimler/HizliTeslimat.png" border="0"></td>
					</tr>
					<tr>
						<td align="center"><b>Bugün Teslimat</b></td>
					</tr>
					<tr>
						<td align="center">Saat 14:00!a kadar verdiğiniz siparişler aynı gün kapınızda.</td>
					</tr>
				</table></td>
				<td width="11">&nbsp;</td>
				<td width="258"><table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="Resimler/GuvenliAlisveris.png" border="0"></td>
					</tr>
					<tr>
						<td align="center"><b>Tek Tıkla Güvenli Alışveriş</b></td>
					</tr>
					<tr>
						<td align="center">Ödeme ve adres bilgilerinizi kaydedin, güvenli alışveriş yapın.</td>
					</tr>
				</table></td>
				<td width="11">&nbsp;</td>
				<td width="258"><table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="Resimler/MobilErisim.png" border="0"></td>
					</tr>
					<tr>
						<td align="center"><b>Mobil Erişim</b></td>
					</tr>
					<tr>
						<td align="center">Dilediğiniz her cihazdan sitemize erişebilir ve alışveriş yapabilirsiniz.</td>
					</tr>
				</table></td>
				<td width="11">&nbsp;</td>
				<td width="258"><table width="258" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center"><img src="Resimler/IadeGarantisi.png" border="0"></td>
					</tr>
					<tr>
						<td align="center"><b>Kolay İade</b></td>
					</tr>
					<tr>
						<td align="center">Aldığınız herhangi bir ürünü 14 gün içerisinde kolaylıkla iade edebilirsiniz.</td>
					</tr>
				</table></td>
			</tr>
		</table></td>
	</tr>
</table>