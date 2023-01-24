$(document).ready(function(){
	
	$.SoruIcerigiGoster			=	function(ElemanIDsi){
		var SoruIDsi			=	ElemanIDsi;
		var IslenecekAlan		=	"#" + ElemanIDsi;
		$(".SorununCevapAlani").slideUp();
		$(IslenecekAlan).parent().find(".SorununCevapAlani").slideToggle();
	}
	
	$.UrunDetayResmiDegistir	=	function(Klasor, ResimDegeri){
		var ResimIcinDosyaYolu	=	"Resimler/UrunResimleri/" + Klasor + "/" + ResimDegeri;
		$("#BuyukResim").attr("src", ResimIcinDosyaYolu);
	}
	
	$.KrediKartiSecildi			=	function(){
		$(".BHAlanlari").css("display", "none");
		$(".KKAlanlari").css("display", "block");
	}
	
	$.BankaHavalesiSecildi			=	function(){
		$(".KKAlanlari").css("display", "none");
		$(".BHAlanlari").css("display", "block");
	}
});