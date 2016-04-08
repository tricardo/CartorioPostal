<?php include('header.php'); 

    $permissao = verifica_permissao('Direcao',$controle_id_departamento_p,$controle_id_departamento_s);
    if($permissao == 'FALSE'){
        header('location:pagina-erro.php');
        exit;
    }
    
    $usuarioDAO = new UsuarioDAO();
    
    pt_register('GET','id_usuario');
    $id_usuario = isset($id_usuario) ? $id_usuario : 0;

    $usuario = $usuarioDAO->selectPorId($id_usuario);

    #vars
    if($_GET){ $c = Post_StdClass($_GET); } 
    $c->id_usuario = isset($id_usuario) ? $id_usuario : 0;
    
    #
    $link = '';
    $link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
    $link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
    $link .= (isset($c->status) AND strlen($c->status) > 0) ? '&status='.$c->status : '';
    $link .= (isset($c->id_empresa) AND strlen($c->id_empresa) > 0) ? '&id_empresa='.$c->id_empresa : '';
    $link .= (isset($c->id_departamento) AND strlen($c->id_departamento) > 0) ? '&id_departamento='.$c->id_departamento : '';
    $link .= '&id_usuario='.$c->id_usuario;

?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; colaboradores &rsaquo;&rsaquo; <a href="usuarios-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-09').css({'font-weight':'bold'});
</script>
<div class="content-forms"> 
    <?php CamposObrigatorios(); ?>
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>Nova Senha Para <?=NomeH1(2,array('nome'=>$usuario->nome))?></h3>
        <dl>
            <table class="table1">
                <tbody>
                    <tr>
                        <td  class="msg-ret">
                            <?php
                            if ($controle_id_empresa != '1' && ($usuario->id_empresa != $controle_id_empresa or $_SESSION['controle_teste'] != '')) {
                                echo '<h4>Usuário Inativo ou Não é conveniado!</h4>';
                            } else {
                                $show_msgbox = 1;
                                $senha = '';
                                $tamanho = 6;
                                $caracteres = "abcdefghijkmnpqrstuvwxyz23456789";
                                srand((double) microtime() * 1000000);
                                for ($i = 0; $i < $tamanho; $i++) {
                                    $senha .= $caracteres[rand() % strlen($caracteres)];
                                }
                                #atualiza no sistema
                                $usuarioDAO->atualizaSenha($usuario->email, $senha);
                                if(PRODUCAO == 0){
                                    #atualiza no ead
                                    require_once('model/DatabaseEAD.php');
                                    $eadDAO = new EadDAO();
                                    $eadDAO->atualizaEad($usuario, $senha);
                                    
                                    
                                    set_time_limit(0);
                                    require("includes/maladireta/config.inc.php");
                                    require("includes/maladireta/class.Email.php");
                                    include("includes/maladireta/class.PHPMailer.php");
                                    error_reporting(1);


                                        $Subject = 'Senha de Acesso do Sistema Corporativo';
                                        $html = 'Prezado(a) ' . $usuario->nome . ',<br><br>

                                    As informações abaixo são confidenciais e importantes para você acessar nosso <strong style="color:#0000FF">Sistema Corporativo</strong>.<br><br>

                                    Seu login é: ' . $usuario->email . '<br>
                                    E sua senha de acesso é: ' . $senha . '<br><br>

                                    Para entrar no sistema acesse www.cartoriopostal.com.br/login/ faça login na área corporativa para acessar o <strong style="color:#FF0000">Sistema Corporativo</strong>.<br>
                                    Seu login e senha só funcionará quando a franquia for inaugurada.

                                    Para entrar no nosso Serviço de Atendimento a Franquia (SAF) acesse www.cartoriopostal.com.br/login/ e faça login.<br>
                                    Você pode acessar o SAF a qualquer momento, mesmo antes da inauguração da sua unidade.

                                    Caso contrário envie um e-mail para ti@cartoriopostal.com.br<br><br>

                                    Att,<br>
                                    Equipe Cartório Postal<br>
                                    ';

                                    $mailer = new SMTPMailer();

                                    $From = 'Sistema Cartório Postal';
                                    $AddAddress = $usuario->email . ',' . $nome;
                                    $AddBCC = '';
                                    if ($controle_id_usuario != 1) {
                                        $AddBCC = 'ti@cartoriopostal.com.br';
                                    }
                                    $mailer->SEND($From, $AddAddress, $AddCC, $AddBCC, '', $Subject, $html);
                                }
                                $msgbox .= MsgBox();
                                echo '<h4>Senha Atual: '.$senha.'</h4>';
                            } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </dl>
        <dl>
            <div class="buttons">
                <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
            </div>
        </dl>
    </form>
    <script>preencheCampo()</script>
</div>
<?php include('footer.php'); ?>