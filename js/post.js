$(document).ready(function(){

	$(".voltar").hide();
	$("#all_modal").hide();
	$("#colecao_modal_add").hide();
	$("#post_modal").hide();
	$("#colecao_modal").hide();

	$("#select_colecao").click(function(){
		$(".buttons_modal_add").hide(500);
		$("#colecao_modal_add").show(500);
		$(".voltar").show(500);
		$(".fechar").css({marginLeft : "0px"});
	});

	$("#select_posts").click(function(){
		$(".buttons_modal_add").hide(500);
		$("#all_modal").show(500);
		$(".voltar").show(500);
		$(".fechar").css({marginLeft : "0px"});
	});

	$("#alterar").click(function(){
		$(".buttons_modal_post").hide(500);
		$("#form").show(500);
		$(".voltar").show(500);
		$(".fechar").css({marginLeft : "0px"});
	});

	$("#add_colecao").click(function(){
		$(".buttons_modal_post").hide(500);
		$("#colecao_modal").show(500);
		$(".voltar").show(500);
		$(".fechar").css({marginLeft : "0px"});
	});

	$(".voltar_add").click(function(){
		$("#all_modal").hide();
		$("#colecao_modal_add").hide();
		$(".buttons_modal_post").hide();
		$(".buttons_modal_add").show(500);
		$(".voltar").hide();
		$(".fechar").css({marginLeft : "97%"});
	});

	$(".voltar_post").click(function(){
		$(".buttons_modal_post").show(500);
		$("#murais_modal").hide();
		$("#colecao_modal").hide();
		$(".voltar").hide();
		$(".fechar").css({marginLeft : "97%"});
	});

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

		$("#colecao_modal").fadeOut("slow");
		$(".fechar").css({marginLeft : "97%"});
		$(".buttons_modal_post").show(1000);
		$(".voltar").fadeOut("slow");
		$("#colecao_modal_add").fadeOut("slow");
		$("#all_modal").fadeOut("slow");
		$(".buttons_modal_add").show("slow");
		$(this).fadeOut();
		$('.window').fadeOut();
	});

	$('.fechar').click(function(ev){

		ev.preventDefault();

		$("#colecao_modal").fadeOut(1000);
		$(".fechar").css({marginLeft : "97%"});
		$(".buttons_modal_post").show(1000);
		$(".voltar").fadeOut(1000);
		$("#all_modal").fadeOut(1000);
		$("#colecao_modal_add").fadeOut(1000);
		$(".buttons_modal_add").show(1000);
		$('#mascara').fadeOut();
		$('.window').fadeOut();
	});

	$('#arquivo').change(function () {

		$("#newpost").css({ padding: '0px' });
		$("#newpost").css({ width: '210px' });
		$("#newpost").css({ height: '265px' });
		$("#postimg").show();
		$("#imgpost").hide();
  
		const file = $(this)[0].files[0]
  
		const fileReader = new FileReader()
  
		fileReader.onloadend = function () {
		   $('#postimg').attr('src', fileReader.result);
		}
  
		fileReader.readAsDataURL(file)
	 });
  
});