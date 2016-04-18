<?php include('header.php'); 
        
    $permissao = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
    if ($permissao == 'FALSE' or $controle_id_empresa != '1') {
        header('location:pagina-erro.php');
        exit;
    }
    $permissao = verifica_permissao('Direcao', $controle_id_departamento_p, $controle_id_departamento_s);
    
    #DAO
    $empresaDAO = new EmpresaDAO();
    $franquia   = new FranquiasDAO();
    $bancoDAO   = new BancoDAO();
    $royalties  = new RoyaltieFixoDAO();
    $correioDAO = new CorreioDAO();
    
    #vars
    pt_register('GET','id');
    pt_register('GET','pagina');
    pt_register('GET','busca');
    pt_register('GET','status');
    pt_register('GET','opcoes_form');
    $opcoes_form = isset($opcoes_form) ? $opcoes_form : 1;
    
    #forms
    
    
    #
    $link = '';
    $link .= (isset($pagina)) ? '?pagina='.$pagina : '?pagina=1';
    $link .= (isset($busca) AND strlen($busca) > 0) ? '&busca='.$busca : '';
    $link .= (isset($status) AND strlen($status) > 0) ? '&status='.$status : ''; 
    $show_msgbox = 0;
    $arr   = new stdClass(); ?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; franquias &rsaquo;&rsaquo; <a href="franquias-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-08').css({'font-weight':'bold'});
</script>

<div class="content-forms">
    <?php if($id > 0){ ?>
     <div class="opcoes">
        <label>selecione uma opção: </label>
        <select onchange="opcoesForm(this.value)" id="opcoes_form">
            <option value="1"<?=$opcoes_form == 1 ? ' selected="selected"' : ''?>>Informações da Franquia</option>
                <option value="2"<?=$opcoes_form == 2 ? ' selected="selected"' : ''?>>Ficha dos Correios</option>
                <option value="3"<?=$opcoes_form == 3 ? ' selected="selected"' : ''?>>Contratos</option>
                <option value="4"<?=$opcoes_form == 4 ? ' selected="selected"' : ''?>>Informações do Franquado</option>
                <option value="5"<?=$opcoes_form == 5 ? ' selected="selected"' : ''?>>Documentação</option>
                <option value="6"<?=$opcoes_form == 6 ? ' selected="selected"' : ''?>>Informações Sobre o Ponto</option>
                <option value="7"<?=$opcoes_form == 7 ? ' selected="selected"' : ''?>>Layouts</option>
                <option value="8"<?=$opcoes_form == 8 ? ' selected="selected"' : ''?>>Abertura da Empresa</option>
                <option value="13"<?=$opcoes_form == 13 ? ' selected="selected"' : ''?>>Faixa de CEP</option>
                <option value="9"<?=$opcoes_form == 9 ? ' selected="selected"' : ''?>>Treinamento</option>
                <option value="10"<?=$opcoes_form == 10 ? ' selected="selected"' : ''?>>Checklist de Inauguração</option>
                <option value="11"<?=$opcoes_form == 11 ? ' selected="selected"' : ''?>>Início das Atividades</option>
                <option value="12"<?=$opcoes_form == 12 ? ' selected="selected"' : ''?>>Inauguração</option>
        </select>
    </div>
    <?php }
     AddRegistro('franquias-editar.php'.$link.'&id=0'); 
     $link .= (isset($id)) ? '&id='.$id : '&id=0'; ?>
    <?php 
    CamposObrigatorios(); 
    include('franquias-editar-01.php');
    if($id > 0){
        include('franquias-editar-02.php');
        include('franquias-editar-03.php');
        include('franquias-editar-04.php');
        include('franquias-editar-05.php');
        include('franquias-editar-06.php');
        include('franquias-editar-07.php');
        include('franquias-editar-08.php');
        include('franquias-editar-09.php');
        include('franquias-editar-10.php');
        include('franquias-editar-11.php');
        include('franquias-editar-12.php');
        include('franquias-editar-13.php');
    }
    ?>
    <script>
        preencheCampo();
        opcoesForm(<?=$opcoes_form?>);
    </script>
</div>

<?php include('footer.php'); ?>