<?
require("includes/funcoes_bb.php");
$contaDAO = new ContaDAO();

$id_conta=609;
#variaveis importantes
#id_conta

function tamanho_string($str,$var=' ',$lado='e',$tamanho){
    if($lado=='e'){
        $carac=strlen($str);
        while ($carac < $tamanho ){
            $str=$var.$str;
            $carac++;
        }
    } else {
        $carac=strlen($str);
        while ($carac < $tamanho ){
            $str=$str.$var;
            $carac++;
        }
    }
    return $str;
}

pt_register('GET','submit');
if ($submit) {

    #captura as informa��es do ultimo envio
    $bb = $contaDAO->selectPorId($id_conta, $controle_id_empresa);

    #conta corrente e agencia
    $bb->codigo = tamanho_string(trim($bb->codigo),'0','e','7');

    #nome do favorecido
    $bb->favorecido = tamanho_string(trim(strtoupper($bb->favorecido)),' ','d','30');

    #versao do documento incrementada � contada por envio
    $bb->versao++;
    $bb->versao = tamanho_string($bb->versao,'0','e','7');

    #dia e mes para o nome do arquivo
    $diames 	= date("dm");
    $ano 		= date("y");

    #data atual e ultima data de envio
    $bb->ultima = str_replace('-', '', $bb->ultima);
    $data 		= date("dmy");

    #calcula o numero da remessa para definir o nome do arquivo
    if ($bb->ultima==$data)	$bb->remessa++; else $bb->remessa=0;
    $bb->remessa_ = tamanho_string($bb->remessa,'0','e','2');

    #carteira
    $bb->carteira = tamanho_string($bb->carteira,'0','e','2');

    #separa��o de agencia e digito
    $pos = strpos($bb->agencia, '-');
    $bb->agencia = tamanho_string(substr($bb->agencia,0,$pos),'0','e','5');

    #conta e digito
    $bb->conta = tamanho_string(str_replace('-','',$bb->conta),'0','e','9');

    #escreve o header do arquivo de remessa
    $nomeArquivo = "CB".$diames.$bb->remessa_.".REM";
    $arquivoDiretorio = "../boletos/remessabancodobrasil/".date('Y').'/'.$nomeArquivo;
    $file_path = "../boletos/remessabancodobrasil/".date("Y")."/";
    $arquivoConteudo  = "01REMESSA01COBRANCA       ".$bb->agencia.$bb->conta."000000".$bb->favorecido."001BANCO DO BRASIL".$data.$bb->versao."                      ".$bb->codigo."                                                                                                                                                                                                                                                                  "."000001\r\n";

    #variavel do numero de linhas
    $linha=2;
    $i=0;


    #captura as informa��es do ultimo envio
    $brasil = $contaDAO->selectBoletosBrasil($controle_id_empresa, $id_conta);
    $cont=0;
    foreach($brasil as $b){
        $cont++;
        //nosso n�mero (sem dv) � 11 digitos

        $nossonumero = formata_numero($b->id_conta_fatura,10,0);

        //dv do nosso n�mero
        //$dv_nosso_numero = digitoVerificador_nossonumero($nnum);
        $nossonumero = $bb->codigo.$nossonumero;

        $b->juros_mora = number_format(((float)($b->valor)/100*(float)($b->juros_mora)/30),2,".","");

        #nosso numero
        //$b->nossonumero = tamanho_string($b->id_conta_fatura,'0','e','11').$dv_nosso_numero;
        $b->nossonumero = $nossonumero;

        #numero do documento
        $b->controle_empresa = tamanho_string($controle_id_empresa.'-'.$b->id_conta_fatura,' ','d','25');

        #valor de desconto por dia (opcional)
        $b->valor_desc_dia = tamanho_string(str_replace('.','',$b->valor_desc_dia),'0','e','10');

        #valor cobrado
        $b->valor = tamanho_string(str_replace('.','',$b->valor),'0','e','11');

        #valor de mora por dia (opcional)
        $b->juros_mora = tamanho_string(str_replace('.','',$b->juros_mora),'0','e','11');

        #valor de desconto at� a data (opcional)
        $b->valor_desc = tamanho_string(str_replace('.','',$b->valor_desc),'0','e','11');

        #valor de abatimento concedido ou cancelado
        $b->abatimento = tamanho_string(str_replace('.','',$b->abatimento),'0','e','11');

        #numero do documento que � igual a fatura
        $b->documento = tamanho_string($b->id_conta_fatura,' ','d','10');

        $b->ocorrencia = tamanho_string($b->ocorrencia,'0','e','2');
        $b->tipo = tamanho_string($b->tipo,'0','e','2');

        #banco e agencia deposit�ria
        #if($b->ocorrencia=='01') {
        $b->banco_enc = '000';
        $b->agencia_enc = '00000';
        #}

        $b->instrucao1 = tamanho_string($b->instrucao1,'0','e','2');
        $b->instrucao2 = tamanho_string($b->instrucao2,'0','e','2');

        #dados do sacado
        $b->cpf = tamanho_string(str_replace('-','',str_replace('/','',str_replace('.','',$b->cpf))),'0','e','14');
        $b->sacado = tamanho_string($b->sacado,' ','d','37');
        $b->endereco = tamanho_string($b->endereco,' ','d','40');
        $b->mensagem1 = tamanho_string($b->mensagem1,' ','d','12');
        $b->cep = tamanho_string(str_replace('-','',$b->cep),'0','e','8');
        $b->mensagem2 = tamanho_string($b->mensagem2,' ','d','40');
        $sequencia = tamanho_string($linha,'0','e','6');

            $arquivoConteudo .= "7"."02"."00000000000000".$bb->agencia.$bb->conta.$bb->codigo.$b->controle_empresa.$b->nossonumero."00"."00"."   "."0"."   "."019"."0"."000000"."04DSC".$bb->carteira."01"."0000000000".$b->vencimento.$b->valor."001"."0000"." ".$b->especie.$b->aceite.$b->emissao."00"."00".$b->juros_mora.$b->data_desc.$b->valor_desc."00000000000".$b->abatimento.$b->tipo.$b->cpf.$b->sacado."   ".$b->endereco."000000000000".$b->cep."000000000000000"."00".$b->mensagem2."00"." ".$sequencia."\r\n";  // ..$bb->agencia.$bb->conta.$b->controle_empresa."00000000".$b->nossonumero.$b->valor_desc_dia.$b->emissao_papeleta."               ".$b->ocorrencia.$b->documento.$b->vencimento..$b->banco_enc.$b->agencia_enc..$b->instrucao1.$b->instrucao2..$b->data_desc.$b->valor_desc."0000000000000".$b->abatimento.$b->tipo.$b->cpf..$b->endereco.$b->mensagem1.$b->mensagem2."\r\n";
        $brad_update = $contaDAO->atualizaBoletosBrad($controle_id_empresa,$b->id_conta_fatura);

        $linha++;
    }


#lista ocorrencias
   /* $brad = $contaDAO->selectBoletosBradOco($controle_id_empresa);

    foreach($brad as $b){
        $cont++;
        if($b->ocorrencia==31){
            $b->valor 		= $b->valor_o;
            $b->juros_mora 	= $b->juros_mora_o;
            $b->instrucao1 	= $b->instrucao1_o;
            $b->instrucao2 	= $b->instrucao2_o;
            $b->cpf 		= $b->cpf_o;
            $b->sacado 		= $b->sacado_o;
            $b->endereco 	= $b->endereco_o;
            $b->mensagem1 	= $b->mensagem1_o;
            $b->cep 		= $b->cep_o;
            $b->mensagem2 	= $b->mensagem2_o;
            $b->tipo 		= $b->tipo_o;
        }
        //nosso n�mero (sem dv) � 11 digitos
        $nnum = formata_numero($bradesco->carteira,2,0).formata_numero($b->id_conta_fatura,11,0);
        //dv do nosso n�mero
        $dv_nosso_numero = digitoVerificador_nossonumero($nnum);

        #nosso numero
        $b->nossonumero = tamanho_string($b->id_conta_fatura,'0','e','11').$dv_nosso_numero;

        #numero do documento
        $b->controle_empresa = tamanho_string($controle_id_empresa.'-'.$b->id_conta_fatura,' ','d','25');

        #valor de desconto por dia (opcional)
        $b->valor_desc_dia = tamanho_string(str_replace('.','',$b->valor_desc_dia),'0','e','10');

        #valor cobrado
        $b->valor = tamanho_string(str_replace('.','',$b->valor),'0','e','13');

        #valor de mora por dia (opcional)
        $b->juros_mora = tamanho_string(str_replace('.','',$b->juros_mora),'0','e','13');

        #valor de desconto at� a data (opcional)
        $b->valor_desc = tamanho_string(str_replace('.','',$b->valor_desc),'0','e','13');

        #valor de abatimento concedido ou cancelado
        $b->abatimento = tamanho_string(str_replace('.','',$b->abatimento),'0','e','13');

        #numero do documento que � igual a fatura
        $b->documento = tamanho_string($b->id_conta_fatura,' ','d','10');

        $b->ocorrencia = tamanho_string($b->ocorrencia,'0','e','2');
        $b->tipo = tamanho_string($b->tipo,'0','e','2');

        #banco e agencia deposit�ria
        #if($b->ocorrencia=='01') {
        $b->banco_enc = '000';
        $b->agencia_enc = '00000';
        #}

        $b->instrucao1 = tamanho_string($b->instrucao1,'0','e','2');
        $b->instrucao2 = tamanho_string($b->instrucao2,'0','e','2');

        #dados do sacado
        $b->cpf = tamanho_string(str_replace('-','',str_replace('/','',str_replace('.','',$b->cpf))),'0','e','14');
        $b->sacado = tamanho_string($b->sacado,' ','d','40');
        $b->endereco = tamanho_string($b->endereco,' ','d','40');
        $b->mensagem1 = tamanho_string($b->mensagem1,' ','d','12');
        $b->cep = tamanho_string(str_replace('-','',$b->cep),'0','e','8');
        $b->mensagem2 = tamanho_string($b->mensagem2,' ','d','60');
        $sequencia = tamanho_string($linha,'0','e','6');

        $arquivoConteudo .= "1                   0".$bradesco->carteira.$bradesco->agencia.$bradesco->conta.$b->controle_empresa."00000000".$b->nossonumero.$b->valor_desc_dia.$b->emissao_papeleta."               ".$b->ocorrencia.$b->documento.$b->vencimento.$b->valor.$b->banco_enc.$b->agencia_enc.$b->especie.$b->aceite.$b->emissao.$b->instrucao1.$b->instrucao2.$b->juros_mora.$b->data_desc.$b->valor_desc."0000000000000".$b->abatimento.$b->tipo.$b->cpf.$b->sacado.$b->endereco.$b->mensagem1.$b->cep.$b->mensagem2.$sequencia."\r\n";
        $brad_update = $contaDAO->atualizaBoletosBradOco($controle_id_empresa,$b->id_conta_fatura_oco);

        $linha++;
    }
*/
#escreve a ultima linha
    $sequencia = tamanho_string($linha,'0','e','6');
    $arquivoConteudo .= "9                                                                                                                                                                                                                                                                                                                                                                                                         ".$sequencia;

    if($cont==0){
        echo"<BR><font style='color: blue;'>&nbsp;&nbsp;Todos os Boletos j� foram registrados</font><br />";
    } else {
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777);
        }#alterado

        if(!is_file($arquivoDiretorio)) {
            if(fopen($arquivoDiretorio,"w+")) {
                if (!$handle = fopen($arquivoDiretorio, 'w+')) {
                    echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
                    exit;
                }
                if(!fwrite($handle, $arquivoConteudo)) {
                    echo"<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
                    exit;
                }
                echo '<br><br>Arquivo criado com sucesso!<br>Transmita o arquivo pelo site do banco!<br><br>';
            } else {
                echo"<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />";
                exit;
            }
        } else {
            echo"<BR><font style='color: blue;'>&nbsp;&nbsp;O ARQUIVO <b>".$nomeArquivo."</b> J� EXISTE.</font><br />";
            exit;
        }

        #Colocar aqui o script para download do arquivo
        $bradesco = $contaDAO->atualizarBradesco($id_conta,$controle_id_empresa,$bradesco->versao,$bradesco->remessa,$arquivoDiretorio);
    }

}
?>