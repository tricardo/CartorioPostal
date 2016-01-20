<?

require("../includes/verifica_logado_ajax.inc.php");
require("../includes/funcoes.php");
require("../includes/global.inc.php");
require("../includes/geraexcel/excelwriter.inc.php");

$c = new stdClass();

if ($_POST) {
    foreach ($_POST as $cp => $valor) {
        $valor = str_replace('por100tagem', '%', $valor);
        $c->$cp = str_replace('**amp**', '&', trim($valor));
    }
}

if ($c->c_status == 'on') {
    $campos_header[] = 'STATUS';
}

if ($c->c_unidade == 'on') {
    $campos_header[] = 'UNIDADE';
    $campo_total[] = '';
}

if ($c->c_empresa == 'on') {
    $campos_header[] = 'EMPRESA';
    $campo_total[] = '';
}

if ($c->c_nome == 'on') {
    $campos_header[] = 'NOME';
    $campo_total[] = '';
}

if ($c->c_cpf_cnpj == 'on') {
    $campos_header[] = 'CPF/CNPJ';
    $campo_total[] = '';
}

if ($c->c_telefone == 'on') {
    $campos_header[] = 'TELEFONE';
    $campo_total[] = '';
}

if ($c->c_celular == 'on') {
    $campos_header[] = 'CELULAR';
    $campo_total[] = '';
}

if ($c->c_email == 'on') {
    $campos_header[] = 'E-MAIL';
    $campo_total[] = '';
}

if ($c->c_cep == 'on') {
    $campos_header[] = 'CEP';
    $campo_total[] = '';
}

if ($c->c_endereco == 'on') {
    $campos_header[] = 'ENDERECO';
    $campo_total[] = '';
}

if ($c->c_bairro == 'on') {
    $campos_header[] = 'BAIRRO';
    $campo_total[] = '';
}

if ($c->c_complemento == 'on') {
    $campos_header[] = 'COMPLEMENTO';
    $campo_total[] = '';
}

if ($c->c_cidade == 'on') {
    $campos_header[] = 'CIDADE';
    $campo_total[] = '';
}

if ($c->c_uf == 'on') {
    $campos_header[] = 'UF';
    $campo_total[] = '';
}

if ($c->c_final_contrato == 'on') {
    $campos_header[] = 'FINAL DE CONTRATO';
    $campo_total[] = '';
}

if ($c->c_royalties == 'on') {
    $campos_header[] = "ROYALTIES";
    $campos_header[] = "MES/ANO";
}
if ($c->c_observacoes == 'on') {
    $campos_header[] = "OBSERVACOES";
}

$nomeArquivo = 'franquia_' . date("Ym") . "_" . $controle_id_empresa . ".xls";
$arquivoDiretorio = "../relatorios/cadastrados/" . $nomeArquivo;
$excel = new ExcelWriter($arquivoDiretorio);

$excel->writeLine($campos_header);

$financeiroDAO = new FinanceiroDAO();
$lista = $financeiroDAO->relRoyaltiesEmAberto($c);

$id_empresa = 0;

foreach ($lista as $res) {

    $campos = array();

    if($id_empresa != $res->id_empresa && $id_empresa > 0){
        $campo_total[] = number_format((float)$valor_total, 2, '.', '');
        $excel->writeLine($campo_total);
        $excel->writeRow();
        $excel->writeRow();
        $valor_total = 0;
    }

    $campo_total = array();


    if($c->c_royalties == 'on'){
        $campo_total[] = 'Total';
    }

    if ($c->c_status == 'on') {
        $campos[] = $res->status;
    }

    if ($c->c_unidade == 'on') {
        $campos[] = $res->fantasia;
        $campo_total[] = "";
    }

    if ($c->c_empresa == 'on') {
        $campos[] = $res->empresa;
        $campo_total[] = "";
    }

    if ($c->c_nome == 'on') {
        $campos[] = $res->nome;
        $campo_total[] = "";
    }

    if ($c->c_cpf_cnpj == 'on') {
        $campos[] = $res->cpf;
        $campo_total[] = "";
    }

    if ($c->c_telefone == 'on') {
        $campos[] = $res->tel;
        $campo_total[] = "";
    }

    if ($c->c_celular == 'on') {
        $campos[] = $res->cel;
        $campo_total[] = "";
    }

    if ($c->c_email == 'on') {
        $campos[] = $res->email;
        $campo_total[] = "";
    }

    if ($c->c_cep == 'on') {
        $campos[] = $res->cep;
        $campo_total[] = "";
    }


    if ($c->c_endereco == 'on') {
        $campos[] = $res->endereco;
        $campo_total[] = "";
    }

    if ($c->c_bairro == 'on') {
        $campos[] = $res->bairro;
        $campo_total[] = "";
    }

    if ($c->c_complemento == 'on') {
        $campos[] = $res->complemento;
        $campo_total[] = "";
    }

    if ($c->c_cidade == 'on') {
        $campos[] = $res->cidade;
        $campo_total[] = "";
    }

    if ($c->c_uf == 'on') {
        $campos[] = $res->estado;
        $campo_total[] = "";

    }

    if ($c->c_final_contrato == 'on') {
        $campos[] = $res->validade_contrato;
        $campo_total[] = "";
    }

    if ($c->c_royalties == 'on') {

        $campos[] = number_format($valor_total, 2);
        $campos[] = date("m/Y", strtotime($res->data));
        $valor_total = (float) ($res->valor_royalties) + (float) ($valor_total);
    }

    if ($c->c_observacoes == 'on') {
        $campos[] = $res->observacao;
    }

    $excel->writeLine($campos);

   $id_empresa = $res->id_empresa;

}

$campo_total[] = number_format((float)$valor_total, 2, '.', '');
$excel->writeLine($campo_total);
$excel->writeRow();
$excel->writeRow();
$valor_total = 0;

$excel->close();

header("Content-type: octet/stream");
header("Content-disposition: attachment; filename=exporta/" . $nomeArquivo . ";");
header("Content-Length: " . filesize($arquivoDiretorio));

readfile($arquivoDiretorio);
die();
?>