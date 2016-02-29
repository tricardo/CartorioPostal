<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
    <? 
    $p_valor = '';
    foreach($servicosMenu as $s){
        if($s->desc_site<>'') $descricao_menu = $s->desc_site; else $descricao_menu=$s->descricao;
        $p_valor .='
            <tr>
                <td align="left" valign="middle"><a href="/certidao/'.$s->id_servico.'/'.str_replace('-2a-via','',strtolower(limpa_url($descricao_menu))).'" title="'.$descricao_menu.'">'.$descricao_menu.'</a></td>
            </tr>';
    }
    echo $p_valor;
    ?>
</table>