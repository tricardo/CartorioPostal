<?php include('header.php'); ?>

<script>
    menu(3,'bt-01');
    $('#titulo').html('iniciar &rsaquo;&rsaquo; convenções');
    $('#sub-49').css({'font-weight':'bold'});
</script>
<div class="content-list-forms"></div>
<div class="content-list-table"> 
        <div class="paginacao">
            FOI ENCONTRADO 1 REGISTRO
        </div>
        <table>
            <thead>
                <tr>
                    <th class="buttons">#</th>
                    <th>convenção</th>
                    <th class="buttons">visualizar</th>
                </tr>
            </thead>
            <tbody>
                <tr <?=TRColor('#FFF')?>>
                    <td class="buttons">1</td>
                    <td>1º Convenção Regional São Paulo</td>
                    <td class="buttons"><a href="convencoes-visualizar.php?id_convencao=1"><img src="images/bt-message.png"></a></td>
                </tr>
                <!--<tr <?=TRColor('#FFFEEE')?>>
                    <td class="buttons">2</td>
                    <td>Convenção 2011</td>
                    <td class="buttons"><a href="convencoes-visualizar.php?id_convencao=2"><img src="images/bt-message.png"></a></td>
                </tr>-->
            </tbody>
        </table>
        <div class="paginacao">
            FOI ENCONTRADO 1 REGISTRO
        </div>
        <script>PaginacaoWidth()</script>
</div>
<?php include('footer.php'); ?>