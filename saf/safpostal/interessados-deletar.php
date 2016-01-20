<?
require "../includes/topo.php";
$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
$c      = new stdClass();
$ficha  = new FichaDAO();
$lista  = new ListaInteressadosDAO();
$status = new StatusDAO();
foreach($_POST as $cp => $valor){ $c->$cp = $valor; }

$c->acao = 1;
$t = 60;

if($c->lim){ 
	$c->lim1 = ($c->lim * $t) - $t; 
	$c->lim2 = $t - 1;
} else {
	$c->lim1 = 0; 
	$c->lim2 = $t;
	$c->lim  = 1;
}
$c->id_usuario = $safpostal_id_usuario; ?>
<div id="principal">
	<div style="width:152px;"><? require "menu_lateral.php"; ?></div>
	<div style="width:768px;">
	  <div id="titulo">
			<div id="titulo1">&nbsp;&nbsp;Interessados</div>
			<div id="titulo2">Franquia: <? echo $safpostal_fantasia ?></div>
	  </div>
      <? if($safpostal_id_usuario == 1 || $safpostal_id_usuario == 56 || $safpostal_id_usuario == 272){
	  	$mostrar = 1;
	  } else { $c->consultor = $safpostal_id_usuario; $mostrar = 0; } ?>
        <form id="form1" name="form1" action="" method="post">
        <table width="100%" border="0" cellspacing="2" cellpadding="0" style="float:left; color:#333;">
          <tr>
          	<td colspan="7">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="50%" height="30">Consultor:
                    <? if($mostrar == 1){ ?>
                    <select id="consultor" name="consultor" class="form_estilo" style="width:301px;">
                        <option value="0">--</option>
                        <? $dt = $objQuery->SQLQuery("SELECT * FROM vsites_user_usuario as uu WHERE status='Ativo' AND id_empresa=".$safpostal_id_empresa." ORDER BY nome");
                        $res = mysql_fetch_array($dt); 
                        while($res = mysql_fetch_array($dt)){?>
                            <option value="<?=$res['id_usuario']?>" <? if($c->consultor==$res['id_usuario']){?> selected="selected" <? } ?>>
                                <?=ucwords(strtolower($res['nome'])).' ['.$res['id_usuario'].']'; ?>
                            </option>
                        <? }?>
                    </select>
                    <? } else { ?>
                    <select id="consultor2" name="consultor2" class="form_estilo" style="width:301px;">
                    	<option value=""><?=$safpostal_nome?></option>
                    </select>
                    <? } ?>
                    </td>
                    <td>Nome: <input value="<?=$c->nome?>" type="text" name="nome" id="nome" class="form_estilo" style="width:333px; margin-left:4px;" maxlength="50" /></td>
                  </tr>
                  <tr>
                    <td height="30">Status: <select name="id_status" id="id_status" class="form_estilo" style="width:320px;">
                            <option value="0"></option>
                            <? $e = $status->listaStatus();
                            foreach($e as $j => $st){
                                if($st->id_status != 18){
									if($c->id_status == $st->id_status){
                                    	echo '<option value="'.$st->id_status.'" selected="selected">'.$st->status.'</option>'."\n";
									} else {
										echo '<option value="'.$st->id_status.'">'.$st->status.'</option>'."\n";
									}
                                }
                            }
							if($c->id_usuario == 1){
								if($c->id_status == 20){
									echo '<option value="20" selected="selected">Excluído</option>'."\n";
								} else {
									echo '<option value="20">Excluído</option>'."\n";
								}
							 }?>
                        </select>
                    </td>
                    <td><? $e = $ficha->ListarCidade($c);
					if(count($e) > 0){ ?>
                       Cidade: <select name="cidade" id="cidade" class="form_estilo" style="width:266px; margin-left:-3px;">
                       <option value=""></option>
                       <? foreach($e as $j => $ci){?>
                       		<option value="<?=trim(strtoupper($ci->cidade_interesse))?>" <? echo (strtolower(trim($ci->cidade_interesse)) == strtolower(trim($c->cidade))) ? 'selected="selected"' : '';?>><?=trim(strtoupper($ci->cidade_interesse))?></option>
                       <? }?>
                    </select><? }
                    $e = $ficha->ListarUF($c);
					if(count($e) > 0){ ?>
                       UF: <select name="uf" id="uf" class="form_estilo" style="width:40px;">
                       <option value=""></option>
                       <? foreach($e as $j => $uf){?>
                       		<option value="<?=trim(strtoupper($uf->estado_interesse))?>" <? echo ($uf->estado_interesse == $c->uf) ? 'selected="selected"' : '';?>><?=trim(strtoupper($uf->estado_interesse))?></option>
                       <? }?>
                    </select><? } else { echo '&nbsp;'; }?>
                    </td>
                  </tr>
                  <tr>
                    <td>Mês: <select id="mes" name="mes" class="form_estilo" style="width:217px;">
                    	<? $mes = array('','Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
						for($i = 0; $i < count($mes); $i++){ ?>
	                    	<option value="<?=$i?>" <? echo ($i == $c->mes) ? 'selected="selected"' : '';?>><?=$mes[$i]?></option>
                        <? }?>
                    </select>
                    <? $e = $ficha->ListarAno($c);
					if(count($e) > 0){ ?>
                       Ano: <select name="ano" id="ano" class="form_estilo" style="width:80px;">
                       <option value="0"></option>
                       <? foreach($e as $j => $a){?>
                       		<option value="<?=$a->data?>" <? echo ($a->data == $c->ano) ? 'selected="selected"' : '';?>><?=$a->data?></option>
                       <? }?>
                    </select><? } else { echo '&nbsp;'; }?></td>
                    <td align="right">
                    <input type="submit" value="Filtrar" name="btn" id="btn" class="form_estilo" 
                    style="width:80px; height:20px; text-align:center; vertical-align:middle;" /></td>
                  </tr>
                </table>
            </td>
          </tr>
          
          <? $dt = $ficha->site_ficha_cadastro($c); $i = 0;
		  if($dt[0][0]->Total > 0){?>
          <tr>
            <td colspan="7">Foram encontrado(s) <?=$dt[0][0]->Total?> registro(s).</td>
          </tr>          
          <tr style="background-color:#CEEDFF; text-align:center; font-weight:bold;">
            <td class="td1" style="text-align:left">&nbsp;Nome</td>
            <td class="td1">Consultor</td>
            <td class="td1">Cidade / UF</td>
            <td class="td1">Status</td>
            <td class="td1">Cadastro</td>
            <td class="td1">&nbsp;</td>
          </tr>
		  <? foreach($dt[1] as $resultado => $e){
		  	$data  = explode('-', $e->data);
			$color = ($color == '#FFF') ? '#EAF8FF' : '#FFF'; 
			$sql= "SELECT * FROM vsites_user_usuario as uu WHERE id_usuario=".$e->id_usuario;
			$dt2 = $objQuery->SQLQuery($sql);
			$res = mysql_fetch_array($dt2); ?>
          <tr style="background-color:<?=$color?>"
          onmouseover="this.style.backgroundColor='#FFCC66'"
          onmouseout="this.style.backgroundColor='<?=$color?>'"
          title="Clique na linha para visualizar este registro.">
            <td onclick="javascript:location.href='interessados_edit.php?id=<?=$e->id_ficha?>'" class="td2" style="text-align:left; height:20px; cursor:pointer;">&nbsp;<?=ucwords(strtolower($e->nome))?></td>
            <td onclick="javascript:location.href='interessados_edit.php?id=<?=$e->id_ficha?>'" class="td2" style="text-align:center; cursor:pointer;">&nbsp;<?=ucwords(strtolower($res['nome']))?>&nbsp;</td>
            <td onclick="javascript:location.href='interessados_edit.php?id=<?=$e->id_ficha?>'" class="td2" style="cursor:pointer; text-align:center">&nbsp;<?
            echo strtoupper(substr(trim($e->cidade_interesse), 0, 20));
			echo (strlen($e->estado_interesse) > 0 && strlen($e->cidade_interesse) > 0) ? ' / ' : '&nbsp;';
			echo strtoupper($e->estado_interesse); ?>&nbsp;</td>
            <td onclick="javascript:location.href='interessados_edit.php?id=<?=$e->id_ficha?>'" class="td2" style="text-align:center; cursor:pointer;"><?=strtoupper(substr($e->status, 0, 12))?></td>
            <td onclick="javascript:location.href='interessados_edit.php?id=<?=$e->id_ficha?>'" class="td2" style="text-align:center; cursor:pointer;"><?=$data[2].'/'.$data[1].'/'.$data[0]?></td>
            <td class="td2" style="width:21px; text-align:center"><a href="imprimir_ficha.php?id=<?=$e->id_ficha?>" target="_blank"><img src="../images/estrutura/botoes/imprimir.png" style="width:15px; height:15px; border:0" /></a></td>
          </tr>
          <? $i++; } 
          $total = $dt[0][0]->Total / $c->lim2;
		  if(strpos($total,'.')){ $total = (int)$total + 1; }
		  if($total > 1){?>
          <tr>
            <td colspan="7" style="text-align:center; font-size:10px;"><?
				for($i = 1; $i <= $total; $i++){ 
					if($c->lim == $i){?>
                		<label class="bt_lk1"><?=$i?></label> | 
                    <? }else {?>
                    	<input type="button" class="bt_lk" onclick="document.getElementById('lim').value=<?=$i?>; this.form.submit();" value="<?=$i?>" /> | 
                <? }}?><input type="hidden" id="lim" name="lim" /></td>
          </tr> 
          <? }} else { ?>
          <tr>
            <td colspan="7" style="color:#FF000; text-align:center; height:25px">Nenhum registro encontrado.</td>
          </tr>
          <? } ?>
        </table>
        </form>
  </div>
</div>
<? require "../includes/rodape.php"; ?>