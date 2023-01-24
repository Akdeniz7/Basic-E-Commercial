<?php

if(isset($_POST["KargoTakipNosu"])){
	$GelenKargoTakipNosu		=	SayiliIcerikleriFiltrele(Guvenlik($_POST["KargoTakipNosu"]));
}else{
	$GelenKargoTakipNosu		=	"";
}

if($GelenKargoTakipNosu!=""){
	header("Location:https://www.yurticikargo.com/tr/online-servisler/gonderi-sorgula?code=" . $GelenKargoTakipNosu);
	exit();
}else{
	header("Location:index.php?SK=14");
	exit();
}
?>