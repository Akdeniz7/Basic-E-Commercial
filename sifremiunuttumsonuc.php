<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Frameworks/PHPMailer/src/Exception.php';
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';

if(isset($_POST["EmailAdresi"])){
	$GelenEmailAdresi		=	Guvenlik($_POST["EmailAdresi"]);
}else{
	$GelenEmailAdresi		=	"";
}
if(isset($_POST["TelefonNumarasi"])){
	$GelenTelefonNumarasi	=	Guvenlik($_POST["TelefonNumarasi"]);
}else{
	$GelenTelefonNumarasi	=	"";
}

if(($GelenEmailAdresi!="") or ($GelenTelefonNumarasi!="")){
	$KontrolSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM uyeler WHERE EmailAdresi = ? OR TelefonNumarasi = ? AND SilinmeDurumu = ?");
	$KontrolSorgusu->execute([$GelenEmailAdresi, $GelenTelefonNumarasi, 0]);
	$KullaniciSayisi	=	$KontrolSorgusu->rowCount();
	$KullaniciKaydi		=	$KontrolSorgusu->fetch(PDO::FETCH_ASSOC);

	if($KullaniciSayisi>0){
		$MailIcerigiHazirla		=	"Merhaba Sayın " . $KullaniciKaydi["IsimSoyisim"] . "<br /><br />Sitemiz üzerinde bulunan hesabınızın şifresini sıfırlamak için lütfen <a href='" . $SiteLinki . "/index.php?SK=43&AktivasyonKodu=" . $KullaniciKaydi["AktivasyonKodu"] . "&Email=" . $KullaniciKaydi["EmailAdresi"] . "'>BURAYA TIKLAYINIZ</a>.<br /><br />Saygılarımızla, iyi çalışmalar...<br />" . $SiteAdi;

		$MailGonder		=	new PHPMailer(true);

		try{
			$MailGonder->SMTPDebug			=	0;
			$MailGonder->isSMTP();
			$MailGonder->Host				=	DonusumleriGeriDondur($SiteEmailHostAdresi);
			$MailGonder->SMTPAuth			=	true;
			$MailGonder->CharSet			=	"UTF-8";
			$MailGonder->Username			=	DonusumleriGeriDondur($SiteEmailAdresi);
			$MailGonder->Password			=	DonusumleriGeriDondur($SiteEmailSifresi);
			$MailGonder->SMTPSecure			=	'tls';
			$MailGonder->Port				=	587;
			$MailGonder->SMTPOptions		=	array(
													'ssl' => array(
														'verify_peer' => false,
														'verify_peer_name' => false,
														'allow_self_signed' => true
													)
												);
			$MailGonder->setFrom(DonusumleriGeriDondur($SiteEmailAdresi), DonusumleriGeriDondur($SiteAdi));
			$MailGonder->addAddress(DonusumleriGeriDondur($KullaniciKaydi["EmailAdresi"]), DonusumleriGeriDondur($KullaniciKaydi["IsimSoyisim"]));					
			$MailGonder->addReplyTo(DonusumleriGeriDondur($SiteEmailAdresi), DonusumleriGeriDondur($SiteAdi));
			$MailGonder->isHTML(true);
			$MailGonder->Subject			=	$SiteAdi . ' Şifre Sıfırlama';
			$MailGonder->MsgHTML($MailIcerigiHazirla);
			$MailGonder->send();

			header("Location:index.php?SK=39");
			exit();
		}catch(Exception $e){
			header("Location:index.php?SK=40");
			exit();
		}			
	}else{
		header("Location:index.php?SK=41");
		exit();
	}
}else{
	header("Location:index.php?SK=42");
	exit();
}
?>