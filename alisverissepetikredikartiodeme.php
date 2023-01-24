<?php
if(isset($_SESSION["Kullanici"])){
	$SepettekiUrunlerSorgusu	=	$VeritabaniBaglantisi->prepare("SELECT * FROM sepet WHERE UyeId = ? ORDER BY id DESC");
	$SepettekiUrunlerSorgusu->execute([$KullaniciID]);
	$SepettekiUrunSayisi		=	$SepettekiUrunlerSorgusu->rowCount();
	$SepettiKayitlar			=	$SepettekiUrunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);

	if($SepettekiUrunSayisi>0){
		$SepettekiToplamUrunSayisi			=	0;
		$SepettekiToplamFiyat				=	0;
		$SepettekiToplamKargoFiyati			=	0;
		$SepettekiToplamKargoFiyatiHesapla	=	0;

		foreach($SepettiKayitlar as $SepetSatirlari){
			$SepetIdsi						=	$SepetSatirlari["id"];
			$SepettekiSepetNumarasi			=	$SepetSatirlari["SepetNumarasi"];
			$SepettekiUrununIdsi			=	$SepetSatirlari["UrunId"];
			$SepettekiUrununVaryantIdsi		=	$SepetSatirlari["VaryantId"];
			$SepettekiUrununAdedi			=	$SepetSatirlari["UrunAdedi"];

			$UrunBilgileriSorgusu			=	$VeritabaniBaglantisi->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
			$UrunBilgileriSorgusu->execute([$SepettekiUrununIdsi]);
			$UrunKaydi						=	$UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);
				$UrununFiyati			=	$UrunKaydi["UrunFiyati"];
				$UrununParaBirimi		=	$UrunKaydi["ParaBirimi"];
				$UrununKargoUcreti		=	$UrunKaydi["KargoUcreti"];

			if($UrununParaBirimi=="USD"){
				$UrunFiyatiHesapla				=	$UrununFiyati*$DolarKuru;
				$UrunFiyatiBicimlendir			=	FiyatBicimlendir($UrunFiyatiHesapla);
			}elseif($UrununParaBirimi=="EUR"){
				$UrunFiyatiHesapla				=	$UrununFiyati*$EuroKuru;
				$UrunFiyatiBicimlendir			=	FiyatBicimlendir($UrunFiyatiHesapla);
			}else{
				$UrunFiyatiHesapla				=	$UrununFiyati;
				$UrunFiyatiBicimlendir			=	FiyatBicimlendir($UrununFiyati);
			}

			$UrunToplamFiyatiHesapla				=	($UrunFiyatiHesapla*$SepettekiUrununAdedi);
			$UrunToplamFiyatiBicimlendir			=	FiyatBicimlendir($UrunToplamFiyatiHesapla);

			$SepettekiToplamUrunSayisi				+=	$SepettekiUrununAdedi;
			$SepettekiToplamFiyat					+=	($UrunFiyatiHesapla*$SepettekiUrununAdedi);

			$SepettekiToplamKargoFiyatiHesapla		+=	($UrununKargoUcreti*$SepettekiUrununAdedi);
			$SepettekiToplamKargoFiyatiBicimlendir	=	FiyatBicimlendir($SepettekiToplamKargoFiyatiHesapla);
		}

		if($SepettekiToplamFiyat>=$UcretsizKargoBaraji){
			$SepettekiToplamKargoFiyatiHesapla		=	0;
			$SepettekiToplamKargoFiyatiBicimlendir	=	FiyatBicimlendir($SepettekiToplamKargoFiyatiHesapla);

			$OdenecekToplamTutariBicimlendir		=	FiyatBicimlendir($SepettekiToplamFiyat);
		}else{
			$OdenecekToplamTutariHesapla			=	($SepettekiToplamFiyat+$SepettekiToplamKargoFiyatiHesapla);
			$OdenecekToplamTutariBicimlendir		=	FiyatBicimlendir($OdenecekToplamTutariHesapla);
		}
	
		$clientId		=	DonusumleriGeriDondur($ClientID);	//	Bankadan Sanal Pos Onaylanınca Bankanın Verdiği İşyeri Numarası
		$amount			=	$OdenecekToplamTutariHesapla;	//	Sepet Ücreti yada İşlem Tutarı yada Karttan Çekilecek Tutar
		$oid			=	$SepettekiSepetNumarasi;	//	Sipariş Numarası (Tekrarlanmayan Bir Değer) (Örneğin Sepet Tablosundaki IDyi Kullanabilirsiniz) (Her İşlemde Değişmeli ve Asla Tekrarlanmamalı)
		$okUrl			=	"http://www.extraegitim.net/alisverissepetikredikartiodemesonuctamam.php";	//	Ödeme İşlemi Başarıyla Gerçekleşir ise Dönülecek Sayfa
		$failUrl		=	"http://www.extraegitim.net/alisverissepetikredikartiodemesonuchata.php";	//	Ödeme İşlemi Red Olur ise Dönülecek Sayfa
		$rnd			=	@microtime();
		$storekey		=	DonusumleriGeriDondur($StoreKey);	// Sanal Pos Onaylandığında Bankanın Size Verdiği Sanal Pos Ekranına Girerek Oluşturulacak Olan İş Yeri Anahtarı
		$storetype		=	"3d";	//	3D Modeli
		$hashstr		=	$clientId.$oid.$amount.$okUrl.$failUrl.$rnd.$storekey;	// Bankanın Kendi Ayarladığı Hash Parametresi
		$hash			=	@base64_encode(@pack('H*',@sha1($hashstr)));	// Bankanın Kendi Ayarladığı Hash Şifreleme Parametresi
		$description	=	"Ürün Satışı";	//	Extra Bir Açıklama Yazmak İsterseniz Çekim İle İlgili Buraya Yazıyoruz
		$xid			=	"";		//	20 bytelik, 28 Karakterli base64 Olarak Boş Bırılınca Sistem Tarafindan Ototmatik Üretilir. Lütfen Boş Bırakın
		$lang			=	"";		//	Çekim Gösterim Dili Default Türkçedir. Ayarlamak İsterseniz Türkçe (tr), İngilizce (en) Girilmelidir. Boş Bırakılırsa (tr) Kabu Edilmiş Olur.
		$email			=	"";	//	İsterseniz Çekimi Yapan Kullanıcınızın E-Mail Adresini Gönderebilirsiniz
		$userid			=	"";	//	İsterseniz Çekimi Yapan Kullanıcınızın Idsini Gönderebilirsiniz
?>
<form action="https://<sunucu_adresi>/<3dgate_path>" method="post"> <!-- Bu Adres Banka veya EST Firması Tarafından Verilir -->
	<input type="hidden" name="clientid" value="<?=$clientId?>" />
	<input type="hidden" name="amount" value="<?=$amount?>" />
	<input type="hidden" name="oid" value="<?=$oid?>" />
	<input type="hidden" name="okUrl" value="<?=$okUrl?>" />
	<input type="hidden" name="failUrl" value="<?=$failUrl?>" />
	<input type="hidden" name="rnd" value="<?=$rnd?>" />
	<input type="hidden" name="hash" value="<?=$hash?>" />
	<input type="hidden" name="storetype" value="3d" />	
	<input type="hidden" name="lang" value="tr" />
	<table width="1065" align="center" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="800" valign="top">
				<table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
					<tr height="40">
						<td style="color:#FF9900"><h3>Alışveriş Sepeti</h3></td>
					</tr>
					<tr height="30">
						<td valign="top" style="border-bottom: 1px dashed #CCCCCC;">Kredi Kartı Bilgilerini Aşağıdan Belirtebilir ve Ödeme Yapabilirsin.</td>
					</tr>
					<tr height="10">
						<td style="font-size: 10px;">&nbsp;</td>
					</tr>
					<tr>
						<td><table width="800" align="center" border="0" cellpadding="0" cellspacing="0">
							<tr height="40">
								<td width="250">Kredi Kart Numarası</td>
								<td colspan="4" width="550"><input type="text" name="pan" class="InputAlanlari">
							</tr>
							<tr height="40">
								<td>Son Kullanma Tarihi</td>
								<td width="100"><select name="Ecom_Payment_Card_ExpDate_Month" class="SelectAlanlari">
									<option value=""></option>
									<option value="01">01</option>
									<option value="02">02</option>
									<option value="03">03</option>
									<option value="04">04</option>
									<option value="05">05</option>
									<option value="06">06</option>
									<option value="07">07</option>
									<option value="08">08</option>
									<option value="09">09</option>
									<option value="10">10</option>
									<option value="11">11</option>
									<option value="12">12</option>
								</select></td>
								<td width="20" align="center"> - </td>
								<td width="100"><select name="Ecom_Payment_Card_ExpDate_Year" class="SelectAlanlari">
									<option value=""></option>
									<option value="2013">2013</option>
									<option value="2014">2014</option>
									<option value="2015">2015</option>
									<option value="2016">2016</option>
									<option value="2017">2017</option>
									<option value="2018">2018</option>
									<option value="2019">2019</option>
									<option value="2020">2020</option>
								</select></td>
								<td width="330"></td>
							</tr>
							<tr height="40">
								<td>Kart Türü</td>
								<td colspan="4"><input type="radio" value="1" name="cardType"> Visa <input type="radio" value="2" name="cardType"> MasterCard</td>
							</tr>
							<tr height="40">
								<td>Güvenlik Kodu</td>
								<td width="100"><input type="text" name="cv2" size="4" value="" class="InputAlanlari" /></td>
								<td colspan="2">&nbsp;</td>
							</tr>
							<tr height="40">
								<td align="center">&nbsp;</td>
								<td colspan="4" align="left"><input type="submit" value="Ödeme Yap" class="YesilButon" /></td>
							</tr>
						</table></td>
					</tr>
				</table>
			</td>

			<td width="15">&nbsp;</td>

			<td width="250" valign="top"><table width="250" align="center" border="0" cellpadding="0" cellspacing="0">
				<tr height="40">
					<td  style="color:#FF9900" align="right"><h3>Sipariş Özeti</h3></td>
				</tr>
				<tr height="30">
					<td valign="top" style="border-bottom: 1px dashed #CCCCCC;" align="right">Toplam <b style="color: red;"><?php echo $SepettekiToplamUrunSayisi; ?></b> Adet Ürün</td>
				</tr>
				<tr height="5">
					<td height="5" style="font-size: 5px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="right">Ödenecek Tutar (KDV Dahil)</td>
				</tr>
				<tr>
					<td align="right" style="font-size: 25px; font-weight: bold;"><?php echo $OdenecekToplamTutariBicimlendir; ?> TL</td>
				</tr>
				<tr height="10">
					<td style="font-size: 10px;">&nbsp;</td>
				</tr>
				<tr>
					<td align="right">Ürünler Toplam Tutarı (KDV Dahil)</td>
				</tr>
				<tr>
					<td align="right" style="font-size: 25px; font-weight: bold;"><?php echo FiyatBicimlendir($SepettekiToplamFiyat); ?> TL</td>
				</tr>
				<tr height="10">
					<td style="font-size: 10px;">&nbsp;</td>
				</tr>				
				<tr>
					<td align="right">Kargo Tutarı (KDV Dahil)</td>
				</tr>
				<tr>
					<td align="right" style="font-size: 25px; font-weight: bold;"><?php echo $SepettekiToplamKargoFiyatiBicimlendir; ?> TL</td>
				</tr>
			</table></td>
		</tr>
	</table>
</form>
<?php
	}else{
		header("Location:index.php");
		exit();
	}
}else{
	header("Location:index.php");
	exit();
}
?>