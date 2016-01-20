<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
include_once( "../includes/verifica_logado_conveniado.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$_SESSION['pagina'] = 'editar-senha.php';
$_SESSION['form']   = '';

$ConveniadoDAO = new ConveniadoDAO();
$conveniado    = $ConveniadoDAO->selectPorId($conveniado_id_conveniado, '');
$senha = '';
if(count($conveniado) > 0){
	$senha = substr($conveniado->senha, 0, 12);
}
?>

<form onsubmit="return Pesquisa(this.id, 'carrega_senha.php');" id="form1" name="form1" method="post">
<table cellspacing="0" cellpadding="0" border="0" id="titulo">
  <tr>
    <td>Editar Senha</td>
  </tr>
</table>
<table cellspacing="0" cellpadding="0" border="0" id="fldset">
 <tr>
  	<td>Minha Senha</td>
  </tr>
</table>
<table cellspacing="0" cellpadding="0" style="border:solid 1px #999; width:744px;" id="nav">
  <tr>
    <td>
    	<table cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td colspan="11" style="height:10px;"></td>
          </tr>
          <tr>
            <td style="width:20px;"></td>
            <td>
            	<strong>Senha Atual:</strong><br />
                <input type="password" style="width:330px;" id="atual_senha" name="atual_senha" disabled="disabled" value="<?=$senha?>" class="form_estilo" />
			</td>
          </tr>
          <tr>
            <td style="width:20px;"></td>
            <td>
				
            	<strong>Nova Senha:</strong><br />
                <input type="password" name="nova_senha" id="nova_senha" value="" style="width:330px;" class="form_estilo" maxlength="40" />
			</td>
          </tr>
          <tr>
            <td style="width:20px;"></td>
            <td>
            	<strong>Confirme a Nova Senha:</strong><br />
                <input type="password" name="repetir_senha" id="repetir_senha" value="" style="width:330px;" class="form_estilo" maxlength="40" />
			</td>
          </tr>
          <tr>
            <td style="width:20px;"></td>
            <td>
	        	<input type="submit" id="altr" name="altr" class="button_busca" value="Alterar" style="margin-left:223px;" />
			</td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</td></tr></table>
</form>
<div id="retorno"></div>