<?php
pt_register('POST', 'submit_anexo_excluir');
pt_register('POST', 'submit_anexo');
pt_register('GET', 'id_pagamento');
$file_path = "../anexos_fin/" . date('Ym') . "/";
if ($submit_anexo) {
    $error = '<ul class="erro">';
    #upload de imagens
    $config = array();
    $config["tamanho"] = 999999; // Tamanho máximo do file_anexo (em bytes)
    $config["largura"] = 1024; // Largura máxima (pixels)
    $config["altura"] = 1024; // Altura máxima (pixels)
    // Upload da imagem
    $file_anexo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
    // Formulário postado... executa as ações
    if ($file_anexo['name'] <> '') {
        $error_image = valida_upload_pdf($file_anexo, $config);
        if ($error_image) {
            $error .= $error_image;
            $erros['anexo'] = 1;
        }
    } else {
        $error.= '<li><b>Selecione o arquivo para fazer upload</b></li>';
        $erros['anexo'] = 1;
    }
    if (!is_dir($file_path))
        mkdir($file_path);

    if (!file_exists($file_path)) {
        if (mkdir($file_path, "0777")) {
            
        } else {
            echo"\nERRO AO CRIAR O ARQUIVO: <b>" . $nomeArquivo . "";
            exit;
        }
    }

    $p = $pagamentoDAO->buscaPorId($id_pagamento, $controle_id_empresa);
    if ($p->id_pagamento == '') {
        $error.= '<li><b>Você não tem permissão para anexar o documento</b></li>';
    }

    #fim do upload foto
    if (COUNT($erros) == 0) {
        if ($file_anexo['name'] <> '') {
            preg_match("/\.(gif|bmp|png|jpg|jpeg|pdf){1}$/i", $file_anexo["name"], $ext); // Pega extensão do file_anexo
            $imagem_nome = $controle_id_usuario . md5(uniqid(time())) . "." . $ext[1]; // Gera um nome único para a imagem
            $imagem_dir = $file_path . $imagem_nome; // Caminho de onde a imagem ficará
            move_uploaded_file($file_anexo["tmp_name"], $imagem_dir); // Faz o upload da imagem
            $pagamentoDAO->adicionarAnexo($imagem_dir, $id_pagamento, $controle_id_empresa);
        }
        //alterado 01/04/2011
        $titulo = 'Adicionar anexo';
        $msg = 'Anexo adicionado com sucesso!';
        $pagina = '';
        $funcJs = "openAlertBox('" . $titulo . "','" . $msg . "','" . $pagina . "');";
        echo '<img src="../images/null.gif" class="nulo" onload="' . $funcJs . '" />';
    } else {
        $error .= '</ul>';
        echo $error;
    }
} else if ($submit_anexo_excluir) {
    pt_register('POST', 'id_pagamento_anexo');
    $l = $pagamentoDAO->buscaAnexoPorId($id_pagamento_anexo, $id_pagamento, $controle_id_empresa);
    if (file_exists($l->anexo))
        unlink($l->anexo);
    $pagamentoDAO->deletaAnexo($id_pagamento_anexo, $id_pagamento, $controle_id_empresa);
}
?>
<table width="650" class="tabela">
    <tr>
        <td colspan="4" class="tabela_tit">Comprovante de pagamento</td>
    </tr>
    <? if ($controle_depto_p[27] != 1) { ?>
        <tr>
            <td align="right"><strong>Arquivo: </strong></td>
            <td colspan="3">
                <form enctype="multipart/form-data" action="#aba2" method="post" name="fornecedor_form">
                    <input type="file" name="arquivo"  class="form_estilo "/>
                    <input type="submit" name="submit_anexo" value="enviar"/>
                </form>
            </td>
        </tr>
    <? } ?>
    <tr>
        <td colspan="3">
            <?
            $lista = $pagamentoDAO->listaAnexo($id_pagamento, $controle_id_empresa);
            $p_valor = '';
            foreach ($lista as $l) {
                $p_valor .= '<form method="post" action="#aba2">';
                if ($controle_depto_p[27] != 1) {
                    $p_valor .='
			<input type="hidden" name="id_pagamento_anexo" value="' . $l->id_pagamento_anexo . '"/>
			<input type="submit" name="submit_anexo_excluir" value="Excluir" onclick="return confirm(\'Deseja realmente excluir?\');"/>';
                }
                $p_valor .='<a href="' . $l->anexo . '" target="_blank">Clique para donwload</a>
			</form>';
            }
            echo $p_valor;
            ?>
        <td>
    </tr>
</table>
