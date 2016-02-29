<?
require('includes/url.php');
pt_register('GET','id_empresa');
pt_register('GET','busca_dados');
pt_register('GET','pagina');
?>
<div id="container" style="font: 15px/122% Arial; color: #666666; text-align: justify;">
        <img src="<?= URL_IMAGES;?>pages/depoimentos-dos-clientes-da-cartorio-postal.png" alt="depoimentos dos clientes da cartorio postal" title="Depoimentos dos clientes da Cartório Postal" style="margin: 5px 0 20px 0;" />
        <div id="depoimento">
        Fundei a Cartório Postal no ano de 1992, deste ano em diante a empresa vem crescendo e realizando conquistas importantes ao longo do tempo.<br /><br />
        A conquista mais importante é o sistema de Franquias adotado no ano<br /> de 2009 que vem sendo um sucesso, hoje estamos com mais de 150<br /> contratos fechados e mais de 90 lojas em funcionamento por todo Brasil.<br /><br />
        A cada dia colhemos reconhecimento e confiança dos nossos clientes<br /> e franqueados, reconhecimento este que valida nosso sucesso e<br /> credibilidade.<br /><br />
        Um abraço a todos e coloco-me a disposição!<br /><br />
        <strong style="color: #202A72;">Presidente Sr. Flávio Lopes da Costa.</strong>
        </div>
        <div style="width: 196px; height: 205px; top: 1200px; margin-left: 490px; position: absolute;">
            <img src="<?= URL_IMAGES;?>pages/imagem-depoimento.png" alt="" title="" />
        </div>
        <div id="list">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                <?
                $onde ="";
                if($busca_dados<>''){$onde .= " and d.depoimento like '".$busca."%' ";}
                $condicao = "FROM cp_depoimento as d, cartorio_banco2.vsites_user_empresa as ue WHERE d.id_empresa=ue.id_empresa AND d.status='1' AND ue.id_empresa='".$fr->id_empresa."' ORDER BY d.id_depoimento DESC";
                $campo = "ue.id_empresa, ue.fantasia, d.id_depoimento, d.nome, d.email, d.depoimento, date_format(d.data, '%d/%m/%Y') as data, d.status";
                $url_busca = $_SERVER['REQUEST_URI'];
                $url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
                $url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
                $query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 5);
                $p_valor = "";
                $i = 0;
                while($res = mysql_fetch_array($query)){
                $p_valor .= '
                <tr>
                    <td align="left" valign="middle" style="font-size: 15px; color: #333333;" class="faixa_depoimento">
                        <strong style="text-transform: uppercase;">POR - ' .$res["nome"] . '</strong> - Enviado: ' . $res["data"] . '
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle">
                        <img src="'.URL_IMAGES.'pages/aspa_bottom.png" alt="depoimento" title="Depoimento postado por: ' .$res["nome"]. '" style="margin-top:10px;" />
                        <p style="font-size: 15px; color: #333333;">' . $res["depoimento"] . '</p>
                        <img src="'.URL_IMAGES.'pages/aspa_top.png" alt="depoimento" title="Depoimento postado por: ' .$res["nome"] . '" />
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="middle" height="20"></td>
                </tr>';
                }
                echo $p_valor;
                ?>
                <tr>
                    <td align="center" valign="middle" colspan="2">
                        <?
                        $objQuery->QTDPaginaOtimizado('/certidoes/franquia-depoimentos/');
                        ?>
                    </td>
                </tr>
            </table>
            <?
            pt_register('POST','submit1');
            if($submit1){
                $errors=array();
                pt_register('POST','id_empresa');
                pt_register('POST','nome');
                pt_register('POST','email');
                pt_register('POST','depoimento');
                if($nome=="" || $email=="" || $depoimento==""){
                    if($nome=="")       $errors['nome']=1;
                    if($email=="")      $errors['email']=1;
                    if($depoimento=="") $errors['depoimento']=1;
                    $error.="<span style='font: 12px Arial; color:#000000;'>Nome / E-mail / Depoimento / </span>";
                }
                $valida = validaEMAIL($email);
                if($valida=='false'){
                    $errors['email']=1;
                    $error.="<span style='font: 12px Arial; color:#000000;'>E-mail Inválido, digite corretamente / </span>";
                }
                if(count($errors)<1){
                    $query="INSERT INTO cp_depoimento(";
                    $query .="id_empresa, nome, email, depoimento, data)";
                    $query .="VALUES";
                    $query .="('".$fr->id_empresa."','".$nome."','".$email."','".$depoimento."',NOW())";
                    $result = $objQuery->SQLQuery($query);
                    $id = $objQuery->ID;
                    $done=1;
                }
            }
            if($done!=1){
            ?>
            <form name="frm" action="" method="post" enctype="multipart/form-data">
                <table border="0" width="100%" align="center" cellpadding="3" cellspacing="3">
                    <tr>
                        <td align="left" valign="middle" colspan="4">
                            <?
                            if($error!=''){
                                    echo '<fieldset>
                                          <legend><strong style="font-size: 12px; color: #FF0000;">Ocorreram os seguintes erros:</strong></legend>';
                                    if ($errors){
                                        echo $error;
                                    }
                                    echo '</fieldset>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle">
                             <label for="nome" accesskey="1">Nome:</label>
                        </td>
                        <td align="left" valign="middle">
                             <label for="email" accesskey="2">E-mail:</label>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle">
                             <input name="nome" type="text" id="nome" value="<?= $nome;?>" <?=($errors['nome'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                        </td>
                        <td align="left" valign="middle">
                             <input name="email" type="text" id="email" value="<?= $email;?>" <?=($errors['email'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" colspan="2">
                             <label for="campo1" accesskey="4">Depoimento:</label>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="middle" colspan="2">
                            <textarea name="depoimento" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando1');contarCaracteres(this.value,300,'sprestante1','campo1')" <?=($errors['depoimento'])?'style="border: 1px solid #FF0000; width: 100%; height: 80px;"':''; ?> ><?= $depoimento;?></textarea>
                            <span id="spcontando1" style="font-size: 12px;">Ainda não temos nada digitado..</span><br />
                            <span id="sprestante1" style="font-size: 12px;"></span>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" valign="middle" colspan="4">
                            <input name="submit1" type="submit" value=" " title="Clique aqui para fazer o cadastro" class="bt_enviar" />
                        </td>
                    </tr>
                </table>
            </form>
            <?
            }
            if($done){
                echo '<img src="'.URL_IMAGES.'pages/mensagem-enviada-com-sucesso.png" alt="mensagem enviada com sucesso" title="Mensagem enviada com sucesso!" />';
                echo '<meta HTTP-EQUIV="refresh" CONTENT="5; URL='.URL_SITE.'">';
            }
            ?>
        </div>
</div>