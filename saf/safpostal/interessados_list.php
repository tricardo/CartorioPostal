<?
require "../includes/topo.php";
$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$dt  = new ListaInteressadosDAO();?>
<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
	<td colspan="3" height="2"></td>
  </tr>
  <tr>
	<td width="152" align="left" valign="top">
		<? require "menu_lateral.php"; ?>
	</td>
	<td width="2"></td>
	<td align="left" valign="top">
    	<div style="height:20px; width:766px; background-image:url(../images/paginas/index/barra_de_titulo1.png); background-position:left bottom; background-repeat:no-repeat;">
        	<p style="float:left; margin:0; margin-top:3px; width:322px; font-weight:bold;">Lista de Interessados</p>
            <p style="float:left; margin:0; margin-top:3px; margin-left:28px; width:416px; font-weight:bold; font-weight:bold">
            	Franquia: <? echo $safpostal_fantasia ?></p>
        </div>
        <div style="height:54px; width:766px; float:left;">
        	<div style="margin:0; width:766px; height:25px; margin-top:15px; background-color:#F5F5F5; border-bottom:solid 1px #0071B6; float:left;">
            	<p style="margin:0; margin-top:7px; font-weight:bold">
                	Cadastros preenchidos pelo site
                    <img src="../images/null.gif" width="1" height="1" border="0" onload="listarInteressados(3, 18, 1, 20);" />
                </p>
            </div>
        </div>
        <form action="#Interessados" method="post" onsubmit="listarInteressados(3, 18, 1, 20); return false;"> 
        <div style="float:left; width:766px; margin-top:-5px;">
        	<p style="float:left; font-weight:bold; margin-top:15px;">Estado:</p>
            <p style="float:left; margin-left:10px;">
            	<select name="estado_interesse" id="estado_interesse" onchange="carrega_cidades_interessados(3, this.value, 18);" class="form_estilo">
                    <option value=""></option>
                    <? $e = $dt->buscaEstadoInteresse(18);
					foreach($e as $j => $uf){
						echo '<option value="'.$uf->estado_interesse.'">'.$uf->estado_interesse.'</option>'."\n";
					} ?>
                </select>
            </p>
            <p style="float:left; font-weight:bold; margin-top:15px; margin-left:10px;">Cidade:</p>
            <p id="d_cidade_interesse" style="float:left; margin-top:11px; margin-left:10px;">
                <select class="form_estilo" style="width:240px;">
                    <option value=""></option>
                </select>
            </p>
			<p style="float:left; font-weight:bold; margin-top:15px; margin-left:10px;">Nome:</p>
            <p style="float:left; margin-left:10px;">
            	<input type="text" name="nome" id="nome" class="form_estilo" style="width:240px;" maxlength="50" />
            </p>
            <p style="float:left; margin:0;"><input type="submit" name="button" id="button" value="Buscar" class="form_submit" style="width:75px;" /></p>
			<p style="float:left; margin:0;"><input type="reset" name="rst" id="rst" value="Limpar" style="width:75px; margin-left:10px;" /></p>
        </div>
        </form>
        <div style="margin-top:10px; width:766px; float:left">
        	<div style="width:761px;" id="listar"></div>
        </div>
    </td>
  </tr>
</table>
<?
require "../includes/rodape.php";
?>