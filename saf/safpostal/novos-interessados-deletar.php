<?
require "../includes/topo.php";
$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$c      = new stdClass();
$ficha  = new FichaDAO();
foreach($_POST as $cp => $valor){ $c->$cp = $valor; }

if($c->usuario > 0){
	if($c->id_ficha){
		for($i = 0; $i < count($c->id_ficha); $i++){
			$sql = $ficha->direcionaUsuario($c->id_ficha[$i], $c->usuario);
		}
	} else {
		$msg = '<div style="color:#FF0000;">Você deve selecionar um consultor e pelo menos 1 interessado.</div>';
	}
}
$c->id_usuario = $safpostal_id_usuario; ?>
<div id="principal">
	<div style="width:152px;"><? require "menu_lateral.php"; ?></div>
	<div style="width:768px;">
	  <div id="titulo">
			<div id="titulo1">&nbsp;&nbsp;Novos Interessados</div>
			<div id="titulo2">Franquia: <? echo $safpostal_fantasia ?></div>
	  </div>
      <? if($safpostal_id_usuario == 1 || $safpostal_id_usuario == 56 || $safpostal_id_usuario == 272){?>
        <form id="form1" name="form1" action="" method="post">
        <table width="100%" border="0" cellspacing="2" cellpadding="0" style="float:left; color:#333;">
          <tr>
          	<td colspan="7"><?=$msg?></td>
          </tr>
          <tr>
            <td height="30" colspan="7">
            	Consultor: 
                <select id="usuario" name="usuario" class="form_estilo" style="width:612px;">
                	<option value="0">--</option>
                	<? $dt = $objQuery->SQLQuery("SELECT * FROM vsites_user_usuario as uu WHERE status='Ativo' AND id_empresa=".$safpostal_id_empresa." ORDER BY nome");
					$res = mysql_fetch_array($dt); 
					while($res = mysql_fetch_array($dt)){?>
                    	<option value="<?=$res['id_usuario']?>"><?=ucwords(strtolower($res['nome'])).' ['.$res['id_usuario'].']'?></option>
                    <? }?>
                </select>
                
                <input type="submit" value="Direcionar" name="btn" id="btn" class="form_estilo" style="width:80px; height:20px; text-align:center; vertical-align:middle;" />
            </td>
          </tr>
          <? 
		  $dt = $ficha->site_ficha_cadastro($c); $i = 0;
		  if($dt[0][0]->Total > 0){?>
          <tr>
            <td colspan="7">Foram encontrado(s) <?=$dt[0][0]->Total?> registro(s).</td>
          </tr>          
          <tr style="background-color:#CEEDFF; text-align:center; font-weight:bold;">
            <td class="td1"><img src="../images/estrutura/botoes/check2.png" id="checkbox_buttom" onclick="CheckAll('id_ficha[]');" /></td>
            <td class="td1" style="text-align:left">&nbsp;Nome</td>
            <td class="td1" style="text-align:left">&nbsp;E-mail</td>
            <td class="td1">Telefone</td>
            <td class="td1">Cidade / UF</td>
            <td class="td1">Cadastro<input type="hidden" value="1" name="checkbox_image" id="checkbox_image" /></td>
            <td class="td1">&nbsp;</td>
          </tr>
		  <? foreach($dt[1] as $resultado => $e){
		  	$data  = explode('-', $e->data);
			$color = ($color == '#FFF') ? '#EAF8FF' : '#FFF'; ?>
          <tr style="background-color:<?=$color?>">
            <td class="td2"><input type="checkbox" class="form_estilo" value="<?=$e->id_ficha?>" id="id_ficha<?=$i?>" name="id_ficha[]" /></td>
            <td class="td2" style="text-align:left; height:20px;">&nbsp;<?=ucwords(strtolower($e->nome))?></td>
            <td class="td2" style="text-align:left">&nbsp;<?=strtolower($e->email)?></td>
            <td class="td2">&nbsp;<?=$e->tel_res?>&nbsp;</td>
            <td class="td2">&nbsp;<?=ucwords(strtolower($e->cidade_interesse)) .' / '.strtoupper($e->estado_interesse)?>&nbsp;</td>
            <td class="td2">&nbsp;<?=$data[2].'/'.$data[1].'/'.$data[0]?>&nbsp;</td>
            <td class="td2" style="width:21px; text-align:center"><a href="imprimir_ficha.php?id=<?=$e->id_ficha?>" target="_blank"><img src="../images/estrutura/botoes/imprimir.png" style="width:15px; height:15px; border:0" /></a></td>
          </tr>
          <? $i++; }} else { ?>
          <tr>
            <td colspan="7" style="color:#FF000; text-align:center; height:25px">Nenhum registro encontrado.</td>
          </tr>
          <? } ?>
        </table>
        </form>
        <? } else { echo '<span style="color:#FF0000">Você não tem permissão para visualizar esta página.</span>'; }?>
  </div>
</div>
<? require "../includes/rodape.php"; ?>