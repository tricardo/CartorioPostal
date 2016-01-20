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
		<?
		switch($_GET['pag']){
			case 'video1';
			require_once('video1.php');
			break;

			case 'video2';
			require_once('video2.php');
			break;

			case 'video3';
			require_once('video3.php');
			break;

			case 'video4';
			require_once('video4.php');
			break;

			case 'video5';
			require_once('video5.php');
			break;

			case 'video6';
			require_once('video6.php');
			break;

			case 'video7';
			require_once('video7.php');
			break;

			case 'video8';
			require_once('video8.php');
			break;

			case 'video9';
			require_once('video9.php');
			break;

			case 'video10';
			require_once('video10.php');
			break;
		}
		?>

        <table width="100%" border="0" cellpadding="2" cellspacing="3" bgcolor="#FFFFFF">
          <tr>
            <td align="center" valign="middle" colspan="5">
				<img src="../images/paginas/logo-convencao.png" border="0">
			</td>
          </tr>
		  <tr>
			<td>
				<a href="#" title="Clique aqui para visualizar o 1º video"><img src="../images/paginas/video01.png" border="0"></a>
			</td>
			<td>
				<a href="?pag=video2" title="Clique aqui para visualizar o 2º video"><img src="../images/paginas/video02.png" border="0"></a>
			</td>
			<td>
				<a href="?pag=video3" title="Clique aqui para visualizar o 3º video"><img src="../images/paginas/video03.png" border="0"></a>
			</td>
			<td>
				<a href="?pag=video4" title="Clique aqui para visualizar o 4º video"><img src="../images/paginas/video04.png" border="0"></a>
			</td>
			<td>
				<a href="?pag=video5" title="Clique aqui para visualizar o 5º video"><img src="../images/paginas/video05.png" border="0"></a>
			</td>
		  </tr>
		   <tr>
			<td>
				<a href="?pag=video6" title="Clique aqui para visualizar o 6º video"><img src="../images/paginas/video06.png" border="0"></a>
			</td>
			<td>
				<a href="#" title="Clique aqui para visualizar o 7º video"><img src="../images/paginas/video07.png" border="0"></a>
			</td>
			<td>
				<a href="?pag=video8" title="Clique aqui para visualizar o 8º video"><img src="../images/paginas/video08.png" border="0"></a>
			</td>
			<td>
				<a href="?pag=video9" title="Clique aqui para visualizar o 9º video"><img src="../images/paginas/video09.png" border="0"></a>
			</td>
			<td>
				<a href="#" title="Clique aqui para visualizar o 10º video"><img src="../images/paginas/video10.png" border="0"></a>
			</td>
		  </tr>
		  <tr>
		  <td colspan="5">
			
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