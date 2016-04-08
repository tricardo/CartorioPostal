<?php include('header.php'); 

$perm_fin = verifica_permissao('Financeiro', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_pgto = verifica_permissao('Financeiro PgtoCont', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_cobr = verifica_permissao('Financeiro Cobrança', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_comp = verifica_permissao('Financeiro Compra', $controle_id_departamento_p, $controle_id_departamento_s);
$perm_sup = verifica_permissao('Supervisor', $controle_id_departamento_p, $controle_id_departamento_s);
$show_msgbox = 0;

$pedidoDAO = new PedidoDAO(); 
?>
<script>
    menu(3,'bt-01');
    $('#titulo').html('iniciar &rsaquo;&rsaquo; home');
    $('#sub-01').css({'font-weight':'bold'});
</script>
<div class="principal">
    <?php $permissao_dir = verifica_permissao('Direcionamento_site',$controle_id_departamento_p,$controle_id_departamento_s);
    if($permissao_dir != 'FALSE'){ ?>
    <div>
        <h4>Últimos 20 Pedidos</h4>
        <div class="content-list-table" style="overflow-y: auto; max-height: 300px;">
            <table>
                <thead>
                    <tr>
                        <th>Ordem</th>
                        <th>Data</th>
                        <th>Solicitante</th>
                        <th>Serviço</th>
                        <th>Regiao</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $color = '#FFFEEE';
                    foreach($pedidoDAO->ultimos_pedidos($controle_id_empresa) AS $p){  
                        $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';  ?>
                        <tr <?=TRColor($color)?>>
                            <td class="buttons"><a href="direcionamento-site-listar.php?busca_id_pedido=<?=$p->id_pedido . '/'.$p->ordem?>"><?='#'.$p->id_pedido . '/'.$p->ordem?></a></td>
                            <td class="buttons"><?=invert($p->data,'/','PHP')?></td>
                            <td style="text-transform: uppercase"><?= $p->cpf.' <br> '.utf8_encode((strtolower($p->nome)))?></td>
                            <td style="text-transform: uppercase"><?= utf8_encode((strtolower($p->desc_servico)))?></td>
                            <td style="text-transform: uppercase"><?= utf8_encode((strtolower($p->cidade.'-'))).$p->estado?></td>
                       </tr>
                       <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
    <div class="pri-left pri-margin">
        <h4>Menu Rápido</h4>
        <div class="content-list-table">
            <table>
                <thead>
                    <tr>
                        <th class="buttons">&nbsp;</th>
                        <th>Página</th>
                    </tr>
                </thead>
                <tbody>
                    <tr <?=TRColor('#FFFEEE')?>>
                        <td class="buttons"><img src="images/bt-01.png"></td>
                        <td><a href="rede-de-franqueados.php">Rede de Franqueados</a></td>
                    </tr>
                    <tr <?=TRColor('#FFFEEE')?>>
                        <td class="buttons"><img src="images/bt-01.png"></td>
                        <td><a href="comunicados.php">Comunicados</a></td>
                    </tr>
                    <?php $permissao_d = verifica_permissao('Direcionamento', $controle_id_departamento_p, $controle_id_departamento_s);
                    if ($permissao_d == 'TRUE') {?>
                        <tr <?=TRColor('#FFFEEE')?>>
                            <td class="buttons"><img src="images/bt-02.png"></td>
                            <td><a href="direcionamento-listar.php">Direcionamento</a></td>
                        </tr>
                    <?php } 
                    $permissao_p = verifica_permissao('Pedido', $controle_id_departamento_p, $controle_id_departamento_s);
                    if ($permissao_p == 'TRUE') {?>
                        <tr <?=TRColor('#FFFEEE')?>>
                            <td class="buttons"><img src="images/bt-02.png"></td>
                            <td><a href="pedido-listar.php">Pedidos</a></td>
                        </tr>
                    <?php } 
                    $permissao_e = verifica_permissao('EXPANSAO',$controle_id_departamento_p,$controle_id_departamento_s);
                    $permissao_e2 = verifica_permissao('Franquia', $controle_id_departamento_p, $controle_id_departamento_s);
                    if(($permissao_e == 'TRUE' OR $permissao_e2 == 'TRUE') AND $controle_id_empresa == 1){ ?>
                        <tr <?=TRColor('#FFFEEE')?>>
                            <td class="buttons"><img src="images/bt-03.png"></td>
                            <td><a href="expansao-fichas-listar.php">Fichas</a></td>
                        </tr>
                        <tr <?=TRColor('#FFFEEE')?>>
                            <td class="buttons"><img src="images/bt-03.png"></td>
                            <td><a href="expansao-agenda.php">Agenda</a></td>
                        </tr>
                    <?php } 
                    if (($perm_fin == 'TRUE' || $perm_cobr == 'TRUE' || $perm_comp == 'TRUE' || $perm_sup == 'TRUE') OR $controle_id_usuario == 1) { ?>
                        <?php if ($perm_fin == 'TRUE') { ?>
                            <tr <?=TRColor('#FFFEEE')?>>
                                <td class="buttons"><img src="images/bt-04.png"></td>
                                <td><a href="desembolso-listar.php">Desembolso</a></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="pri-right">
        <h4>Últimas Atualizações do Sistema</h4>
        <div class="content-list-table">
            <table>
                <thead>
                    <tr>
                        <th>Página</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($permissao_financeiro == 'TRUE' AND $permissao27 == 'TRUE'){ ?>
                        <?php if($controle_id_empresa == 1){ ?>
                            <tr <?=TRColor('#FFFEEE')?>>
                                <td><a href="http://www.cartoriopostal.com.br/sistemav2/recebimentos-de-pedidos.php">Financeiro >> Pedidos</a></td>
                                <td>Exportar Todos</td>
                            </tr>
                        <?php } ?>
                        <tr <?=TRColor('#FFFEEE')?>>
                            <td><a href="http://www.cartoriopostal.com.br/sistemav2/recebimentos-de-pedidos.php">Financeiro >> Pedidos</a></td>
                            <td>Exportar</td>
                        </tr>
                        <tr <?=TRColor('#FFFEEE')?>>
                            <td><a href="http://www.cartoriopostal.com.br/sistemav2/recebimentos-de-pedidos.php">Financeiro >> Pedidos</a></td>
                            <td>Fatura</td>
                        </tr>
                        <tr <?=TRColor('#FFFEEE')?>>
                            <td><a href="http://www.cartoriopostal.com.br/sistemav2/recebimentos-de-pedidos.php">Financeiro >> Pedidos</a></td>
                            <td>Gerar Novo Boleto</td>
                        </tr>
                        <tr <?=TRColor('#FFFEEE')?>>
                            <td><a href="http://www.cartoriopostal.com.br/sistemav2/recebimentos-de-pedidos.php">Financeiro >> Pedidos</a></td>
                            <td>&nbsp;</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php if(!isset($_SESSION['verifica_logado_usuario_cp'])){ ?>
        <div>
            <h4>Sistema 1.0 (antigo)</h4>
            <div class="content-list-table content-list-table-img">
                <a href="../sistema/controle/index.php" target="_blank"><img src="images/sistema-01.png"></a>
            </div>
        </div>
    <?php } ?>
</div>
<div class="grafico">
    <div>
        <script type="text/javascript">
            google.load("visualization", "1", {packages:["corechart"]});
            google.setOnLoadCallback(drawChart);
            function drawChart() {
              var data = google.visualization.arrayToDataTable([
                ['', 'Pedidos e Ordens'],
                <?php 
                $grafico = $pedidoDAO->graficos($controle_id_empresa, 1);
                $data_f = date('Y-m-d 23:59:59', strtotime('- 1 days', strtotime(date('Y-m-d'))));
                for($i = 0; $i < count($grafico); $i++){ 
                    $grafico[$i]->data = explode('-',$grafico[$i]->data);
                    $grafico[$i]->data = $grafico[$i]->data[1].'/'.$grafico[$i]->data[0];
                    echo "['".$grafico[$i]->data."',  ".$grafico[$i]->total."],";
                } ?>
              ]);

              var options = {
                title: 'Total de Pedidos e Ordens até <?=invert($data_f,'/','PHP')?>',
                hAxis: {title: '',  titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
              };

              var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
              chart.draw(data, options);
            }
        </script>
        <div id="chart_div"></div>
    </div>
</div>
<?php include('footer.php'); ?>
