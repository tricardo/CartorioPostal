<?
require('header.php');
$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

pt_register("GET", "id");

if(empty($id)){
    echo "<script>location.href='financeiro_boleto_remessa.php';</script>";
}

$contaDAO = new ContaDAO();

$permissao = verifica_permissao('Financeiro',$controle_id_departamento_p,$controle_id_departamento_s);
$permissao_fin_cobranca = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);

if (($permissao == 'FALSE' or $controle_id_empresa != 1) and ($permissao_fin_cobranca == 'FALSE' or $controle_id_empresa != 1)) {
    echo '<br><br><strong>Você não tem permissão para acessar essa página</strong>';
    exit;
}
?>
    <div id="topo">
        <h1 class="tit"><img src="../images/tit/tit_rel_banco.png" alt="Título" />Gera Remessa Banco do Brasil</h1>
        <a href="#" class="topo">topo</a>
        <hr class="tit" />
    </div>
    <div id="meio">
        <table border="0" height="100%" width="100%">
            <tr>
                <td valign="top">
                    <form enctype="multipart/form-data" action="" method="post" name="gera_remessa_cart">
                        <center>
                            <table width="650" class="tabela">
                                <tr>
                                    <td colspan="4" class="tabela_tit">Remessa</td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="center">
                                        <?
                                        pt_register('post','submit');
                                        if($submit<>''){
                                            require('../boletos/gerabancodobrasil.php');
                                        }

                                        pt_register('post','submit_import');
                                        if($submit_import<>''){
                                            require('../boletos/retornobrad.php');
                                        }

                                        $sql = $objQuery->SQLQuery("SELECT COUNT(0) as total from vsites_conta_fatura as cf where  status=0 and id_empresa='".$controle_id_empresa."'");
                                        $num = mysql_num_rows($sql);
                                        if($num=='' or $num=='0'){
                                            $sql = $objQuery->SQLQuery("SELECT COUNT(0) as total from vsites_conta_fatura_oco as cf where  status=0 and id_empresa='".$controle_id_empresa."'");
                                            $num = mysql_num_rows($sql);
                                        }
                                        if($num<>0){
                                            ?>
                                            <input type="submit" name="submit" value="Gerar Remessa" class="button_busca" />
                                        <? } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" class="tabela_tit">Importar Retorno</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div align="right"><strong>Selecione o arquivo: </strong></div>
                                    </td>
                                    <td colspan="3"><input type="file" name="file_import" style="width: 200px" value="<?= $file_import ?>" class="form_estilo" /> Opção disponível apenas para Banco do Brasil</td>
                                </tr>
                                <tr>
                                    <td colspan="4">
                                        <div align="center"><input type="submit" name="submit_import" value="Importar" class="button_busca" /></div>
                                    </td>
                                </tr>
                            </table>
                        </center>
                        <center><br>
                            <br>
                            <table width="650" class="result_tabela" cellpadding="4"
                                   cellspacing="1">
                                <tr>
                                    <td class="tabela_tit"><strong>Data </strong></td>
                                    <td class="tabela_tit"><strong>Arquivo Remessa</strong></td>
                                </tr>
                                <?
                                $sql = $objQuery->SQLQuery("SELECT * from vsites_arquivo_bb_rem where id_empresa='".$controle_id_empresa."' order by data desc limit 25");
                                $p_valor = '';
                                while($res = mysql_fetch_array($sql)){
                                    $p_valor .= '
					<tr>
						<td class="result_celula"> '.invert($res['data'],'/','PHP').'</td>
						<td class="result_celula"> <a href="download_remessa_bb.php?id='.$res['id_brasil_rem'].'">'.str_replace('../boletos/remessabancodobrasil/','',$res['arquivo']).'</a></td>
					</tr>';
                                }
                                echo $p_valor;
                                ?>
                            </table>
                            <br>
                            <table width="650" class="result_tabela" cellpadding="4"
                                   cellspacing="1">
                                <tr>
                                    <td class="tabela_tit"><strong>Data </strong></td>
                                    <td class="tabela_tit"><strong>Arquivo Retorno</strong></td>
                                </tr>
                                <?
                                $sql = $objQuery->SQLQuery("SELECT * from vsites_arquivo_bb_ret where id_empresa='".$controle_id_empresa."' order by data desc limit 25");
                                $p_valor = '';
                                while($res = mysql_fetch_array($sql)){
                                    $p_valor .= '
					<tr>
						<td class="result_celula"> '.invert($res['data'],'/','PHP').'</td>
						<td class="result_celula"> <a href="download_ret_bb.php?id='.$res['id_brasil_ret'].'">Clique para download</a></td>
					</tr>';
                                }
                                echo $p_valor;
                                ?>
                            </table>
                        </center>

                    </form>
                </td>
            </tr>
        </table>
    </div>
<?php
require('footer.php');
?>