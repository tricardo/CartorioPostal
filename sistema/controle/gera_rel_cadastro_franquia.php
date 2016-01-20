<?

require( "../includes/verifica_logado_ajax.inc.php");
require( "../includes/funcoes.php" );
require( "../includes/global.inc.php" );
require("../includes/geraexcel/excelwriter.inc.php");


$c = new stdClass();

if($_POST){
    foreach($_POST as $cp => $valor){
        $valor = str_replace('por100tagem','%',$valor);
        $c->$cp = str_replace('**amp**','&',trim($valor));
    }
}

$campos = array();
$campos_fim = array();

if ($c->c_royalties == 'on'){
    $campos_fim[] = 'Total de Royalties:';
}

if ($c->c_status == 'on') {
    $campos[] = 'STATUS';
}
if ($c->c_tipo_franquia == 'on') {
    $campos[] = 'TIPO FRANQUIA';
    $campos_fim[] = '';
}
if ($c->c_unidade == 'on') {
    $campos[] = 'UNIDADE';
    $campos_fim[] = '';
}
if ($c->c_empresa == 'on') {
    $campos[] = 'EMPRESA';
    $campos_fim[] = '';
}
if ($c->c_nome == 'on') {
    $campos[] = 'NOME';
    $campos_fim[] = '';
}
if ($c->c_cpf_cnpj == 'on') {
    $campos[] = 'CPF/CNPJ';
    $campos_fim[] = '';
}
if ($c->c_telefone == 'on') {
    $campos[] = 'TELEFONE';
    $campos_fim[] = '';
}
if ($c->c_celular == 'on') {
    $campos[] = 'CELULAR';
    $campos_fim[] = '';
}
if ($c->c_email == 'on') {
    $campos[] = 'E-MAIL';
    $campos_fim[] = '';
}
if ($c->c_cep == 'on') {
    $campos[] = 'CEP';
    $campos_fim[] = '';
}
if ($c->c_endereco == 'on') {
    $campos[] = 'ENDERECO';
    $campos_fim[] = '';
}
if ($c->c_bairro == 'on') {
    $campos[] = 'BAIRRO';
    $campos_fim[] = '';
}
if ($c->c_complemento == 'on') {
    $campos[] = 'COMPLEMENTO';
    $campos_fim[] = '';
}
if ($c->c_cidade == 'on') {
    $campos[] = 'CIDADE';
    $campos_fim[] = '';
}
if ($c->c_uf == 'on') {
    $campos[] = 'UF';
    $campos_fim[] = '';
}
if ($c->c_banco == 'on') {
    $campos[] = 'BANCO';
    $campos_fim[] = '';
}
if ($c->c_agencia == 'on') {
    $campos[] = 'AGENCIA';
    $campos_fim[] = '';
}
if ($c->c_conta == 'on') {
    $campos[] = 'CONTA';
    $campos_fim[] = '';
}
if ($c->c_favorecido == 'on') {
    $campos[] = 'FAVORECIDO';
    $campos_fim[] = '';
}
if ($c->c_inicio_contrato == 'on') {
    $campos[] = 'INICIO DE CONTRATO';
    $campos_fim[] = '';
}
if ($c->c_final_contrato == 'on') {
    $campos[] = 'FINAL DE CONTRATO';
    $campos_fim[] = '';
}
if ($c->c_liberacao_sistema == 'on') {
    $campos[] = 'LIBERACAO DO SISTEMA';
    $campos_fim[] = '';
}
if ($c->c_observacoes == 'on') {
    $campos[] = 'OBSERVACOES';
    $campos_fim[] = '';
}
if ($c->c_royalties == 'on'){
    $campos[] = "ROYALTIES";
}

$nomeArquivo = 'franquia_' . date("Ym") . "_" . $controle_id_empresa . ".xls";
$arquivoDiretorio = "../relatorios/cadastrados/" . $nomeArquivo;
$excel = new ExcelWriter($arquivoDiretorio);

$excel->writeLine($campos);

$financeiroDAO = new FinanceiroDAO();
$lista = $financeiroDAO->relCadastroFranquia($c);

foreach ($lista as $res) {

    $campos = array();

    if ($c->c_status == 'on') {
        $campos[] =  $res->status;
    }
    if ($c->c_tipo_franquia == 'on') {
        $campos[] = $res->franquia_tipo;
    }
    if ($c->c_unidade == 'on') {
        $campos[] = $res->fantasia;
    }
    if ($c->c_empresa == 'on') {
        $campos[] = $res->empresa;
    }
    if ($c->c_nome == 'on') {
        $campos[] = $res->nome;
    }
    if ($c->c_cpf_cnpj == 'on') {
        $campos[] = $res->cpf;
    }
    if ($c->c_telefone == 'on') {
        $campos[] = $res->tel;
    }
    if ($c->c_celular == 'on') {
        $campos[] = $res->cel;
    }
    if ($c->c_email == 'on') {
        $campos[] = $res->email;
    }
    if ($c->c_cep == 'on') {
        $campos[] = $res->cep;
    }
    if ($c->c_endereco == 'on') {
        $campos[] = $res->endereco;
    }
    if ($c->c_bairro == 'on') {
        $campos[] = $res->bairro;
    }
    if ($c->c_complemento == 'on') {
        $campos[] = $res->complemento;
    }
    if ($c->c_cidade == 'on') {
        $campos[] = $res->cidade;
    }
    if ($c->c_uf == 'on') {
        $campos[] = $res->estado;
    }
    if ($c->c_banco == 'on') {
        $campos[] = $res->banco;
    }
    if ($c->c_agencia == 'on') {
        $campos[] = $res->agencia;
    }
    if ($c->c_conta == 'on') {
        $campos[] = $res->conta;
    }
    if ($c->c_favorecido == 'on') {
        $campos[] = $res->favorecido;
    }
    if ($c->c_inicio_contrato == 'on') {
        $campos[] = $res->inauguracao_data;
    }
    if ($c->c_final_contrato == 'on') {
        $campos[] = $res->validade_contrato;
    }
    if ($c->c_liberacao_sistema == 'on') {
        $campos[] = $res->inicio;
    }

    if ($c->c_observacoes == 'on') {
        $campos[] = $res->observacao;
    }

    if ($c->c_royalties == 'on'){

        $campos[] = number_format($res->valor, 2, ",", ".");
    }

    $excel->writeLine($campos);

    $valor_total = (float) ($res->valor) + (float) ($valor_total);
}

    if ($c->c_royalties == 'on'){
        $campos_fim[] = number_format($valor_total, 2, ",", ".");
    }

$excel->writeLine($campos_fim);

$excel->close();

header("Content-type: octet/stream");
header("Content-disposition: attachment; filename=exporta/" . $nomeArquivo . ";");
header("Content-Length: " . filesize($arquivoDiretorio));

readfile($arquivoDiretorio);
die();
?>