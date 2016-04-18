<?php include('header.php'); 

$permissao = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
if($permissao == 'FALSE' and $controle_depto_p[27]!=1){
    header('location:pagina-erro.php');
    exit;
}

pt_register('GET','opcoes_form');
$opcoes_form = isset($opcoes_form) ? $opcoes_form : 1;
$show_msgbox = 0;

$fornecedorDAO = new FornecedorDAO();
$financeiroDAO = new FinanceiroDAO();
$pagamentoDAO = new PagamentoDAO();
$bancoDAO = new BancoDAO();
$contaDAO = new ContaDAO();
$regimeDAO = new RegimeDAO();
$departamentoDAO = new DepartamentoDAO();


$c = Post_StdClass($_GET);

$c->pagina = isset($c->pagina) ? $c->pagina : 1;
$c->busca = isset($c->busca) ? $c->busca : '';
$c->id_departamento = isset($c->id_departamento) ? $c->id_departamento : '';
$c->id_forma_pagamento = isset($c->id_forma_pagamento) ? $c->id_forma_pagamento : '';
$c->situacao = isset($c->situacao) ? $c->situacao : '';
$c->busca_data_i = isset($c->busca_data_i) ? $c->busca_data_i : date('01/m/Y', strtotime("- 1 month"));
$c->busca_data_f = isset($c->busca_data_f) ? $c->busca_data_f : date('t/m/Y', strtotime("+ 1 month"));

$link = '';
$link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
$link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
$link .= (isset($c->id_departamento) AND strlen($c->id_departamento) > 0) ? '&id_departamento='.$c->id_departamento : '';
$link .= (isset($c->id_forma_pagamento) AND strlen($c->id_forma_pagamento) > 0) ? '&id_forma_pagamento='.$c->id_forma_pagamento : '';
$link .= (isset($c->situacao) AND strlen($c->situacao) > 0) ? '&situacao='.$c->situacao : '';
$link .= (isset($c->busca_data_i) AND strlen($c->busca_data_i) > 0) ? '&busca_data_i='.$c->busca_data_i : '';
$link .= (isset($c->busca_data_f) AND strlen($c->busca_data_f) > 0) ? '&busca_data_f='.$c->busca_data_f : '';

pt_register('GET','id_pagamento');
$id_pagamento = isset($id_pagamento) ? $id_pagamento : 0; ?>
<script>
    menu(3,'bt-04');
    $('#titulo').html('financeiro &rsaquo;&rsaquo; cobrança  &rsaquo;&rsaquo; <a href="contas-a-pagar-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-26').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php if($id_pagamento > 0){ ?>
     <div class="opcoes">
        <label>selecione uma opção: </label>
        <select onchange="opcoesForm(this.value)" id="opcoes_form">
            <option value="1"<?=$opcoes_form == 1 ? ' selected="selected"' : ''?>>Contas à Pagar</option>
            <option value="2"<?=$opcoes_form == 2 ? ' selected="selected"' : ''?>>Comprovantes de pagamento</option>
        </select>
    </div>
    <?php } ?>
    <?php 
    AddRegistro('contas-a-pagar-editar.php'.$link.'&id_pagamento=0');
    $link .= '&id_pagamento='.$c->id_pagamento;  ?>  
    <?php CamposObrigatorios(); 
    include('contas-a-pagar-editar-01.php');
    if($id_pagamento > 0){
        include('contas-a-pagar-editar-02.php');
    }
    ?>
    <script>
        opcoesForm(<?=$opcoes_form?>);
        preencheCampo();
    </script>
    <?php if(isset($_POST['f_anexo']) OR isset($exc_anexo)){ ?>
    <div class="msgbox">
        <div class="panel"><a href="#" onclick="$('.msgbox').hide()">fechar X</a></div>
        <div class="text"></div>
    </div>
    <script>
        BoxMsg(<?=($_POST) ? 1 : (isset($exc_anexo) ? 1 : 0)?>,<?=$errors?>,'<?=$campos?>','<?=$msgbox?>');
        </script>
    <?php
    }
    $errors=0;
    $campos='';
    $msgbox='';
    ?>
</div>
<?php include('footer.php'); ?>