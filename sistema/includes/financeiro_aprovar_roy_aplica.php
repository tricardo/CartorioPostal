<?
$errors = 0;
$result = '';
if ((in_array('2', $departamento_p) != 1) and (in_array('19', $departamento_p) != 1)) {
    $errors = 1;
    $result .= '<br><br><strong>Você não tem permissão para realizar essa operação.</strong>';
    exit;
}
pt_register('POST', 'financeiro_descricao');
pt_register('POST', 'financeiro_forma');
pt_register('POST', 'financeiro_data_p');
pt_register('POST', 'financeiro_identificacao');
pt_register('POST', 'financeiro_nossa_conta');
pt_register('POST', 'financeiro_classificacao');
$financeiro_data_p = invert($financeiro_data_p, '-', 'SQL');

$f->financeiro_descricao = $financeiro_descricao;
$f->financeiro_forma = $financeiro_forma;
$f->financeiro_data_p = $financeiro_data_p;
$f->financeiro_identificacao = $financeiro_identificacao;
$f->financeiro_nossa_conta = $financeiro_nossa_conta;
$f->financeiro_classificacao = $financeiro_classificacao;

if ($financeiro_nossa_conta == "") {
    $errors = 1;
    $result .= '<div class="erro"><strong>O campo conta é obrigatório.</strong><br>
		<a href="conta.php">Cadastrar Conta</a></div>';
}

if ($financeiro_forma == "") {
    $errors = 1;
    $result .= '<div class="erro"><strong>O campo forma é obrigatório.</strong><br>
		<a href="conta.php">Cadastrar Conta</a></div>';
}

if ($financeiro_data_p == "--" or $financeiro_data_p > date('Y-m-d')) {
    $errors = 1;
    $result .= '<div class="erro"><strong>Preencha a data do recebimento corretamente.</strong></div>';
}

$im = str_replace(',', "','", str_replace(',##', "", "'" . htmlentities($_COOKIE['fr_id_rel_royalties']) . "##") . "'");
$lista = $financeiroDAO->listaRoyIn($im);

if ($lista[0]->id_rel_royalties == '') {
    $errors = 1;
    $result .= '<div class="erro">- Nenhuma ordem foi selecionada</div>';
}


if ($errors == 0) {
    #verifica permissão
    foreach ($lista as $l) {
        $errors = 0;
        pt_register('POST', 'roy' . $l->id_rel_royalties);
        pt_register('POST', 'fpp' . $l->id_rel_royalties);

        $financeiro_valor = (float)(${'roy' . $l->id_rel_royalties}) + (float)(${'fpp' . $l->id_rel_royalties});
        if ($financeiro_valor == "") {
            $errors = 1;
            $result .= '<div class="erro"><strong>' . $l->fantasia . '</strong>: O campo valor é obrigatório.</div>';
        }

        $f->roy_rec = ${'roy' . $l->id_rel_royalties};
        $f->fpp_rec = ${'fpp' . $l->id_rel_royalties};
        $f->financeiro_valor = $financeiro_valor;
        $f->id_empresa_f = $l->id_empresa;

        if ($errors == 0) {
            $financeiroDAO->inserirRecebimentoRoy($l->id_rel_royalties, $controle_id_empresa, $controle_id_usuario, $f);
            $result .= '<div class="sucesso"><strong>' . $l->fantasia . '</strong>: Registro atualizado com sucesso.</div>';
        }
    }
}
echo $result;

echo "
		<script>
			eraseCookie('fr_rel_royalties');
		</script>
		<div class=\"sucesso\">
			<a href=\"financeiro_royalties.php\">Clique aqui para voltar</a>
		</div>
		";
unset($_COOKIE['fr_id_rel_royalties']);

exit;
?>