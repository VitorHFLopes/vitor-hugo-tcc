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
    //$retorno = array('code' => 20);//Mock
    $retorno = json_decode(exec($comando . ' 0'), true);
}
?>
<?php if (is_null($opcao) or $opcao != 'Status'): ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Comando Arduino</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
            <meta charset="UTF-8">
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <style>
                body{
                    background: #fdfdfdf;
                }
                .btn{
                    width: 120px;
                    margin-left: 10px;
                }
            </style>
        </head>
        <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-lg-offset-1 col-sm-12 col-xs-12">
                    <h1>Sistema de Envase</h1>
                    <div class="well" id="status">
                        <?=$opcao.' está ligado'; ?>
                    </div>
                    <form>
                        <ul class="list-group">
                            <li class="list-group-item">
                                <span class="pull-left">
                                    <h4>Líquido Laranja</h4>
                                </span>
                                <span class="pull-right">
                                    <input type="submit" name="opcao" class="btn btn-success" value="Liga laranja">    
                                    <input type="submit" name="opcao" class="btn btn-danger" value="Desliga laranja">    
                                </span>
                                <div class="clearfix"></div>
                            </li>
                            <li class="list-group-item">
                                <span class="pull-left">
                                    <h4>Líquido Verde</h4>
                                </span>
                                <span class="pull-right">
                                    <input type="submit" name="opcao" class="btn btn-success" value="Liga verde">
                                    <input type="submit" name="opcao" class="btn btn-danger" value="Desliga verde">
                                </span>
                                <div class="clearfix"></div>
                            </li>
                        </ul>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <th>Cores</th>
                                <th>Misturador</th>
                                <th>Enchendo</th>
                                <th>Reservatório</th>
                                <th>Transportando</th>
                            </tr>
                            <tr>
                                <tr class="text-danger">
                                	<td class="text-right">Vermelho <i class="iconvermelho hidden glyphicon glyphicon-tint"></i></td>
                                	<td><i class="misturando hidden glyphicon glyphicon-ok"></i></td>
                                	<td><i class="enchendo hidden glyphicon glyphicon-ok"></i></td>
                                	<td><i class="reservatorio hidden glyphicon glyphicon-ok"></i></td>
                                	<td><i class="transportando hidden glyphicon glyphicon-ok"></i></td>
                            	</tr>
                                <tr class="text-warning">
                                	<td class="text-right">Amarelo <i class="iconamarelo hidden glyphicon glyphicon-tint"></i></td>
                                	<td><i class="misturando hidden glyphicon glyphicon-ok"></i></td>
                                	<td><i class="enchendo hidden glyphicon glyphicon-ok"></i></td>
                                	<td><i class="reservatorio hidden glyphicon glyphicon-ok"></i></td>
                                	<td><i class="transportando hidden glyphicon glyphicon-ok"></i></td>
                            	</tr>
                                <tr class="text-info">
                                	<td class=" text-right">Azul <i class="iconazul hidden glyphicon glyphicon-tint"></i></td>
                                	<td><i class="misturando hidden glyphicon glyphicon-ok"></i></td>
                                	<td><i class="enchendo hidden glyphicon glyphicon-ok"></i></td>
                                	<td><i class="reservatorio hidden glyphicon glyphicon-ok"></i></td>
                                	<td><i class="transportando hidden glyphicon glyphicon-ok"></i></td>
                            	</tr>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        	<script src="js/jquery.min.js"></script>
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

                	//var contador = 9;//mock
            		var liquido = "";

                	var show = function(item){
                		if(liquido == "laranja"){
                			item1 = 'tr.text-danger '+item;
                			item2 = 'tr.text-warning '+item;
                		}else{
							item1 = 'tr.text-info '+item;
                			item2 = 'tr.text-warning '+item;
                		}

                		jQuery(item1).removeClass('hidden');
                		jQuery(item2).removeClass('hidden');
                	}

                	var hide = function(item){
                		jQuery(item).addClass('hidden');
                	}

                    var exibeStatus = function (data) {
                        var divStatus = document.getElementById('status');
                        var codigo = data.code;
                        
                        /** mock 
                        var codigo = contador;
                        if(!!codes[codigo]){
                        	divStatus.innerHTML = '<strong>Status: </strong>' + codes[codigo];
                        }
                        /** mock **/

                        switch(codigo){
                        	case 10:
                        		liquido = 'verde';
                        		hide('.glyphicon');

                        		show('.iconamarelo');
                        		show('.iconazul');

                        		hide('.iconvermelho');
                        		break;
                    		case 11:
                    			liquido = 'laranja';
                    			hide('.glyphicon');
                    			
                    			show('.iconamarelo');
                        		show('.iconvermelho');

                        		hide('.iconazul');
                        		break;
                    		case 12:
                    		case 13:
                    		case 20:
                    		case 21:
                    			show('.misturando');

                    			hide('.enchendo');
                    			hide('.reservatorio');
                    			hide('.transportando');
                    			break;
                			case 22:
                			case 23:
                			case 30:
                			case 31:
                				show('.misturando');
                				show('.enchendo');

                				hide('.reservatorio');
                    			hide('.transportando');
                				break;
            				case 32:
            				case 33:
                				show('.misturando');
                				show('.enchendo');            				
            					show('.reservatorio');

                    			hide('.transportando');
            					break;
        					case 40:
        					case 50:
        					case 51:
        					case 52:
        					case 53:
        					case 60:
        					case 61:
        					case 70:
			    				show('.misturando');
			    				show('.enchendo');            				
								show('.reservatorio');
        						show('.transportando');
        						break;
    						case 80:
    							hide('.glyphicon');
    						default:
    							break;
                        }

                        divStatus.innerHTML = '<strong>Status: </strong>' + codes[codigo];
                    };
                    var verificaStatus = function () {
                    	//contador++;//mock

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