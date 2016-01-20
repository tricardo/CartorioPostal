<?
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
$dt  = new ListaInteressadosDAO();
$dt1 = new StatusDAO();
$c = new stdClass();
$e = $dt->buscaFichaCadastros($id); if(count($e) > 0){ foreach($e as $cp => $valor){ $c->$cp = $valor; } }
$e = $dt->buscaCadastroAdicionais($id); if(count($e) > 0){ foreach($e as $cp => $valor){ $c->$cp = $valor; } }
$e = $dt->buscaConjuge($id); if(count($e) > 0){ foreach($e as $cp => $valor){ $c->$cp = $valor; } }
$e = $dt->buscaEndereco2($id); if(count($e) > 0){ foreach($e as $cp => $valor){ $c->$cp = $valor; } }
$e = $dt->buscaReferenciaBancaria($id); if(count($e) > 0){ foreach($e as $cp => $valor){ $c->$cp = $valor; } }
$e = $dt->buscaDemonstrativoRendimento($id); if(count($e) > 0){ foreach($e as $cp => $valor){ $c->$cp = $valor; } }
$e = $dt->buscaBensConsumo($id); if(count($e) > 0){ foreach($e as $cp => $valor){ $c->$cp = $valor; } }
$e = $dt->buscaDadosAdinistrativo($id); if(count($e) > 0){foreach($e as $cp => $valor){ $c->$cp = $valor; }}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAF Postal</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}
body {
	background-color: #FFFFFF;
	margin-left: 10px;
	margin-top: 10px;
	margin-right: 0px;
	margin-bottom: 0px;
}
img { border:none; width:auto; height:auto; }
strong { font-size:10px; }
td { padding:5px; }
.titulo { font-weight:bold; color:#1A1C64; background-color:#E2A800; border:solid 1px #333333; }
.subtitulo { font-weight:bold; color:#FFFFFF; background-color:#1A1C64; font-size:11px; border:solid 1px #333333; border-top:none;  }
.borda1 { border:solid 1px #333333; border-top:none; }
.borda2 { border:solid 1px #333333; border-left:none; border-top:none; }
-->
</style>
</head>
<body>
<?
if($safpostal_id_usuario != $c->id_usuario){
	if($safpostal_id_usuario != 1 && $safpostal_id_usuario != 56 && $safpostal_id_usuario != 272){
		echo '<span style="color:#FF0000">Você não tem permissão para visualizar esta página.</span>';
		exit();
	}
}?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td rowspan="7">&nbsp;</td>
    <td height="110" align="center" valign="top" width="960"><img src="http://www.cartoriopostal.com.br/saf/images/logo.png" />&nbsp;</td>
    <td rowspan="7">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4" class="titulo">- Dados Adminstrativos&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" class="subtitulo">Informativo:&nbsp;</td>
        </tr>
      <tr>
        <td class="borda1"><strong>Tipo da Franquia:</strong><br />
          <? switch($c->tipo_franquia){
		  	case 1: echo 'Master'; break;
			case 2: echo 'Unitária'; break;
			case 3: echo 'Internacional'; break;
		  }?>&nbsp;</td>
        <td class="borda2"><strong>N.&ordm; COF:</strong><br />
          <?=$c->num_cof?>&nbsp;</td>
        <td class="borda2"><strong>Valor da COF:</strong><br />
          <?=$c->valor_cof?>&nbsp;</td>
        <td class="borda2"><strong>Forma de Pagto.:</strong><br />
          <?=$c->forma_pagto?>&nbsp;</td>
      </tr>
      <tr>
        <td class="borda1"><strong>Origem:</strong><br />
          <? switch($c->origem){
		  	case 1: echo 'ABF'; break;
			case 2: echo 'E-mail'; break;
			case 3: echo 'Site'; break;
		  }?>&nbsp;</td>
        <td class="borda2"><strong>N.&ordm; COF Emitido:</strong><br />
          <?=($c->cof_emitido == 1)?'Sim':'Não';?>&nbsp;</td>
        <td colspan="2" class="borda2"><strong>Valor Efetivo da Franquia:</strong><br />
          <?=$c->valor_efetivo?>&nbsp;</td>
        </tr>
    </table> </td>
  </tr>
  <tr>
    <td><table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4" class="titulo">- Dados do Solicitante&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="subtitulo">Dados Pessoais:&nbsp;</td>
      </tr>
      <tr>
        <td class="borda1" colspan="2"><strong>Nome:</strong><br /><?=$c->nome?>&nbsp;</td>
        <td class="borda2"><strong>RG:</strong><br /><?=$c->rg?>
        / <? switch($c->orgao_emissor){
        case 1: echo 'SP-AC'; break;
		case 2: echo 'SSP-AL'; break;
		case 3: echo 'SSP-AM'; break;
		case 4: echo 'SSP-AP'; break;
		case 5: echo 'SSP-BA'; break;
		case 6: echo 'SSP-CE'; break;
		case 7: echo 'SSP-DF'; break;
		case 8: echo 'SSP-ES'; break;
		case 9: echo 'SSP-GO'; break;
		case 10: echo 'SSP-MA'; break;
		case 11: echo 'SSP-MG'; break;
		case 12: echo 'SSP-MS'; break;
		case 13: echo 'SSP-MT'; break;
		case 14: echo 'SSP-PA'; break;
		case 15: echo 'SSP-PB'; break;
		case 16: echo 'SSP-PE'; break;
		case 17: echo 'SSP-PI'; break;
		case 18: echo 'SSP-PR'; break;
		case 19: echo 'SSP-RJ'; break;
		case 20: echo 'SSP-RN'; break;
		case 21: echo 'SSP-RO'; break;
		case 22: echo 'SSP-RR'; break;
		case 23: echo 'SSP-RS'; break;
		case 24: echo 'SSP-SC'; break;
		case 25: echo 'SSP-SE'; break;
		case 26: echo 'SSP-SP'; break;
		case 27: echo 'SSP-TO'; break;
		}?>&nbsp;</td>
        <td class="borda2"><strong>CPF:</strong><br /><?=$c->cpf?>&nbsp;</td>
      </tr>
      <tr>
        <td width="50%" colspan="2" class="borda1"><strong>Data de Nascimento:</strong><br /><?=$c->nascimento?>&nbsp;</td>
        <td width="50%" colspan="2" class="borda2"><strong>E-mail:</strong><br /><?=$c->email?>&nbsp;</td>
      </tr>
      <tr>
        <td class="borda1"><strong>Residencial:</strong><br /><?=$c->tel_res?>&nbsp;</td>
        <td class="borda2"><strong>Recado:</strong><br /><?=$c->tel_rec?>&nbsp;</td>
        <td colspan="2" class="borda2"><strong>Celular:</strong><br /><?=$c->tel_cel?>&nbsp;</td>
      </tr>
		<tr>
        <td class="borda1" colspan="2"><strong>Nacionalidade:</strong><br /><?=$c->nacionalidade?>&nbsp;</td>
        <td colspan="2" class="borda2"><strong>Local de Nascimento:</strong><br /><?=$c->local_nascimento?>&nbsp;</td>
      </tr>
      <tr>
        <td class="borda1"><strong>Estado Civil:</strong><br /><?=$c->estado_civil?>&nbsp;</td>
        <td class="borda2"><strong>Possui Filhos?</strong><br /><?=$c->filhos?>&nbsp;</td>
        <td colspan="2" class="borda2"><strong>Quantos?</strong><br /><?=$c->filhos_quant?>&nbsp;</td>
      </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Regime de Casamento:</strong><br /><?=$c->regime?>&nbsp;</td>
          <td colspan="2" class="borda2"><strong>Data do Casamento:</strong><br /><?=$c->data_casamento?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Nome do Pai:</strong><br /><?=$c->nome_pai?>&nbsp;</td>
          <td colspan="2" class="borda2"><strong>Nome da M&atilde;e:</strong><br /><?=$c->nome_mae?>&nbsp;</td>
        </tr>
        <tr>
        <td class="borda1" colspan="2"><strong>Nome do S&oacute;cio:</strong><br /><?=$c->nome_socio?>&nbsp;</td>
        <td colspan="2" class="borda2"><strong>Profiss&atilde;o:</strong><br /><?=$c->profissao?>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="subtitulo">Dados Pessoais do Cônjuge se Houver:&nbsp;</td>
      </tr>
      <tr>
        <td class="borda1" colspan="2"><strong>Nome:</strong><br /><?=$c->conjuge_nome?>&nbsp;</td>
        <td class="borda2"><strong>RG:</strong><br /><?=$c->conjuge_rg?>&nbsp;</td>
        <td class="borda2"><strong>CPF:</strong><br /><?=$c->conjuge_cpf?>&nbsp;</td>
      </tr>
      <tr>
        <td width="50%" colspan="2" class="borda1"><strong>Data de Nascimento:</strong><br /><?=$c->conjuge_nascimento?>&nbsp;</td>
        <td width="50%" colspan="2" class="borda2"><strong>E-mail:</strong><br /><?=$c->conjuge_email?>&nbsp;</td>
      </tr>
       <tr>
          <td class="borda1" colspan="2"><strong>Nome do Pai:</strong><br /><?=$c->conjuge_nome_pai?>&nbsp;</td>
          <td colspan="2" class="borda2"><strong>Nome da M&atilde;e:</strong><br /><?=$c->conjuge_nome_mae?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Profissão:</strong><br /><?=$c->conjuge_profissao?>&nbsp;</td>
          <td colspan="2" class="borda2"><strong>Cargo:</strong><br /><?=$c->conjuge_cargo?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Empresa:</strong><br /><?=$c->conjuge_empresa?>&nbsp;</td>
          <td class="borda2"><strong>Telefone:</strong><br /><?=$c->conjuge_telefone?>&nbsp;</td>
          <td class="borda2"><strong>Admissão:</strong><br /><?=$c->conjuge_admissao?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Endereço da Empresa:</strong><br /><?=$c->conjuge_end_empresa.', '.$c->conjuge_numero?>&nbsp;</td>
          <td class="borda2"><strong>Complemento:</strong><br /><?=$c->conjuge_complemento?>&nbsp;</td>
          <td class="borda2"><strong>Bairro:</strong><br /><?=$c->conjuge_bairro?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>UF:</strong><br /><?=$c->conjuge_estado?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Cidade:</strong><br /><?=$c->conjuge_cidade?>&nbsp;</td>
          <td class="borda2"><strong>CEP:</strong><br /><?=$c->conjuge_cep?>&nbsp;</td>
        </tr>
        <tr>
        <td colspan="4" class="subtitulo">Endereço Atual do Solicitante:&nbsp;</td>
      </tr>
       <tr>
          <td class="borda1" colspan="2"><strong>Endereço:</strong><br /><?=$c->endereco.', '.$c->numero?>&nbsp;</td>
          <td class="borda2"><strong>Complemento:</strong><br /><?=$c->complemento?>&nbsp;</td>
          <td class="borda2"><strong>Bairro:</strong><br /><?=$c->bairro?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>UF:</strong><br /><?=$c->estado?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Cidade:</strong><br /><?=$c->cidade?>&nbsp;</td>
          <td class="borda2"><strong>CEP:</strong><br /><?=$c->cep?>&nbsp;</td>
        </tr>
         <tr>
        <td width="50%" colspan="2" class="borda1"><strong>Tipo do Imóvel:</strong><br /><? switch($c->tip_imovel){
			case 1: echo 'Própria'; break;
			case 2: echo 'Alugada'; break;
			case 3: echo 'Familiares'; break; }?>&nbsp;</td>
        <td width="50%" colspan="2" class="borda2"><strong>Reside na Praça Desde:</strong><br /><?=$c->reside_praca?>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="subtitulo">Endereço Anterior do Solicitante:&nbsp;</td>
      </tr>
       <tr>
          <td class="borda1" colspan="2"><strong>Endereço:</strong><br /><?=$c->anterior_endereco.', '.$c->anterior_numero?>&nbsp;</td>
          <td class="borda2"><strong>Complemento:</strong><br /><?=$c->anterior_complemento?>&nbsp;</td>
          <td class="borda2"><strong>Bairro:</strong><br /><?=$c->anterior_bairro?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>UF:</strong><br /><?=$c->anterior_estado?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Cidade:</strong><br /><?=$c->anterior_cidade?>&nbsp;</td>
          <td class="borda2"><strong>CEP:</strong><br /><?=$c->anterior_cep?>&nbsp;</td>
        </tr>
        <tr>
        <td colspan="4" class="subtitulo">Lazer:&nbsp;</td>
      </tr>
      	<tr>
        	<td class="borda1" colspan="4"><?  $rel_lazer = array();
					$e = $dt->relNomeFichaLazer($id);
					$i = 0;
					foreach($e as $lz => $l){ $rel_lazer[$i] = $l->lazer; $i++; }
					for($i =0;$i < count($rel_lazer);$i++){echo $rel_lazer[$i].'<br /> ';}
            ?></td>
        </tr>
    </table>  </td>
  </tr>
  <tr>
    <td><table width="960" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="4" class="titulo">- Hist&oacute;rico Profissional e Empresarial&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="subtitulo">Experi&ecirc;ncia com Franquias:&nbsp;</td>
      </tr> 
      <tr>
          <td class="borda1" colspan="2" width="50%"><strong>Deseja ser Franqueado, Sócio e/ou Fiador?</strong><br /><?=$c->franqueado?>&nbsp;</td>
          <td colspan="2" class="borda2" width="50%"><strong>Tem Experiência com Franquias?</strong><br /><?=($c->experiencia==1)?'Sim':'Não';?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Se Não, Qual o Motivo de Não Possuir o Negócio?</strong><br /><?=$c->motivo?>&nbsp;</td>
          <td colspan="2" class="borda2"><strong>Se Sim, Responda as Perguntas Abaixo:<br />Número de Funcionários:</strong><br /><?=$c->funcionarios2?>&nbsp;</td>
        </tr>
         <tr>
          <td class="borda1" colspan="2"><strong>Faturamento:</strong><br /><?=$c->faturamento2?>&nbsp;</td>
          <td colspan="2" class="borda2"><strong>Qual Franquia?</strong><br /><?=$c->qual_franquia?>&nbsp;</td>
        </tr>
         <tr>
          <td class="borda1" colspan="4"><strong>Na sua Opinião Quais os Fatores Determinantes para o Sucesso de um Negócio?</strong><br /><?=$c->opiniao?>&nbsp;</td>
        </tr>
        <tr>
        <td colspan="4" class="subtitulo">- Hist&oacute;rico Profissional&nbsp;</td>
      </tr>
      <tr>
          <td class="borda1" colspan="2"><strong>Empresa:</strong><br /><?=$c->empresa_t?>&nbsp;</td>
          <td colspan="2" class="borda2"><strong>Cargo Atual:</strong><br /><?=$c->cargo?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="4"><strong>Faça um Breve Relato Sobre seu Histórico:</strong><br /><?=$c->historico?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Período:</strong><br /><?=$c->periodo?>&nbsp;</td>
          <td class="borda2"><strong>Funcionários:</strong><br /><?=$c->funcionarios?>&nbsp;</td>
          <td class="borda2"><strong>Faturamento:</strong><br /><?=$c->faturamento?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Contato:</strong><br /><?=$c->contato?>&nbsp;</td>
          <td class="borda2"><strong>Ramo de Atuação:</strong><br /><?=$c->ramo_at?>&nbsp;</td>
          <td class="borda2"><strong>Nome da Empresa:</strong><br /><?=$c->empresa_p?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Cursos:</strong><br /><?=$c->cursos?>&nbsp;</td>
          <td colspan="2" class="borda2"><strong>Grau de Escolaridade:</strong><br /><?=$c->escolaridade?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Qual Faculdade?</strong><br /><?=$c->faculdade?>&nbsp;</td>
          <td class="borda2"><strong>Ano de Conclusão:</strong><br /><?=$c->conclusao?>&nbsp;</td>
          <td class="borda2"><strong>Tem ou Teve Negócio Próprio?</strong><br /><?=$c->negocios?>&nbsp;</td>
        </tr>
        <tr>
        <td colspan="4" class="subtitulo">- Sobre a Franquia Cartório Postal&nbsp;</td>
      </tr>
      <tr>
          <td class="borda1" colspan="4"><strong>Enumere o que você considera importante na franquia Cartório Postal, sendo que o número 1 é o mais importante:</strong><br /><?
          $e = $dt->EnumPergunta(); $i = 0;
			foreach($e as $j => $ep){
				$id_pergunta[$i] = $ep->id_enum_perg;
				$pergunta[$i]    = $ep->pergunta;
				$i++;
			}
			for($i = 0; $i < count($id_pergunta); $i++){
				$e = $dt->buscaRelEnumPergunta($id, $id_pergunta[$i]); $valor = $e->valor;
				echo $valor.' '.$pergunta[$i].'<br />';
			}
		  ?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="4"><strong>Como Conheceu as Franquias Cartório Postal:</strong><br /><?=$c->conheceu_cp?></td>
        </tr>
        <tr>
        	<td colspan="2" class="borda1"><strong>Já Esteve em uma de Nossas Unidades?</strong><br /><?=$c->unidades?></td>
            <td class="borda2"><strong>Qual?</strong><br /><?=$c->unidades_valor?></td>
            <td class="borda2"><strong>Deseja Receber Comunicados de Outras Empresas da Rede?</strong><br /><?=$c->comunicados?></td>
        </tr>
        <tr>
          <td class="borda1" colspan="4"><strong>Porque o Interesse em ser um Franqueado?</strong><br /><?=$c->interesse?></td>
        </tr>
        <tr>
          <td class="borda1" colspan="4"><strong>Selecione o Estado e a Cidade de Interesse:</strong><br /><?=$c->estado_interesse.' - '.$c->cidade_interesse?></td>
        </tr>
        <tr>
          <td class="borda1" colspan="4"><strong>Seu Espaço Para Observações:</strong><br /><?=$c->observacao?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="960" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="4" class="titulo">- Informações Financeiras e Adicionais&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="subtitulo">Informações Financeiras:&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2" width="50%"><strong>Tem Capital Imediato Disponível para Investir?</strong><br /><?=$c->capital?>&nbsp;</td>
          <td class="borda2" colspan="2" width="50%"><strong>Valor Disponível:</strong><br /><?=$c->valor_disp?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="4"><strong>Informe se Depende de Empréstimo ou Venda de Bens para Investir em sua Franquia Cartório Postal:</strong><br /><?=$c->emprestimo?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="4"><strong>Informe se o Capital Citado for de Terceiros:</strong><br /><?=$c->capital_terc?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>Quando Pretende dar Início ao Negócio?</strong><br /><?=$c->inicio_neg?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Qual o seu Tempo Dedicado a Franquia?</strong><br /><?=$c->dedicado_franq?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1" colspan="2"><strong>A Franquia Será a Principal Fonte de Renda?</strong><br /><?=$c->fonte_renda?>&nbsp;</td> 
          <td class="borda2" colspan="2"><strong>Pretende Ter Sócios? Especifique.</strong><br /><?=$c->socios?>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="subtitulo">Referências Bancárias:&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>Banco:</strong><br /><?=$c->banco?>&nbsp;</td>
          <td class="borda2"><strong>Cartão de Crédito:</strong><br /><?=$c->cartao_credito?>&nbsp;</td>
          <td class="borda2"><strong>Vencimento:</strong><br /><?=$c->vencimento?>&nbsp;</td>
          <td class="borda2"><strong>Limite:</strong><br /><?=$c->limite?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>Telefone:</strong><br /><?=$c->telefone_banco?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Nome do Gerente:</strong><br /><?=$c->nome_gerente?>&nbsp;</td>
          <td class="borda2"><strong>Agência e Conta:</strong><br /><?=$c->agencia_conta?>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="subtitulo">Demonstrativo de Rendimento:&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>Honorários:</strong><br /><?=$c->honorarios?>&nbsp;</td>
          <td class="borda2"><strong>Salários</strong><br /><?=$c->salarios?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Comissões:</strong><br /><?=$c->comissoes?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>Salário do Conjuge:</strong><br /><?=$c->salario_conjuge?>&nbsp;</td>
          <td class="borda2"><strong>Renda de Aluguéis:</strong><br /><?=$c->renda_alugueis?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Possui Empréstimos Financeiros:</strong><br /><?=$c->emprestimo_financeiro?>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="subtitulo">Bens de Consumo:&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>Modelo do Veículo:</strong><br /><?=$c->modelo_veiculo?>&nbsp;</td>
          <td class="borda2"><strong>Marca do Veículo:</strong><br /><?=$c->marca_veiculo?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Ano do Veículo:</strong><br /><?=$c->ano_veiculo?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>Placa do Veículo:</strong><br /><?=$c->placa_veiculo?>&nbsp;</td>
          <td class="borda2"><strong>Valor do Veículo:</strong><br /><?=$c->valor_veiculo?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Financiado?</strong><br /><?=$c->financiado?>&nbsp;</td>
        </tr>
        <tr>
          <td class="borda1"><strong>Imóvel:</strong><br /><?=$c->imovel?>&nbsp;</td>
          <td class="borda2"><strong>Valor Venal:</strong><br /><?=$c->valor_venal?>&nbsp;</td>
          <td class="borda2" colspan="2"><strong>Somatória do Valor Financiado:</strong><br /><?=$c->somatoria?>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td align="right" height="70"><a href="javascript:self.print()"><img src="http://www.cartoriopostal.com.br/saf/images/estrutura/botoes/imprimir.png" hspace="2" style="width:50px; height:50px;" /></a></td>
  </tr>
</table>
</body>
</html>