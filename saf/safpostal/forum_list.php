<?
require "../includes/topo.php";
pt_register("GET","busca");
pt_register("GET","lista");
?>
<table width="920" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="3" height="2"></td>
  </tr>
  <tr>
    <td width="150" align="left" valign="top">
    <table width="150" border="0" cellspacing="0" cellpadding="0" align="left">
      <tr>
        <td><? require "menu_lateral.php"; ?></td>
      </tr>
    </table>
    </td>
    <td width="2"></td>
    <td align="left" valign="top">
    	<table width="768" border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td width="764" align="center" valign="top" background="../images/paginas/index/barra_de_titulo1.png"><table width="768" border="0" cellspacing="0" cellpadding="0">
	          <tr>
	            <td width="345" height="20" align="left" valign="middle"><strong>Perguntas e Respostas</strong></td>
	            <td width="415" align="left" valign="middle"><span style="font-weight: bold">Franquia: <? echo $safpostal_fantasia ?></span></td>
	          </tr>
	        </table></td>
	      </tr>
	      <tr>
        <td align="center">
        <br>
        <form name="form_forum" action="" method="get" enctype="multipart/form-data">
		<div style="float:left">    
			<img src="../images/paginas/chat/lupa.png" alt="busca" />
        </div>
        <div>
        	<input type="hidden" name="lista" value="<?php echo $lista?>"/>
			<input type="text" class="form_estilo" name="busca" value="<?= $busca ?>" size="30" />
			<input type="submit" name="submit" class="button_busca" value=" Buscar " />
        	<input type="submit" name="limpar" class="button_busca" onclick="busca.value='';" value=" Mostrar Todos " />
        </div>
		</form><br />
        <div id="conteudo_forum_list">
		
        <div id="titulo_forum_list"><strong>
        <table border="0" width="100%" cellpadding="0" cellspacing="0">
        	<tr>
        		<td width="60%" align="left" valign="middle">Tópicos</td>
        	</tr>
        </table></strong>
        </div>
        </div>
		<table border="0" width="100%" cellpadding="0" cellspacing="0" id="alter">		 
		<?
		$onde ="";
		if($lista=="pendentes") $st=0;
		elseif($lista=="cancelados") $st=2;
		else $st=1;
		
		if($busca<>''){$onde .= " and (f.titulo like '%$busca%' or pergunta like '%$busca%')";}
		if($st==1){
			$onde.=" or (f.id_usuario = $safpostal_id_usuario and f.status=0)";
		}
		
		$condicao = "FROM saf_forum as f WHERE f.status='$st' " . $onde . " ORDER BY id_forum DESC ";
		$campo = " f.titulo, f.id_forum, date_format(f.data, '%d/%m/%y') as data , f.status";
		
		pt_register('GET','pagina');
		$url_busca = $_SERVER['REQUEST_URI'];
		$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
		$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
		$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca);
		$p_valor = "";
		while($res = mysql_fetch_array($query)){ 
				$p_valor .= '
				<tr>
					<td align="left" valign="middle" height="25">
						<a href="forum_edit.php?id=' . $res['id_forum'] . '" style="display:block" title="Clique aqui">
						<b>' . $res['data'] . '</b> - ' . $res['titulo'] .' </a>
					</td>
				<tr>';
		}
		echo $p_valor;
		?>
		</table>
		</table>
		<?php if($lista=='pendentes' && $permissao=='TRUE'){?>
		<div id="conteudo_forum_list">
	        <div id="titulo_forum_list">
		        <table border="0" width="100%" cellpadding="0" cellspacing="0">
		        	<tr><td width="60%" align="left" valign="middle"><strong>Respostas Pendentes</strong></td></tr>
		        </table>
	        </div>
        </div>
        <table border="0" width="100%" cellpadding="0" cellspacing="0" id="alter">		 
		<?
		$onde ="";
		if($busca<>''){$onde .= " and ( resposta like '%$busca%')";}
		
		$condicao = "FROM saf_forum_resposta as f WHERE f.status='Pendente' " . $onde . " ORDER BY id_forum DESC ";
		$campo = "date_format(f.data, '%d/%m/%y') as data , id_usuario,resposta,status,id_forum";
		
		pt_register('GET','pagina');
		$url_busca = $_SERVER['REQUEST_URI'];
		$url_busca_pos = strpos($_SERVER['REQUEST_URI'],'.php');
		$url_busca = substr(str_replace('pagina='.$pagina.'&','',$url_busca),$url_busca_pos+5);
		$query = $objQuery->paginacao( $campo , $condicao, $pagina , $url_busca);
		$p_valor = "";
		while($res = mysql_fetch_array($query)){ 
				$p_valor .= '
				<tr>
					<td align="left" valign="middle" height="25">
						<a href="forum_edit.php?id=' . $res['id_forum'] . '" style="display:block" title="Clique aqui">
						<b>' . $res['data'] . '</b> - ' .nl2br($res['resposta']) . ' </a>
						<br>
					</td>
				<tr>';
		}
		echo $p_valor;
		?>
		</table>
        <?php } ?>
    </td>
  </tr>
</table>
</td>
      </tr>
    </table>
   </td>
  </tr>
</table>

<?
require "../includes/rodape.php";
?>