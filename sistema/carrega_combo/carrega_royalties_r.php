<?
header("Content-Type: text/html; charset=ISO-8859-1", true);
require("../includes/verifica_logado_ajax.inc.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
$financeiroDAO = new FinanceiroDAO();
$empresaDAO = new EmpresaDAO();
$permissao = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$permissao_fin_cobranca = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);
if (($permissao == 'FALSE' or $controle_id_empresa != 1) and ($permissao_fin_cobranca == 'FALSE' or $controle_id_empresa != 1)) {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}

pt_register('GET', 'id_empresa');
pt_register('GET', 'ref');
$p_valor .=
    '<tr>
			<td class="result_tabela">Recebimento</td>
			<td class="result_tabela">Forma</td>
			<td class="result_tabela">Valor Recebido</td>
			<td class="result_tabela">Descrição</td>
		</tr>';
$rec = $financeiroDAO->recebimentoRoy($ref, $id_empresa);
foreach ($rec as $r) {
    $p_valor .=
        '<tr>
			<td class="result_celula">' . $r->financeiro_data_p . '</td>
			<td class="result_celula">' . $r->financeiro_forma . '</td>
			<td class="result_celula">R$ ' . $r->financeiro_valor . '</td>
			<td class="result_celula">' . $r->financeiro_descricao . '</td>

		</tr>';
}
echo '<table cellpadding="3" cellspacing="1" class="result_tabela">' . $p_valor . '</table>';
?>