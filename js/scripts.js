$(document).ready(function () {

    // CONFIGURANDO OS BOTÕES DO NAVBAR

    $("#como").click(function () {
        $(".comop").slideDown("slow");
        $(".title").hide();
        $(".quemp").hide();
    });

    $("#inicio").click(function () {
        $(".title").slideDown("slow");
        $(".comop").hide();
        $(".quemp").hide();
    });

    $("#quem").click(function () {
        $(".quemp").slideDown("slow");
        $(".title").hide();
        $(".comop").hide();
    });
    //////////////////////////////////////

    // CONFIGURANDO A PARTE DO LOGIN

    $("#btnCadastro").click(function () {
        $("#fLogin").hide();
        $("#fCadastro").show(1000);
        $(".pWelcome").text('Olá, junte-se ao WallPost');
        $(".pLc").text('Cadastro');
        $("#btnCadastro").text('Cadastrar');
        $("#btnesqueci").hide();
        $("#fesqueci").hide();

        if (cadastro === 1) {

            $("#inpcadastro").click();

        }

        cadastro = 1;
        login = 0;
        console.log("login é = " + login);
        console.log("cadastro é = " + cadastro);
    });

    $("#btnLogin").click(function () {
        $("#fCadastro").hide();
        $("#fLogin").show(1000);
        $(".pWelcome").text('Bem vindo de volta,');
        $(".pLc").text('Login');
        $("#btnCadastro").text('Criar conta');
        $("#btnesqueci").show(1000);
        $("#fesqueci").hide();
        cadastro = 0;
        if (login === 1) {
            $("#inplogin").click();
        }
        cadastro = 0;
        login = 1;
        console.log("login é = " + login);
        console.log("cadastro é = " + cadastro);

        // if($("#txtnome").val() == 'admin' && $("#password").val() == 'admin'){
        //     $("#inplogin").click();
        // }

    });

    $("#btnesqueci").click(function () {
        $("#fCadastro").hide();
        $("#fLogin").hide(1000);
        $(".pWelcome").text('Vamos lembra-lo,');
        $(".pLc").text('Relembre-se');
        $("#btnesqueci").hide();
        $("#fesqueci").show(1000);
        cadastro = 0;
        login = 0;
        console.log("login é = " + login);
        console.log("cadastro é = " + cadastro);
    });

    // VARIAVEL PARA CONTROLE DE CLICK

    var login = 1;
    var cadastro = 0;

    // MASCARA DE CAMPO
    $('.celular').mask('(00) 00000-0000');

});