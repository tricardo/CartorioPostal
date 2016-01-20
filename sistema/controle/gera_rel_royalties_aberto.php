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

$arquivo = "relatorio_royalties_aberto_". date("Ym") . ".xls";

$abas = array('Royalties em Aberto');

$z = 0;
require('../includes/excelstyle.php');
$worksheet = &$workbook->addWorksheet(str_replace(' ', '_', $abas[$i]));

if ($c->c_status == 'on') {
    $worksheet->write(0, $z, 'STATUS', $styletitulo);
    $z++;
}

$worksheet->write(0, $z, 'UNIDADE', $styletitulo);
$z++;

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

if ($c->c_final_contrato == 'on') {
    $worksheet->write(0, $z, 'FINAL DE CONTRATO', $styletitulo);
    $z++;
}

$worksheet->write(0, $z, 'ROYALTIES', $styletitulo);
$z++;
$worksheet->write(0, $z, 'MES/ANO', $styletitulo);
$z++;

if ($c->c_observacoes == 'on') {
    $worksheet->write(0, $z, 'OBSERVACOES', $styletitulo);
    $z++;
}

$financeiroDAO = new FinanceiroDAO();
$lista = $financeiroDAO->relRoyaltiesEmAberto($c);

$id_empresa = 0;
$i = 1;
$col_royalties = 0;
$saldo_total = 0.0;

foreach ($lista as $res) {
    $j = 0;

    if ($id_empresa != $res->id_empresa && $id_empresa > 0) {
        $worksheet->write($i, 0, 'Total:', null);
        $worksheet->write($i, $col_royalties, $valor_total, $rel_Royialties_style01);
        $valor_total = 0;
        $i = $i+2;
    }

    if ($c->c_status == 'on') {
        $worksheet->write($i, $j, $res->status, null);
        $j++;
    }

    $worksheet->write($i, $j, $res->fantasia, null);
    $j++;

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

    if ($c->c_final_contrato == 'on') {
        $worksheet->write($i, $j, $res->validade_contrato, null);
        $j++;
    }

    $col_royalties = $j;

    $worksheet->write($i, $j, $res->valor_royalties, $rel_Royialties_style01);
    $j++;
    $worksheet->write($i, $j, date("m/Y", strtotime($res->data)), null);
    $j++;

    $valor_total = (float)($res->valor_royalties) + (float)($valor_total);
    $saldo_total = (float)($res->valor_royalties) + (float)($saldo_total);

    if ($c->c_observacoes == 'on') {
        if($id_empresa != $res->id_empresa){
            $worksheet->write($i, $j, $res->observacao, null);
            $j++;
        }
    }

     $i++;

    $id_empresa = $res->id_empresa;
}

$worksheet->write($i, 0, 'Total:', null);
$worksheet->write($i, $col_royalties, $valor_total, $rel_Royialties_style01);
$valor_total = 0;
$i = $i+2;

$worksheet->write($i, 0, 'Saldo Total:', null);
$worksheet->write($i, $col_royalties, $saldo_total, $rel_Royialties_style01);


$workbook->close();
?>