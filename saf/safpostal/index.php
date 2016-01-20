<?
require "../includes/topo.php";
?>
<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3" height="2"></td>
    </tr>
  <tr>
    <td width="150" align="left" valign="top">
    <table width="150" border="0" cellspacing="0" cellpadding="0" align="left">
      <tr>
        <td><? require "menu_lateral.php"; ?></td>
      </tr>
    </table>
    </td>
    <td width="2"></td>
    <td align="left" valign="top"><table width="768" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="764" align="center" valign="top" background="../images/paginas/index/barra_de_titulo1.png"><table width="768" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="345" height="20" align="left" valign="middle"><strong>Página inicial</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center" valign="middle">
        <table border="0" cellpadding="0" cellspacing="0" bgcolor="#0071B6">
        <tr>
        <td bgcolor="#FFFFFF">
		<? 
		$evento='';
		if($evento<>''){ 
			require('evento.php');
		} else { 
		?>

        <table width="100%" border="0" cellpadding="2" cellspacing="10" bgcolor="#FFFFFF">
          <tr>
            <td height="126" colspan="2" align="center" valign="middle" background="../images/paginas/index/fundo2.png"><strong>Central de Ajuda</strong><br />
              <br />
              A Central de Ajuda tem o objetivo de resolver todos os incidentes  e problemas que os franqueados possam ter. Escolha o departamento desejado para  abrir um pedido.<br />
              Fale em tempo real com um de nossos  departamentos.<br />
              O Atendimento On-Line &eacute; das 09 &agrave;s 17 horas, de 2&ordf; a 6&ordf; feira.</td>
            </tr>
          <tr>
            <td width="50%" height="126" align="center" valign="middle" background="../images/paginas/index/fundo1.png"><strong>Perguntas e Respostas<br />
              <br />
            </strong>Acesse as perguntas mais frequentes  sobre produtos e servi&ccedil;os oferecidos pelo Cart&oacute;rio Postal e encontre as  respostas para suas d&uacute;vidas. Caso n&atilde;o consiga resolver sua dificuldade, entre  em contato com nossa central de atendimento atrav&eacute;s de email, suporte online ou  telefone.              </td>
            <td width="50%" align="center" valign="middle" background="../images/paginas/index/fundo1.png"><strong>&Aacute;rea de Downloads</strong><br />
              <br />
              Baixe materiais institucionais como manuais,  apresenta&ccedil;&otilde;es corporativas, imagens, boletos entre outros.</td>
          </tr>
          <tr>
            <td height="126" align="center" valign="middle" background="../images/paginas/index/fundo1.png"><strong>Informativos<br />
              <br />
            </strong>
              Conhe&ccedil;a todos os informativos  distribu&iacute;dos para a rede franqueada, contendo novidades sobre os produtos e  servi&ccedil;os oferecidos.</td>
            <td align="center" valign="middle" background="../images/paginas/index/fundo1.png"><p><strong>Rede de Franqueados</strong><br />
              <br />
              Telefones e endere&ccedil;os da rede  franqueada.</td>
          </tr>
        </table>
		<? } ?>
        </td>
        </tr>
        </table>
        </td>
      </tr>
    </table></td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>