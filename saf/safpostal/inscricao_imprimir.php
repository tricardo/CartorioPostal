<?
require( "../includes/verifica_logado_safpostal.inc.php" );
require( '../includes/classQuery_sistecart.php' );
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );

?>
<?= '<?xml version="1.0" encoding="iso-8859-1"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<head>

<script src="../SpryAssets/SpryAccordion.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryAccordion.css" rel="stylesheet" type="text/css" />
<link href="../css/paginas.css" rel="stylesheet" type="text/css" />
<link href="../css/estilo.css" rel="stylesheet" type="text/css" />
		<script src="../js/jquery.js" type="text/javascript"></script>
        <script src="../js/box_movel2/jquery-1.2.6.min.js" type="text/javascript"></script>
		<script src="../js/ajax.js" language="javascript" ></script>
        <script src="../js/interface.js" type="text/javascript"></script>
		<script src="../js/js.js" type="text/javascript"></script>

<title>.:Saf Postal:.</title>
<link href="../css/estilo.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="estrutura">

<?
pt_register('GET','id');
$sql = $objQuery_sistecart->SQLQuery
					("SELECT *,date_format(f.data, '%d/%m/%Y') data, date_format(f.data_impressao, '%d/%m/%Y') data_impressao, f.nome, f.rg, f.cpf, f.email, f.nascimento, f.tel_res, f.tel_rec, f.tel_cel, f.estado_civil, f.filhos, f.filhos_quant, f.endereco, f.numero, f.complemento, 
					f.bairro, f.cep, f.estado, f.cidade, f.cargo, f.empresa_t, f.historico, f.escolaridade, f.cursos, f.negocios, f.empresa_p, f.ramo_at, f.periodo, f.funcionarios, f.faturamento, f.capital, 
					f.valor_disp, f.emprestimo, f.capital_terc, f.inicio_neg, f.dedicado_franq, f.fonte_renda, f.socios, f.caixa_empresa, f.conheceu_cp, f.unidades, f.unidades_valor, 
					f.comunicados, f.interesse, f.estado_interesse, f.cidade_interesse, f.observacao, f.status

					FROM site_ficha_cadastro as f WHERE f.id_ficha='" .$id. "'");

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
$data					= $res['data'];
$data_impressao			= $res['data_impressao'];
?>

<div id="gera_orçamento">
<table border="1" width="100%" align="center" cellpadding="4" cellspacing="1" class="tabela3">
<tr>
<td align="center" colspan="5" height="100"><img src="../images/logo.png"></td>
</tr>
<tr>
<td height="20" colspan="5" align="left" valign="top" bgcolor="#EBEFF1"><strong>DADOS PESSOAIS DO INTERESSADO(A)</strong></td>
</tr>
<tr>
<td width="646" height="20" align="left" valign="top"><strong>NOME:<br /></strong><?echo $nome ?></td>
<td width="125" align="left" valign="top"><strong>NASCIMENTO</strong><br /><?echo $nascimento ?></td>
<td height="20" align="left" valign="top"><strong>CADASTRO:<br /></strong><?echo $data ?></td>
<td width="170" align="left" valign="top"><strong>RG:<br /></strong><?echo $rg ?></td>
<td width="141" align="left" valign="top"><strong>CPF:<br /></strong><?echo $cpf ?></td>
</tr>
<tr>
<td height="20" colspan="2" align="left" valign="top"><strong>EMAIL:<br /></strong><?echo $email ?></td>
<td width="171" align="left" valign="top"><strong>ESTADO CIVIL:<br /></strong><?echo $estado_civil ?></td>
<td align="left" valign="top"><strong>POSSUI FILHOS:<br /></strong><?echo $filhos ?></td>
<td align="left" valign="top"><strong>QUANTOS?:<br /></strong><?echo $filhos_quant ?></td>
</tr>
<tr>
<td height="10" colspan="5" align="right" valign="middle"></td>
</tr>
</table>

<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" class="tabela3">
<tr>
<td height="20" colspan="3" align="left" valign="middle" bgcolor="#EBEFF1"><strong>DADOS PARA CONTATO:</strong></td>
</tr>
<tr>
<td width="204" height="20" align="left" valign="top"><strong>TEL RESIDENCIAL:<br /></strong><?echo $tel_res ?></td>
<td width="200" align="left" valign="top"><strong>TEL RECADO:<br /></strong><?echo $tel_rec ?></td>
<td width="211" align="left" valign="top"><strong>TEL CELULAR:<br /></strong><?echo $tel_cel ?></td>
</tr>
<tr>
<td height="10" colspan="3" align="right" valign="middle"></td>
</tr>
</table>

<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tabela3">
<tr>
<td height="20" colspan="3" align="left" valign="middle" bgcolor="#EBEFF1"><strong>ENDERE&Ccedil;O  PARA CONTATO:</strong></td>
</tr>
<tr>
<td width="520" height="20" align="left" valign="top"><strong>ENDERE&Ccedil;O:<br /></strong><?echo $endereco ?></td>
<td width="76" align="left" valign="top"><strong>N&ordm;:<br /></strong><?echo $numero ?></td>
<td width="346" align="left" valign="top"><strong>COMPLEMENTO:<br /></strong><?echo $complemento ?></td>
</tr>
</table>

<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tabela3">
<tr>
<td width="396" height="20" align="left" valign="top"><strong>BAIRRO:<br /></strong><?echo $bairro ?></td>
<td width="100" align="left" valign="top"><strong>CEP:</strong><br />  <?echo $cep ?></td>
<td width="3" align="left" valign="top"><strong>UF:<br /></strong><?echo $estado ?></td>
<td width="387" align="left" valign="top"><strong>CIDADE:<br /></strong><?echo $cidade ?></td></tr>
<tr>
<td height="10" colspan="4" align="right" valign="middle"></td>
</tr>
</table>

<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tabela3">
<tr>
<td height="20" colspan="3" align="left" valign="middle" bgcolor="#EBEFF1"><strong>DADOS DO HISTÓRICO PROFISSIONAL E EMPRESARIAL:</strong></td>
</tr>
<tr>
<td width="395" height="20" align="left" valign="top" colspan="2"><strong>CARGO ATUAL:<br /></strong><?echo $cargo ?></td>
<td align="left" valign="top"><strong>EMPRESA:<br /></strong><?echo $empresa_t ?></td>
</tr>
<tr>
<td height="20" align="left" valign="top" colspan="3"><strong>FAÇA UM BREVE RELATO SOBRE SEU HISTÓRICO:</strong><br /><?echo $historico ?></td>
</tr>
<tr>
<td width="221" height="20" align="left" valign="top"><strong>ESCOLARIDADE:</strong><br /><?echo $escolaridade ?></td>
<td align="left" valign="top"><strong>CURSOS:<br /></strong><?echo $cursos ?></td>
<td width="310" align="left" valign="top"><strong>JÁ TEM OU TEVE NEGÓCIO PRÓPRIO?:<br /></strong><?echo $negocios ?></td>
</tr>
<tr>
<td width="221" height="20" align="left" valign="top"><strong>PERÍODO:</strong><br /><?echo $periodo ?></td>
<td align="left" valign="top"><strong>FUNCIONÁRIOS:<br /></strong><?echo $funcionarios ?></td>
<td width="310" align="left" valign="top"><strong>FATURAMENTO:<br /></strong><?echo $faturamento ?></td>
</tr>
<tr>
<td height="10" colspan="4" align="right" valign="middle"></td>
</tr>
</table>

<table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="tabela3">
<tr>
<td height="20" colspan="3" align="left" valign="middle" bgcolor="#EBEFF1"><strong>DADOS FINANCEIROS E ADICIONAIS:</strong></td>
</tr>
<tr>
<td width="395" height="20" align="left" valign="top" colspan="2"><strong>TEM CAPITAL IMEDIATO DISPONÍVEL PARA INVESTIR?:<br /></strong><?echo $capital ?></td>
<td width="363" align="left" valign="top"><strong>VALOR DISPONÍVEL:<br /></strong><?echo $valor_disp ?></td>
</tr>
<tr>
<td height="20" align="left" valign="top" colspan="3"><strong>INFORME SE DEPENDE DE EMPRÉSTIMO OU VENDA DE BENS PARA INVESTIR EM SUA FRANQUIA CP:</strong><br /><?echo $emprestimo ?></td>
</tr>
<tr>
<td height="20" align="left" valign="top" colspan="3"><strong>INFORME SE O CAPITAL CITADO FOR DE TERCEIROS:</strong><br /><?echo $capital_terc ?></td>
</tr>
<tr>
<td width="395" height="20" align="left" valign="top" colspan="2"><strong>QUANDO PRETENDE DAR INÍCIO AO NEGÓCIO?:<br /></strong><?echo $inicio_neg ?></td>
<td align="left" valign="top"><strong>QUAL O SEU TEMPO DEDICADO A FRANQUIA:<br /></strong><?echo $dedicado_franq ?></td>
</tr>
<tr>
<td width="395" height="20" align="left" valign="top" colspan="2"><strong>A FRANQUIA SERÁ A PRINCIPAL FONTE DE RENDA?:<br /></strong><?echo $fonte_renda ?></td>
<td align="left" valign="top"><strong>PRETENDE TER SÓCIOS? ESPECIFIQUE:<br /></strong><?echo $socios ?></td>
</tr>
<tr>
<td height="20" align="left" valign="top" colspan="3"><strong>QUANTO TEMPO PODERÁ SUPRIR SUAS EMPRESAS ANTES DE UTILIZAR O CAIXA DA EMPRESA?:</strong><br /><?echo $caixa_empresa ?></td>
</tr>
<tr>
<td height="20" align="left" valign="top" colspan="3"><strong>COMO CONHECEU AS FRAQUIAS CARTÓRIO POSTAL:</strong><br /><?echo $conheceu_cp ?></td>
</tr>
<tr>
<td width="355" height="20" align="left" valign="top" colspan="2"><strong>JÁ ESTEVE EM UMA DE NOSSAS UNIDADES?:<br /></strong><?echo $unidades ?><strong> QUAL: </strong><?echo $unidades_valor ?></td>
<td width="455" align="left" valign="top"><strong>DESEJA RECEBER COMUNICADOS DE OUTRAS EMPRESAS DA REDE?:<br /></strong><?echo $comunicados ?></td>
</tr>
<tr>
<td height="20" align="left" valign="top" colspan="3"><strong>PORQUE O INTERESSE EM SER UM FRANQUEADO?:</strong><br /><?echo $interesse ?></td>
</tr>
<tr>
<td width="355" height="20" align="left" valign="top" colspan="3"><strong>ESTADO E CIDADE DE INTERESSE:<br /></strong><?echo $estado_interesse ?><strong> - </strong><?echo $cidade_interesse ?></td>
</tr>
<tr>
<td height="20" align="left" valign="top" colspan="3"><strong>SEU ESPAÇO PARA OBSERVAÇÕES?:</strong><br /><?echo $observacao ?></td>
</tr>
<tr>
<td height="20" align="left" valign="top" colspan="3"><strong>ANOTAÇÕES SOBRE ESTE CADASTRO:</strong><br /><?echo $observacao_expansao ?></td>
</tr>
<tr>
<td width="355" height="20" align="left" valign="top" colspan="2"><strong>STATUS:<br /></strong><?echo $status ?></td>
<td width="455" align="left" valign="top"><strong>ESTÁ FICHA DE CADASTRO FOI VISUALIZADA PELO DEPARTAMENTO DE EXPANSÃO?:<br /></strong><?echo $ficha_enviada ?></td>
</tr>
<tr>
<td width="355" height="20" align="left" valign="top" colspan="2"><strong>DATA DA ATUALIZAÇÃO DO CADASTRO:<br /></strong><?echo $data_impressao ?></td>
<td height="20" colspan="5" align="center" valign="top"><a href="javascript:self.print()" title="Clique aqui para Imprimir"><img src="../images/estrutura/botoes/imprimir.png" width="50" height="50" border="0" /></a></td>
</tr>
</table>
</div>
</div>
</body>
</html>