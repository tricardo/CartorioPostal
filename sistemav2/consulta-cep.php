<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 

if(isset($_POST['cep']) AND isset($_POST['complemento'])){
        $CepDAO = new CepDAO();
        
        $cep = str_replace('-', '',$_POST['cep']);
        $comp= $_POST['complemento'];
        $obj = $_POST['obj'];
        
        $listar = $CepDAO->listar(array('cep'=>$cep));
        $cont   = 0;
        $arr1 = array(
                array('endereco','sacado_endereco','dev_endereco','anterior_endereco'),
                array('bairro','dev_bairro','anterior_bairro'),
                array('cidade','sacado_cidade','dev_cidade','anterior_cidade'),
                array('estado','estados','uf','sacado_estado','dev_estado','anterior_estado')
            );
        $arr2 = array('logr_nome','bairro_nome','cidade_nome','estado_sigla');
        $arrt = array('t','t','t','s');
        if(count($listar) > 0){
            $cont   = count($listar);
            $listar = UTF_Encodes($listar); 
            $listar = $listar[0];
        } else {
            $listar = new stdClass();
            $listar->logr_nome     = '';
            $listar->bairro_nome   = '';
            $listar->cidade_nome   = '';
            $listar->estado_sigla  = '';
        } ?>
        <script>  
            //$('.ajax').hide();
            <?php 
            $modo_especial = '';
            if(substr_count($obj,"anterior_") > 0){
                $modo_especial = 'anterior_';
            }
            for($i = 0; $i < count($arr1); $i++){ 
                if(is_array($arr1[$i])){ 
                    for($j = 0; $j < count($arr1[$i]); $j++){ 
                        if(strlen($modo_especial) > 0){
                            if(substr_count($arr1[$i][$j],$modo_especial) > 0){ 
                                if($arrt[$i] == 't'){  ?>
                                    if($('#<?=$arr1[$i][$j].$comp?>').length > 0){
                                        $('#<?=$arr1[$i][$j].$comp?>').val('<?=$listar->$arr2[$i]?>');
                                    }
                          <?php } else { ?>
                                    if($('#<?=$arr1[$i][$j].$comp?>').length > 0){
                                        $('#<?=$arr1[$i][$j].$comp?> option[value=<?=$listar->$arr2[$i]?>]').attr('selected','selected');
                                        $('#<?=$arr1[$i][$j].$comp?>').trigger('chosen:updated');
                                    }
                        <?php        
                                }
                            }
                        } else {
                            if($arrt[$i] == 't'){ ?>
                                if($('#<?=$arr1[$i][$j].$comp?>').length > 0){
                                    $('#<?=$arr1[$i][$j].$comp?>').val('<?=$listar->$arr2[$i]?>');
                                }
                      <?php } else { ?>
                                if($('#<?=$arr1[$i][$j].$comp?>').length > 0){
                                    $('#<?=$arr1[$i][$j].$comp?> option[value=<?=$listar->$arr2[$i]?>]').attr('selected','selected');
                                    $('#<?=$arr1[$i][$j].$comp?>').trigger('chosen:updated');
                                }
                    <?php   }
                        }
                    }
                } else { 
                    if($arrt[$i] == 't'){ ?>    
                        if($('#<?=$arr1[$i].$comp?>').length > 0){
                            $('#<?=$arr1[$i].$comp?>').val('<?=$listar->$arr2[$i]?>');
                        }
                    <?php } else { ?>
                       if($('#<?=$arr1[$i].$comp?>').length > 0){
                           $('#<?=$arr1[$i].$comp?> option[value=<?=$listar->$arr2[$i]?>]').attr('selected','selected');
                           $('#<?=$arr1[$i].$comp?>').trigger('chosen:updated');
                       }
            <?php }}} 
            if(strlen($cep) == 8){
                $tempo= 5000;
                $msg = 'Nenhum registro encontrado com o CEP <b>'.$_POST['cep'].'</b>!';
                if($cont > 1){ 
                    $tempo = 2000;
                    $msg = 'Foram encontrados '.count($listar).' registros com o CEP <b>'.$_POST['cep'].'</b>!';
                } elseif($cont == 1){ 
                    $tempo = 2000;
                    $msg = 'Foi encontrado 1 registro com o CEP <b>'.$_POST['cep'].'</b>!';
                } ?>   
                if($('#dv_message_alert<?=$comp?>').length > 0){ 
                    $('#dv_message_alert<?=$comp?>').html('<img src="images/back-alert.png"><span><?=$msg?></span>');
                    $('#dv_message_alert<?=$comp?>').show();
                    setTimeout("$('#dv_message_alert<?=$comp?>').hide();", <?=$tempo?>);
                }   
            <?php } ?> 
        </script>
    <?php 
}
