<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
require( "../includes/verifica_logado_safpostal.inc.php" );
require( '../includes/classQuery_sistecart.php' );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}

pt_register('GET','id');
$cor = '#FFF';
$dt = new StatusDAO(); 
$dt1 = new ListaInteressadosDAO();
$e = $dt->buscaHistorico($id);
$f = $dt1->buscaDataInclude($id);
if(count($e) > 0){
?>
<p align="right"><a href="#historico" onclick="VisualizarHistorico(0, 0);">X FECHAR HISTÓRICO</a></p>
<table width="756" border="0" cellspacing="2" cellpadding="0" style="border:solid 1px #0071B6; margin-top:5px;">
      <tr style="font-weight: bold; background:#95D8FF; font-size:10px;">
        <td width="180" height="20" style="border-bottom:solid 1px #0071B6;">&nbsp;&nbsp;STATUS ANTERIOR</td>
        <td width="131" style="border-bottom:solid 1px #0071B6;">&nbsp;&nbsp;ALTERADO POR:</td>
        <td width="229" style="border-bottom:solid 1px #0071B6;">&nbsp;&nbsp;OBSERVA&Ccedil;&Otilde;ES</td>
        <td width="85" align="center" style="border-bottom:solid 1px #0071B6;">REUNIÃO</td>
        <td width="117" align="center" style="border-bottom:solid 1px #0071B6;">INCLUS&Atilde;O</td>
      </tr>
	<? foreach($e as $j => $hst){?>
      <tr style="background:<?=$cor?>; font-size:10px;">
      	<td style="border-bottom:solid 1px #EFEFEF;">&nbsp;&nbsp;<?=$hst->status?></td>
        <td style="border-bottom:solid 1px #EFEFEF;">&nbsp;&nbsp;<?
        if($hst->id_user_alt == 0){
			echo 'Sistema';
		} else {
			$sql = $objQuery->SQLQuery("SELECT uu.nome, ue.fantasia FROM vsites_user_usuario as uu, vsites_user_empresa as ue WHERE uu.id_usuario=".$hst->id_user_alt);
			$row = mysql_fetch_array($sql);
			echo $row['nome'];
		}?></td>
        <td style="border-bottom:solid 1px #EFEFEF;"><div style="width:219px; margin-left:5px; font-weight:normal; text-transform:none; text-align:justify"><?=$hst->observacao?></div></td>
        <td align="center" style="border-bottom:solid 1px #EFEFEF;"><?
        switch($hst->id_status){
			case 5: case 10: 
			case 12: 
				$data = explode('-', $hst->data_reuniao);
				echo $data[2].'/'.$data[1].'/'.$data[0];
			break;
			
			default:
				echo '-';
		}?></td>
        <td align="center" style="border-bottom:solid 1px #EFEFEF;"><?
        if($hst->data_inclusao == '0000-00-00 00:00:00'){
			$data = explode('-', $f->data);
			echo $data[2].'/'.$data[1].'/'.$data[0];
		} else {
			$d = explode(' ', $hst->data_inclusao);
			$data = explode('-', $d[0]);
			$hora = explode(':', $d[1]);
			echo $data[2].'/'.$data[1].'/'.$data[0] . ' ' . $hora[0].':'.$hora[1];
		}
		?></td>
      </tr>
    <? 
	if($cor == '#FFF'){ $cor = '#FFEBAE'; } else { $cor = '#FFF'; }
	} ?>
</table>
<? } else {
	echo '<span style="color:#FF0000;">Nenhum registro cadastrado.</span>';
}?>
