<?php
$opcao = filter_input(INPUT_GET, 'opcao');
$comando = 'main';
if ($opcao == 'Liga verde') {
    $retorno = json_decode(exec($comando . ' 1'), true);
} else if ($opcao == 'Liga laranja') {
    $retorno = json_decode(exec($comando . ' 2'), true);
} else if ($opcao == 'Desliga verde') {
    $retorno = json_decode(exec($comando . ' 3'), true);
} else if ($opcao == 'Desliga laranja') {
    $retorno = json_decode(exec($comando . ' 4'), true);
} else if ($opcao == 'Status') {
    $retorno = array('code' => 20);//Mock
    //$retorno = json_decode(exec($comando . ' 0'), true);
}
?>
<?php if (is_null($opcao) or $opcao != 'Status'): ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Comando Arduino</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <link rel="stylesheet" href="css/styles.css">
            <link rel="stylesheet" type="text/css" href="jquery.tzCheckbox/jquery.tzCheckbox.css" />
        </head>
        <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 col-sm-12 col-xs-12">
                    <h1>Sistema de Envase</h1>
                    <?php echo $_GET['opcao'];?>
                    <h2>PROCESSO DE ENVASE COM ÊNFASE EM CONTROLE A DISTÂNCIA POR MEIO DE SISTEMA SUPERVISÓRIO</h2>
                    <div id="page">
                        <form id="mainForm">
                            <ul>
                                <li class="btnVerde">
                                    <label for="btnVerde">Líquido Verde: </label>
                                    <input type="checkbox" id="btnVerde" name="btnVerde" data-on="Ligado" data-off="Desligado" />
                                </li>
                                <li class="btnLaranja">
                                    <label for="btnLaranja">Líquido Laranja: </label>
                                    <input type="checkbox" id="btnLaranja" name="btnLaranja" data-on="Ligado" data-off="Desligado" />                                    
                                </li>
                            </ul>
                            <input type="hidden" name="opcao">
                        </form>
                    </div>
                    <div class="well">
                        <p id="status"><?=$opcao . ' está ligado'; ?></p>
                    </div>
                    <!--form>
                        <button type="button" class="btn btn-success">Bomba Azul </button>
                        <input type="submit" name="opcao" class="btn btn-success" value="Liga verde">
                        <input type="submit" name="opcao" class="btn btn-warning" value="Liga laranja">
                        <input type="submit" name="opcao" class="btn btn-danger" value="Desliga verde">
                        <input type="submit" name="opcao" class="btn btn-danger" value="Desliga laranja">
                    </form-->
                </div>
            </div>
        </div>
           
            

            <script src="js/jquery.min.js"></script>
            <script src="jquery.tzCheckbox/jquery.tzCheckbox.js"></script>
            <script src="js/script.js"></script>
            <script>
                (function () {

                    var codes = [];
                    
                    codes[10] = "Enchendo o misturador com os liquidos amarelo e azul";
                    codes[11] = "Enchendo o misturador com os liquidos amarelo e vermelho";                    
                    codes[12] = "Liquidos amarelo e azul prontos para serem misturados";
                    codes[13] = "Liquidos amarelo e vermelho prontos para serem misturados";
                    
                    codes[20] = "Misturando os liquidos amarelo e azul";
                    codes[21] = "Misturando os liquidos amarelo e vermelho";                    
                    codes[22] = "Liquido verde pronto para ser bombeado para o reservatório";
                    codes[23] = "Liquido laranja pronto para ser bombeado para o reservatório";
                    
                    codes[30] = "Enchendo o reservatório com o liquido verde";
                    codes[31] = "Enchendo o reservatório com o liquido laranja";
                    codes[32] = "Liquido verde pronto para ser envasado";
                    codes[33] = "Liquido laranja pronto para ser envasado";

                    codes[40] = "Garrafa posicionada";

                    codes[50] = "Envasando a garrafa com liquido verde";
                    codes[51] = "Envasando a garrafa com liquido laranja";
                    codes[52] = "Aguardando a próxima garrafa com liquido verde";
                    codes[53] = "Aguardando a próxima garrafa com liquido laranja";

                    codes[60] = "Transportando as garrafas com liquido verde";
                    codes[61] = "Transportando as garrafas com liquido laranja";

                    codes[70] = "Aguardando mais garrafas";

                    codes[80] = "Aguardando novo processo";

                    var exibeStatus = function (data) {
                        var divStatus = document.getElementById('status');
                        divStatus.innerHTML = '<p>Status: ' + codes[data.code] + '</p>';
                    };
                    var verificaStatus = function () {
                        var xmlhttp = new XMLHttpRequest();
                        var url = "?opcao=Status";
                        xmlhttp.onreadystatechange = function () {
                            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                                console.log(xmlhttp.responseText);
                                var myArr = JSON.parse(xmlhttp.responseText);
                                exibeStatus(myArr);
                            }
                        };
                        xmlhttp.open("GET", url, true);
                        xmlhttp.send();
                    }
                    setInterval(verificaStatus, 2000);
                })();
            </script>
        </body>
    </html>
<?php
    else: 
        echo json_encode($retorno);
    endif;
?>