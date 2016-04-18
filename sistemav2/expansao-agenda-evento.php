<?php
require("includes/verifica_logado_controle.inc.php");

$expansaoDAO = new ExpansaoDAO();

pt_register('POST','data');

$c = new stdClass();

$exp_item = $expansaoDAO->verAcesso(1, $controle_id_empresa, $controle_id_usuario, 
	$controle_id_departamento_p, $controle_id_departamento_s, $controle_nome);

$dt = explode('-',$data);
$c->c_id_usuario = $controle_id_usuario;
$c->ano = $dt[0];
$c->mes = $dt[1];
$c->dia = $dt[2];
$c->mes2 = $dt[1];
$c->dia2 = $dt[2]; ?>

<table>
    <thead>
        <tr>
            <th colspan="6">Eventos (<?=($c->dia < 10 ? '0'.$c->dia :$c->dia).' de '.DataAno(4,$c->mes).' de '.$c->ano?>)</th>
        </tr>
        <tr>
            <th class="buttons">#</th>
            <th class="buttons size100">data</th>
            <th>status</th>
            <th>nome</th>
            <th>consultor</th>
            <th>contato</th>
        </tr>
    </thead>
    <tbody>
        <?php $color = '#FFFEEE';
        if(!is_array($exp_item->id_departamento_p)){
            $exp_item->id_departamento_p = explode(',',$exp_item->id_departamento_p);
        }
        $total = 0;
        foreach ($expansaoDAO->agenda(2,$c,$exp_item) as $res) {            
            $mostrar = 0;
            if($exp_item->id_usuario == 1){
                $mostrar = 1;
            }
            if((in_array(29, $exp_item->id_departamento_p)) && $mostrar == 0){ 
                $mostrar = 1;
            } 
            if($mostrar == 0 && $res->id_usuario == $exp_item->id_usuario){
                $mostrar = 1;
            } 
            $total++;
             $color = $color == '#FFF' ? '#FFFFEE' : '#FFF'; ?>
            <tr <?=TRColor($color)?>>
                <td class="buttons"><?=$mostrar == 1 ? '<a href="expansao-fichas-editar.php?pagina=1&id_ficha='.$res->id_ficha.'&opcoes_form=4" target="_blank">'.$res->id_ficha.'</a>' : $res->id_ficha?></td>
                <td class="buttons size100"><?=invert($res->agenda,'/','PHP')?></td>
                <td><?=utf8_encode(ucwords(strtolower($res->status1)))?></td>
                <td><?=utf8_encode(ucwords(strtolower($res->cliente)))?></td>
                <td><?=utf8_encode(ucwords(strtolower($res->consultor)))?></td>
                <td><?=utf8_encode(ucwords(strtolower($res->relacionamento)))?></td>
            </tr>
            <?php if(strlen($res->obs) > 0){ ?>
                <tr <?=TRColor($color)?>>
                    <td colspan="6"><?=utf8_encode(ucwords(strtolower($res->obs)))?></td>
                </tr>
        <?php }}
        if($total == 0){ ?>
            <tr>
                <td colspan="6"><?=RetornaVazio();?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
