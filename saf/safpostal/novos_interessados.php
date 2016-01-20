<?
require "../includes/topo.php";
$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$dt  = new ListaInteressadosDAO();
$dt1 = new StatusDAO();
$total_pagina = 20;
$idst = 0;?>
<div id="calendario"></div>
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
        	<p style="float:left; margin:0; margin-top:3px; width:322px; font-weight:bold;">Lista de Novos Interessados</p>
            <p style="float:left; margin:0; margin-top:3px; margin-left:28px; width:416px; font-weight:bold; font-weight:bold">Franquia: <? echo $safpostal_fantasia ?></p>
        </div>
        <div style="height:54px; width:766px; float:left;">
        	<div style="margin:0; width:766px; height:25px; margin-top:15px; background-color:#F5F5F5; border-bottom:solid 1px #0071B6; float:left;">
            	<p style="margin:0; margin-top:7px; font-weight:bold">
                	Cadastros preenchidos pelo site
                    <img src="../images/null.gif" width="1" height="1" border="0" onload="listarInteressados(2, <?=$idst?>, 1, <?=$total_pagina?>); Direcionamento(<?=$safpostal_id_empresa?>);" />
                </p>
            </div>
        </div>
        <form action="#Novos Interessados" method="post" onsubmit="VerData(2, <?=$idst?>, 1, <?=$total_pagina?>); return false;"> 
        <table width="765" border="0" cellspacing="0" cellpadding="0" style="float:left">
          <tr>
            <td>
            	<p style="float:left; font-weight:bold; margin-top:15px; margin-left:5px; width:78px">Usuário:</p>
                <p style="float:left; width:300px;" id="direcionamento"></p>
            
            	<p style="float:left; font-weight:bold; margin-top:15px; margin-left:5px; width:52px;">Nome:</p>
                <p style="float:left; width:300px;">
                    <input type="text" name="nome" id="nome" class="form_estilo" style="width:287px; margin-left:5px;" maxlength="50" />
                </p>
                
                
                <p style="float:left; font-weight:bold; margin-top:15px; margin-left:5px; width:78px;">Cidade:</p>
                <div style="float:left; width:298px">
                    <div id="d_cidade_interesse" style="float:left; margin-top:11px;">
                        <select class="form_estilo" style="width:298px;">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <p style="float:left; font-weight:bold; margin-top:15px; margin-left:10px;">Estado:</p>
                <p style="float:left; margin-left:5px;">
                    <select name="estado_interesse" id="estado_interesse" onchange="carrega_cidades_interessados(2, this.value, <?=$idst?>);" class="form_estilo">
                        <option value=""></option>
                        <? $e = $dt->buscaEstadoInteresse($idst);
                        foreach($e as $j => $uf){
                            echo '<option value="'.$uf->estado_interesse.'">'.$uf->estado_interesse.'</option>'."\n";
                        } ?>
                    </select>
                </p>
                <p style="float:left; font-weight:bold; margin-top:16px; margin-left:5px;">Status:</p>
                <p style="float:left;  margin-left:5px;">
                    <select name="id_status" id="id_status" class="form_estilo" style="width:190px;">
                        <option value=""></option>
                        <? $e = $dt1->listaStatus();
                        foreach($e as $j => $st){
                            if($st->id_status != 18){
                                echo '<option value="'.$st->id_status.'">'.$st->status.'</option>'."\n";
                            }
                        }?>
                    </select>
                </p> 
            </td>
          </tr>
          <tr>
            <td>
            	<p style="float:left; font-weight:bold; margin-left:5px; margin-top:8px;">Data de reunião<br />buscar:&nbsp;&nbsp;&nbsp; entre</p>
                <p style="float:left; margin-left:5px;">
                    <input type="text" name="data1" id="data1" class="form_estilo" style="width:100px;" maxlength="10" readonly="readonly" />
                </p>
                <p style="float:left;">
                    <a href="#Data1" onclick="Calendario('data1');"><img src="../images/calendario.png" border="0" id="idata1" style="margin-left:-1px; margin-top:2px;" /></a>
                </p>
                 <p style="float:left; font-weight:bold; margin-left:10px; margin-top:8px;">&nbsp;<br />a</p>
                 <p style="float:left; margin-left:5px;">
                    <input type="text" name="data2" id="data2" class="form_estilo" style="width:100px;" maxlength="10" readonly="readonly" />
                </p>
                <p style="float:left;">
                    <a href="#Data1" onclick="Calendario('data2');"><img src="../images/calendario.png" border="0" id="idata2" style="margin-left:-1px; margin-top:2px;" /></a>
                </p>
            </td>
          </tr>
          <tr>
            <td align="right" height="25"><p style="float:left; margin:0; margin-top:7px; margin-left:5px;">
                	<input type="submit" name="button" id="button" value="Buscar" style="width:75px; margin-left:5px;" />
            		<input type="reset" name="rst" id="rst" value="Limpar" style="width:75px;" />
                 </p></td>
          </tr>
        </table>
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