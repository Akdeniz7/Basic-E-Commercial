<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Frameworks/PHPMailer/src/Exception.php';
require 'Frameworks/PHPMailer/src/PHPMailer.php';
require 'Frameworks/PHPMailer/src/SMTP.php';

if(isset($_POST["IsimSoyisim"])){
	$GelenIsimSoyisim		=	Guvenlik($_POST["IsimSoyisim"]);
}else{
	$GelenIsimSoyisim		=	"";
}

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

if(isset($_POST["Mesaj"])){
	$GelenMesaj				=	Guvenlik($_POST["Mesaj"]);
}else{
	$GelenMesaj				=	"";
}

if(($GelenIsimSoyisim!="") and ($GelenEmailAdresi!="") and ($GelenTelefonNumarasi!="") and ($GelenMesaj!="")){
	$MailIcerigiHazirla		=	"İsim Soyisim : " . $GelenIsimSoyisim . "<br />E-Mail Adresi : " . $GelenEmailAdresi . "<br />Telefon Numarası : " . $GelenTelefonNumarasi . "<br />Mesaj : " . $GelenMesaj;
	
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
		$MailGonder->addAddress(DonusumleriGeriDondur($SiteEmailAdresi), DonusumleriGeriDondur($SiteAdi));
		$MailGonder->addReplyTo($GelenEmailAdresi, $GelenIsimSoyisim);
		$MailGonder->isHTML(true);
		$MailGonder->Subject = DonusumleriGeriDondur($SiteAdi) . ' İletişim Formu Mesajı';
		$MailGonder->MsgHTML($MailIcerigiHazirla);
		$MailGonder->send();
		
		header("Location:index.php?SK=18");
		exit();
	}catch(Exception $e){
		header("Location:index.php?SK=19");
		exit();
	}
}else{
	header("Location:index.php?SK=20");
	exit();
}
?>