<?
require("includes/funcoes_bb.php");

pt_register("GET", "id");

$contaDAO = new ContaDAO();

$id_conta = $id;
#variaveis importantes
#id_conta

function tamanho_string($str, $var = ' ', $lado = 'e', $tamanho)
{
    if ($lado == 'e') {
        $carac = strlen($str);
        while ($carac < $tamanho) {
            $str = $var . $str;
            $carac++;
        }
    } else {
        $carac = strlen($str);
        while ($carac < $tamanho) {
            $str = $str . $var;
            $carac++;
        }
    }
    return $str;
}

pt_register('GET', 'submit');
if ($submit) {

    #captura as informaï¿½ï¿½es do ultimo envio
    $bb = $contaDAO->selectPorId($id_conta, $controle_id_empresa);

    #conta corrente e agencia
    $bb->convenioheader = tamanho_string(trim($bb->codigo), '0', 'e', '9');

    #nome do favorecido
    $bb->favorecido = tamanho_string(trim(strtoupper($bb->favorecido)), ' ', 'd', '30');

    #versao do documento incrementada ï¿½ contada por envio
    $bb->versao++;
    $bb->versao = tamanho_string($bb->versao, '0', 'e', '7');

    #dia e mes para o nome do arquivo
    $diames = date("dm");
    $ano = date("y");

    #data atual e ultima data de envio
    $bb->ultima = str_replace('-', '', $bb->ultima);
    $data = date("dmy");
    $hora = date("Hms");

    #calcula o numero da remessa para definir o nome do arquivo
    if ($bb->ultima == $data) $bb->remessa++; else $bb->remessa = 0;
    $bb->remessa_ = tamanho_string($bb->remessa, '0', 'e', '2');

    #carteira
    $bb->carteira = tamanho_string($bb->carteira, '0', 'e', '2');

    #separaï¿½ï¿½o de agencia e digito
    $bb->agencia = tamanho_string(str_replace('-', '', $bb->agencia), '0', 'e', '6');

    #conta e digito
    $bb->conta = tamanho_string(str_replace('-', '', $bb->conta), '0', 'e', '13');

    #conta e digito
    $bb->banco = strtoupper(tamanho_string($bb->banco, ' ', 'd', '30'));

    $numeroLote = tamanho_string(1, '0', 'e', '4');

    $bb->remessa++;
    $bb->remessa = tamanho_string($bb->remessa, '0', 'e', '8');

    #escreve o header do arquivo de remessa
    $nomeArquivo = "CBR" . $hora  . $diames . $ano . ".REM";
    $arquivoDiretorio = "../boletos/remessabancodobrasil/" . date('Y') . '/' . $nomeArquivo;
    $file_path = "../boletos/remessabancodobrasil/" . date("Y") . "/";

    $linha = 0;

    $headerArquivo = "001" . "0000" . "0" . "         " . "2" . "10914772000192" . $bb->convenioheader . "0014" . $bb->carteira . "019" . "  " . $bb->agencia . $bb->conta . "0" . $bb->favorecido . $bb->banco . "          " . "1" . date("dmY") . date("Hms") . "000000" . "083" . "00000" . "                    " . "                    " . "                             " . "\r\n";
    $linha++;

    $headerLote = "001" . $numeroLote . "1" . "R" . "01" . "  " . "042" . " " . "2" . "010914772000192" . $bb->convenioheader . "0014" . $bb->carteira . "019" . "  " . $bb->agencia . $bb->conta . "0" . $bb->favorecido . "                                        " . "                                        " . $bb->remessa . date("dmY") . "00000000" . "000000000000000000000000000000000" . "\r\n";
    $linha++;

    #variavel do numero de linhas

    $i = 0;


    #captura as informações do ultimo envio
    $brasil = $contaDAO->selectBoletosBrasil($controle_id_empresa, $id_conta);

    $cont = 0;
    foreach ($brasil as $b) {
        $cont++;

        $bb->codigo = tamanho_string(trim($bb->codigo), '0', 'e', '7');

        //nosso número (sem dv) ï¿½ 11 digitos
        $nossonumero = formata_numero($b->id_conta_fatura, 10, 0);

        $b->nossonumero = $bb->codigo . $nossonumero;

        $b->juros_mora = number_format(((float)($b->valor) / 100 * (float)($b->juros_mora) / 30), 2, ".", "");


        #numero do documento
        $b->controle_empresa = tamanho_string($controle_id_empresa . '-' . $b->id_conta_fatura, ' ', 'd', '25');

        #valor de desconto por dia (opcional)
        $b->valor_desc_dia = tamanho_string(str_replace('.', '', $b->valor_desc_dia), '0', 'e', '10');

        #valor cobrado
        $b->valor = tamanho_string(str_replace('.', '', $b->valor), '0', 'e', '15');

        #valor de mora por dia (opcional)
        $b->juros_mora = tamanho_string(str_replace('.', '', $b->juros_mora), '0', 'e', '11');

        #valor de desconto atï¿½ a data (opcional)
        $b->valor_desc = tamanho_string(str_replace('.', '', $b->valor_desc), '0', 'e', '11');

        #valor de abatimento concedido ou cancelado
        $b->abatimento = tamanho_string(str_replace('.', '', $b->abatimento), '0', 'e', '11');

        $b->ocorrencia = tamanho_string($b->ocorrencia, '0', 'e', '2');
        $b->tipo = tamanho_string($b->tipo, '0', 'e', '1');

        #banco e agencia depositï¿½ria
        #if($b->ocorrencia=='01') {
        $b->banco_enc = '000';
        $b->agencia_enc = '00000';
        #}

        $b->instrucao1 = tamanho_string($b->instrucao1, '0', 'e', '2');
        $b->instrucao2 = tamanho_string($b->instrucao2, '0', 'e', '2');

        #dados do sacado
        $b->cpf = tamanho_string(str_replace('-', '', str_replace('/', '', str_replace('.', '', $b->cpf))), '0', 'e', '15');
        $b->sacado = tamanho_string($b->sacado, ' ', 'd', '40');
        $b->endereco = tamanho_string($b->endereco, ' ', 'd', '40');
        $b->bairro = tamanho_string($b->bairro, ' ', 'd', '15');
        $b->cidade = tamanho_string($b->cidade, ' ', 'd', '15');
        $b->estado = tamanho_string($b->estado, ' ', 'd', '2');
        $b->cep = tamanho_string(str_replace('-', '', $b->cep), '0', 'e', '8');

        $b->mensagem1 = tamanho_string($b->mensagem1, ' ', 'd', '12');
        $b->mensagem2 = tamanho_string($b->mensagem2, ' ', 'd', '40');

        $b->numero_beneficiario = tamanho_string($b->numero_beneficiario, ' ', 'e', '15');

        $b->cnpj_sacador = tamanho_string(str_replace('-', '', str_replace('/', '', str_replace('.', '', $b->cnpj_sacador))), '0', 'e', '15');
        $b->nome_sacador = tamanho_string($b->nome_sacador, ' ', 'd', '40');

        switch ($b->especie) {
            case 2:
                $b->especie = 12;
                break;
            case 5:
                $b->especie = 17;
                break;
            case 10:
                $b->especie = 7;
                break;
            case 11:
                $b->especie = 19;
                break;
            case 12:
                $b->especie = "04";
                break;
        }

        $numeroSequencia = tamanho_string($cont, '0', 'e', '5');

        $segmentoP = "001" . $numeroLote . "3" . $numeroSequencia . "P" . " " . "01" . $bb->agencia . $bb->conta . "0" . $b->nossonumero . "   " . "7" . "0" . "0" . "2" . "2" . $b->numero_beneficiario . $b->vencimento . $b->valor . "00000" . " " . $b->especie . $b->aceite . $b->emissao . "0" . "00000000" . "000000000000000" . "0" . "00000000" . "000000000000000" . "000000000000000" . "000000000000000" . "0000000000000000000000000" . "2" . tamanho_string($b->dias_protesto, '0', 'e', '2') . "0" . "000" . "09" . "0000000000" . " " . "\r\n";
        $cont++;
        $linha++;

        $numeroSequencia = tamanho_string($cont, '0', 'e', '5');
        //$segmentoQ = "001" . $numeroLote . "3" . $numeroSequencia . "Q" . " " . "01" . $b->tipo . $b->cpf . $b->sacado . $b->endereco . $b->bairro . "               " . $b->cep . "               " . $b->estado . "0" . $b->cnpj_sacador . "                                        " . "000" . "                    " . "        " . "\r\n";
        $segmentoQ = "001" . $numeroLote . "3" . $numeroSequencia . "Q" . " " . "01" . $b->tipo . $b->cpf . substr($b->sacado, 0, 40) . substr($b->endereco, 0, 40) . substr($b->bairro, 0, 15)  . $b->cep . substr($b->cidade, 0, 15) . $b->estado . "0" . $b->cnpj_sacador . "                                        " . "000" . "                    " . "        " . "\r\n";
        $linha++;


        $conteudoArquivo .= $segmentoP . $segmentoQ;

        $brad_update = $contaDAO->atualizaBoletosBrad($controle_id_empresa,$b->id_conta_fatura);
    }

    $trailerLote = "001" . $numeroLote . "5" . "         " . tamanho_string($linha, '0', 'e', '6') . "                                                                                                                                                                                                                         " . "\r\n";
    $linha++;

    $numeroLote = tamanho_string($numeroLote, '0', 'e', '6');

    $linha++;

    $linha = tamanho_string($linha, '0', 'e', '6');

    $trailerArquivo = "001" . "9999" . "9" . "         " . $numeroLote . $linha . "000000" . "                                                                                                                                                                                                             ";

    $Arquivo = $headerArquivo . $headerLote . $conteudoArquivo . $trailerLote . $trailerArquivo;

    if ($cont == 0) {
        echo "<BR><font style='color: blue;'>&nbsp;&nbsp;Todos os Boletos já foram registrados</font><br />";
    } else {
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777);
        }#alterado

        if (!is_file($arquivoDiretorio)) {
            if (fopen($arquivoDiretorio, "w+")) {
                if (!$handle = fopen($arquivoDiretorio, 'w+')) {
                    echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO: <b>" . $nomeArquivo . "</b>.</font><br />";
                    exit;
                }
                if (!fwrite($handle, $Arquivo)) {
                    echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO: <b>" . $nomeArquivo . "</b>.</font><br />";
                    exit;
                }
                echo '<br><br>Arquivo criado com sucesso!<br>Transmita o arquivo pelo site do banco!<br><br>';
            } else {
                echo "<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>" . $nomeArquivo . "</b>.</font><br />";
                exit;
            }
        } else {
            echo "<BR><font style='color: blue;'>&nbsp;&nbsp;O ARQUIVO <b>" . $nomeArquivo . "</b> JÁ EXISTE.</font><br />";
            exit;
        }

        #Colocar aqui o script para download do arquivo
        $bradesco = $contaDAO->atualizarBrasil($id_conta, $controle_id_empresa, $bradesco->versao, $bradesco->remessa, $arquivoDiretorio);
    }

}
?>