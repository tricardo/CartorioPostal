<?php
require("includes/verifica_logado_controle.inc-ajax.php"); 
if($_POST){

    $servicoDAO = new ServicoDAO();
    $id_servico = $_POST['id_serv']; ?>
     <select name="busca_id_servico" id="busca_id_servico" class="chzn-select">
        <option value="0"<?=$id_servico=='0' ? ' selected="selected" ' : ''; ?>>Todos</option>
        <?php 
        foreach($servicoDAO->listaPorDepartamento($_POST['id_depto']) as $servico){
            $p_valor = '';
            if($controle_id_empresa==1 or $controle_id_empresa!=1 and $servico->franqueadora==0){                  
                    $p_valor .='<option value="'.$servico->id_servico.'"';
                    $p_valor .=($id_servico==$servico->id_servico)?' selected="selected" ':'';
                    $p_valor .='>'.utf8_encode($servico->descricao).'</option>';
            } 
            echo $p_valor;
        } ?>
    </select>
   
    <script>aplicarClass()</script>
<?php } ?>

