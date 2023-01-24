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
if(isset($_POST["Sifre"])){
	$GelenSifre				=	Guvenlik($_POST["Sifre"]);
}else{
	$GelenSifre				=	"";
}

$MD5liSifre					=	md5($GelenSifre);

if(($GelenEmailAdresi!="") and ($GelenSifre!="")){
	$KontrolSorgusu		=	$VeritabaniBaglantisi->prepare("SELECT * FROM uyeler WHERE EmailAdresi = ? AND Sifre = ? AND SilinmeDurumu = ?");
	$KontrolSorgusu->execute([$GelenEmailAdresi, $MD5liSifre, 0]);
	$KullaniciSayisi	=	$KontrolSorgusu->rowCount();
	$KullaniciKaydi		=	$KontrolSorgusu->fetch(PDO::FETCH_ASSOC);
	
	if($KullaniciSayisi>0){
		if($KullaniciKaydi["Durumu"]==1){
			$_SESSION["Kullanici"]	=	$GelenEmailAdresi;
			
			if($_SESSION["Kullanici"]==$GelenEmailAdresi){
				header("Location:index.php?SK=50");
				exit();
			}else{
				header("Location:index.php?SK=33");
				exit();
			}
		}else{
			$MailIcerigiHazirla		=	"Merhaba Sayın " . $KullaniciKaydi["IsimSoyisim"] . "<br /><br />Sitemize yapmış olduğunuz üyelik kaydını tamamlamak için lütfen <a href='" . $SiteLinki . "/aktivasyon.php?AktivasyonKodu=" . $KullaniciKaydi["AktivasyonKodu"] . "&Email=" . $KullaniciKaydi["EmailAdresi"] . "'>BURAYA TIKLAYINIZ</a>.<br /><br />Saygılarımızla, iyi çalışmalar...<br />" . $SiteAdi;

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
				$MailGonder->Subject			=	$SiteAdi . ' Yeni Üyelik Aktivasyonu';
				$MailGonder->MsgHTML($MailIcerigiHazirla);
				$MailGonder->send();

				header("Location:index.php?SK=36");
				exit();
			}catch(Exception $e){
				header("Location:index.php?SK=33");
				exit();
			}			
		}
	}else{
		header("Location:index.php?SK=34");
		exit();
	}
}else{
	header("Location:index.php?SK=35");
	exit();
}
?>