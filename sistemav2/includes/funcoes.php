<?php
function NomeH1($acao = 1, $arr = array()){
    switch($acao){
        case 1:
            global $VARS;
            if(strlen($VARS->nome) > 0){
                return (substr_count(utf8_encode($VARS->nome),"@cartoriopostal.com.br") > 0) ? str_replace('@cartoriopostal.com.br','',utf8_encode($VARS->nome)) : utf8_encode($VARS->nome);
            } else {
                return str_replace('@cartoriopostal.com.br','',utf8_encode($VARS->email));
            }
            break;
            
        case 2:
            return (substr_count(utf8_encode($arr['nome']),"@cartoriopostal.com.br") > 0) ? str_replace('@cartoriopostal.com.br','',utf8_encode($arr['nome'])) : utf8_encode($arr['nome']);
            break;
    }
}

function CamposObrigatorios(){
    echo '<label class="required">campos marcados em vermelho é de preenchimento obrigatório</label>';
}

function AddRegistro($link = ''){
    echo '<div class="adicionar">
        <h3><a href="'.$link.'">
            <img src="images/bt-add.png" title="Adicionar novo registro" alt="Adicionar novo registro">
            adicionar novo registro
       </a></h3>
    </div>';
}

function CriarVar($arr = array()){
    $vars = new stdClass();
    for($i = 0; $i < count($arr); $i++){
        if(is_array($arr[$i])){
            if(isset($arr[$i]) AND strlen($arr[$i]) > 0){
                $vars->$arr[$i] = '';
            }
        }
    }
    return $vars;
}

function TRColor($color){
    echo 'style="background:'.$color.'" onmouseover="this.style.backgroundColor=\'#FFFFCC\'" onmouseout="this.style.backgroundColor=\''.$color.'\'"';
}

function ProgressoBar($progresso){
    echo '<div class="progresso">
            <div style="width:'.($progresso*6).'px;"></div>
            <p style="color:'.($progresso <= 50 ? '#222' : '#FFF').';'.($progresso == 0 ? 'margin-top:10px' : '').'">'.round($progresso).'%</p>
        </div>';
}

function ConcatVar($nome1, $nome2, $obj, $tipo = ''){
    $nome = $nome1.$nome2;
    if(isset($obj->$nome)){
        return $obj->$nome;   
    } else {
        return $tipo;
    }
}

function ObjToArray($obj){
    $arr = array();
    foreach($obj AS $token => $value){
        $arr[$token] = $value;
    }
    return $arr;
}

function ErrorFiles($id){
    switch($id){
        case 1: return 'O arquivo enviado excede o limite definido na diretiva upload_max_filesize do php.ini.'; break;
        case 2: return 'O arquivo excede o limite definido em MAX_FILE_SIZE no formulário HTML.'; break;
        case 3: return 'O upload do arquivo foi feito parcialmente.'; break;
        case 4: return 'Nenhum arquivo foi enviado.'; break;
        case 6: return 'Pasta temporária ausente. Introduzido no PHP 5.0.3.'; break;
        case 7: return 'Falha em escrever o arquivo em disco. Introduzido no PHP 5.1.0.'; break;
        case 8: return 'Uma extensão do PHP interrompeu o upload do arquivo. O PHP não fornece uma maneira de determinar qual extensão causou a interrupção.'; break;
        default: return 0;
    }
}

function ExtensaoOk($ext, $acao = 1){
    $arr = array('doc','xls','jpg','gif','png','pdf');
    switch($acao){
        case 2: $arr = array_merge($arr, array('txt')); break;
    }
    if(!in_array($ext, $arr)){
        return 'As extensões permitidas para upload são:'.implode(',',$arr).'!';
    }
    return 0;
}

function Post_StdClass($obj){
    $c = new stdClass();
    #$temp = array();
    foreach($obj as $cp => $valor){ 
        if(is_array($valor)){
            $c->$cp = $valor;
        } else {
            #print_r($cp);
            #echo '=';
            $c->$cp = (isset($valor) AND strlen($valor) > 0 AND !is_array($valor)) ? trim($valor) : ''; 
            #print_r($c->$cp);
            #echo "\n";
        }
        #$temp[] = "'".$cp."'";
    }
    #print_r(implode(',',$temp));
    return $c;
}

function MsgBox($acao = 1){
    switch($acao){
        case 1: return 'registro atualizado com sucesso!'; break;
        case 2: return 'registro cadastrado com sucesso!'; break;
        case 3: return 'registro excluído com sucesso!'; break;
    }
    
}

function Post_PtRegister($obj = ''){
    global $_POST;
    foreach($_POST as $cp => $valor){ 
        pt_register('PÒST',$cp);
    }
    return $_POST;
}

function UTF_ArrEncodes($obj = array(), $acao = 1){
    for($i = 0; $i < count($obj); $i++){
        if($acao == 1){
            $obj[$i] = (isset($obj[$i]) AND !empty($obj[$i])) ? utf8_encode($obj[$i]) : '';
        } else {
            $obj[$i]= (isset($obj[$i]) AND !empty($obj[$i])) ? utf8_decode($obj[$i]) : '';
        }
    }
}

function UTF_Encodes($obj, $acao = 1){
    if(count($obj) > 0){
        if(is_object($obj)){
            foreach($obj AS $nome => $valor){
                if(is_array($valor)){
                   $obj->$nome = implode(',', $valor);
                } else {
                    if($acao == 1){
                        $obj->$nome = (isset($valor) AND !empty($valor)) ? utf8_encode($valor) : '';
                    } else {
                        $obj->$nome = (isset($valor) AND !empty($valor)) ? utf8_decode($valor) : '';
                    }
                }
            }
        } else {
            for($i = 0; $i < count($obj); $i++){
                foreach($obj[$i] AS $nome => $valor){
                    if(is_array($valor)){                        
                    } else {
                        if($acao == 1){
                            $obj[$i]->$nome = (isset($valor) AND !empty($valor)) ? utf8_encode($valor) : '';
                        } else {
                            $obj[$i]->$nome = (isset($valor) AND !empty($valor)) ? utf8_decode($valor) : '';
                        }
                    }
                }
            }
        }
    }
    return $obj;
}

function DtVazio($num = 1){
    $html = '';
    for($i = 1; $i <= $num; $i++){
        $html .= '<dt></dt><dd></dd>';
    }
    echo $html;
}

function RetornaVazio($acao = 1, $msg = ''){
    switch($acao){
        case 1:
            echo '<h3>O resultado da sua pesquisa retornou: 0 registro(s) encontrado(s)</h3>';
            break;
        
        case 2:
            echo '<h3>Faça buscas com o formulário acima para carregar o resultado aqui.</h3>';
            break;
        
        case 3:
            echo '<h3>'.$msg.'</h3>';
            break;
    }
}

function RetornaErro($msg = '', $acao = 1){
    switch($acao){
        case 1:
            echo '<h3>'.$msg.'</h3>';
            break;
    }
}

function limpa_string($string) {
    $string = str_replace('á', 'a', $string);
    $string = str_replace('à', 'a', $string);
    $string = str_replace('À', 'A', $string);
    $string = str_replace('Á', 'A', $string);
    $string = str_replace('ã', 'a', $string);
    $string = str_replace('Ã', 'A', $string);
    $string = str_replace('Â', 'A', $string);
    $string = str_replace('â', 'a', $string);

    $string = str_replace('é', 'e', $string);
    $string = str_replace('è', 'e', $string);
    $string = str_replace('È', 'E', $string);
    $string = str_replace('É', 'E', $string);
    $string = str_replace('ê', 'e', $string);
    $string = str_replace('Ê', 'E', $string);
    $string = str_replace('Ë', 'E', $string);
    $string = str_replace('ë', 'e', $string);

    $string = str_replace('í', 'i', $string);
    $string = str_replace('ì', 'i', $string);
    $string = str_replace('Ì', 'I', $string);
    $string = str_replace('Í', 'I', $string);
    $string = str_replace('î', 'i', $string);
    $string = str_replace('Î', 'I', $string);
    $string = str_replace('ï', 'i', $string);
    $string = str_replace('Ï', 'I', $string);

    $string = str_replace('ó', 'o', $string);
    $string = str_replace('ò', 'o', $string);
    $string = str_replace('Ò', 'O', $string);
    $string = str_replace('Ó', 'O', $string);
    $string = str_replace('õ', 'o', $string);
    $string = str_replace('Õ', 'O', $string);
    $string = str_replace('Ô', 'O', $string);
    $string = str_replace('ô', 'o', $string);
    $string = str_replace('ö', 'o', $string);
    $string = str_replace('Ö', 'O', $string);

    $string = str_replace('ú', 'u', $string);
    $string = str_replace('ù', 'u', $string);
    $string = str_replace('Ù', 'U', $string);
    $string = str_replace('Ú', 'U', $string);
    $string = str_replace('û', 'u', $string);
    $string = str_replace('Û', 'U', $string);
    $string = str_replace('ü', 'u', $string);
    $string = str_replace('Ü', 'U', $string);

    $string = str_replace('~', '', $string);
    $string = str_replace('^', '', $string);
    $string = str_replace('´', '', $string);
    $string = str_replace('`', '', $string);
    $string = str_replace('"', '', $string);
    $string = str_replace("'", '', $string);
    $string = str_replace('!', '', $string);
    $string = str_replace('@', '', $string);
    $string = str_replace(']', '', $string);
    $string = str_replace('[', '', $string);
    $string = str_replace('}', '', $string);
    $string = str_replace('{', '', $string);
    $string = str_replace('ç', 'c', $string);
    $string = str_replace('Ç', 'C', $string);
    $string = str_replace(',', '', $string);
    $string = str_replace('.', '', $string);
    $string = str_replace('>', '', $string);
    $string = str_replace('<', '', $string);
    $string = str_replace(':', '', $string);
    $string = str_replace('?', '', $string);
    $string = str_replace('/', '', $string);
    $string = str_replace("\\", '', $string);
    $string = str_replace('|', '', $string);
    $string = str_replace('#', '', $string);
    $string = str_replace('$', '', $string);
    $string = str_replace('%', '', $string);
    $string = str_replace('¨', '', $string);
    $string = str_replace('&', '', $string);
    $string = str_replace('*', '', $string);
    $string = str_replace('(', '', $string);
    $string = str_replace(')', '', $string);
    $string = str_replace('=', '', $string);
    $string = str_replace('+', '', $string);

    return $string;
}

function limpa_url($url) {
    $url = str_replace('á', 'a', $url);
    $url = str_replace('à', 'a', $url);
    $url = str_replace('À', 'A', $url);
    $url = str_replace('Á', 'A', $url);
    $url = str_replace('ã', 'a', $url);
    $url = str_replace('Ã', 'A', $url);
    $url = str_replace('Â', 'A', $url);
    $url = str_replace('â', 'a', $url);

    $url = str_replace('é', 'e', $url);
    $url = str_replace('è', 'e', $url);
    $url = str_replace('È', 'E', $url);
    $url = str_replace('É', 'E', $url);
    $url = str_replace('ê', 'e', $url);
    $url = str_replace('Ê', 'E', $url);
    $url = str_replace('Ë', 'E', $url);
    $url = str_replace('ë', 'e', $url);

    $url = str_replace('í', 'i', $url);
    $url = str_replace('ì', 'i', $url);
    $url = str_replace('Ì', 'I', $url);
    $url = str_replace('Í', 'I', $url);
    $url = str_replace('î', 'i', $url);
    $url = str_replace('Î', 'I', $url);
    $url = str_replace('ï', 'i', $url);
    $url = str_replace('Ï', 'I', $url);

    $url = str_replace('ó', 'o', $url);
    $url = str_replace('ò', 'o', $url);
    $url = str_replace('Ò', 'O', $url);
    $url = str_replace('Ó', 'O', $url);
    $url = str_replace('õ', 'o', $url);
    $url = str_replace('Õ', 'O', $url);
    $url = str_replace('Ô', 'O', $url);
    $url = str_replace('ô', 'o', $url);
    $url = str_replace('ö', 'o', $url);
    $url = str_replace('Ö', 'O', $url);

    $url = str_replace('ú', 'u', $url);
    $url = str_replace('ù', 'u', $url);
    $url = str_replace('Ù', 'U', $url);
    $url = str_replace('Ú', 'U', $url);
    $url = str_replace('û', 'u', $url);
    $url = str_replace('Û', 'U', $url);
    $url = str_replace('ü', 'u', $url);
    $url = str_replace('Ü', 'U', $url);

    $url = str_replace('~', '', $url);
    $url = str_replace('^', '', $url);
    $url = str_replace('´', '', $url);
    $url = str_replace('`', '', $url);
    $url = str_replace('"', '', $url);
    $url = str_replace("'", '', $url);
    $url = str_replace('!', '', $url);
    $url = str_replace('@', '', $url);
    $url = str_replace(']', '', $url);
    $url = str_replace('[', '', $url);
    $url = str_replace('}', '', $url);
    $url = str_replace('{', '', $url);
    $url = str_replace('ç', 'c', $url);
    $url = str_replace('Ç', 'C', $url);
    $url = str_replace(',', '', $url);
    $url = str_replace('.', '', $url);
    $url = str_replace('>', '', $url);
    $url = str_replace('<', '', $url);
    $url = str_replace(';', '', $url);
    $url = str_replace(':', '', $url);
    $url = str_replace('?', '', $url);
    $url = str_replace('/', '', $url);
    $url = str_replace("\\", '', $url);
    $url = str_replace('|', '', $url);
    $url = str_replace('#', '', $url);
    $url = str_replace('$', '', $url);
    $url = str_replace('%', '', $url);
    $url = str_replace('¨', '', $url);
    $url = str_replace('&', '', $url);
    $url = str_replace('*', '', $url);
    $url = str_replace('(', '', $url);
    $url = str_replace(')', '', $url);
    $url = str_replace('=', '', $url);
    $url = str_replace('+', '', $url);

    return $url;
}

function diasemana($data) {
    $ano = substr("$data", 0, 4);
    $mes = substr("$data", 5, -3);
    $dia = substr("$data", 8, 9);

    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
    return $diasemana;
}

function traduzMes($m) {
    if ($m == 1)
        return 'Janeiro';
    elseif ($m == 2)
        return 'Fevereiro';
    elseif ($m == 3)
        return 'Março';
    elseif ($m == 4)
        return 'Abril';
    elseif ($m == 5)
        return 'Maio';
    elseif ($m == 6)
        return 'Junho';
    elseif ($m == 7)
        return 'Julho';
    elseif ($m == 8)
        return 'Agosto';
    elseif ($m == 9)
        return 'Setembro';
    elseif ($m == 10)
        return 'Outubro';
    elseif ($m == 11)
        return 'Novembro';
    elseif ($m == 12)
        return 'Dezembro';
}

/**
 * formata uma data
 * se tipo == SQL recebe dd*mm*yyyy e retorna yyyy*mm*dd
 * se tipo!=SQL recebe yyyy*mm*dd e devolve dd*mm*yyy
 *
 * @param $datainv
 * @param $sep separador para retornar
 * @param $tipo
 */
function invert($datainv, $sep, $tipo, $hora = '') {//recebe a data e o separador
    $datainv = $datainv;
    if ($tipo != 'SQL') {
        $ano = substr("$datainv", 0, 4);
        $mes = substr("$datainv", 5, 2);
        $dia = substr("$datainv", 8, 2);
        $datainv = "$dia$sep$mes$sep$ano";
        if(strlen($hora) > 0){
            $datainv .= ' '.substr("$datainv", 12, 5);
        }
    } else {
        $ano = substr("$datainv", 6, 4);
        $mes = substr("$datainv", 3, 2);
        $dia = substr("$datainv", 0, 2);
        $datainv = $ano . '-' . $mes . '-' . $dia;
        $datainv .= (strlen($hora) > 0) ? ' '.$hora : '';
    }
    return $datainv;
}

function verifica_invert_data($datainv = '', $ret = '', $sep = '-', $tipo = 'SQL', $hora = ''){
    switch($ret){
        case 1:
            if(strlen($datainv) > 0){
                return invert($datainv, $sep, $tipo, $hora);
            } else {
                return $tipo == 'SQL' ? '0000-00-00' : '00/00/0000';
            }
            break;
        
        default:
            return invert($datainv, $sep, $tipo, $hora);
    }
}

function validaData2($data, $formato = 'DD/MM/AAAA') {
    switch($formato) {
        case 'DD-MM-AAAA':
        case 'DD/MM/AAAA':
            list($d, $m, $a) = str_replace('/', '', str_replace('-', '', $data));
        break;

        case 'AAAA/MM/DD':
        case 'AAAA-MM-DD':
            $data = str_replace('/', '', str_replace('-', '', $data));
            $a = substr($data, 0, 4);
            $m = substr($data, 4, 2);
            $d = substr($data, 6, 2);
        break;

        case 'AAAA/DD/MM':
        case 'AAAA-DD-MM':
            list($a, $d, $m) = str_replace('/', '', str_replace('-', '', $data));
        break;

        case 'MM-DD-AAAA':
        case 'MM/DD/AAAA':
            list($m, $d, $a) = str_replace('/', '', str_replace('-', '', $data));
        break;

        case 'AAAAMMDD':
            $a = substr($data, 0, 4);
            $m = substr($data, 4, 2);
            $d = substr($data, 6, 2);
        break;

        case 'AAAADDMM':
            $a = substr($data, 0, 4);
            $d = substr($data, 4, 2);
            $m = substr($data, 6, 2);
        break;

        default:
            return false;
        break;
    }
    return checkdate($m, $d, $a);
}

function valida_data($data, $tipo='DD/MM/AAAA', $hora = ''){  
    if(strlen($hora) == 0){
        switch($tipo){
            case 'DD/MM/AAAA':
                if(strlen($data) == 10){
                    $data = explode('/', $data);
                    return checkdate($data[1], $data[0], $data[2]);
                }
                break;
            case 'AAAA-MM-DD':
                if(strlen($data) == 10){
                    $data = explode('-', $data);
                    return checkdate($data[1], $data[2], $data[0]);
                }
                break;
        }
    }
    return false;
}

function valida_numero($num) {
    if (ereg('[^0-9]', $num)) {
        return 'FALSE';
    }
    return 'TRUE';
}

#verifica permissao
function verifica_permissao($area, $id_departamento_p, $id_departamento_s) {//recebe a data e o separador
    $departamento_s = explode(',', $id_departamento_s);
    $departamento_p = explode(',', $id_departamento_p);
    if (count($departamento_s)) {
        foreach ($departamento_s as $l) {
            $controle_depto_s[$l] = '1';
        }
    }
    if (count($departamento_p)) {
        foreach ($departamento_p as $l) {
            $controle_depto_p[$l] = '1';
        }
    }

    $id_departamento_p = explode(',', $id_departamento_p);
    $id_departamento_s = explode(',', $id_departamento_s);

    switch ($area) {
        case 'Pedido':
            if ($controle_depto_p['2'] == 1 or $controle_depto_p['3'] == 1 or $controle_depto_p['4'] == 1 or $controle_depto_p['5'] == 1 or $controle_depto_p['6'] == 1 or $controle_depto_p['8'] == 1 or $controle_depto_p['9'] == 1 or $controle_depto_p['10'] == 1 or $controle_depto_p['16'] == 1 or $controle_depto_s['19'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
        case 'Conta':
            if ($controle_depto_s['2'] == 1 or $controle_depto_p['14'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Direcao':
            if ($controle_depto_p['16'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Franquia':
            if ($controle_depto_p['16'] == 1 or $controle_depto_p['17'] == 1 or $controle_depto_p['1'] == 1 or $controle_depto_p['28'] == 1)
                return 'TRUE';
            break;
        case 'Rel_gerencial':
            if ($controle_depto_p['16'] == 1 or $controle_depto_s['17'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'EXPANSAO':
            if ($controle_depto_p['3'] == 1 or $controle_depto_p['26'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'EXPANSAO_S':
            if ($controle_depto_s['3'] == 1 or $controle_depto_s['26'] == 1 or $controle_depto_s['1'] == 1)
                return 'TRUE';
            break;
        case 'Rel_supervisores':
            if ($controle_depto_s['3'] == 1 or $controle_depto_s['5'] == 1 or $controle_depto_s['8'] == 1 or $controle_depto_s['9'] == 1 or $controle_depto_s['11'] == 1 or $controle_depto_s['12'] == 1 or $controle_depto_s['15'] == 1 or $controle_depto_s['16'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Rel_n_supervisores':
            if ($controle_depto_p['3'] == 1 or $controle_depto_p['5'] == 1 or $controle_depto_p['8'] == 1 or $controle_depto_p['9'] == 1 or $controle_depto_s['11'] == 1 or $controle_depto_s['12'] == 1 or $controle_depto_s['15'] == 1 or $controle_depto_s['16'] == 1 or $controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Rel_atendimento':
            if ($controle_depto_s['6'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro_rel':
            if ($controle_depto_p['2'] == 1 or $controle_depto_s['16'] == 1)
                return 'TRUE';
            break;
        case 'Rel_financeiro_franquia':
            if ($controle_depto_s['2'] == 1 or $controle_depto_s['16'] == 1)
                return 'TRUE';
            break;
        case 'Imoveis':
            if ($controle_depto_p['8'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Processos':
            if ($controle_depto_p['5'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case '2via':
            if ($controle_depto_p['3'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro':
            if ($controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Cobrança':
            if ($controle_depto_p['19'] == 1)
                return 'TRUE';
            break;
        case 'Pontos de Vendas':
            if ($controle_depto_s['14'] == 1)
                return 'TRUE';
            break;
        case 'Empresas':
            if ($controle_depto_p['1'] == 1)
                return 'TRUE';
            break;
        case 'Cartorio':
            if ($controle_depto_p['3'] == 1 or $controle_depto_p['5'] == 1 or $controle_depto_p['8'] == 1 or $controle_depto_p['9'] == 1 or $controle_depto_p['11'] == 1 or $controle_depto_p['1'] == 1 or $controle_depto_p['6'] == 1)
                return 'TRUE';
            break;
        case 'Duplicidade':
            if ($controle_depto_p['1'] == 1 or $controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Departamento':
            if ($controle_depto_p['8'] == 1 or $controle_depto_p['3'] == 1 or $controle_depto_p['5'] == 1 or $controle_depto_p['9'] == 1)
                return 'TRUE';
            break;
        case 'Protesto':
            if ($controle_depto_p['9'] == 1 or $controle_depto_p['11'] == 1)
                return 'TRUE';
            break;
        case 'Cliente':
            if ($controle_depto_s['10'] == 1 or $controle_depto_s['2'] == 1 or $controle_depto_p['1'] == 1 or $controle_depto_s['14'] == 1 or $controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Parceiro':
            if ($controle_depto_s['10'] == 1 or $controle_depto_s['2'] == 1 or $controle_depto_p['1'] == 1 or $controle_depto_s['14'] == 1 or $controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Pedido Add':
            if ($controle_depto_p['6'] == 1)
                return 'TRUE';
            break;
        case 'Pedido Import':
            if ($controle_depto_s['6'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Pedido Import Cart':
            if ($controle_depto_s['5'] == 1 or $controle_depto_p['16'] == 1)
                return 'TRUE';
            break;
        case 'Direcionamento':
            if ($controle_depto_s['3'] == 1 or $controle_depto_s['4'] == 1 or $controle_depto_s['5'] == 1 or $controle_depto_s['8'] == 1 or $controle_depto_s['9'] == 1 or $controle_depto_s['11'] == 1 or $controle_depto_s['12'] == 1 or $controle_depto_s['18'] == 1)
                return 'TRUE';
            break;
        case 'Direcionamento_site':
            if ($controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Pedido Edit':
            if ($controle_depto_p['10'] == 1 or $controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Desembolsado':
            if ($controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Pedido Edit Valor':
            if ($controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Pedido Edit Troco':
            if ($controle_depto_p['10'] == 1 or $controle_depto_p['2'] == 1)
                return 'TRUE';
            break;
        case 'Remessa_Retorno':
            if ($controle_depto_s['6'] == 1 or $controle_depto_p['5'] == 1)
                return 'TRUE';
            break;
        case 'Supervisor Atendimento':
            if ($controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Supervisor Financeiro':
            if ($controle_depto_s['2'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Compra':
            if ($controle_depto_s['20'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro Pgto':
            if ($controle_depto_s['21'] == 1)
                return 'TRUE';
            break;
        case 'Financeiro PgtoCont':
            if ($controle_depto_s['21'] == 1 or $controle_depto_p['27'] == 1)
                return 'TRUE';
            break;            
        case 'Supervisor':
            if (COUNT($id_departamento_s) > 0)
                return 'TRUE';
            break;
        case 'Franchising':
            if ($controle_depto_p['17'] == 1)
                return 'TRUE';
            break;
        case 'Rel_comercial':
            if ($controle_depto_s['14'] == 1 or $controle_depto_s['16'] == 1)
                return 'TRUE';
            break;
        case 'FAQ':
            if ($controle_depto_s['6'] == 1)
                return 'TRUE';
            break;
        case 'Mala Direta':
            if ($controle_depto_s['17'] == 1 or $controle_depto_s['28'] == 1)
                return 'TRUE';
            break;
    }

    return 'FALSE';
}

// VERIFICA CPF
function validaCPF($cpf) {
    $soma = 0;
    $cpf = str_replace('.', '', $cpf);
    $cpf = str_replace('-', '', $cpf);
    $cpf = str_replace('/', '', $cpf);
    if (strlen($cpf) <> 11 or $cpf == '11111111111' or $cpf == '22222222222' or $cpf == '33333333333' or $cpf == '44444444444' or $cpf == '55555555555' or $cpf == '66666666666' or $cpf == '77777777777' or $cpf == '88888888888' or $cpf == '99999999999') {
        $valida = 'false';
        return $valida;
    }
    // Verifica 1º digito
    //PEGA O DIGITO VERIFIACADOR
    $dv_informado = substr($cpf, 9, 2);

    for ($i = 0; $i <= 8; $i++) {
        $digito[$i] = substr($cpf, $i, 1);
    }

    //CALCULA O VALOR DO 10º DIGITO DE VERIFICAÇÂO
    $posicao = 10;
    $soma = 0;

    for ($i = 0; $i <= 8; $i++) {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }

    $digito[9] = $soma % 11;

    if ($digito[9] < 2) {
        $digito[9] = 0;
    } else {
        $digito[9] = 11 - $digito[9];
    }

    //CALCULA O VALOR DO 11º DIGITO DE VERIFICAÇÃO
    $posicao = 11;
    $soma = 0;

    for ($i = 0; $i <= 9; $i++) {
        $soma = $soma + $digito[$i] * $posicao;
        $posicao = $posicao - 1;
    }

    $digito[10] = $soma % 11;

    if ($digito[10] < 2) {
        $digito[10] = 0;
    } else {
        $digito[10] = 11 - $digito[10];
    }

    //VERIFICA SE O DV CALCULADO É IGUAL AO INFORMADO
    $dv = $digito[9] * 10 + $digito[10];
    $dv_informado = $dv_informado * 1;
    if ($dv != $dv_informado)
        $valida = 'false';
    else
        $valida = 'true';
    return $valida;
}

/**
 * valida se o telefone está no formato (99) 9999-9999
 * @param $tel
 * @return boolean
 */
function validaTel($tel) {
    if(strlen($tel) == 15){
        $pattern = '/(\(\d\d\)) (\d{5}-\d{4})/';
    } else {
        $pattern = '/(\(\d\d\)) (\d{4}-\d{4})/';
    }
    return preg_match($pattern, $tel, $matches);
}

function validaEMAIL($email) {
    $mail_correcto = 0;
    //verifico umas coisas
    if ((strlen($email) >= 6) && (substr_count($email, "@") == 1) && (substr($email, 0, 1) != "@") && (substr($email, strlen($email) - 1, 1) != "@")) {
        if ((!strstr($email, "'")) && (!strstr($email, "\"")) && (!strstr($email, "\\")) && (!strstr($email, "\$")) && (!strstr($email, " "))) {
            //vejo se tem caracter .
            if (substr_count($email, ".") >= 1) {
                //obtenho a terminação do dominio
                $term_dom = substr(strrchr($email, '.'), 1);
                //verifico que a terminação do dominio seja correcta
                if (strlen($term_dom) > 1 && strlen($term_dom) < 5 && (!strstr($term_dom, "@"))) {
                    //verifico que o de antes do dominio seja correcto
                    $antes_dom = substr($email, 0, strlen($email) - strlen($term_dom) - 1);
                    $caracter_ult = substr($antes_dom, strlen($antes_dom) - 1, 1);
                    if ($caracter_ult != "@" && $caracter_ult != ".") {
                        $mail_correcto = 1;
                    }
                }
            }
        }
    }

    if ($mail_correcto)
        return 'true';
    else
        return 'false';
}

// VERFICA CNPJ
function validaCNPJ($cnpj) {
    $cnpj = str_replace('.', '', $cnpj);
    $cnpj = str_replace('-', '', $cnpj);
    $cnpj = str_replace('/', '', $cnpj);
    if (strlen($cnpj) <> 14)
        return 'false';

    $soma = 0;

    $soma += ($cnpj[0] * 5);
    $soma += ($cnpj[1] * 4);
    $soma += ($cnpj[2] * 3);
    $soma += ($cnpj[3] * 2);
    $soma += ($cnpj[4] * 9);
    $soma += ($cnpj[5] * 8);
    $soma += ($cnpj[6] * 7);
    $soma += ($cnpj[7] * 6);
    $soma += ($cnpj[8] * 5);
    $soma += ($cnpj[9] * 4);
    $soma += ($cnpj[10] * 3);
    $soma += ($cnpj[11] * 2);

    $d1 = $soma % 11;
    $d1 = $d1 < 2 ? 0 : 11 - $d1;

    $soma = 0;
    $soma += ($cnpj[0] * 6);
    $soma += ($cnpj[1] * 5);
    $soma += ($cnpj[2] * 4);
    $soma += ($cnpj[3] * 3);
    $soma += ($cnpj[4] * 2);
    $soma += ($cnpj[5] * 9);
    $soma += ($cnpj[6] * 8);
    $soma += ($cnpj[7] * 7);
    $soma += ($cnpj[8] * 6);
    $soma += ($cnpj[9] * 5);
    $soma += ($cnpj[10] * 4);
    $soma += ($cnpj[11] * 3);
    $soma += ($cnpj[12] * 2);


    $d2 = $soma % 11;
    $d2 = $d2 < 2 ? 0 : 11 - $d2;

    if ($cnpj[12] == $d1 && $cnpj[13] == $d2) {
        return 'true';
    } else {
        return 'false';
    }
}

function valida_upload($arquivo, $config) {
    // Verifica se o mime-type do arquivo é de imagem
    $error = '';
    if (!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"])) {
        $error.="<li><b>Arquivo em formato inválido! A imagem deve ser jpg, jpeg,
				bmp, gif ou png. Envie outro arquivo.</b></li>";
    } else {
        // Verifica tamanho do arquivo
        if ($arquivo["size"] > $config["tamanho"]) {
            $error.="<li><b>Arquivo em tamanho muito grande!
			A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. 
			Envie outro arquivo.</b></li>";
        }

        // Para verificar as dimensões da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);

        // Verifica largura
        if ($tamanhos[0] > $config["largura"]) {
            $error.="<li><b>Largura da imagem não deve
					ultrapassar " . $config["largura"] . " pixels.</b></li>";
        }

        // Verifica altura
        if ($tamanhos[1] > $config["altura"]) {
            $error.="<li><b>Altura da imagem não deve
					ultrapassar " . $config["altura"] . " pixels.</b></li>";
        }
    }
    return $error;
}

function valida_upload_pdf($arquivo, $config) {
    // Verifica se o mime-type do arquivo é de imagem
    $error = '';
    if (!eregi("^image\/(pjpeg|jpeg|png|gif|bmp|pdf)$", $arquivo["type"]) and !eregi("^application\/(pdf)$", $arquivo["type"]) and !eregi("text/pdf", $arquivo["type"]) and !eregi("^application/x-www-form-urlencoded$", $arquivo["type"])) {
        $error.="Arquivo em formato inválido! O arquivo deve ser jpg, jpeg,
				bmp, gif, pdf ou png. Envie outro arquivo." . $arquivo["type"];
		
    }
    return $error;
}

function valida_upload_csv($arquivo, $config) {
    // Verifica se o mime-type do arquivo é de imagem
    $error = '';
    if (!eregi(".csv$", $arquivo["type"])) {
        $error.="<li><b>Arquivo em formato inválido! O arquivo precisa ser CSV. Envie outro arquivo.</b></li>";
    }
    return $error;
}

function valida_upload_txt($arquivo) {
    // Verifica se o mime-type do arquivo é de imagem
    $error = '';
    if (!eregi("csv$", $arquivo["type"]) and !eregi("text/comma-separated-values$", $arquivo["type"]) and !eregi("text/plain$", $arquivo["type"]) and !eregi("octet/stream$", $arquivo["type"]) and !eregi("application/octet-stream$", $arquivo["type"])) {
        $error.="<li><b>Arquivo em formato inválido! O arquivo precisa ser RET, REM, CSV ou TXT. Envie outro arquivo.</b></li>" . $arquivo["type"];
    }
    return $error;
}

#soma data

function SomarData($data, $dias, $meses, $ano) {
    //passe a data no formato dd/mm/yyyy
    $data = explode("/", $data);
    $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));
    return $newData;
}

#fim soma data
#soma data

function SubtrairData($data, $dias, $meses, $ano) {
    //passe a data no formato dd/mm/yyyy
    $data = explode("/", $data);
    $newData = date("d/m/Y", mktime(0, 0, 0, $data[1] - $meses, $data[0] - $dias, $data[2] - $ano));
    return $newData;
}

#fim soma data

function ValidaData($dat) {
    $dat = str_replace('.', '', str_replace(' ', '', str_replace('-', '', str_replace('/', '', $dat))));

    $d = substr($dat, 0, 2);
    $m = substr($dat, 2, 2);
    $y = substr($dat, 4, 4);
    if (strlen($dat) < 8 or !is_numeric($d) or !is_numeric($m) or !is_numeric($y))
        return FALSE;

    if (checkdate($m, $d, $y)) {
        return TRUE;
    } else {
        return FALSE;
    }
}

# Gera Thumbnails

function thumbMaker($imagem, $aprox, $destino) {
    if (!file_exists($imagem)) {
        echo "<center><h3>Imagem não encontrada.</h3></center>";
        return false;
    }

    // verifica se está executando sob windows ou unix-like, para a
    // aplicação do separador de diretórios correto.
    $barra = "/";

    // obtém a extensão pelo mime-type
    $ext = getExt($imagem);
    if (!$ext) {
        echo "<center><h3>Tipo inválido</h3></center>";
        return false;
    }
    // separa o nome do arquivo do(s) diretório(s)
    $dir_arq = explode($barra, $imagem);


    // monta o nome do arquivo a ser gerado (thumbnail). O sizeof abaixo obtém o número de itens
    // no array, dessa forma podemos pegar somente o nome do arquivo, não importando em que
    // diretório está.
    $i = sizeof($dir_arq) - 1; // pega o nome do arquivo, sem os diretórios
    $arquivo_miniatura = $destino . $barra . "mini_" . $dir_arq[$i];

    // imagem de origem
    if ($ext == "png")
        $img_origem = imagecreatefrompng($imagem);
    elseif ($ext == "jpg")
        $img_origem = imagecreatefromjpeg($imagem);

    // obtém as dimensões da imagem original
    $origem_x = ImagesX($img_origem);
    $origem_y = ImagesY($img_origem);

    $x = $origem_x;
    $y = $origem_y;

    // Aqui é feito um cálculo para aproximar o tamanho da imagem ao valor passado em $aprox.
    // Não importa se a foto for grande ou pequena, o thumb de todas elas será mais ou menos do
    // mesmo tamanho.
    if ($x >= $y) {
        if ($x > $aprox) {
            $x1 = (int) ($x * ($aprox / $x));
            $y1 = (int) ($y * ($aprox / $x));
        }
        // incluido o else abaixo. Caso a imagem seja menor do que
        // deve ser aproximado, mantém tamanho original para o thumb.
        else {
            $x1 = $x;
            $y1 = $y;
        }
    } else {
        if ($y > $aprox) {
            $x1 = (int) ($x * ($aprox / $y));
            $y1 = (int) ($y * ($aprox / $y));
        }
        // incluido o else abaixo. Caso a imagem seja menor do que
        // deve ser aproximado, mantém tamanho original para o thumb.
        else {
            $x1 = $x;
            $y1 = $y;
        }
    }
    $x = $x1;
    $y = $y1;

    // cria a imagem do thumbnail
    $img_final = ImageCreateTrueColor($x, $y);
    ImageCopyResampled($img_final, $img_origem, 0, 0, 0, 0, $x + 1, $y + 1, $origem_x, $origem_y);

    // o arquivo é gravado
    if ($ext == "png")
        imagepng($img_final, $arquivo_miniatura);
    elseif ($ext == "jpg")
        imagejpeg($img_final, $arquivo_miniatura);

    // a memória usada para tudo isso é liberada.
    ImageDestroy($img_origem);
    ImageDestroy($img_final);

    return true;
}

// getExt - Verifica o mime-type da imagem e retorna a extensão do arquivo
function getExt($imagem) {
    // isso é para obter o mime-type da imagem.
    $mime = getimagesize($imagem);

    if ($mime[2] == 2) {
        $ext = "jpg";
        return $ext;
    } else
    if ($mime[2] == 3) {
        $ext = "png";
        return $ext;
    }
    else
        return false;
}

function somar_dias_uteis($str_data, $int_qtd_dias_somar = 1) {

    $str_data = substr($str_data, 0, 10);
    if ($str_data == '' or $str_data == '0000-00-00' or $str_data == '00-00-0000') {
        return '00/00/0000';
    }

    // Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
    // Transforma para DATE - aaaa-mm-dd
    // Se a data estiver no formato brasileiro: dd/mm/aaaa
    // Converte-a para o padrão americano: aaaa-mm-dd

    if (preg_match("@/@", $str_data) == 1) {
        $str_data = implode("-", array_reverse(explode("/", $str_data)));
    }

    $array_data = explode('-', $str_data);
    $count_days = 0;
    $int_qtd_dias_uteis = 0;

    while ($int_qtd_dias_uteis < $int_qtd_dias_somar) {
        $count_days++;
        $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])));
        if ($dias_da_semana != '0' && $dias_da_semana != '6') {
            $int_qtd_dias_uteis++;
        }
    }

    $str_data_final = gmdate('Y-m-d', strtotime('+' . $count_days . ' day', strtotime($str_data)));
    $array_data = explode('-', $str_data_final);

    $feriadoDAO = new FeriadoDAO();
    $sql_data_prazo = $feriadoDAO->DiasUteis($str_data,$str_data_final);
    $num_feriados = count($sql_data_prazo);

    #Adiciona os feriados
    $count_days = 0;
    $int_qtd_dias_uteis = 0;

    while ($int_qtd_dias_uteis < $num_feriados) {
        $count_days++;
        $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])));
        if ($dias_da_semana != '0' && $dias_da_semana != '6') {
            $int_qtd_dias_uteis++;
        }
    }

    $str_data_final2 = gmdate('Y-m-d', strtotime('+' . $count_days . ' day', strtotime($str_data_final)));
    $array_data = explode('-', $str_data_final2);

    #Adiciona os feriados pela segunda vez caso encontre feriados na primeira busca
    if ($num_feriados <> 0) {
        $sql_data_prazo = $feriadoDAO->DiasUteis($str_data_final,$str_data_final2);
        $num_feriados = count($sql_data_prazo);
        $count_days = 0;
        $int_qtd_dias_uteis = 0;
        while ($int_qtd_dias_uteis < $num_feriados) {
            $count_days++;
            $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])));
            if ($dias_da_semana != '0' && $dias_da_semana != '6') {
                $int_qtd_dias_uteis++;
            }
        }
        $str_data_final = $str_data_final2;
        $str_data_final2 = gmdate('Y-m-d', strtotime('+' . $count_days . ' day', strtotime($str_data_final2)));
        $array_data = explode('-', $str_data_final2);

        #Adiciona os feriados pela terceira vez caso encontre feriados na segunda busca
        if ($num_feriados <> 0) {
            
             $sql_data_prazo = $feriadoDAO->DiasUteis($str_data_final,$str_data_final2);
            $num_feriados = count($sql_data_prazo);
            
            
            $count_days = 0;
            $int_qtd_dias_uteis = 0;
            while ($int_qtd_dias_uteis < $num_feriados) {
                $count_days++;
                $dias_da_semana = gmdate('w', strtotime('+' . $count_days . ' day', mktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0])));
                if ($dias_da_semana != '0' && $dias_da_semana != '6') {
                    $int_qtd_dias_uteis++;
                }
            }
            $str_data_final = $str_data_final2;
            $str_data_final2 = gmdate('Y-m-d', strtotime('+' . $count_days . ' day', strtotime($str_data_final2)));
            $array_data = explode('-', $str_data_final2);
        }
    }

    if (gmdate('w', strtotime($str_data_final2)) == '6') {
        $str_data_final2 = gmdate('Y-m-d', strtotime('+2 day', strtotime($str_data_final2)));
    }

    if (gmdate('w', strtotime($str_data_final2)) == '0') {
        $str_data_final2 = gmdate('Y-m-d', strtotime('+1 day', strtotime($str_data_final2)));
    }

    return $str_data_final2;
}

#fim do gera thumbnails
#dias uteis

function dias_uteis($datainicial, $datafinal=null) {
    if (!isset($datainicial))
        return false;
    if (!isset($datafinal))
        $datafinal = date('d/m/Y');

    $segundos_datainicial = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#", "$3/$2/$1", $datainicial));
    $segundos_datafinal = strtotime(preg_replace("#(\d{2})/(\d{2})/(\d{4})#", "$3/$2/$1", $datafinal));
    $dias = abs(floor(floor(($segundos_datafinal - $segundos_datainicial) / 3600) / 24));
    $uteis = 0;
    for ($i = 1; $i <= $dias; $i++) {
        $diai = $segundos_datainicial + ($i * 3600 * 24);
        $w = date('w', $diai);
        if ($w == 0) {
            //echo date('d/m/Y',$diai)." ? Domingo<br />";
        } elseif ($w == 6) {
            //echo date('d/m/Y',$diai)." ? Sábado<br />";
        } else {
            //echo date('d/m/Y',$diai)." ? dia útil<br />";
            $uteis++;
        }
    }
    return $uteis;
}

function __autoload($classe) {
    $dir = preg_match('/^([A-Z][a-z]+)DAO/i', $classe, $result);
    if(defined('AUTOLOAD_CLASS')){
        if(substr_count($classe, 'DAO') > 0){
            if (is_file("model/" . $result[1] . "DAO.php")) {
                require_once("model/" . $result[1] . "DAO.php");
                return;
            } else {
                print_r('<h1 style="color:#CC0000">Classe '.$classe.' não encontrada!</h1>');
                exit;
            }
        } else {
            $dir = preg_match('/^([A-Z][a-z]+)CLASS/i', $classe, $result);
            if (is_file("classes/" . $result[1] . "CLASS.php")) {
                require_once("classes/" . $result[1] . "CLASS.php");
                return;
            } else {
                print_r('<h1 style="color:#CC0000">Classe '.$classe.' não encontrada!</h1>');
                exit;
            }
        }
    } else {
        if (is_file("../model/" . $result[1] . "DAO.php")) {
            require_once("../model/" . $result[1] . "DAO.php");
            return;
        } else {
            $dir = preg_match('/^([A-Z][a-z]+)CLASS/i', $classe, $result);
            if (is_file("../classes/" . $result[1] . "CLASS.php")) {
                require_once("../classes/" . $result[1] . "CLASS.php");
                return;
            } else {
                print_r('<h1 style="color:#CC0000">Classe '.$classe.' não encontrada!</h1>');
                exit;
            }
        }
    }
}

function formatarCPF_CNPJ($campo, $formatado = true) {
    //retira formato
    $codigoLimpo = ereg_replace("[' '-./ t]", '', $campo);
    // pega o tamanho da string menos os digitos verificadores
    $tamanho = (strlen($codigoLimpo) - 2);
    //verifica se o tamanho do código informado é válido
    if ($tamanho != 9 && $tamanho != 12) {
        return false;
    }

    if ($formatado) {
        // seleciona a máscara para cpf ou cnpj
        $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';

        $indice = -1;
        for ($i = 0; $i < strlen($mascara); $i++) {
            if ($mascara[$i] == '#')
                $mascara[$i] = $codigoLimpo[++$indice];
        }
        //retorna o campo formatado
        $retorno = $mascara;
    }else {
        //se não quer formatado, retorna o campo limpo
        $retorno = $codigoLimpo;
    }

    return $retorno;
}

function AjaxPaginacao($lista) {
    $total = $lista[0];
    $qtde_pagina = $lista[1];
    $num_pagina = $lista[2];
    $pagina = $lista[3];
    $form = $lista[4];
    $limite = 12;

    if ($total > 1) {
        $paginacao .= '&nbsp;Foram encontrados ' . $total . ' registros nesta forma de busca.<br />';
        if (($total % $qtde_pagina) == 0) {
            $total_loop = $total / $qtde_pagina;
        } else {
            $total_loop = (int) (($total / $qtde_pagina) + 1);
        }
        $paginacao .= '&nbsp;';
        if ($total > $qtde_pagina) {
            $paginacao .= '<a href="#" onclick="AjaxPaginacao(\'' . $pagina . '\',0, \'' . $form . '\');" style="color:#333333; font-weight:bold"><< primeira</a> |&nbsp;&nbsp;';
            for ($i = ($num_pagina - $limite); $i <= ($num_pagina + $limite); $i++) {
                if ($i > 0 && $i < $total_loop) {
                    if ($i == ($num_pagina + 1)) {
                        if ($i < 10) {
                            $paginacao .= '<span style="font-weight:bold">[0' . $i . ']</span> |&nbsp;&nbsp;';
                        } else {
                            $paginacao .= '<span style="font-weight:bold">[' . $i . ']</span> |&nbsp;&nbsp;';
                        }
                        //$i++;
                    } else {
                        $paginacao .= '<a href="#" onclick="AjaxPaginacao(\'' . $pagina . '\',' . ($i - 1) . ', \'' . $form . '\');" style="color:#333333">';
                        if ($i < 10)
                            $paginacao .= '0' . $i;
                        else
                            $paginacao .= $i;

                        $paginacao .= '</a> | ';
                    }
                }
            }
            $paginacao .= ' <a href="#" onclick="AjaxPaginacao(\'' . $pagina . '\',' . ($total_loop - 1) . ', \'' . $form . '\');" style="color:#333333; font-weight:bold">última >></a>&nbsp;&nbsp;';
        }
    } else {
        $paginacao .= '&nbsp;Foi encontrado 01 registro nesta forma de busca.<br />';
    }

    return $paginacao;
}

function FormataNumero($str) {
    for ($i = 0; $i < strlen($str); $i++) {
        if (
                $str[$i] == '0' ||
                $str[$i] == '1' ||
                $str[$i] == '2' ||
                $str[$i] == '3' ||
                $str[$i] == '4' ||
                $str[$i] == '5' ||
                $str[$i] == '6' ||
                $str[$i] == '7' ||
                $str[$i] == '8' ||
                $str[$i] == '9'
        ) {
            $campo .= $str[$i];
        }
    }
    return $campo;
}

function FormataControleId($n) {
    $id_ficha = '';
    for ($i = 0; $i < (6 - strlen($n)); $i++) {
        $id_ficha .= '0';
    }
    $id_ficha .= $n;
    $id_ficha = substr($id_ficha, 0, 3) . '.' . substr($id_ficha, -3, 3);
    return $id_ficha;
}

function FormataInteresse($acao, $field) {
    $retorno = $field;
    switch ($acao) {
        case 1:
            if (strlen($retorno) > 0) {
                $d1 = explode(' ', $retorno);
                $d2 = explode('-', $d1[0]);
                $retorno = $d2[2] . '/' . $d2[1] . '/' . $d2[0];
            }
            break;

        case 2:
            switch ($retorno) {
                case 0: $retorno = 'Aberto';
                    break;
                case 1: $retorno = 'Aprovado';
                    break;
                case 2: $retorno = 'Reprovado';
                    break;
            }
            break;

        case 3:
            $retorno = (strlen($retorno) == 0) ? '&nbsp;' : $retorno;
            break;

        case 4:
            $retorno = ($field->total == 1) ? 'Foi encontrado ' : 'Foram encontrados ';
            $retorno .= $field->total;
            $retorno .= ($field->total == 1) ? ' registro.' : ' registros.<br />';
            $k = (($field->total % $field->paginacao) == 0) ? ($field->total / $field->paginacao) : ($field->total / $field->paginacao) + 1;
            $k = (int) $k;
            if ($k > 1) {
                if ($field->pagina > 0) {
                    $retorno .= '<a href="?pagina=' . $field->pagina . '">anterior</a> ';
                }
                $field->pagina = $field->pagina + 1;
                for ($i = 1; $i <= $k; $i++) {
                    if ($field->pagina == $i) {
                        $retorno .= '<strong>[' . $i . ']</strong> ';
                    } else {
                        $retorno .= '<a href="?pagina=' . $i . '">' . $i . '</a> | ';
                    }
                }
                if ($field->pagina < $k) {
                    $retorno .= '<a href="?pagina=' . ($field->pagina + 1) . '">próxima</a> ';
                }
            }
            break;
    }
    return $retorno;
}

function ultimoDiaMes($data="") {
    if (!$data) {
        $dia = date("d");
        $mes = date("m");
        $ano = date("Y");
    } else {
        $data2 = explode('/', $data);
        $dia = $data2[0];
        $mes = $data2[1];
        $ano = $data2[2];
    }
    $data = mktime(0, 0, 0, $mes + 1, $dia - 1, $ano);
    return date('d', $data);
}

function mes_ext($mes) {
    switch ($mes) {
        case 01:
            return 'Janeiro';
            break;
        case 02:
            return 'Fevereiro';
            break;
        case 3:
            return 'Março';
            break;
        case 4:
            return 'Abril';
            break;
        case 5:
            return 'Maio';
            break;
        case 6:
            return 'Junho';
            break;
        case 7:
            return 'Julho';
            break;
        case 8:
            return 'Agosto';
            break;
        case 9:
            return 'Setembro';
            break;
        case 10:
            return 'Outubro';
            break;
        case 11:
            return 'Novembro';
            break;
        case 12:
            return 'Dezembro';
            break;
    }
}

function UFs($acao = 1){
    $CepDAO = new CepDAO();
    $arr    = array();
    switch($acao){
        case 1:
            foreach ($CepDAO->ufs() AS $l){
                $arr[] = $l->estado_sigla;
            }
            return $arr;
            break;
        default:
                return array('AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT',
                    'MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP',
                    'SE','TO');
    }
}

function RelTipTit($pg = ''){
    $arr = array();
    switch($pg){
        case 'atendimento': 
            $arr = array('titulo'=>'Atendimento','sub'=>33,'retorno'=>'relatorios-atendimento.php'); 
            break;
        case 'financeiro': 
            $arr = array('titulo'=>'Financeiro','sub'=>36,'retorno'=>'relatorios-financeiro.php'); 
            break;
        case 'cancelados': 
            $arr = array('titulo'=>'Financeiro','sub'=>36); 
            break;
        case 'em-aberto': 
            $arr = array('titulo'=>'Financeiro','sub'=>36); 
            break;
        case 'diretoria': 
            $arr = array('titulo'=>'Diretoria','sub'=>34,'retorno'=>'relatorios-diretoria.php'); 
            break;
        case 'expansao': 
            $arr = array('titulo'=>'Expansão','sub'=>35,'retorno'=>'relatorios-expansao.php'); 
            break;
        case 'operacional': 
            $arr = array('titulo'=>'Operacional','sub'=>38,'retorno'=>'relatorios-operacional.php'); 
            break;
        case 'franquia': 
            $arr = array('titulo'=>'Franquia','sub'=>37,'retorno'=>'relatorios-franquia.php'); 
            break;
    }
    return $arr;
}

function TableFields($tipo = 1){
    switch($tipo){
        case 1:
            return array(array('c_atendente','Atendente'),
                        array('c_cidade','Cidade'),
                        array('c_dpto','Departamento'),
                        array('c_entrega','Entrega'),
                        array('c_estado','Estado'),
                        array('c_forma','Forma de Pagamento'),
                        array('c_origem','Origem'),
                        array('c_prazo','Prazo'),
                        array('c_programado','Programado'),
                        array('c_servico','Serviço'),
                        array('c_status','Status'));
            break;
    }
}


function TiposDeStatus($acao = 1){
    $ret = array();
    switch($acao){
        case 1:
            $ret[0] = array('id'=>'Ativo','texto'=>'Ativo');
            $ret[1] = array('id'=>'Inativo','texto'=>'Inativo');
            break;
        
        case 2:
            $ret[0] = array('id'=>1,'texto'=>'Master');
            $ret[1] = array('id'=>2,'texto'=>'Unitária');
            $ret[2] = array('id'=>3,'texto'=>'Subfranquia');
            $ret[3] = array('id'=>4,'texto'=>'Internacional');
            break;
        
        case 3:
            $ret[0] = array('id'=>'Ativo','texto'=>'Ativo');
            $ret[1] = array('id'=>'Bloqueado','texto'=>'Bloqueado');
            $ret[2] = array('id'=>'Cancelado','texto'=>'Cancelado');
            $ret[3] = array('id'=>'Implantação','texto'=>'Implantação');
            $ret[4] = array('id'=>'Inativo','texto'=>'Inativo');
            break;
        
        case 4:
            $ret[0] = array('id'=>1,'texto'=>'Sim');
            $ret[1] = array('id'=>0,'texto'=>'Não');
            break;
        
        case 5:
            $ret[0] = array('id'=>'Ativo','texto'=>'Ativo');
            $ret[1] = array('id'=>'Cancelado','texto'=>'Cancelado');
            $ret[2] = array('id'=>'Inativo','texto'=>'Inativo');
            break;
        
        case 6:
            $ret[0] = array('id'=>1,'texto'=>'Cartório');
            $ret[1] = array('id'=>0,'texto'=>'Contato');
            break;
        
        case 7:
            $ret[0] = array('id'=>1,'texto'=>'Ativo');
            $ret[1] = array('id'=>2,'texto'=>'Cancelado');
            break;
        
        case 8:
            $ret[0] = array('id'=>'','texto'=>'Sem Endosso');
            $ret[1] = array('id'=>'T','texto'=>'Endosso Translativo');
            $ret[2] = array('id'=>'M','texto'=>'Endosso Mandato');
            break;
        
        case 9:
            $ret[0] = array('id'=>'A','texto'=>'Aceitos');
            $ret[1] = array('id'=>'N','texto'=>'Não Aceitos');
            break;
        
        case 10:
            $ret[0] = array('id'=>'CPF','texto'=>'CPF');
            $ret[1] = array('id'=>'CNPJ','texto'=>'CNPJ');
            break;
        
        case 11:
            $ret[0] = array('id'=>'Em Aberto','texto'=>'Em Aberto');
            $ret[1] = array('id'=>'Iniciar Cotação','texto'=>'Iniciar Cotação');
            $ret[2] = array('id'=>'Concluída','texto'=>'Concluída');
            break;
        
        case 12:
            $ret[0] = array('id'=>'0','texto'=>'Desembolso Pendente');
            $ret[1] = array('id'=>'1','texto'=>'Desembolso Aprovado');
            $ret[2] = array('id'=>'2','texto'=>'Desembolso Reprovado');
            $ret[3] = array('id'=>'3','texto'=>'Em Andamento');
            $ret[4] = array('id'=>'4','texto'=>'Em Execução');
            
            break;
    }
    return $ret;
}

function listar_arquivos($p){
    $diretorio = dir($p);
    $arr = array();
    $excluir = array('.','..','Thumbs.db','Thumbs');
    while($arquivo = $diretorio->read()){
        if(strlen($arquivo) > 0 AND !in_array($arquivo, $excluir)){
            $texto = str_replace('-',' ',str_replace('.png','',str_replace('.jpg','',$arquivo)));
            $arr[$arquivo] = array('id'=>$arquivo,'texto'=>$texto);
        }
    }
    sort($arr);
    return $arr;
}

function assinaturas($acao = 1){
    $path = "assinaturas/";
    $diretorio = dir($path);
    
    $arr = array();
    while($arquivo = $diretorio->read()){
        if(strlen($arquivo) > 0 AND $arquivo != '.' AND $arquivo != '..'){
            $texto = str_replace('-',' ',str_replace('.png','',str_replace('.jpg','',$arquivo)));
            $arr[$arquivo] = array('id'=>$arquivo,'texto'=>$texto);
        }
    }
    sort($arr);
    return $arr;
}

function lista_emails($lista){
    switch($lista){
        case 'mala_direta':
            return 'roberto.magalhaes@cartoriopostal.com.br;claudia.mattos@cartoriopostal.com.br;fabiana.abreu@cartoriopostal.com.br;';
            
        case 'juridico':    
            return 'renato.bacin@cartoriopostal.com.br,Renato Bacin;
			priscila.paro@cartoriopostal.com.br,Priscila Paro;weslley.floriano@cartoriopostal.com.br,Weslley Floriano';
            break;
        
        case 'implantacao':
            return 'ti@cartoriopostal.com.br,TI;nivaldo.silva@cartoriopostal.com.br,Nivaldo Silva';
            break;
    }
}

function DataAno($tipo = 1, $var = ''){
    switch($tipo){
        case 1:
            return array('01'=>'Janeiro','02'=>'Fevereiro','03'=>'Março','04'=>'Abril','05'=>'Maio','06'=>'Junho',
                '07'=>'Julho','08'=>'Agosto','09'=>'Setembro','10'=>'Outubro','11'=>'Novembro','12'=>'Dezembro');
            break;
        
        case 2:
            $arr = array();
            for($i = 2008; $i <= date('Y'); $i++){
                $arr[$i] = $i;
            }
            return $arr;
            break;
            
        case 3:
            $arr = array();
            for($i = 1; $i <= 31; $i++){
                $arr[$i < 10 ? '0'.$i : $i] = $i < 10 ? '0'.$i : $i;
            }
            return $arr;
            break;
            
        case 4:
            $var = (int) $var;
            $var = $var < 10 ? '0'.$var : $var;
            $arr = array('01'=>'Janeiro','02'=>'Fevereiro','03'=>'Março','04'=>'Abril','05'=>'Maio','06'=>'Junho',
                '07'=>'Julho','08'=>'Agosto','09'=>'Setembro','10'=>'Outubro','11'=>'Novembro','12'=>'Dezembro');
            return $arr[$var];
            break;
        
        case 5:
            $arr = array();
            for($i = 2008; $i <= (date('Y')+5); $i++){
                $arr[$i] = $i;
            }
            return $arr;
            break;
    }
}


function TravaFormExp($status){
    global $permissao2;
    global $controle_id_usuario;
    $travar = '';
    if($status == 14 || $status == 18){
        if($permissao2 == 'FALSE' AND $status == 14){
            $travar = ' onsubmit = "alert(\'Esta Ficha Foi Finalizada!\');return false;"';
        }
        if($status == 18 AND $controle_id_usuario != 1){
            $travar = ' onsubmit = "alert(\'Esta Ficha Foi Finalizada!\');return false;"';
        }
    }
    return $travar;
}

function NomeCpExp($i, $f){
    switch($i){ 
        case 0: $nome = 'conjuge_'.$f; break;
        case 4: $nome = 'anterior_'.$f; break;
        case 6:
            $nome = ($f == 'telefone') ? $f.'_banco' : $f;
            break;
        case 7:
            switch($f){
                case 'num_cof': case 'origem': 
                    $nome = $f.'2';
                    break;

                default: $nome = $f;
            }
            break;
        default: $nome = $f;
    }
    
    return $nome;
}

function navegador($acao = 1){
    switch($acao){
        case 1:
            $useragent = $_SERVER['HTTP_USER_AGENT'];

            if ((substr_count($useragent,"MSIE") > 0)) {
              return 'ie';
            } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
              $browser_version=$matched[1];
              return 'opera';
            } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
              $browser_version=$matched[1];
              return 'firefox';
            } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
              $browser_version=$matched[1];
              return '';
            } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
              $browser_version=$matched[1];
              return 'safari';
            } else {
              $browser_version = 0;
              return '';
            }
            break;
            
            
        case 2:
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            
            if ((substr_count($useragent,"MSIE") > 0)) {
              return 'ie';
            } elseif (preg_match( '|Opera/([0-9].[0-9]{1,2})|',$useragent,$matched)) {
              $browser_version=$matched[1];
              return 'opera';
            } elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
              $browser_version=$matched[1];
              return 'firefox';
            } elseif(preg_match('|Chrome/([0-9\.]+)|',$useragent,$matched)) {
              $browser_version=$matched[1];
              return 'chrome';
            } elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
              $browser_version=$matched[1];
              return 'safari';
            } else {
              $browser_version = 0;
              return 'other';
            }
            
            break;
    }
}

function NoExplorer(){
    echo '<!DOCTYPE html>
        <html>
        <head>
        <title>SISTEMA CARTÓRIO POSTAL</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        </head>
        <body>';
    echo '<h1>Internet Explorer<h1>';
    echo '<p>Olá,</p>';
    echo '<p>Este navegador não foi aprovado pela equipe de TI.</p>';
    echo '<p>Por favor use outro navegador.</p>';
    echo '</body></html>';
}

function VerificaNavegadorSO() {
    $ip = $_SERVER['REMOTE_ADDR'];

    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }


    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/AppleWebKit/i',$u_agent))
    {
        $bname = 'AppleWebKit';
        $ub = "Opera";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }

    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
    }


    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    $num_version = 0;
    if ((substr_count($version,".") > 0)) {
        $num_version = explode('.', $version);
        $num_version = $num_version[0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    $Browser = array(
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => $version,
            'num_version'=> $num_version,
            'platform'  => $platform,
            'pattern'    => $pattern
    );
    return $Browser;
    #$navegador = "Navegador: " . $Browser['name'] . " " . $Browser['version'];
    #$so = "SO: " . $Browser['platform'];

    /* Para finalizar coloquei aqui o meu insert para salvar na base de dados... Não fiz nada para mostrar em tela, pois só uso para fins de log do sistema  */
}