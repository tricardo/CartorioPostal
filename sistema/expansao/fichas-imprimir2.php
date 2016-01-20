<? ob_start();
require("../includes/funcoes.php");
require("../includes/verifica_logado_controle.inc.php");
require("../includes/global.inc.php");

$perm_fin = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_pgto = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_cobr = verifica_permissao('Financeiro Cobran�a', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_sup = verifica_permissao('Supervisor', $controle_id_departamento_p, $controle_id_departamento_s); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Sistecart</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
	<link rel="shortcut icon" href="../images/icone.gif" />
	<style type="text/css">
		@import url(../css/style.css);
		@import url(../css/help.css);
		@import url(../css/calendar.css);		
	</style>
</head>
<body>
<? pt_register('GET','id_ficha'); 
$expansao = new ExpansaoDAO();
$c        = new stdClass();
$c->c_id_usuario = $controle_id_usuario;
$c->c_nome     = $controle_nome;
$c->id_ficha   = $id_ficha; 

$exp_item = $expansao->verAcesso(1, $controle_id_empresa, $controle_id_usuario, 
	$controle_id_departamento_p, $controle_id_departamento_s, $controle_nome);
if($exp_item->acesso == 0 and $controle_id_empresa != 1){
	echo '<br><br><strong>Voc� n�o tem permiss�o para acessar essa p�gina</strong>';
	require('rodape.php');
	exit;
} 
$dt = $expansao->imprimir_ficha($c); ?> 
<br /><br />
<table width="70%" cellpadding="4" cellspacing="1" class="result_tabela" style="left:35%;margin-left:-17.5%;position:relative;text-transform:uppercase">
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">Cadastro</td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Dados Pessoais</td>
	</tr>
	<tr>
		<td class="result_celula" style="width:50%"><label style="font-weight:bold">Status: </label><?=$dt[0][0]->status?></td>
		<td class="result_celula" style="width:50%;"><label style="font-weight:bold">data de cadastro: </label><?=$dt[0][0]->data?></td>
	</tr>
	<tr>
		<td class="result_celula" style="width:50%"><label style="font-weight:bold">Nome: </label><?=$dt[0][0]->nome?></td>
		<td class="result_celula" style="width:50%;"><label style="font-weight:bold">E-MAIL: </label><span style="text-transform:lowercase"><?=($dt[0][0]->email)?></span></td>
	</tr>
	<tr>
		<td class="result_celula"><label style="font-weight:bold">RG: </label><?=$dt[0][0]->rg?></td>
		<td class="result_celula"><label style="font-weight:bold">CPF: </label>
			<?=$expansao->orgao_emissor($dt[1][0]->orgao_emissor).' - '.$dt[0][0]->cpf?>
		</td>
	</tr>
	<tr>
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Data de Nascimento: </label><?=$dt[0][0]->nascimento?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Residencial: </label><?=$dt[0][0]->tel_res?></td>
		<td class="result_celula"><label style="font-weight:bold">Recado: </label><?=$dt[0][0]->tel_rec?></td>
	</tr>
	<tr>
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Celular: </label><?=$dt[0][0]->tel_cel?></td>
	</tr>	
	<tr>
		<td class="result_celula"><label style="font-weight:bold">Nacionalidade: </label><?=$dt[0][0]->nacionalidade?></td>
		<td class="result_celula"><label style="font-weight:bold">Local de Nascimento: </label><?=$dt[1][0]->local_nascimento?></td>
	</tr>
	<tr>
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Estado Civil: </label><?=$dt[0][0]->estado_civil?></td>
	</tr>
	<tr>
		<td class="result_celula"><label style="font-weight:bold">Possui Filhos? </label><?=($dt[0][0]->filhos == 1) ? 'Sim':'N�o'?></td>
		<td class="result_celula"><label style="font-weight:bold">Quantos? </label><?=$dt[0][0]->filhos_quant?></td>
	</tr>
	<tr>
		<td class="result_celula"><label style="font-weight:bold">Data do Casamento: </label><?=$dt[1][0]->data_casamento?></td>
		<td class="result_celula"><label style="font-weight:bold">Regime de Casamento: </label><?=$dt[1][0]->regime?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Nome do Pai: </label><?=$dt[1][0]->nome_pai?></td>
		<td class="result_celula"><label style="font-weight:bold">Nome da M�e: </label><?=$dt[1][0]->nome_mae?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Nome do S�cio: </label><?=$dt[1][0]->nome_socio?></td>
		<td class="result_celula"><label style="font-weight:bold">Profiss�o: </label><?=$dt[1][0]->profissao?></td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Endere�o</td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Endere�o: </label><?=$dt[0][0]->endereco?> 
		<label style="width:40px">N�.: </label><?=$dt[0][0]->numero?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Complemento: </label><?=$dt[0][0]->complemento?></td>
		<td class="result_celula"><label style="font-weight:bold">Bairro: </label><?=$dt[0][0]->bairro?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">CEP: </label><?=$dt[0][0]->cep?></td>
		<td class="result_celula"><label style="font-weight:bold">UF: </label><?=$dt[0][0]->estado?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Cidade: </label><?=$dt[0][0]->cidade?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Tipo do Im�vel: </label><? switch($dt[1][0]->tip_imovel){
			case 1: echo 'Pr�pria'; break;
			case 2: echo 'Alugada'; break;
			case 3: echo 'Familiares'; break; } ?></td>
		<td class="result_celula"><label style="font-weight:bold">Reside na Pra�a Desde: </label><?=$dt[1][0]->reside_praca?></td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* �ltimo Endere�o</td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Endere�o: </label><?=$dt[2][0]->endereco?> 
		<label style="width:40px">N�.: </label><?=$dt[2][0]->numero?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Complemento: </label><?=$dt[2][0]->complemento?></td>
		<td class="result_celula"><label style="font-weight:bold">Bairro: </label><?=$dt[2][0]->bairro?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">CEP: </label><?=$dt[2][0]->cep?></td>
		<td class="result_celula"><label style="font-weight:bold">UF: </label><?=$dt[2][0]->estado?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Cidade: </label><?=$dt[2][0]->cidade?></td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Dados Pessoais do C�njuge se Houver</td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Nome: </label><?=$dt[3][0]->nome?></td>
		<td class="result_celula"><label style="font-weight:bold">E-MAIL: </label><span style="text-transform:lowercase"><?=($dt[3][0]->email)?></span></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">rg: </label><?=$dt[3][0]->rg?></td>
		<td class="result_celula"><label style="font-weight:bold">cpf: </label><?=$dt[3][0]->cpf?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">data de nascimento: </label><?=$dt[3][0]->nascimento?></td>		
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Nome do pai: </label><?=$dt[3][0]->nome_pai?></td>
		<td class="result_celula"><label style="font-weight:bold">Nome da m�e: </label><?=$dt[3][0]->nome_mae?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">profissao: </label><?=$dt[3][0]->profissao?></td>
		<td class="result_celula"><label style="font-weight:bold">cargo: </label><?=$dt[3][0]->cargo?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">empresa: </label><?=$dt[3][0]->empresa?></td>		
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">telefone: </label><?=$dt[3][0]->telefone?></td>
		<td class="result_celula"><label style="font-weight:bold">admiss�o: </label><?=$dt[3][0]->admissao?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Endere�o da empresa: </label><?=$dt[3][0]->end_empresa?> 
		<label style="width:40px">N�.: </label><?=$dt[3][0]->numero?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">complemento: </label><?=$dt[3][0]->complemento?></td>
		<td class="result_celula"><label style="font-weight:bold">bairro: </label><?=$dt[3][0]->bairro?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">cep: </label><?=$dt[3][0]->cep?></td>
		<td class="result_celula"><label style="font-weight:bold">uf: </label><?=$dt[3][0]->estado?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Lazer: </label>
		<? $i = 1; foreach($dt[4] as $b => $res){
			if($i == count($dt[4])){
				echo $res->lazer.'.';
			} else {
				echo $res->lazer.', ';
			} $i++; } ?></td>		
	</tr>
</table><br /><br />
<table width="70%" cellpadding="4" cellspacing="1" class="result_tabela" style="left:35%;margin-left:-17.5%;position:relative;text-transform:uppercase">
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">Empresarial</td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Experi�ncia com Franquias</td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Deseja ser? </label><?=$dt[1][0]->franqueado?></td>
		<td class="result_celula"><label style="font-weight:bold">Experi�ncia com Franq.? </label><?=($dt[1][0]->experiencia == 1) ? 'Sim':'N�o'?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Se N�o, Qual o Motivo de N�o Possuir o Neg�cio?</label><br /><?=$dt[1][0]->motivo?></td>		
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">N�mero de Funcion�rios: </label><?=$dt[1][0]->funcionarios2?></td>
		<td class="result_celula"><label style="font-weight:bold">Faturamento: </label><?=$dt[0][0]->faturamento?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Qual Franquia?</label><br /><?=$dt[1][0]->qual_franquia?></td>		
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Na sua Opini�o Quais os Fatores Determinantes para o Sucesso de um Neg�cio?</label><br /><?=$dt[1][0]->opiniao?></td>		
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Hist�rico Profissional</td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Empresa: </label><?=$dt[0][0]->empresa_t?></td>
		<td class="result_celula"><label style="font-weight:bold">Cargo Atual: </label><?=$dt[0][0]->cargo?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">Fa�a um Breve Relato Sobre seu Hist�rico:</label><br /><?=$dt[0][0]->historico?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Per�odo: </label><?=$dt[0][0]->periodo?></td>
		<td class="result_celula"><label style="font-weight:bold">Funcion�rios: </label><?=$dt[0][0]->funcionarios?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Faturamento: </label><?=$dt[0][0]->faturamento?></td>
		<td class="result_celula"><label style="font-weight:bold">contato: </label><?=$dt[1][0]->contato?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Ramo de Atua��o: </label><?=$dt[0][0]->ramo_at?></td>
		<td class="result_celula"><label style="font-weight:bold">Nome da Empresa: </label><?=$dt[0][0]->empresa_p?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Grau de Escolaridade: </label><?=$dt[0][0]->cursos?></td>
		<td class="result_celula"><label style="font-weight:bold">Nome da Empresa: </label><?=$dt[0][0]->escolaridade?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Qual Faculdade: </label><?=$dt[1][0]->faculdade?></td>
		<td class="result_celula"><label style="font-weight:bold">Ano de Conclus�o: </label><?=$dt[1][0]->conclusao?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">Tem ou Teve Neg�cio Pr�prio? </label><?=($dt[0][0]->negocios == 1) ? 'Sim':'N�o'?></td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Sobre a Franquia Cart�rio Postal</td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label  style="font-weight:bold">Enumere o que voc� considera importante na franquia Cart�rio Postal, sendo que o n�mero 1 � o mais importante:</label><br />
			<?foreach($dt[5] as $b => $res){
				echo $res->valor . ' - '. $res->pergunta.'<br />'; }  ?>
		</td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Como Conheceu as Franquias Cart�rio Postal:</label><br /><?=$dt[0][0]->conheceu_cp?>
		</td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">J� Esteve em uma de Nossas Unidades? </label><?=($dt[0][0]->unidades == 1) ? 'Sim':'N�o'?>
		</td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Qual? </label><?=$dt[0][0]->unidades_valor?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Deseja Receber Comunicados de Outras Empresas da Rede?  </label><?=($dt[0][0]->comunicados == 1) ? 'Sim':'N�o'?>
		</td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Porque o Interesse em ser um Franqueado? </label><br /><?=$dt[0][0]->interesse?>
		</td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Selecione o Estado e a Cidade de Interesse: </label><?=$dt[0][0]->estado_interesse.' / '.$dt[0][0]->cidade_interesse?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Seu Espa�o Para Observa��es: </label><br /><?=$dt[0][0]->observacao?>
		</td>
	</tr>
</table><br /><br />
<table width="70%" cellpadding="4" cellspacing="1" class="result_tabela" style="left:35%;margin-left:-17.5%;position:relative;text-transform:uppercase">
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">Banc�rio</td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Informa��es Adicionais</td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">Tem Capital Imediato Dispon�vel para Investir? </label><?=$dt[0][0]->capital?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">Valor Dispon�vel: </label><?=$dt[0][0]->valor_disp?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">Informe se Depende de Empr�stimo ou Venda de Bens para Investir em sua Franquia Cart�rio Postal: </label><br /><?=$dt[0][0]->emprestimo?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">Informe se o Capital Citado for de Terceiros: </label><br /><?=$dt[0][0]->capital_terc?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">Quando Pretende dar In�cio ao Neg�cio? </label><?=$dt[0][0]->inicio_neg?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">Qual o seu Tempo Dedicado a Franquia? </label><?=$dt[0][0]->dedicado_franq?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">A Franquia Ser� a Principal Fonte de Renda? </label><?=$dt[0][0]->fonte_renda?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2">
			<label style="font-weight:bold">Pretende Ter S�cios? Especifique. </label><br /><?=$dt[0][0]->socios?></td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Refer�ncias Banc�rias</td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Banco: </label><?=$dt[6][0]->banco?></td>
		<td class="result_celula"><label style="font-weight:bold">Cart�o de Cr�dito: </label><?=$dt[6][0]->cartao_credito?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Vencimento: </label><?=$dt[6][0]->vencimento?></td>
		<td class="result_celula"><label style="font-weight:bold">Limite: </label><?=$dt[6][0]->limite?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Nome do Gerente: </label><?=$dt[6][0]->nome_gerente?></td>
		<td class="result_celula"><label style="font-weight:bold">Ag�ncia e Conta: </label><?=$dt[6][0]->agencia_conta?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Telefone: </label><?=$dt[6][0]->telefone_banco?></td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Demonstrativo de Rendimento</td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Honor�rios: </label><?=$dt[7][0]->honorarios?></td>
		<td class="result_celula"><label style="font-weight:bold">Sal�rios: </label><?=$dt[7][0]->salarios?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Comiss�es: </label><?=$dt[7][0]->comissoes?></td>
		<td class="result_celula"><label style="font-weight:bold">Sal�rio do Conjuge: </label><?=$dt[7][0]->salario_conjuge?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Renda de Alugu�is: </label><?=$dt[7][0]->renda_alugueis?></td>		
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Possui Empr�stimos Financeiros: </label><?=$dt[7][0]->emprestimo_financeiro?></td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Bens de Consumo</td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Modelo do Ve�culo: </label><?=$dt[8][0]->modelo_veiculo?></td>
		<td class="result_celula"><label style="font-weight:bold">Marca do Ve�culo: </label><?=$dt[8][0]->marca_veiculo?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Ano do Ve�culo: </label><?=$dt[8][0]->ano_veiculo?></td>
		<td class="result_celula"><label style="font-weight:bold">Placa do Ve�culo: </label><?=$dt[8][0]->placa_veiculo?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Valor do Ve�culo: </label><?=$dt[8][0]->valor_veiculo?></td>		
		<td class="result_celula"><label style="font-weight:bold">Financiado? </label><?=$dt[8][0]->financiado?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Im�vel: </label><?=$dt[8][0]->imovel?></td>		
		<td class="result_celula"><label style="font-weight:bold">Valor Venal: </label><?=$dt[8][0]->valor_venal?></td>
	</tr>
	<tr>		
		<td class="result_celula" colspan="2"><label style="font-weight:bold">Somat�ria do Valor Financiado: </label><?=$dt[8][0]->somatoria?></td>
	</tr>
</table><br /><br />
<table width="70%" cellpadding="4" cellspacing="1" class="result_tabela" style="left:35%;margin-left:-17.5%;position:relative;text-transform:uppercase">
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">Jur�dico</td>
	</tr>
	<tr>
		<td class="result_menu" style="font-weight:bold" colspan="2">* Informativo</td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Tipo da Franquia: </label><?switch($dt[9][0]->tipo_franquia){
			case 1: echo 'Master'; break;
			case 2: echo 'Unit�ria'; break;
			case 3: echo 'Subfranquia'; break;
			case 4: echo 'Internacional'; break; } ?></td>		
		<td class="result_celula"><label style="font-weight:bold">N.� COF: </label><?=$dt[9][0]->num_cof?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Valor da COF: </label><?=$dt[9][0]->valor_cof?></td>		
		<td class="result_celula"><label style="font-weight:bold">Forma de Pagto.: </label><?=$dt[9][0]->forma_pagto?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Origem: </label><?switch($dt[9][0]->origem){
			case 1: echo 'ABF'; break;
			case 2: echo 'E-mail'; break;
			case 3: echo 'Site'; break;  } ?></td>		
		<td class="result_celula"><label style="font-weight:bold">Valor Efetivo: </label><?=$dt[9][0]->valor_efetivo?></td>
	</tr>
	<tr>		
		<td class="result_celula"><label style="font-weight:bold">Valor do Royaltie: </label><?=$dt[9][0]->valor_royaltie?></td>		
		<td class="result_celula"><label style="font-weight:bold">N.� COF Emitido: </label><?=($dt[9][0]->num_cof_emitida == 1) ?'Sim':'N�o';?></td>
	</tr>
</table>
<table width="70%" cellpadding="0" cellspacing="0" style="left:35%;margin-left:-17.5%;position:relative;text-transform:uppercase;">
	<tr>
		<td style="text-align:right;font-size:10px;">Cart�rio Postal - <?=date('d/m/Y H:i:s')?>&nbsp;&nbsp;</td>
	</tr>
</table><br /><br />&nbsp;
</body>
</html>