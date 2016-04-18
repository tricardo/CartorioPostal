<?php
require("includes/verifica_logado_controle.inc.php");

$expansaoDAO = new ExpansaoDAO();

pt_register('POST','mes');
pt_register('POST','ano'); 
$mes = (int) $mes;
$mes = $mes < 10 ? '0'.$mes : $mes;

$c = new stdClass();

if($mes==12) {
    $mes_p=1;
    $ano_p=$ano+1;
} else {
    $mes_p=$mes+1;
    $ano_p=$ano;
}

if($mes==01) {
    $mes_a=12;
    $ano_a=$ano-1;
} else {
    $mes_a=$mes-1;
    $ano_a=$ano;
}
$ini = ((int)date('w', strtotime($ano.'-'.$mes.'-01')))+1;
$fim = (int)date('t', strtotime($ano.'-'.$mes.'-01'));

$exp_item = $expansaoDAO->verAcesso(1, $controle_id_empresa, $controle_id_usuario, 
	$controle_id_departamento_p, $controle_id_departamento_s, $controle_nome);

$c->c_id_usuario = $controle_id_usuario;
$c->ano = $ano;
$c->mes = $mes;

$dias = array();
$dia = ((int)$mes != (int)date('m')) ? 1 : date('d');
foreach($expansaoDAO->agenda(1,$c,$exp_item) AS $f){
    $dias[] = (int)$f->dia;
} ?>
<table style="border:solid 1px #CCC">
    <thead>
        <tr>
            <th colspan="7" class="buttons">Calendário de Eventos</th>
        </tr>
        <tr>
            <th class="buttons" style="font-size: 15px; cursor: pointer" onclick="carrega_calendario('<?= $mes_a ?>','<?= $ano_a ?>');" title="<?= $mes_a.'/'.$ano_a ?>">&lsaquo;&lsaquo;</th>
            <th class="buttons" colspan="5">
                <select id="mes" name="mes" onchange="carrega_calendario(this.value, $('#ano').val())" class="bt-none">
                    <?php foreach(DataAno() AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$mes ? ' selected="selected"' : ''?>><?=$f?></option>
                    <?php } ?>
                </select> 
                <select id="ano" name="ano" onchange="carrega_calendario($('#mes').val(), this.value)" class="bt-none">
                    <?php foreach(DataAno(5) AS $p => $f){ ?>
                    <option value="<?=$p?>"<?=$p==$ano ? ' selected="selected"' : ''?>><?=$f?></option>
                    <?php } ?>
                </select>
            </th>
            <th class="buttons" style="font-size: 15px; cursor: pointer" onclick="carrega_calendario('<?= $mes_p ?>','<?= $ano_p ?>');" title="<?= $mes_p.'/'.$ano_p ?>">&rsaquo;&rsaquo;</th>
        </tr>
        <tr>
            <th class="buttons">dom</th>
            <th class="buttons">seg</th>
            <th class="buttons">ter</th>
            <th class="buttons">qua</th>
            <th class="buttons">qui</th>
            <th class="buttons">sex</th>
            <th class="buttons">sáb</th>
        </tr>
    </thead>
    <tbody>
        <?php $cont = 0;
        for($i = 1; $i <= 7; $i++){  ?>
            <tr style="background: #FFF">
                <?php for($j = 1; $j <= 7; $j++){ 
                    $valor = '';
                    $css_class = 'calender-td-padrao';                   
                    $onclk = '';
                    if($j == $ini OR $cont > 0){
                        if($cont < $fim){
                            $cont++;
                            $valor = $cont;
                            if(date('Y-m-d') == date('Y-m-d', strtotime($ano.'-'.$mes.'-'.$cont))){
                                 $css_class = 'calender-td-dia';
                            } else {
                                if(in_array($cont, $dias)){
                                    $onclk = ' onclick="carrega_evento(\''.($ano.'-'.((int)$mes < 10 ? '0'.((int)$mes) : $mes).'-'.($cont < 10 ? '0'.$cont : $cont)).'\')" title="'.($cont < 10 ? '0'.$cont : $cont).'/'.(((int)$mes < 10 ? '0'.((int)$mes) : $mes).'/'.$ano).'"';
                                    $css_class = 'calendar_td_eve';
                                }
                            }
                        }
                    }
                    
                    if(($j == 1 OR $j == 7) OR ($cont == 0 OR $cont > $fim)){
                        $css_class = ($j == 1 OR $j == 7) ? 'calender-td-fds' : 'calender-td-sdt';
                        $css_class = ($cont == 0 OR $cont > $fim) ? 'calender-td-sdt' : $css_class;
                    }
                                       
                    if($cont >= $fim){
                        $cont = 1000; 
                        $i = 8;
                    } ?>
                    <td class="buttons <?=$css_class?>"<?=$onclk?>><?=$valor?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php if(count($dias) > 0){ ?>
    <script>carrega_evento('<?=$ano.'-'.($mes > 0 ? $mes : '0'.$mes).'-'.($dia > 0 ? $dia : '0'.$dia)?>')</script>
<?php } ?>
