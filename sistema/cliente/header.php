<?
include_once( "../includes/verifica_logado_cli.inc.php" );
include_once( "../includes/funcoes.php" );
include_once( "../includes/global.inc.php" );
?>
<?= '<?xml version="1.0" encoding="iso-8859-1"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sistecart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" href="../css/style.css" type="text/css">
	<script	src="../js/js.js" language="javascript"></script> <script
	src="../js/jquery.js" type="text/javascript"></script> <script
	language="javascript" src="../js/ajax.js"></script> <script
	src="../js/interface.js" type="text/javascript"></script> <!-- efeito de abas -->
<link rel="stylesheet" href="../css/jquery.tabs.css" type="text/css"
	media="print, projection, screen"><script
	src="../js/abas/jquery.tabs.pack.js" type="text/javascript"></script> <script
	type="text/javascript">
			$(function() {
				$('#container-hotsite').tabs({ fxSlide: true, fxFade: true, fxSpeed: 'normal' });
			});
		</script> <!-- fim do efeito de abas --> <script>
            $(function(){

                
                $(".menuv li.submenu").each(function(){
                    var el = $('#' + $(this).attr('id') + ' ul:eq(0)');
                    
                    $(this).hover(function(){
                        el.show();
                    }, function(){
                        el.hide();
                    });
                });
                
                $(".menuh li.subv").each(function(){
                    var el = $('#' + $(this).attr('id') + ' ul:eq(0)');
                    
                    $(this).hover(function(){
                        el.show();
                    }, function(){
                        el.hide();
                    });
                });
            });
        </script> <script Language="JavaScript">
        
        <!-- 
        // Tem um bando de bugs nas funcoes referentes a datas no javascript,
        // entao o melhor e simplificar: vamos comparar a hora local da maquina
        // cliente com a hora da cidade desejada e calcular o horario da cidade
        // a cada segundo de acordo com essa diferenca. Nao vamos usar tempos
        // UTC porque ha varios problemas com timezones e horario de verao.
        
        
        var hora_inicial_cidade = new Date(<?= date(Y) ?>, <?= date(m)-1 ?> ,<?= date(d) ?> ,<?= date(G) ?> ,<?= date(i) ?> ,(31 + 2));
        
        // Na data acima, somamos 2 segs ao horario enviado pelo servidor porque
        // ha um certo atraso entre o momento em que o servidor "gera" a data e o momento
        // em que o javascript e executado; "adiantando" o relogio 2 segundos, esse erro
        // e minimizado (mas nao eliminado, pois nao da pra determinar o erro com precisao).
        var contagemID = null;
        var contagemAtivada = false;
        var diferenca = 0;
        var acerta = 0;
        
        // Array relacionando o numero do mes ao nome
        mes_port = new Object();
              mes_port[0] ="jan";      mes_port[1] ="fev";      mes_port[2] ="mar";     mes_port[3] ="abr";
              mes_port[4] ="mai";      mes_port[5] ="jun";      mes_port[6] ="jul";     mes_port[7] ="ago";
              mes_port[8] ="set";      mes_port[9] ="out";      mes_port[10] ="nov";    mes_port[11] ="dez";
        
        // Vamos usar sempre o ano com 4 digitos; como ha diferencas entre
        // o explorer e o navigator, precisa desta funcaozinha.
        function getFullYear(obj_data) {
            var ano = obj_data.getYear();
            if (ano < 1000) ano += 1900;
            return ano;
        }
        
        
        // Calculemos a diferenca entre o horario enviado pelo servidor e o horario da
        // maquina cliente; com esse numero, podemos recalcular a cada segundo o horario
        // correto da cidade independente do horario da maquina cliente.
        function iniciaconta(){
                  hora_inicial_local=new Date;
                  diferenca =(hora_inicial_cidade.getTime() - hora_inicial_local.getTime()); 
                  return diferenca;
        }
        
        function mostrarTempo(acerta){
        
            // Pega a hora local atual:
            var agora = new Date();
            // Acerta de acordo com a diferenca calculada antes:
            agora.setTime(agora.getTime() + acerta);
            // Divide em ano, mes, dia etc.
                var ano = getFullYear(agora);
                var mes = mes_port[agora.getMonth()];
                var dia = agora.getDate();
        
                var data_cidade=((dia < 10) ? "0" : "") + dia +"/" +mes+"/" + ano + " - ";
        
                var hora = agora.getHours();
                var minuto = agora.getMinutes();
                var segundo = agora.getSeconds();
        
            var hora_cidade = ((((hora >12) ? hora -12 :hora) ) < 10 ? "0" : "") + ((hora >12) ? hora -12 :hora);
                hora_cidade += ((minuto < 10) ? ":0" : ":") + minuto;
                hora_cidade += ((segundo < 10) ? ":0" : ":") + segundo;
                hora_cidade += (hora >= 12) ? " PM" : " AM" ;
        
            // Lanca a data correta na pagina HTML.
            document.form.mostrador.value =data_cidade + hora_cidade;
        
            // Atualiza a cada segundo.
            contagemID = setTimeout("mostrarTempo (acerta)",1000);
        
                contagemAtivada = true;
        }
        
        function iniciar_relogio() {
            acerta=iniciaconta();
                mostrarTempo(acerta);
        }
        
        // -->
        
        </script>

</head>
<body OnLoad="iniciar_relogio()">
<div id="menu_topo">
<div id="logo_menu" style="text-align: center"><img
	src="../images/logo_menu.png" alt="Logo Menu" /></div>
<div id="menu-h">
<div style="float: left">
<ul class="menuh">
	<li id="submenu-110" class="subv"><a href="index.php"><img
		src="../images/icon/icon_pedido.png" style="border: 0" /> Meus Pedidos</a>
	</li>
	<li id="submenu-111" class="subv"><a href="sair.php"><img
		src="../images/icon/icon_sair.png" style="border: 0" /> Sair</a>
	</li>
</ul>
</div>

</div>
</div>
<br><br>
