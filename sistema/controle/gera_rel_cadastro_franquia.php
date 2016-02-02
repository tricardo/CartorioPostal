<?
require("../includes/funcoes.php");
require("../includes/verifica_logado_controle.inc.php");
require("../includes/global.inc.php");
require("../classes/spreadsheet_excel_writer/Writer.php");


$c = new stdClass();

if ($_POST) {
    foreach ($_POST as $cp => $valor) {
        $valor = str_replace('por100tagem', '%', $valor);
        $c->$cp = str_replace('**amp**', '&', trim($valor));
    }
}

$arquivo = "cadastro_franquia_" . date("Ym") . ".xls";

$abas = array('Cadastro de Franquia');

$z = 0;

require('../includes/excelstyle.php');
$worksheet = &$workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));


if ($c->c_status == 'on') {
    $worksheet->write(0, $z, 'STATUS', $styletitulo);
    $z++;
}

if ($c->c_status == 'on') {
    $worksheet->write(0, $z, 'TIPO FRANQUIA', $styletitulo);
    $z++;
}

if ($c->c_unidade == 'on') {
    $worksheet->write(0, $z, 'UNIDADE', $styletitulo);
    $z++;
}
if ($c->c_empresa == 'on') {
    $worksheet->write(0, $z, 'EMPRESA', $styletitulo);
    $z++;
}
if ($c->c_nome == 'on') {
    $worksheet->write(0, $z, 'NOME', $styletitulo);
    $z++;
}
if ($c->c_cpf_cnpj == 'on') {
    $worksheet->write(0, $z, 'CPF/CNPJ', $styletitulo);
    $z++;
}
if ($c->c_telefone == 'on') {
    $worksheet->write(0, $z, 'TELEFONE', $styletitulo);
    $z++;
}
if ($c->c_celular == 'on') {
    $worksheet->write(0, $z, 'CELULAR', $styletitulo);
    $z++;
}
if ($c->c_email == 'on') {
    $worksheet->write(0, $z, 'E-MAIL', $styletitulo);
    $z++;
}
if ($c->c_cep == 'on') {
    $worksheet->write(0, $z, 'CEP', $styletitulo);
    $z++;
}
if ($c->c_endereco == 'on') {
    $worksheet->write(0, $z, 'ENDERECO', $styletitulo);
    $z++;
}
if ($c->c_bairro == 'on') {
    $worksheet->write(0, $z, 'BAIRRO', $styletitulo);
    $z++;
}
if ($c->c_complemento == 'on') {
    $worksheet->write(0, $z, 'COMPLEMENTO', $styletitulo);
    $z++;
}
if ($c->c_cidade == 'on') {
    $worksheet->write(0, $z, 'CIDADE', $styletitulo);
    $z++;
}
if ($c->c_uf == 'on') {
    $worksheet->write(0, $z, 'UF', $styletitulo);
    $z++;
}
if ($c->c_banco == 'on') {
    $worksheet->write(0, $z, 'BANCO', $styletitulo);
    $z++;
}
if ($c->c_agencia == 'on') {
    $worksheet->write(0, $z, 'AGENCIA', $styletitulo);
    $z++;
}
if ($c->c_conta == 'on') {
    $worksheet->write(0, $z, 'CONTA', $styletitulo);
    $z++;
}
if ($c->c_favorecido == 'on') {
    $worksheet->write(0, $z, 'FAVORECIDO', $styletitulo);
    $z++;
}
if ($c->c_inicio_contrato == 'on') {
    $worksheet->write(0, $z, 'INICIO DE CONTRATO', $styletitulo);
    $z++;
}
if ($c->c_final_contrato == 'on') {
    $worksheet->write(0, $z, 'FINAL DE CONTRATO', $styletitulo);
    $z++;
}
if ($c->c_liberacao_sistema == 'on') {
    $worksheet->write(0, $z, 'LIBERACAO DO SISTEMA', $styletitulo);
    $z++;
}
if ($c->c_observacoes == 'on') {
    $worksheet->write(0, $z, 'OBSERVACOES', $styletitulo);
    $z++;
}
if ($c->c_royalties == 'on') {
    $worksheet->write(0, $z, 'ROYALTIES', $styletitulo);
    $z++;
}

$financeiroDAO = new FinanceiroDAO();
$lista = $financeiroDAO->relCadastroFranquia($c);

$i = 1;
$saldo_total = 0.0;
$col_royalties = 0;

foreach ($lista as $res) {

    $j = 0;

    if ($c->c_status == 'on') {
        $worksheet->write($i, $j, $res->status, null);
        $j++;
    }
    if ($c->c_tipo_franquia == 'on') {
        $worksheet->write($i, $j, $res->franquia_tipo, null);
        $j++;
    }
    if ($c->c_unidade == 'on') {
        $worksheet->write($i, $j, $res->fantasia, null);
        $j++;
    }
    if ($c->c_empresa == 'on') {
        $worksheet->write($i, $j, $res->empresa, null);
        $j++;
    }
    if ($c->c_nome == 'on') {
        $worksheet->write($i, $j, $res->nome, null);
        $j++;
    }
    if ($c->c_cpf_cnpj == 'on') {
        $worksheet->write($i, $j, $res->cpf, null);
        $j++;
    }
    if ($c->c_telefone == 'on') {
        $worksheet->write($i, $j, $res->tel, null);
        $j++;
    }
    if ($c->c_celular == 'on') {
        $worksheet->write($i, $j, $res->cel, null);
        $j++;
    }
    if ($c->c_email == 'on') {
        $worksheet->write($i, $j, $res->email, null);
        $j++;
    }
    if ($c->c_cep == 'on') {
        $worksheet->write($i, $j, $res->cep, null);
        $j++;
    }
    if ($c->c_endereco == 'on') {
        $worksheet->write($i, $j, $res->endereco, null);
        $j++;
    }
    if ($c->c_bairro == 'on') {
        $worksheet->write($i, $j, $res->bairro, null);
        $j++;
    }
    if ($c->c_complemento == 'on') {
        $worksheet->write($i, $j, $res->complemento, null);
        $j++;
    }
    if ($c->c_cidade == 'on') {
        $worksheet->write($i, $j, $res->cidade, null);
        $j++;
    }
    if ($c->c_uf == 'on') {
        $worksheet->write($i, $j, $res->estado, null);
        $j++;
    }
    if ($c->c_banco == 'on') {
        $worksheet->write($i, $j, $res->banco, null);
        $j++;
    }
    if ($c->c_agencia == 'on') {
        $worksheet->write($i, $j, $res->agencia, null);
        $j++;
    }
    if ($c->c_conta == 'on') {
        $worksheet->write($i, $j, $res->conta, null);
        $j++;
    }
    if ($c->c_favorecido == 'on') {
        $worksheet->write($i, $j, $res->favorecido, null);
        $j++;
    }
    if ($c->c_inicio_contrato == 'on') {
        $worksheet->write($i, $j, invert($res->inauguracao_data, '/', 'PHP'), null);
        $j++;
    }
    if ($c->c_final_contrato == 'on') {
        $worksheet->write($i, $j, invert($res->validade_contrato, '/', 'PHP'), null);
        $j++;
    }
    if ($c->c_liberacao_sistema == 'on') {
        $worksheet->write($i, $j, invert($res->inicio, '/', 'PHP'), null);
        $j++;
    }

    if ($c->c_observacoes == 'on') {
        $worksheet->write($i, $j, $res->observacao, null);
        $j++;
    }

    if ($c->c_royalties == 'on') {
        $col_royalties = $j;
        $worksheet->write($i, $j, $res->valor, $rel_Royialties_style01);
        $saldo_total += (float)($res->valor);
        $j++;
    }

    $i++;
}

if ($c->c_royalties == 'on') {
    $worksheet->write($i, 0, 'Total de Royalties:', null);
    $worksheet->write($i, $col_royalties, $saldo_total, $rel_Royialties_style01);
}

$workbook->close();
?>