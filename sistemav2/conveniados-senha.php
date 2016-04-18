<?php include('header.php'); 

    $permissao = verifica_permissao('Cliente',$controle_id_departamento_p,$controle_id_departamento_s);
    if($permissao == 'FALSE'){
        header('location:pagina-erro.php');
        exit;
    }
    
    $conveniadoDAO = new ConveniadoDAO();
    
    pt_register('GET','id_conveniado');
    pt_register('GET','id_cliente');
    $id_conveniado = isset($id_conveniado) ? $id_conveniado : 0;
    $id_cliente = isset($id_cliente) ? $id_cliente : 0;

    #vars
    if($_GET){ $c = Post_StdClass($_GET); } 
    $c->id_conveniado = isset($id_conveniado) ? $id_conveniado : 0;
    
    #
    $link = '';
    $link .= (isset($c->pagina)) ? '?pagina='.$c->pagina : '?pagina=1';
    $link .= (isset($c->busca) AND strlen($c->busca) > 0) ? '&busca='.$c->busca : '';
    $link .= (isset($c->id_cliente) AND strlen($c->id_cliente) > 0) ? '&id_cliente='.$c->id_cliente : '';
    
    $conveniado = $conveniadoDAO->selectPorId($id_conveniado, $controle_id_empresa); ?>
<script>
    menu(3,'bt-02');
    $('#titulo').html('cadastros &rsaquo;&rsaquo; clientes &rsaquo;&rsaquo; conveniados &rsaquo;&rsaquo; <a href="conveniados-listar.php<?=$link?>" id="voltar">listar</a>');
    $('#sub-10').css({'font-weight':'bold'});
</script>
<div class="content-forms"> 
    <?php CamposObrigatorios(); ?>
    <form enctype="multipart/form-data" method="post" id="form1" action="<?=$link?>">
        <h3>Nova Senha Para <?=NomeH1(2,array('nome'=>$conveniado->nome))?></h3>
        <dl>
            <table class="table1">
                <tbody>
                    <tr>
                        <td class="msg-ret">
                            <?php
                            if($conveniado->status!='Ativo'){
                                echo '<h4>Usuário Inativo ou Não é conveniado!</h4>';
                            } else {
                                $show_msgbox = 1;
                                $senha = '';
                                $tamanho = 6;$caracteres = "abcdefghijkmnpqrstuvwxyz23456789"; 	srand((double)microtime()*1000000);
                                for($i=0; $i<$tamanho; $i++){
                                        $senha .= $caracteres[rand()%strlen($caracteres)];
                                }
                                #atualiza no sistema
                                $senha_new = $conveniado->email.$senha;
                                $conveniado->senha_new = md5($senha_new);
                                $conveniadoDAO->atualizaSenha($conveniado);
                                if(PRODUCAO == 0){
                                    
                                    set_time_limit(0);
                                    require("includes/maladireta/config.inc.php");
                                    require("includes/maladireta/class.Email.php");
                                    include("includes/maladireta/class.PHPMailer.php");
                                    error_reporting(1);
                                    
                                    $Sender = "Senha de Acesso Cartório Postal <webmaster@cartoriopostal.com.br>";
                                    $Subject = 'Senha de Acesso Definitivo';
                                    $html = 'Prezado(a) '.$conveniado->nome.',<br><br>

                                    As informações abaixo são confidenciais e importantes para você acessar nosso sistema.<br><br>

                                    Seu login é: '.$conveniado->email.'<br>
                                    E sua senha de acesso é: '.$senha.'<br><br>

                                    Acesse www.cartoriopostal.com.br faça login na àrea restrita. Em caso de dúvidas entre no link suporte para ter ajuda on-line.<br>
                                    Caso contrário envie um e-mail para webmaster@cartoriopostal.com.br<br><br>

                                    Att,<br>
                                    Cartório Postal<br>
                                    ';
                                    $CustomHeaders= '';
                                    $message = new Email($email, $Sender, $Subject, $CustomHeaders);
                                    $message->SetHtmlContent($html);
                                    $message->Send();
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