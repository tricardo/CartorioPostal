<?
require "../includes/topo.php";
$permissao = verifica_permissao('EXPANSAO',$safpostal_departamento_saf);
if($permissao == 'FALSE' or $safpostal_id_empresa!='1'){ 
	echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
	exit;
}
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
            <td width="345" height="20" align="left" valign="middle"><strong>Novos Interessados</strong></td>
            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td align="center" valign="middle">
		
		<?

		pt_register('POST','submit1');

	if ($submit1){
		$errors=0;
		$error="<b>Ocorreram os seguintes erros:</b> ";
		
		pt_register('GET','id');
		pt_register('POST','nome');
		pt_register('POST','rg');
		pt_register('POST','cpf');
		pt_register('POST','email');
		pt_register('POST','nascimento');
		pt_register('POST','tel_res');
		pt_register('POST','tel_rec');
		pt_register('POST','tel_cel');
		pt_register('POST','estado_civil');
		pt_register('POST','filhos');
		pt_register('POST','filhos_quant');
		pt_register('POST','endereco');
		pt_register('POST','numero');
		pt_register('POST','complemento');
		pt_register('POST','bairro');
		pt_register('POST','cep');
		pt_register('POST','estado');
		pt_register('POST','cidade');
		pt_register('POST','cargo');
		pt_register('POST','empresa_t');
		pt_register('POST','historico');
		pt_register('POST','escolaridade');
		pt_register('POST','cursos');
		pt_register('POST','negocios');
		pt_register('POST','empresa_p');
		pt_register('POST','ramo_at');
		pt_register('POST','periodo');
		pt_register('POST','funcionarios');
		pt_register('POST','faturamento');
		pt_register('POST','capital');
		pt_register('POST','valor_disp');
		pt_register('POST','emprestimo');
		pt_register('POST','capital_terc');
		pt_register('POST','inicio_neg');
		pt_register('POST','dedicado_franq');
		pt_register('POST','fonte_renda');
		pt_register('POST','socios');
		pt_register('POST','caixa_empresa');
		pt_register('POST','conheceu_cp');
		pt_register('POST','unidades');
		pt_register('POST','unidades_valor');
		pt_register('POST','comunicados');
		pt_register('POST','interesse');
		pt_register('POST','tel_cel');
		pt_register('POST','estado_interesse');
		pt_register('POST','cidade_interesse');
		pt_register('POST','observacao');
		pt_register('POST','observacao_expansao');
		pt_register('POST','ficha_enviada');
		pt_register('POST','status');

		if($nome=="" || $email=="" || $tel_res==""){
		$errors=1;
		$error.="<span style='color:#FF0000'>Os campos com * são obrigatórios.</samp>";
		}


			if($errors!=1) {
			$query="UPDATE site_ficha_cadastro SET nome='$nome', rg='$rg', cpf='$cpf', email='$email', nascimento='$nascimento',tel_res='$tel_res', tel_rec='$tel_rec', tel_cel='$tel_cel',
			estado_civil='$estado_civil', filhos='$filhos', filhos_quant='$filhos_quant', endereco='$endereco', numero='$numero', complemento='$complemento', 
			bairro='$bairro', cep='$cep', estado='$estado', cidade='$cidade', cargo='$cargo', empresa_t='$empresa_t', historico='$historico', escolaridade='$escolaridade', 
			cursos='$cursos', negocios='$negocios', empresa_p='$empresa_p', ramo_at='$ramo_at', periodo='$periodo', funcionarios='$funcionarios', faturamento='$faturamento', 
			capital='$capital', valor_disp='$valor_disp', emprestimo='$emprestimo', capital_terc='$capital_terc', inicio_neg='$inicio_neg', 
			dedicado_franq='$dedicado_franq', fonte_renda='$fonte_renda', socios='$socios', caixa_empresa='$caixa_empresa', conheceu_cp='$conheceu_cp', 
			unidades='$unidades', unidades_valor='$unidades_valor', comunicados='$comunicados', interesse='$interesse', rg='$rg', estado_interesse='$estado_interesse', 
			cidade_interesse='$cidade_interesse', observacao='$observacao', observacao_expansao='$observacao_expansao', ficha_enviada='$ficha_enviada', status='$status', data_impressao=NOW() WHERE id_ficha='$id'";
	
			$result = $objQuery_sistecart->SQLQuery($query);
			$id = $objQuery_sistecart->ID;
			$done=1;
			}
	}
?>

<?
        if($done!=1){
		pt_register('GET','id');
		$sql = $objQuery_sistecart->SQLQuery("SELECT * FROM site_ficha_cadastro WHERE id_ficha='" . $id . "'");
		$res = mysql_fetch_array($sql);
		$id_ficha				= $res['id_ficha'];
		$nome					= $res['nome'];
		$rg						= $res['rg'];
		$cpf					= $res['cpf'];
		$email					= $res['email'];
		$nascimento				= $res['nascimento'];
		$tel_res				= $res['tel_res'];
		$tel_rec				= $res['tel_rec'];
		$tel_cel				= $res['tel_cel'];
		$estado_civil			= $res['estado_civil'];
		$filhos					= $res['filhos'];
		$filhos_quant			= $res['filhos_quant'];
		$endereco				= $res['endereco'];
		$numero					= $res['numero'];
		$complemento			= $res['complemento'];
		$bairro					= $res['bairro'];
		$cep					= $res['cep'];
		$estado					= $res['estado'];
		$cidade					= $res['cidade'];
		$cargo					= $res['cargo'];
		$empresa_t				= $res['empresa_t'];
		$historico				= $res['historico'];
		$escolaridade			= $res['escolaridade'];
		$cursos					= $res['cursos'];
		$negocios				= $res['negocios'];
		$empresa_p				= $res['empresa_p'];
		$ramo_at				= $res['ramo_at'];
		$periodo				= $res['periodo'];
		$funcionarios			= $res['funcionarios'];
		$faturamento			= $res['faturamento'];
		$capital				= $res['capital'];
		$valor_disp				= $res['valor_disp'];
		$emprestimo				= $res['emprestimo'];
		$capital_terc			= $res['capital_terc'];
		$inicio_neg				= $res['inicio_neg'];
		$dedicado_franq			= $res['dedicado_franq'];
		$fonte_renda			= $res['fonte_renda'];
		$socios					= $res['socios'];
		$caixa_empresa			= $res['caixa_empresa'];
		$conheceu_cp			= $res['conheceu_cp'];
		$unidades				= $res['unidades'];
		$unidades_valor			= $res['unidades_valor'];
		$comunicados			= $res['comunicados'];
		$interesse				= $res['interesse'];
		$estado_interesse		= $res['estado_interesse'];
		$cidade_interesse		= $res['cidade_interesse'];
		$observacao				= $res['observacao'];
		$observacao_expansao	= $res['observacao_expansao'];
		$ficha_enviada			= $res['ficha_enviada'];
		$status					= $res['status'];
		?>

			<table align="center" border="0" cellpadding="3" cellspacing="0" width="600">
			<tr>
			<td align="center">
			<?
			if ($errors) {
			echo '<div class="respotas_erro">'.$error.'</div>';
			}
			?>
			
			<?
			if ($done) {
			echo '<div id="respotas_sucesso" style="font-size:16px">O cadastro foi atualizado com sucesso!</div>';
			}	  
			?>        
			</td>
			</tr>    
			</table>		
			<form name="form_interesse" action="" method="post" enctype="multipart/form-data">
			<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
			<td height="20"></td>
			</tr>
			<tr>
			<td height="30" align="center" valign="middle" bgcolor="#0071B6" style="color:#FFFFFF"><strong>CADASTRO DE NOVOS INTERESSADOS</strong></td>
			</tr>
			<tr>
			<td height="6" align="center" valign="midlle"></td>
			</tr>
			<tr>
			<td height="30" align="left" valign="middle" bgcolor="#95D8FF">DADOS PESSOAIS</td>
			</tr>
			<tr>
			<td align="left" valign="middle"><br>
			<span style="margin-left:0px"><strong>NOME:</strong></span> <span style="margin-left:422px"><strong>NASCIMENTO:</strong></span> <span style="margin-left:1px"><strong>RG:</strong></span> <span style="margin-left:60px"><strong>CPF:</strong></span><br>
			<span style="margin-left:0px"><input name="nome" type="text" value="<?= $nome ?>" style="width:455px"/></span><samp style="color:#FF0000"></samp>
			<span style="margin-left:0px"><input name="nascimento" type="text" value="<?= $nascimento ?>" style="width:84px" onKeyUp="masc_numeros(this,'##/##/####');"/></span><samp style="color:#FF0000"></samp>
			<span style="margin-left:0px"><input name="rg" type="text" value="<?= $rg ?>" style="width:75px" onKeyUp="masc_numeros(this,'##.###.###-#');"/></span><samp style="color:#FF0000"></samp>
			<span style="margin-left:0px"><input name="cpf" type="text" value="<?= $cpf ?>" style="width:90px" onKeyUp="masc_numeros(this,'###.###.###-##');"/></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px"><strong>EMAIL:</strong></span> <span style="margin-left:323px"><strong>ESTADO CIVIL:</strong></span> <span style="margin-left:33px;"><strong>POSSUI FILHOS?</strong></span> <span style="margin-left:7px;"><strong>QUANTOS?</strong></span><br>
			<span style="margin-left:0px"><input name="email" type="text" value="<?= $email ?>" style="width:362px"/></span><samp style="color:#FF0000"></samp>

			<select name="estado_civil" style="width:119px">
			<option value="">.:SELECIONE:.</option>
			<option value="Casado(a)" <? if($estado_civil=='Casado(a)') echo 'selected'; ?>>Casado(a)</option>
			<option value="Solteiro(a)" <? if($estado_civil=='Solteiro(a)') echo 'selected'; ?>>Solteiro(a)</option>
			<option value="Viuvo(a)" <? if($estado_civil=='Viuvo(a)') echo 'selected'; ?>>Viuvo(a)</option>
			<option value="Separado(a)" <? if($estado_civil=='Separado(a)') echo 'selected'; ?>>Separado(a)</option>
			<option value="Divorciado(a)" <? if($estado_civil=='Divorciado(a)') echo 'selected'; ?>>Divorciado(a)</option>
			<option value="Amasiado(a)" <? if($estado_civil=='Amasiado(a)') echo 'selected'; ?>>Amasiado(a)</option>
			</select><samp style="color:#FF0000"></samp>

			<span style="margin-left:2px"><input name="filhos" type="radio" value="Sim" <? if($filhos=='Sim') echo 'checked'; ?> style="margin-left:2px;"/><strong>SIM</strong><input name="filhos" type="radio" value="Não" <? if($filhos=='Não') echo 'checked'; ?>/><strong>NÃO</strong></span>
			<span style="margin-left:30px"><input name="filhos_quant" type="text" value="<?= $filhos_quant ?>" style="width:60px" onKeyUp="masc_numeros(this,'##');"/></span><br><br>
			</td>
			</tr>
			<tr>
			<td height="30" align="left" valign="middle" bgcolor="#95D8FF">DADOS PARA CONTATO</td>
			</tr>
			<tr>
			<td align="left" valign="middle"><br>
			<span style="margin-left:0px"><strong>RESIDENCIAL:</strong></span> <span style="margin-left:36px"><strong>RECADO:</strong></span> <span style="margin-left:63px"><strong>CELULAR:</strong></span><br>
			<span style="margin-left:0px"><input name="tel_res" type="text" value="<?= $tel_res ?>" style="width:112px" onKeyUp="masc_numeros(this,'(##) ####-####');"/></span><samp style="color:#FF0000"></samp>
			<span style="margin-left:0px"><input name="tel_rec" type="text" value="<?= $tel_rec ?>" style="width:112px" onKeyUp="masc_numeros(this,'(##) ####-####');"/></span>
			<span style="margin-left:0px"><input name="tel_cel" type="text" value="<?= $tel_cel ?>" style="width:111px" onKeyUp="masc_numeros(this,'(##) ####-####');"/></span><br><br>
			</td>
			</tr>
			<tr>
			<td height="30" align="left" valign="middle" bgcolor="#95D8FF">ENDEREÇO PARA CONTATO</td>
			</tr>
			<tr>
			<td align="left" valign="middle"><br>
			<span style="margin-left:0px"><strong>ENDEREÇO:</strong></span> <span style="margin-left:298px"><strong>Nº:</strong></span> <span style="margin-left:35px"><strong>COMPLEMENTOº:</strong></span><br>
			<span style="margin-left:0px"><input name="endereco" type="text" value="<?= $endereco ?>" style="width:362px"/></span><samp style="color:#FF0000"></samp>
			<span style="margin-left:0px"><input name="numero" type="text" value="<?= $numero ?>" style="width:51px"/></span>
			<span style="margin-left:0px"><input name="complemento" type="text" value="<?= $complemento ?>" style="width:300px"/></span><br><br>

			<span style="margin-left:0px"><strong>BAIRRO:</strong></span> <span style="margin-left:230px"><strong>CEP:</strong></span> <span style="margin-left:50px;"><strong>ESTADO:</strong></span> <span style="margin-left:8px;"><strong>CIDADE:</strong></span><br>
			<span style="margin-left:0px"><input name="bairro" type="text" value="<?= $bairro ?>" style="width:275px"/></span><samp style="color:#FF0000"></samp>
			<span style="margin-left:0px"><input name="cep" type="text" value="<?= $cep ?>" style="width:74px" onKeyUp="masc_numeros(this,'#####-###');"/></span><samp style="color:#FF0000"></samp>

			<span style="margin-left:0px;">
			<select name="estado" onclick="carrega_cidades(this.value,'');">
			<option value="<?= $estado ?>">UF</option>

			<?
			$sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['estado'].'"';
				if($estado==$res['estado']) echo 'selected="selected"'; 
				echo '>'.$res['estado'].'</option>';
			}
			?>

			</select>
			</span>

			<span style="margin-left:15px"><input name="cidade" type="text" value="<?= $cidade ?>" style="width:295px"/></span><samp style="color:#FF0000"></samp><br><br>
			</td>
			</tr>
			<tr>
			<td height="30" align="left" valign="middle" bgcolor="#95D8FF">DADOS DO HISTÓRICO PROFISSIONAL E EMPRESARIAL</td>
			</tr>
			<tr>
			<td align="left" valign="middle"><br>
			<span style="margin-left:0px"><strong>CARGO ATUAL:</strong></span> <span style="margin-left:275px"><strong>EMPRESA:</strong></span><br>
			<span style="margin-left:0px"><input name="cargo" type="text" value="<?= $cargo ?>" style="width:362px"/></span><samp style="color:#FF0000"></samp>

			<span style="margin-left:0px"><input name="empresa_t" type="text" value="<?= $empresa_t ?>" style="width:362px"/></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px"><strong>FAÇA UM BREVE RELATO SOBRE SEU HISTÓRICO:</strong></span><br>
			<span style="margin-left:0px"><textarea name="historico" style="width:732px;height:67px;"><?= $historico ?></textarea></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px"><strong>ESCOLARIDADE:</strong></span> <span style="margin-left:99px;"><strong>CURSOS</strong></span> <span style="margin-left:185px"><strong>JÁ TEM OU TEVE NEGÓCIO PRÓPRIO?</strong></span><br>
			<select name="escolaridade" style="width:200px">
			<option value="">.:SELECIONE:.</option>
			<option value="Ensino fundamental: Incompleto" <? if($escolaridade=='Ensino fundamental: Incompleto') echo 'selected'; ?>>Ensino fundamental: Incompleto</option>
			<option value="Ensino fundamental: Completo" <? if($escolaridade=='Ensino fundamental: Completo') echo 'selected'; ?>>Ensino fundamental: Completo</option>
			<option value="">----------------------------------------------------------</option>
			<option value="Ensino médio: Incompleto" <? if($escolaridade=='Ensino médio: Incompleto') echo 'selected'; ?>>Ensino médio: Incompleto</option>
			<option value="Ensino médio: Completo" <? if($escolaridade=='Ensino médio: Completo') echo 'selected'; ?>>Ensino médio: Completo</option>
			<option value="">----------------------------------------------------------</option>
			<option value="Ensino superior: Incompleto" <? if($escolaridade=='Ensino superior: Incompleto') echo 'selected'; ?>>Ensino superior: Incompleto</option>
			<option value="Ensino superior: Completo" <? if($escolaridade=='Ensino superior: Completo') echo 'selected'; ?>>Ensino superior: Completo</option>
			<option value="">----------------------------------------------------------</option>
			<option value="Pós graduação" <? if($escolaridade=='Pós graduação') echo 'selected'; ?>>Pós graduação</option>
			<option value="Mestrado" <? if($escolaridade=='Mestrado') echo 'selected'; ?>>Mestrado</option>
			<option value="Doutorado" <? if($escolaridade=='Doutorado') echo 'selected'; ?>>Doutorado</option>
			<option value="MBA" <? if($escolaridade=='MBA') echo 'selected'; ?>>MBA</option>
			</select>
			<span style="margin-left:0px"><input name="cursos" type="text" value="<?= $cursos ?>" style="width:225px"/></span><samp style="color:#FF0000"></samp>

			<span style="margin-left:0px"><input name="negocios" type="radio" value="Sim" <? if($negocios=='Sim') echo 'checked'; ?> style="margin-left:0px;"/><strong>SIM</strong><input name="negocios" type="radio" value="Não" <? if($negocios=='Não') echo 'checked'; ?>/><strong>NÃO</strong></span><br><br>

			<span style="margin-left:0px"><strong>NOME DA EMPRESA:</strong></span> <span style="margin-left:243px"><strong>RAMO DE ATUAÇÃO:</strong></span><br>
			<span style="margin-left:0px"><input name="empresa_p" type="text" value="<?= $empresa_p ?>" style="width:362px"/></span><samp style="color:#FF0000"></samp>

			<span style="margin-left:0px"><input name="ramo_at" type="text" value="<?= $ramo_at ?>" style="width:362px"/></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px"><strong>PERÍODO:</strong></span> <span style="margin-left:59px;"><strong>FUNCIONÁRIOS</strong></span> <span style="margin-left:11px;"><strong>FATURAMENTO</strong></span><br>
			<select name="periodo" style="width:120px">
			<option value="">.:SELECIONE:.</option>
			<option value="6 meses a 1 ano" <? if($periodo=='6 meses a 1 ano') echo 'selected'; ?>>6 meses a 1 ano</option>
			<option value="1 ano a 5 anos" <? if($periodo=='1 ano a 5 anos') echo 'selected'; ?>>1 ano a 5 anos</option>
			<option value="5 anos a 10 anos" <? if($periodo=='5 anos a 10 anos') echo 'selected'; ?>>5 anos a 10 anos</option>
			<option value="acima de 10 anos" <? if($periodo=='acima de 10 anos') echo 'selected'; ?>>acima de 10 anos</option>
			</select>

			<select name="funcionarios" style="width:109px">
			<option value="">.:SELECIONE:.</option>
			<option value="1 a 5" <? if($funcionarios=='1 a 5') echo 'selected'; ?>>1 a 5</option>
			<option value="de 5 a 10" <? if($funcionarios=='de 5 a 10') echo 'selected'; ?>>de 5 a 10</option>
			<option value="de 10 a 50" <? if($funcionarios=='de 10 a 50') echo 'selected'; ?>>de 10 a 50</option>
			<option value="de 50 a 100" <? if($funcionarios=='de 50 a 100') echo 'selected'; ?>>de 50 a 100</option>
			<option value="acima de 100" <? if($funcionarios=='acima de 100') echo 'selected'; ?>>acima de 100</option>
			</select>

			<select name="faturamento" style="width:130px">
			<option value="">.:SELECIONE:.</option>
			<option value="Até R$ 50 mil" <? if($faturamento=='Até R$ 50 mil') echo 'selected'; ?>>Até R$ 50 mil</option>
			<option value="R$ 50 a R$ 100 mil" <? if($faturamento=='R$ 50 a R$ 100 mil') echo 'selected'; ?>>R$ 50 a R$ 100 mil</option>
			<option value="R$ 100 a R$ 300 mil" <? if($faturamento=='R$ 100 a R$ 300 mil') echo 'selected'; ?>>R$ 100 a R$ 300 mil</option>
			<option value="R$ 300 a R$ 500 mil" <? if($faturamento=='R$ 300 a R$ 500 mil') echo 'selected'; ?>>R$ 300 a R$ 500 mil</option>
			<option value="Acima de R$ 500 mil" <? if($faturamento=='Acima de R$ 500 mil') echo 'selected'; ?>>Acima de R$ 500 mil</option>
			</select><br><br>
			</td>
			</tr>
			<tr>
			<td height="30" align="left" valign="middle" bgcolor="#95D8FF">DADOS FINANCEIROS E ADICIONAIS</td>
			</tr>
			<tr>
			<td align="left" valign="middle"><br>
			<span style="margin-left:0px"><strong>TEM CAPITAL IMEDIATO DISPONÍVEL PARA INVESTIR?</strong></span><br>
			<span style="margin-left:0px"><input name="capital" type="radio" value="Sim" <? if($capital=='Sim') echo 'checked'; ?> style="margin-left:0px;"/><strong>SIM</strong><input name="capital" type="radio" value="Não" <? if($capital=='Não') echo 'checked'; ?>/><strong>NÃO</strong></span>

			<span style="margin-left:0px"><strong>VALOR DISPONÍVEL:</strong></span>
			<span style="margin-left:0px"><input name="valor_disp" type="text" value="<?= $valor_disp ?>" style="width:119px"/></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px"><strong>INFORME SE DEPENDE DE EMPRÉSTIMO OU VENDA DE BENS PARA INVESTIR EM SUA FRANQUIA CP:</strong></span><br>
			<span style="margin-left:0px"><textarea name="emprestimo" style="width:732px;height:60px;"><?= $emprestimo ?></textarea></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px"><strong>INFORME SE O CAPITAL CITADO FOR DE TERCEIROS:</strong></span><br>
			<span style="margin-left:0px"><textarea name="capital_terc" style="width:732px;height:60px;"><?= $capital_terc ?></textarea></span><samp style="color:#FF0000"></samp><br>

			<span style="margin-left:0px"><strong>QUANDO PRETENDE DAR INÍCIO AO NEGÓCIO?:</strong></span> <span style="margin-left:10px"><strong>QUAL O SEU TEMPO DEDICADO A FRANQUIA?</strong></span><br>
			<select name="inicio_neg" style="width:120px">
			<option value="">.:SELECIONE:.</option>
			<option value="Imediato" <? if($inicio_neg=='Imediato') echo 'selected'; ?>>Imediato</option>
			<option value="2 meses" <? if($inicio_neg=='2 meses') echo 'selected'; ?>>2 meses</option>
			<option value="4 meses" <? if($inicio_neg=='4 meses') echo 'selected'; ?>>4 meses</option>
			<option value="6 meses" <? if($inicio_neg=='6 meses') echo 'selected'; ?>>6 meses</option>
			<option value="8 meses" <? if($inicio_neg=='8 meses') echo 'selected'; ?>>8 meses</option>
			<option value="acima de 8 meses" <? if($inicio_neg=='acima de 8 meses') echo 'selected'; ?>>acima de 8 meses</option>
			</select>

			<span style="margin-left:184px"><input name="dedicado_franq" type="radio" value="Integral" <? if($dedicado_franq=='Integral') echo 'checked'; ?> style="margin-left:0px;"/><strong>INTEGRAL</strong><input name="dedicado_franq" type="radio" value="Parcial" <? if($dedicado_franq=='Parcial') echo 'checked'; ?>/><strong>PARCIAL</strong><input name="dedicado_franq" type="radio" value="Como Investidor" <? if($dedicado_franq=='Como Investidor') echo 'checked'; ?>/><strong>COMO INVESTIDOR</strong></span><br><br>

			<span style="margin-left:0px"><strong>A FRANQUIA SERÁ A PRINCIPAL FONTE DE RENDA?</strong></span> <span style="margin-left:10px"><strong>PRETENDE TER SÓCIOS? ESPECIFIQUE:</strong></span><br>
			<span style="margin-left:0px"><input name="fonte_renda" type="radio" value="Sim" <? if($fonte_renda=='Sim') echo 'checked'; ?> style="margin-left:0px;"/><strong>SIM</strong><input name="fonte_renda" type="radio" value="Não" <? if($fonte_renda=='Não') echo 'checked'; ?>/><strong>NÃO</strong><input name="fonte_renda" type="radio" value="Temporariamente" <? if($fonte_renda=='Temporariamente') echo 'checked'; ?>/><strong>TEMPORARIAMENTE</strong></span>

			<span style="margin-left:100px"><input name="socios" type="text" value="<?= $socios ?>" style="width:392px"/></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px"><strong>QUANTO TEMPO PODERÁ SUPRIR SUAS EMPRESAS ANTES DE UTILIZAR O CAIXA DA EMPRESA?</strong></span><br>
			<span style="margin-left:0px"><input name="caixa_empresa" type="text" value="<?= $caixa_empresa ?>" style="width:362px"/></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px"><strong>COMO CONHECEU AS FRAQUIAS CARTÓRIO POSTAL:</strong></span><br>
			<span style="margin-left:0px"><textarea name="conheceu_cp" style="width:732px;height:50px;"><?= $conheceu_cp ?></textarea></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px"><strong>JÁ ESTEVE EM UMA DE NOSSAS UNIDADES?</strong></span> <span style="margin-left:10px"><strong>DESEJA RECEBER COMUNICADOS DE OUTRAS EMPRESAS DA REDE?</strong></span><br>
			<span style="margin-left:0px"><input name="unidades" type="radio" value="Sim" <? if($unidades=='Sim') echo 'checked'; ?> style="margin-left:0px;"/><strong>SIM</strong><input name="unidades" type="radio" value="Não" <? if($unidades=='Não') echo 'checked'; ?>/><strong>NÃO</strong></span>

			<span style="margin-left:0px"><strong>QUAL:</strong></span>
			<span style="margin-left:0px"><input name="unidades_valor" type="text" value="<?= $unidades_valor ?>" style="width:133px"/></span>

			<span style="margin-left:8px"><input name="comunicados" type="radio" value="Sim" <? if($comunicados=='Sim') echo 'checked'; ?> style="margin-left:0px;"/><strong>SIM</strong><input name="comunicados" type="radio" value="Não" <? if($comunicados=='Não') echo 'checked'; ?>/><strong>NÃO</strong></span><br><br>

			<span style="margin-left:0px"><strong>PORQUE O INTERESSE EM SER UM FRANQUEADO?</strong></span><br>
			<span style="margin-left:0px"><textarea name="interesse" style="width:732px;height:40px;"><?= $interesse ?></textarea></span><samp style="color:#FF0000"></samp><br><br>

			<span style="margin-left:0px;"><strong>SELECIONE O ESTADO E A CIDADE DE INTERESSE:</strong></span><br>
			<span style="margin-left:0px;"><select name="estado_interesse" onclick="carrega_cidades(this.value,'');">
			<option value="<?= $estado_interesse ?>">UF</option>

			<?
			$sql = $objQuery->SQLQuery("SELECT DISTINCT estado FROM  vsites_cidades as C ORDER BY estado");
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['estado'].'"';
				if($estado_interesse==$res['estado']) echo 'selected="selected"'; 
				echo '>'.$res['estado'].'</option>';
			}
			?>

			</select><samp style="color:#FF0000"></samp>
			</span>

			<span style="margin-left:15px"><input name="cidade_interesse" type="text" value="<?= $cidade_interesse ?>" style="width:295px"/></span><samp style="color:#FF0000"></samp><samp style="color:#FF0000"></samp>
			</span><br><br>

			<span style="margin-left:0px"><strong>SEU ESPAÇO PARA OBSERVAÇÕES?</strong></span><br>
			<span style="margin-left:0px"><textarea name="observacao" style="width:732px;height:40px;"><?= $observacao ?></textarea></span><br><br>

			<span style="margin-left:0px"><strong>ANOTAÇÕES SOBRE ESTE CADASTRO</strong></span><br>
			<span style="margin-left:0px"><textarea name="observacao_expansao" style="width:732px;height:40px;"><?= $observacao_expansao ?></textarea></span><br><br>
			<span style="margin-left:0px"><strong>ALTERAR STATUS</strong></span> <span style="margin-left:70px"><strong>ESTÁ FICHA DE CADASTRO FOI VISUALIZADA PELO DEPARTAMENTO DE EXPANSÃO?</strong></span><br>

			<span style="margin-left:0px">
			<select name="status">
			<option value="">Todos</option>
			<?
			$sql = $objQuery->SQLQuery("SELECT * FROM saf_status_interesse as s ORDER BY s.id_status");
			while($res = mysql_fetch_array($sql)){
				echo '<option value="'.$res['status'].'"';
				if($status==$res['status']) echo 'selected="selected"'; 
				echo '>'.$res['status'].'</option>';
			}
			?>
			</select>
			</span>

			<span style="margin-left:0px"><input name="ficha_enviada" type="radio" value="Sim" <? if($ficha_enviada=='Sim') echo 'checked'; ?> style="margin-left:0px;"/><strong>SIM</strong><input name="ficha_enviada" type="radio" value="Não" <? if($ficha_enviada=='Não') echo 'checked'; ?>/><strong>NÃO</strong></span><br><br>

			<span style="margin-left:300px"><input name="submit1" type="submit" value="Alterar"/></span>
			</td>
			</tr>
			</table>
			</form>
			
			<?
			}
			?>
			
			<table align="center" border="0" cellpadding="3" cellspacing="0" width="600">
			<tr>
			<td align="center">
			<?
			if ($errors) {
			echo '<div class="respotas_erro">'.$error.'</div>';
			}
			?>
			
			<?
			if ($done) {
			echo '<div id="respotas_sucesso" style="font-size:16px">O cadastro foi atualizado com sucesso!</div>';
			echo '<meta HTTP-EQUIV="refresh" CONTENT="2; URL=novos_interessados.php">';
			}	  
			?>        
			</td>
			</tr>    
			</table>
		
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