<?
header("Content-Type: text/html; charset=ISO-8859-1",true);
include_once( "../includes/verifica_logado_conveniado.inc.php" );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
$_SESSION['pagina'] = 'ordem.php';

$busca 		  = 0;
$busca_data_i = date("d").'/'.date("m").'/'.(date("Y")-1);
$busca_data_f = date("d/m/Y");
$busca_id_pacote = 0;
if($_SESSION['form']){
	#$busca 					= $_SESSION['busca'];
	$cpf 				= $_SESSION['cpf'];
	$cnpj 				= $_SESSION['cnpj'];
	$outros 			= $_SESSION['outros'];
	$busca_data_i 			= $_SESSION['busca_data_i'];
	$busca_data_f 			= $_SESSION['busca_data_f'];
	$busca_controle_cliente         = $_SESSION['busca_controle_cliente'];
	$busca_id_pacote 		= $_SESSION['busca_id_pacote'];
	$busca_data_i_co 		= $_SESSION['busca_data_i_co'];
	$busca_data_f_co 		= $_SESSION['busca_data_f_co'];
	$busca_id_departamento          = $_SESSION['busca_id_departamento'];
	$busca_id_status 		= $_SESSION['busca_id_status'];
	$busca_ordenar 			= $_SESSION['busca_ordenar'];
	$busca_ord 			= $_SESSION['busca_ord'];
	$busca_id_servico 		= $_SESSION['busca_id_servico'];
	$busca_id_pedido 		= $_SESSION['busca_id_pedido'];
	$busca_ordem 			= $_SESSION['busca_ordem'];
}
?>
<form onsubmit="return Pesquisa(this.id, 'carrega_pesquisa.php');" id="form1" name="form1" method="post">
<table cellspacing="0" cellpadding="0" border="0" id="titulo">
  <tr>
    <td>Ordem</td>
  </tr>
</table>
<table cellspacing="0" cellpadding="0" border="0" id="fldset">
 <tr>
  	<td>Pesquisa</td>
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
            	<strong>Tipo de Busca:</strong><br />
                <select name="busca" id="busca" style="width:200px;" class="form_estilo" onchange="HabilitaCampo(this.value, 'busca');">
				<? $bsc = array('', 'Nome', 'CPF ou CNPJ', 'CPF ou CNPJ do Devedor', 'Nome do Devedor', 'Nome do Avalista', 'Matrícula'); 
				$select = '';
                for($i = 0; $i < count($bsc); $i++){
                    $select .= '<option value="'.$i.'" ';
                    $select .= ($busca == $i) ? 'selected="selected"' : ''; 
                    $select .= '>'.$bsc[$i].'</option>' . " \n";
                 }
				 echo $select;?>
                </select>
            </td>
            <td style="width:10px;"></td>
            <td>
            	<strong>Buscar:</strong><br />
                <span id="cp"><input onclick="javascript:if(document.getElementById('busca').value == 0){alert('Defina um tipo de busca!'); document.getElementById('busca').focus();}" type="text" id="buscador" name="buscador" class="form_estilo" style="width:210px;" readonly="readonly" /></span>
            </td>
            <td style="width:10px;"></td>
            <td>
            	<strong>Iniciado entre:</strong><br />
                <input type="text" value="<?=$busca_data_i?>" name="busca_data_i" id="busca_data_i" class="form_estilo" style="width:100px;" maxlength="10" readonly="readonly" />
            </td>
            <td>
            	&nbsp;<br /><img src="images/calendario.png" border="0" id="idata0" name="idata" class="calendario-images" onclick="Calendario('busca_data_i');" />
            </td>
            <td style="width:10px;"></td>
            <td>
            	&nbsp;<br /><input type="text"value="<?=$busca_data_f?>" name="busca_data_f" id="busca_data_f" class="form_estilo" style="width:100px;" maxlength="10" readonly="readonly" /></td>
            <td>
            	&nbsp;<br /><img src="images/calendario.png" border="0" id="idata1" name="idata" class="calendario-images" onclick="Calendario('busca_data_f');" />
            </td>
            <td style="width:10px;"></td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td colspan="11" style="height:10px;"></td>
          </tr>
          <tr>
            <td style="width:20px;"></td>
            <td>
            	<strong>Nº Controle:</strong><br /> 
                <input type="text" value="<?=$busca_controle_cliente?>" class="form_estilo" id="busca_controle_cliente" name="busca_controle_cliente" style="width:200px;" maxlength="100" />
            </td>
            <td style="width:10px;"></td>
            <td>
            	<strong>Pacote:</strong><br />
                <select name="busca_id_pacote" id="busca_id_pacote" style="width:210px;" class="form_estilo">
                    <option value="">Todos</option>
					<option value="1" <? if((int) $busca_id_pacote == 1){?> selected="selected" <? }?>>Imóveis/Detran</option>
                </select>
            </td>
            <td style="width:10px;"></td>
            <td>
            	<strong>Conc. Oper.:</strong><br />
                <input type="text" name="busca_data_i_co" id="busca_data_i_co" value="<?=$busca_data_i_co?>" style="width:100px;" class="form_estilo" maxlength="10" readonly="readonly" />
            </td>
            <td>
            	&nbsp;<br /><img src="images/calendario.png" border="0" id="idata2" name="idata" class="calendario-images" onclick="Calendario('busca_data_i_co');" />
            </td>
            <td style="width:10px;"></td>
            <td>
            	&nbsp;<br /><input type="text" name="busca_data_f_co" id="busca_data_f_co" value="<?=$busca_data_f_co?>" style="width:100px;" class="form_estilo" maxlength="10" readonly="readonly" />
            </td>
            <td>
            	&nbsp;<br /><img src="images/calendario.png" border="0" id="idata3" name="idata" class="calendario-images" onclick="Calendario('busca_data_f_co');" />
            </td>
            <td style="width:10px;"></td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td colspan="8" style="height:10px;"></td>
          </tr>
          <tr>
            <td style="width:20px;"></td>
            <td>
            	<strong>Departamento:</strong><br />
                <select name="busca_id_departamento" id="busca_id_departamento" style="width:200px" class="form_estilo">
					<option value="">Todos</option>
                    <? $DepartamentoDAO = new DepartamentoDAO();
					$departamento = $DepartamentoDAO->carregarCombo();
					$select = '';
					foreach($departamento as $d => $dpt){
                    	$select .= '<option value="'.$dpt->id_servico_departamento.'" ';
						$select .= ($busca_id_departamento == $dpt->id_servico_departamento) ? 'selected="selected"' : ''; 
						$select .= '>'.ucwords(trim(strtolower($dpt->departamento))).'</option>' . " \n";
                    }
					echo $select;?>
                </select>
            </td>
            <td style="width:10px;"></td>
            <td>
            	<strong>Status:</strong><br />
                <select name="busca_id_status" id="busca_id_status" style="width:210px" class="form_estilo">
					<option value="">Todos</option>
                    <option value="Cad/Sol/Des/Exe/Ret" <? if($busca_id_status == 'Cad/Sol/Des/Exe/Ret'){?> selected="selected" <? }?>>Cad/Sol/Des/Exe/Ret</option>
                    <? $StatusDAO = new StatusDAO();
					$status = $StatusDAO->carregarCombo();
					$select = '';
					foreach($status as $s => $st){
						$select .= '<option value="'.$st->id_status.'" ';
						$select .= ($busca_id_status == $st->id_status) ? 'selected="selected"' : ''; 
						$select .= '>'.ucwords(trim(strtolower($st->status))).'</option>';
                     }
					 echo $select?>
                </select>
            </td>
            <td style="width:10px;"></td>
            <td>
            	<strong>Ordenando por:</strong><br />
                <select name="busca_ordenar" id="busca_ordenar" style="width:180px" class="form_estilo">
                    <option value="Ordem" <? if($busca_ordenar == 'Ordem'){?> selected="selected" <? }?>>Ordem</option>
                    <option value="Documento de" <? if($busca_ordenar == 'Documento de'){?> selected="selected" <? }?>>Documento de</option>
                    <option value="Data" <? if($busca_ordenar == 'Data'){?> selected="selected" <? }?>>Data</option>
                    <option value="Serviço" <? if($busca_ordenar == 'Serviço'){?> selected="selected" <? }?>>Serviço</option>
                    <option value="Estado" <? if($busca_ordenar == 'Estado'){?> selected="selected" <? }?>>Estado</option>
                    <option value="Cidade" <? if($busca_ordenar == 'Cidade'){?> selected="selected" <? }?>>Cidade</option>
                </select>
            </td>
            <td>
            	&nbsp;<br />
                <select name="busca_ord" id="busca_ord" style="width:69px" class="form_estilo">
					<option value="ASC" <? if($busca_ord == 'ASC'){?> selected="selected" <? }?>>Cres</option>
					<option value="DESC" <? if($busca_ord == 'DESC'){?> selected="selected" <? }?>>Decr</option>
                </select>
            </td>
            <td style="width:10px;"></td>
          </tr>
        </table>
    </td>
  </tr>
  <tr>
    <td>
    	<table cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td colspan="9" style="height:10px;"></td>
          </tr>
          <tr>
            <td style="width:20px;"></td>
            <td>
				<strong>Serviço:</strong><br />
                <select name="busca_id_servico" id="busca_id_servico" style="width:200px;" class="form_estilo">
                    <option value="">Todos</option>
                    <? $ServicoDAO = new ServicoDAO();
					$servico = $ServicoDAO->carregarCombo();
					$select = '';
					foreach($servico as $s => $serv){
						$select .= '<option value="'.$serv->id_servico.'" ';
						$select .= ($busca_id_servico == $serv->id_servico) ? 'selected="selected"' : ''; 
						$select .= '>'.ucwords(trim(strtolower($serv->descricao))).'</option>';?>
                    <? }
					echo $select?>
                </select> 
            </td>
            <td style="width:10px;"></td>
            <td>
 				<strong>Ordem:</strong><br />
            	<input type="text" value="<?=$busca_id_pedido?>" maxlength="15" name="busca_id_pedido" id="busca_id_pedido" style="width:97px;" class="form_estilo" />
            </td>
            <td style="width:10px;"></td>
            <td>
				<strong>Serviço:</strong><br />
            	<input type="text" value="<?=$busca_ordem?>" maxlength="25" name="busca_ordem" id="busca_ordem" style="width:98px;" class="form_estilo" />
            </td>
            <td style="width:10px;"></td>
            <td>
				&nbsp;<br />
            	<input type="reset" name="rst" id="rst" class="button_busca" value="Limpar" onclick="LimparForm();" />
	        	<input type="submit" name="bsc" id="bsc" class="button_busca" value="Buscar" style="margin-left:13px;" />
            </td>
            <td style="width:10px;"></td>
          </tr>
          <tr>
            <td colspan="9" style="height:10px;"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
</form>
<div id="retorno" style="margin-top:10px;"></div>