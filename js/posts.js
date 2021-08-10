
$(document).ready(function () {

	// FORM DO MODAL
	$("#mural_modal").hide();
	$("#form").hide();
	$("#colecao_modal").hide();
	$(".voltar").hide();

	$("#alterar").click(function () {
		$("#buttons_modal").hide(500);
		$("#form").show(500);
		$(".voltar").show(500);
		$(".fechar").css({
			marginLeft: "0px"
		});
	});

	$("#add_colecao").click(function () {
		$("#buttons_modal").hide(500);
		$("#colecao_modal").show(500);
		$(".voltar").show(500);
		$(".fechar").css({
			marginLeft: "0px"
		});
	});

	$("#add_mural").click(function () {
		$("#buttons_modal").hide(500);
		$("#mural_modal").show(500);
		$(".voltar").show(500);
		$(".fechar").css({
			marginLeft: "0px"
		});
		// $('.mural-item').click(function (ev) {
		// 	ev.preventDefault();

		// 	$(".voltar").hide(1000);
		// 	$(".fechar").css({
		// 		marginLeft: "97%"
		// 	});
		// 	$("#mural_modal").fadeOut(1000);
		// 	$("#colecao_modal").fadeOut(1000);
		// 	$("#form").fadeOut(1000, "linear");
		// 	$("#buttons_modal").show(1000);
		// 	$('#mascara').fadeOut();
		// 	$('.window').fadeOut();

		// 	$.toast({
		// 		heading: 'Sucesso!',
		// 		text: "Post adicionado ao mural!",
		// 		showHideTransition: 'fade',
		// 		icon: 'success',
		// 		position: 'top-center',
		// 		bgColor: '#F15A24',
		// 		loaderBg: 'white',
		// 		hideAfter: 4000
		// 	});

		// 	setTimeout(() => {
		// 		window.location.reload()
		// 	}, 4000);
		// });
	});

	$(".voltar").click(function () {
		$("#mural_modal").hide();
		$("#form").hide();
		$("#colecao_modal").hide();
		$("#buttons_modal").show(500);
		$(".voltar").hide();
		$(".fechar").css({
			marginLeft: "97%"
		});
	});

	$('#arquivo').change(function () {

		const file = $(this)[0].files[0]

		const fileReader = new FileReader()

		fileReader.onloadend = function () {
			$('#postimg').attr('src', fileReader.result);
		}

		fileReader.readAsDataURL(file)
	});


	$("a[rel=modal]").click(function (ev) {

		ev.preventDefault();

		var id = $(this).attr("href");

		var alturaTela = $(document).height();
		var larguraTela = $(window).width();

		$('#mascara').css({
			'width': larguraTela,
			'height': alturaTela
		});
		$('#mascara').fadeIn(1000);
		$('#mascara').fadeTo("slow", 0.8);

		var left = ($(window).width() / 2) - ($(id).width() / 2);
		var top = ($(window).height() / 2) - ($(id).height() / 2);

		$(id).css({
			'left': left,
			'top': top
		});

		var nome = $('#input_nmpost').val();
		console.log(nome);

		$.post("../includes/application/crud/Post/postModal_select.php", {
			postNome: $('#input_nmpost').val()
		},
			function (data) {
				setTimeout(function () {
					// retorno = JSON.parse(data);
					// console.log(retorno.sucesso);
					console.log(data.dados);

					// if (retorno.sucesso && retorno.dados !== null) {
					// 	$("#consulta-retorno-dados").html("Consulta -> ");
					// 	$.each(retorno.dados, function (key, item) {
					// 		// console.log(item);
					// 		// console.log(item.nm_remetente);
					// 		$("#consulta-retorno-dados").append("<h5>" + item.nm_remetente + "</h5>");
					// 		$("#consulta-retorno-dados").append("<h5>" + item.ds_email + "</h5>");
					// 		$("#consulta-retorno-dados").append("<h5>" + item.cd_telefone + "</h5>");
					// 		$("#consulta-retorno-dados").append("<h5>" + item.ds_mensagem + "</h5><br>");
					// 		$("#consulta-retorno-dados").append("<button class'btn btn-danger' onclick='apagar(" + item.cd_mensagem + "); return false;'> Remover do banco de dados a mensagem de " + item.nm_remetente + "</buttton>");
					// 		$("#consulta-retorno-dados").append("<hr>");
					// 	});

					// } else {
					// 	$("#consulta-retorno-dados").html("");
					// 	$("#log-insert-mensagem").prepend("Status: " + status + "<br>Data: " + data + '<hr>');
					// }

				}, 500);

			});

		$(id).show();
	});

	$('#mascara').click(function () {

		$(".voltar").hide("slow");
		$(".fechar").css({
			marginLeft: "97%"
		});
		$("#mural_modal").fadeOut("slow");
		$("#form").fadeOut("slow");
		$("#colecao_modal").fadeOut("slow");
		$("#buttons_modal").show("slow");
		$(this).fadeOut();
		$('.window').fadeOut();
	});

	$('.fechar').click(function (ev) {

		ev.preventDefault();

		$(".voltar").hide(1000);
		$(".fechar").css({
			marginLeft: "97%"
		});
		$("#mural_modal").fadeOut(1000);
		$("#colecao_modal").fadeOut(1000);
		$("#form").fadeOut(1000, "linear");
		$("#buttons_modal").show(1000);
		$('#mascara').fadeOut();
		$('.window').fadeOut();

	});
});
