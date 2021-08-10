$(document).ready(function(){

	$("a[rel=modal]").click(function(ev){

		ev.preventDefault();

		var id = $(this).attr("href");

		var alturaTela  = $(document).height();
		var larguraTela = $(window).width();

		$('#mascara').css({'width':larguraTela, 'height':alturaTela});
		$('#mascara').fadeIn(1000);
		$('#mascara').fadeTo("slow", 0.8);

		var left = ($(window).width() / 2 ) - ($(id).width() / 2 );
		var top  = ($(window).height() / 2 ) - ($(id).height() / 2 );

		$(id).css({'left':left, 'top':top});
		$(id).show();
	});

	$('#mascara').click(function(){

		$(".fechar").css({marginLeft : "97%"});
		$(this).fadeOut();
		$('.window').fadeOut();
	});

	$('.fechar').click(function(ev){

		ev.preventDefault();

		$(".fechar").css({marginLeft : "97%"});
		$('#mascara').fadeOut();
		$('.window').fadeOut();
	});
});