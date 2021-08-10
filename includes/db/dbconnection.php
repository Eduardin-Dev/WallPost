<?php
    require_once 'dbconfig.php' ;
    /*
    Compatibilidade: PHP 5.2, 5.3, 5.4, 5.5, 5.6, 7.0, 7.1, 7.2 
    Método mais indicado para conexão por ser o mais seguro.
    http://php.net/manual/pt_BR/class.pdo.php
    */
 
try {

    // Bloco PHP para criar conexões com o Banco de dados
    //Padrão sem se preocupar com acentuação  
    // $conn = new PDO(DBDRIVER . ':host=' . DBHOSTNAME .';dbname=' . DBNAME ,  DBUSERNAME, DBPASSWORD); 

    //Novo e obrigatório formato para que possamos usar os acentos!
    $conn = new PDO(DBDRIVER . ':host=' . DBHOSTNAME .';port=' . DBPORT . ';dbname=' . DBNAME .';charset=utf8',  DBUSERNAME, DBPASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 

    //------------------------------------------
    //PONTE ENTRE O PHP E O BANCO DE DADOS 
    //------------------------------------------
    //Instancia um novo objeto do tipo PDO 
    //Indicando que deverá este objeto conectar ao banco, utilizando o driver do sgbd mysql
    // Acessando a base de dados chamada lojaodobras, no servidor indicado como localhost e utilizando as credenciais de acesso ( user=root / password = usbw)
    // Todas as configurações e parâmetros foram definidos no arquivo dbconfig.php --> require_once 'dbconfig.php' ;

     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    //Modifico atributos /propriedades do objeto de conexão 
    //Informando que os erros devem ser tratados utilizando / enviando  EXCEPTION

    // Outros possíveis tipos de Atributos de ERRO!! 
    // PDO::ERRMODE_SILENT -- Fica quietinho e não fala que deu erro -- MAS GERA LOG! 
    // PDO::ERRMODE_WARNING -- ENVIA uma mensagem de ALERTA -- MAS GERA LOG! 
    // PDO::ERRMODE_EXCEPTION -- Envia uma EXCEPTION que será tratada dentro de um try catch! -- MAS GERA LOG!     


} catch (PDOException $Exception) {
    echo "Erro: " . $Exception->getMessage() . " - Código: " . $Exception->getCode(); 
    exit;
}    
