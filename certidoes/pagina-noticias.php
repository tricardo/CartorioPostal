<?
$id_meta=1;
$pg = 'pagina_news';
require('includes/url.php');
require_once(URL_SITE_INCLUDE.'header.php');
pt_register('GET','id');
$sql = $objQuery->SQLQuery("SELECT ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.chave, ns.descricao, ns.fonte, ns.imagem_news, ns.texto_chamada, ns.texto, ns.destaque, ns.escrito, date_format(ns.data, '%d/%m/%Y') as data FROM cp_news_nova as ns WHERE ns.st_id='1' AND ns.id_news='".$id."'");
$objQuery->SQLQuery("UPDATE cp_news_nova as ns SET acesso = acesso+1 WHERE id_news = '$id'");
$res = mysql_fetch_array($sql);
$comentarios = $objQuery->SQLQuery("SELECT count(*) as comentarios FROM cp_comentario_news as cn, cp_news_nova as ns WHERE ns.id_news=cn.id_news AND cn.st_id='1' AND ns.id_news='".$id."'");
$cont_on = mysql_fetch_array($comentarios);
$id_news = $id;
?>
<div id="container">
    <div class="box_f">
        <div id="coluna_e">
            <div class="box_h">
                <table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" style="margin-bottom: 20px;">
                    <tr>
                        <td><span style="font-size: 12px; color: #666666;">Publicado em: <?= $res['data'];?></span></td>
                        <td><a href="javascript:history.back()" title="Clique aqui para voltar para a página anterior" style="float: right;" class="link_voltar">VOLTAR</a></td>
                    </tr>
                </table>
                <h1 style="font-size: 35px; font-weight: bold; color: #000000;"><?= $res['titulo_news'];?></h1><br /><br />
                <p style="line-height: 150%; font-size: 18px; color: #666666;"><?= $res['texto_chamada'];?></p>
                <div class="linha_h2"></div>
                <table width="100%" border="0" align="center" cellspacing="2" cellpadding="2" style="margin-top: 20px;">
                    <tr>
                      <td width="36%"><span style="font-size: 12px; color: #666666;">Fonte: <?= $res['fonte'];?></span></td>
                      <td width="21%"><span style="font-size: 12px; color: #666666;">Por: <?= $res['escrito'];?></span></td>
                      <td width="3%"><a href="javascript:self.print()" title="Clique aqui para imprimir está notícia"><img src="<?= URL_IMAGES;?>pages/imprimir.gif" alt="clique aqui para imprimir esta noticia" title="Clique aqui para imprimir está notícia" /></a></td>
                        <td colspan="2"><img src="<?= URL_IMAGES;?>pages/comentario-a.png" alt="" title="" align="absmiddle" />
                          <span style="font-size: 12px; color: #666666;">
                          <? 
                          if($cont_on['comentarios'] == 1 OR $cont_on['comentarios'] == 0){
                            echo $cont_on['comentarios']." comentário";
                          }else{
                            echo $cont_on['comentarios']." comentários";
                          }
                          ?>
                          </span>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                          <div id="fb-root"></div>
                          <div class="fb-like" data-send="false" data-width="350" data-show-faces="true"></div>
                      </td>
                      <td>
                        <a href="http://www.facebook.com/share.php?u=<?= $url_rede;?>" target="_blank">
                        <img src="<?= URL_IMAGES;?>/pages/facebook-share.png" alt="compartilhar no facebook" title="Compartilhar no Facebook" />
                      </a>
                      </td>
                      <td width="4%">
                          <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="cartoriopostal" rel="nofollow">Tweetar</a>                      </td>
                      <td width="36%">
                        <a class="a2a_dd" href="http://www.addtoany.com/share_save?linkurl=<?= $url_rede;?>;linkname=CabideiroCultural">
                            <img src="<?= URL_IMAGES ?>icon/bt_compartilhar.png" alt="Compartilhar" border="0"/>                        </a>
                        <script type="text/javascript">
                            var a2a_config = a2a_config || {};
                            a2a_config.linkname = "Cartório Postal";
                            a2a_config.linkurl = "<?= $url_rede;?>";
                            a2a_config.locale = "pt-BR";
                            a2a_config.num_services = 8;
                            a2a_config.prioritize = ["email", "google_gmail", "live", "myspace", "orkut", "yahoo_mail", "blogger_post"];
                        </script>
                        <script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>
                      </td>
                  </tr>
                </table>
                <div class="imagem_noticia">
                    <img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="<?= str_replace("-"," ",$res['url_amigavel']);?>" title="<?= $res['titulo_news'];?>" width="690" />
                </div>
                <div class="texto_noticia"><?= $res['texto'];?></div>
                <div class="linha_h2"></div>
                <table width="100%" border="0" align="center" cellspacing="2" cellpadding="2" style="margin-top: 20px;">
                    <tr>
                      <td width="36%"><span style="font-size: 12px; color: #666666;">Fonte: <?= $res['fonte'];?></span></td>
                      <td width="21%"><span style="font-size: 12px; color: #666666;">Por: <?= $res['escrito'];?></span></td>
                      <td width="3%"><a href="javascript:self.print()" title="Clique aqui para imprimir está notícia"><img src="<?= URL_IMAGES;?>pages/imprimir.gif" alt="clique aqui para imprimir esta noticia" title="Clique aqui para imprimir está notícia" /></a></td>
                        <td colspan="2"><img src="<?= URL_IMAGES;?>pages/comentario-a.png" alt="" title="" align="absmiddle" />
                          <span style="font-size: 12px; color: #666666;">
                          <? 
                          if($cont_on['comentarios'] == 1 OR $cont_on['comentarios'] == 0){
                            echo $cont_on['comentarios']." comentário";
                          }else{
                            echo $cont_on['comentarios']." comentários";
                          }
                          ?>
                          </span>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2">
                          <div id="fb-root"></div>
                          <div class="fb-like" data-send="false" data-width="350" data-show-faces="true"></div>
                      </td>
                      <td>
                        <a href="http://www.facebook.com/share.php?u=<?= $url_rede;?>" target="_blank">
                        <img src="<?= URL_IMAGES;?>/pages/facebook-share.png" alt="compartilhar no facebook" title="Compartilhar no Facebook" />
                      </a>
                      </td>
                      <td width="4%">
                          <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="cartoriopostal" rel="nofollow">Tweetar</a>                      </td>
                      <td width="36%">
                        <a class="a2a_dd" href="http://www.addtoany.com/share_save?linkurl=<?= $url_rede;?>;linkname=CabideiroCultural">
                            <img src="<?= URL_IMAGES ?>icon/bt_compartilhar.png" alt="Compartilhar" border="0"/>                        </a>
                        <script type="text/javascript">
                            var a2a_config = a2a_config || {};
                            a2a_config.linkname = "Cartório Postal";
                            a2a_config.linkurl = "<?= $url_rede;?>";
                            a2a_config.locale = "pt-BR";
                            a2a_config.num_services = 8;
                            a2a_config.prioritize = ["email", "google_gmail", "live", "myspace", "orkut", "yahoo_mail", "blogger_post"];
                        </script>
                        <script type="text/javascript" src="http://static.addtoany.com/menu/page.js"></script>
                      </td>
                  </tr>
                </table>
                <table align="center" width="100" border="0" cellspacing="5" cellpadding="5" bgcolor="#DDDDDD" style="margin-top: 5px;">
                <?
                $loop_cols = 3;
                $i = 1;
                $sql = $objQuery->SQLQuery("SELECT ns.id_news, ci.id_cat_imagem, im.id_imagem, ci.nome_imagem, ci.descricao, ci.url_amigavel, im.imagem, im.st_id FROM cp_news_nova as ns, cp_imagem as im, cp_cat_imagem as ci WHERE ci.id_cat_imagem=ns.id_cat_imagem AND ci.id_cat_imagem=im.id_cat_imagem AND im.st_id='1' AND ns.id_news='" .$id. "' ORDER BY im.id_cat_imagem DESC LIMIT 12");
                while($list = mysql_fetch_array($sql)){
                    if($i < $loop_cols){
                        echo '
                            <td align="center" valign="top" bgcolor="#FFFFFF">
                                <div class="galeria"><a href="'.URL_UPLOAD.''.$list['imagem'].'" title="'.$list['descricao'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['imagem'].'" alt="'.str_replace("-"," ",$list['url_amigavel']).'" title="'.$list['descricao'].'" width="212" /></a></div>
                            </td>
                        ';
                    }elseif($i == $loop_cols){
                        echo '
                            <td align="center" valign="top" bgcolor="#FFFFFF">
                                <div class="galeria"><a href="'.URL_UPLOAD.''.$list['imagem'].'" title="'.$list['descricao'].'" rel="shadowbox[vocation]"><img src="'.URL_UPLOAD.''.$list['imagem'].'" alt="'.str_replace("-"," ",$list['url_amigavel']).'" title="'.$list['descricao'].'" width="212" /></a></div>
                            </td>
                            </tr>
                            <tr>
                        ';
                        $i = 0;
                    }
                $i++;
                }
                ?>
                </table>
                <?
                pt_register('POST','submit1');
                if($submit1){
                    $errors=array();
                    pt_register('POST','id_news');
                    pt_register('POST','nome');
                    pt_register('POST','email');
                    pt_register('POST','comentario');
                    if($comentario==""){
                        if($comentario=="")    $errors['comentario']=1;
                        $error.="<span style='font: 12px Arial; color:#000000;'>Comentário / </span>";
                    }
                    $valida = validaEMAIL($email);
                    if($valida=='false'){
                        $errors['email']=1;
                        $error.="<span style='font: 12px Arial; color:#000000;'>E-mail Inválido, digite corretamente / </span>";
                    }
                    if(count($errors)<1){
                        $query="INSERT INTO cp_comentario_news(st_id, id_news, nome, email, comentario, data)
                        values
                        ('2','".$id_news."','".$nome."','".$email."','".$comentario."',NOW())";
                        $result = $objQuery->SQLQuery($query);
                        $id = $objQuery->ID;
                        $done=1;
                        $msg .= "------------------------------------------------------------------------<br />";
                        $msg .= "<strong>Dados do comentário:.</strong><br />";
                        $msg .= "------------------------------------------------------------------------<br />";
                        $msg .= "<strong>Notícia:</strong> '".$res['titulo_news']."'<br />";
                        $msg .= "<strong>Nome do usuário:</strong> $nome<br />";
                        $msg .= "<strong>E-mail do usuário:</strong> $email<br />";
                        $msg .= "<strong>Comentários:</strong><br /> $comentario";
                        $formato = "\nContent-type: text/html\n charset=iso-8859-1\n";
                        #$destinatario = "antonio.alves@softfox.com.br";
                        $destinatario = "paco@midiatix.com.br";
                        $titulo = "Comentário das notícias: Cartório Postal";
                        mail("$destinatario","$titulo","$msg","from: ".$email.$formato);
                    }
                }
                ?>
                <?
                if($done!=1){
                ?>
                <br /><h2 style="color: #202A72;">DEIXE SEU COMENTÁRIO:</h2>
                <div class="faixa_h"></div>
                <form name="form" action="" method="post" enctype="multipart/form-data">
                    <table width="100%" border="0" align="center" cellspacing="3" cellpadding="3">
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
                            <td width="50%" align="left" valign="middle">
                                <label for="nome" accesskey="1"><strong>SEU NOME</strong></label>
                            </td>
                            <td align="left" valign="middle">
                                <label for="email" accesskey="2"><strong>SEU E-MAIL</strong></label>
                            </td>
                        </tr>
                        <tr>
                            <td>
                               <input name="nome" type="text" id="nome" value="<?= $nome;?>" <?=($errors['nome'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                            <td>
                               <input name="email" type="text" id="email" value="<?= $email;?>" <?=($errors['email'])?'style="border: 1px solid #FF0000; width: 100%; height: 20px;"':''; ?> />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><label for="campo1" accesskey="3"><strong>SEU COMENTÁRIO</strong></label></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea name="comentario" id="campo1" cols="" rows="" onkeyup="mostrarResultado(this.value,300,'spcontando1');contarCaracteres(this.value,300,'sprestante1','campo1')" <?=($errors['comentario'])?'style="border: 1px solid #FF0000; width: 100%; height: 70px;"':''; ?> ><?= $comentario ?></textarea>
                                <span id="spcontando1" style="font-size: 12px;">Ainda não temos nada digitado..</span><br />
                                <span id="sprestante1" style="font-size: 12px;"></span>  
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="2"><input name="submit1" type="submit" value=" " title="Clique aqui para enviar seu comentário" class="bt_enviar" /></td>
                        </tr>
                    </table>
                </form>
                <?
                }
                ?>
                <?
                if($done){
                    echo '<img src="'.URL_IMAGES.'pages/comentario-enviada-com-sucesso.png" alt="comentario enviada com sucesso" title="Comentário enviada com sucesso!" />';
                    echo '<meta HTTP-EQUIV="refresh" CONTENT="5; URL='.URL_SITE.'">';
                }
                ?>
                <table width="100%" border="0" align="center" cellspacing="2" cellpadding="2" style="margin-top: 20px;">
                    <?
                    $onde ="";
                    $condicao = "FROM cp_news_nova as ns, cp_comentario_news as cm, cp_status as st WHERE ns.id_news=cm.id_news AND cm.st_id=st.st_id AND cm.st_id='1' " .$onde. " AND cm.id_news='".$id_news."' ORDER BY cm.id_comentario DESC";
                    $campo = "ns.id_news, cm.id_comentario, cm.nome, cm.email, cm.comentario, cm.st_id, date_format(cm.data, '%d/%m/%Y') as data, st.st_id";
                    $url_busca = $_SERVER['REQUEST_URI'];
                    $url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
                    $url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
                    $query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca, 20);
                    $p_valor = "";
                    $i = 0;
                    while($res = mysql_fetch_array($query)){ 
                        $p_valor .= '
                        <tr>
                            <td align="left" valign="middle" style="font-size: 15px; color: #333333;" class="comentario"><strong>' . $res["nome"] . '</strong> - Enviado: ' . $res["data"] . '</td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle"><p style="font-size: 15px; color: #333333;">' . $res["comentario"] . '</p></td>
                        </tr>
                        <tr>
                            <td align="left" valign="middle" height="20"></td>
                        </tr>';
                    }
                    echo $p_valor;
                    ?>
                    <tr>
                        <td align="center" valign="middle" colspan="5">
                            <?
                            $objQuery->QTDPagina();
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="box_g">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <div class="box_i">
                            <h2 style="color: #202A72;">NOTÍCIAS MAIS ACESSADAS:</h2>
                            <div class="faixa_h"></div>
                            <ul>            
                            <?
                            $sql = $objQuery->SQLQuery("SELECT ns.id_news, ns.st_id, ns.titulo_news, ns.url_amigavel, ns.imagem_news, ns.texto_chamada, ns.acesso, date_format(ns.data, '%d/%m/%Y') as data FROM cp_news_nova as ns WHERE ns.st_id='1' ORDER BY ns.acesso DESC LIMIT 10");
                            while($res = mysql_fetch_array($sql)){
                            ?>
                                <li>
                                    <table width="100%" border="0" align="center" cellspacing="1" cellpadding="1" style="margin-top: 5px;">
                                        <tr>
                                            <td align="center" valign="middle"><div class="imagem_leia_mais"><a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>"><img src="<?= URL_UPLOAD;?><?= $res['imagem_news'];?>" alt="" title="" width="150" /></a></div></td>
                                            <td align="left" valign="top"><div class="texto_leia_mais"><a href="<?= URL_SITE;?>noticia/<?= $res['id_news'];?>/<?= $res['url_amigavel'];?>" title="<?= $res['titulo_news'];?>" class="link_ultima_noticia"><?= $res['titulo_news'];?></a></div></td>
                                        </tr>
                                    </table>
                               </li>
                            <?}?>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" valign="middle">
                        <a href="<?= URL_SITE;?>certidao/" title="Solicite sua Certidão aqui na Cartório Postal">
                            <img src="<?= URL_IMAGES;?>pages/faca-seu-pedido.png" alt="solicite sua certidao aqui na cartorio postal" title="Solicite sua Certidão aqui na Cartório Postal" style="margin-top: 7px;" />
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<? require_once (URL_SITE_INCLUDE.'footer.php'); ?>