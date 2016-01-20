<?php
if ($_POST['submit']) {
	require( "../includes/verifica_logado_ajax.inc.php");
	require( "../includes/funcoes.php" );
	require( "../includes/global.inc.php" );

	if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE' and verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' or $controle_id_empresa!=1){
		echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
		exit;
	}
	
	$b = new stdClass();
	foreach($_POST as $cp => $valor){ $b->$cp = htmlentities($valor); }

	#print_r($b);
	#exit();
	
	$chamadoDAO = new ChamadoDAO();
	$dt = $chamadoDAO->rel_chamado($b);
	if($dt[0] > 0){
		//adiciona classe para montar o excel
		require_once "../classes/spreadsheet_excel_writer/Writer.php";
		
		//monta o nome do arquivo 
		$arquivo = date('YmdHis').'.xls';
		
		$workbook =& new Spreadsheet_Excel_Writer();
		
		//seta o nome do arquivo e coloca send para ir para download
		$workbook->send($arquivo);
		
		//monta as abas da planilha	
		$worksheet =& $workbook->addWorksheet("RELATORIO");
		
		$estilo =  array(
			'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
			'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1
		);

		#1linha
		$worksheet->setMerge(0, 0, 0, 7);
		$worksheet->write(0, 0, 'Relatório de Sistecart - Sistema de Cartório Certidões S/C Ltda', $workbook->addFormat($estilo));
		
		#2linha
		$estilo['Size'] = 14;
		$worksheet->setMerge(1, 0, 1, 7);
		$mes1 = ($b->mes_i < 10) ? '0'.$b->mes_i : $b->mes_i;
		$mes2 = ($b->mes_f < 10) ? '0'.$b->mes_f : $b->mes_f;
		$info_t = 'Chamado de '. $mes1 .'/'.$b->ano_i.' a '.$mes2.'/'.$b->ano_f. ' - Total: '.$dt[0];
		$worksheet->write(1, 0, ''.$info_t.'', $workbook->addFormat($estilo));
		
		#3linha
		$estilo['Size'] = 13;
		$estilo['BgColor'] = 'silver';
		$estilo['Top'] = 1; 
		$estilo['Bottom'] = 1;
		$estilo['Left'] = 1; 
		$estilo['Right'] = 1;
		$estilo['BorderColor'] = 'black';
		$tam = array(20,30,30,30,50,20,20,20);
		$nome = array('Ordem','Usuário','Forma Atend.','Franquia','Pergunta','Abertura','Fechamento','Status');
		for($i = 0; $i < count($nome); $i++){ 
			$estilo['Width'] = $tam[$i]; 
			$worksheet->write(2, $i, $nome[$i], $workbook->addFormat($estilo)); 
		}
		
		#4linha
		$j = 3;
		$estilo['Size'] = 11;
		$estilo['BgColor'] = 'white';
		$estilo['Bold'] = 0;
		$estilo['Align'] = 'left';
		foreach($dt[1] as $c){
			$c->status = ($c->status==0) ?'Pendente' : $c->status='Resolvido';
			$dt = explode('-',$c->data_cadastro);
			$dt1 = substr($dt[2],0,2).'/'.$dt[1].'/'.$dt[0].' '.substr($dt[2],3,5);
			$dt2 = '-';
			if($c->data_atualizacao != '0000-00-00 00:00:00'){
				$dt = explode('-',$c->data_atualizacao);
				$dt2 = substr($dt[2],0,2).'/'.$dt[1].'/'.$dt[0].' '.substr($dt[2],3,5);
			}
			switch($c->forma_atend){
					case 1: $c->forma_atend = 'Telefone'; break;
					case 2: $c->forma_atend = 'E-mail'; break;
					case 3: $c->forma_atend = 'Skype'; break;
					default: $c->forma_atend = '-';
				}
			$nome = array($c->id_pedido.'/'.$c->ordem,$c->nome,$c->forma_atend,$c->franquia,$c->pergunta,$dt1,$dt2,$c->status);
			for($i = 0; $i < count($nome); $i++){
				$worksheet->write($j, $i, $nome[$i], $workbook->addFormat($estilo));	
			}
			$j++;
		}
		$workbook->close();
	} else {
		echo "<script>alert('Nenhum registro encontrado com esta forma de busca.'); location.href='rel_chamado.php';</script>";
	}
} else {
require('header.php');

$empresaDAO = new EmpresaDAO();
$usuarioDAO = new UsuarioDAO();

$empresas = $empresaDAO->listarTodas();
$usuarios = $usuarioDAO->listarAtivosDpto($controle_id_empresa,'17');
?>
<div id="topo">
    <h1 class="tit">
        <img src="../images/tit/tit_cartorio.png" alt="Título" />Relatório de Chamado</h1>
    <hr class="tit" />
    <br />
</div>
<div id="meio">
    <table border="0" height="100%" width="100%">
        <tr>
            <td valign="top">
                <form name="buscador" action="" method="post" ENCTYPE="multipart/form-data" target="_blank">
                    <div class="busca1">
                        <label>Pedido: </label>
                        <input type="text" class="form_estilo" name="id_pedido" value="" /> / 
                        <input type="text" class="form_estilo" name="ordem" value="" size="1" />
                        <br/>
                        <label>Franquia: </label>
                        <select name="id_empresa" style="width: 200px" class="form_estilo">
                            <option></option>
                            <?php foreach($empresas as $e){ ?>
                                <option value="<?=$e->id_empresa;?>"
                                <?=($b->id_empresa == $e->id_empresa)?'selected="selected"':''?>><?=$e->fantasia; ?></option>
                            <?php }?>
                        </select>
                        <label>Usuário: </label>
                        <select name="id_usuario" style="width: 200px" class="form_estilo">
                            <option></option>
                            <?php foreach($usuarios as $e){ ?>
                                <option value="<?=$e->id_usuario;?>"
                                <?=($b->id_usuario == $e->id_usuario)?'selected="selected"':''?>><?=$e->nome; ?></option>
                            <?php }?>
                        </select>
                        <br/>
                        <label>Status: </label>
                        <select name="status" style="width: 200px" class="form_estilo">
                            <option></option>
                            <option value="0">Pendente</option>
                            <option value="1">Resolvido</option>
                        </select>
                        <br>
                        <label>Aberto Entre: </label>
                        <select name="mes_i" id="mes_i" style="width:90px;" class="form_estilo">
                        	<?
                            $mes = array('janeiro','fevereiro','março','abril','maio','junho',
										 'julho','agosto','setembro','outubro','novembro','dezembro');
							$ano = array(); $j = 0;
							for($i = 2011; $i <= date(Y); $i++){ $ano[$j] = $i; $j++; }
							for($i = 0; $i < count($mes); $i++){ ?>
	                        	<option value="<?=$i+1?>" <?=(($i+1) == date('m')) ? 'selected="selected"' : ''?>><?=$mes[$i]?></option>
                            <? }?>
                        </select>
						<select name="ano_i" id="ano_i" style="width:60px;" class="form_estilo">
                        	<? for($i = 0; $i < count($ano); $i++){ ?>
	                        	<option value="<?=$ano[$i]?>" <?=($ano[$i] == date('Y')) ? 'selected="selected"' : ''?>><?=$ano[$i]?></option>
                            <? }?>
                        </select>
                        <b>e </b><br />
                        <select name="mes_f" id="mes_f" style="width:90px; margin-left:106px" class="form_estilo">
                        	<? for($i = 0; $i < count($mes); $i++){ ?>
								<option value="<?=$i+1?>" <?=(($i+1) == date('m')) ? 'selected="selected"' : ''?>><?=$mes[$i]?></option>
                            <? }?>
                        </select>
						<select name="ano_f" id="ano_f" style="width:60px;" class="form_estilo">
                        	<? for($i = 0; $i < count($ano); $i++){ ?>
	                        	<option value="<?=$ano[$i]?>" <?=($ano[$i] == date('Y')) ? 'selected="selected"' : ''?>><?=$ano[$i]?></option>
                            <? }?>
                        </select>
                        <br/>
                        <label>Forma de Atendimento: </label>
				<select name="forma_atend" style="width: 200px" class="form_estilo">
					<option value="0">--</option>
					<option <?=($b->forma_atend=="1")?'selected="selected"':'';?> value="1">Telefone</option>
					<option <?=($b->forma_atend=="2")?'selected="selected"':'';?> value="2">E-mail</option>
                    <option <?=($b->forma_atend=="3")?'selected="selected"':'';?> value="3">Skype</option>
				</select><br /><br/>
                        <input type="submit" name="submit" class="button_busca" value="Buscar" />
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
<?php require('footer.php'); } ?>
