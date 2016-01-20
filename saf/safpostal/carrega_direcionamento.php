<?
	session_start();		
	if($_GET['id'] == 1){
		require( '../includes/classQuery.php' );
    	require( '../includes/browser.php' );
		$sql= "SELECT * FROM vsites_user_usuario as uu WHERE status='Ativo' AND id_empresa=".$_GET['id']." ORDER BY nome";
		$dt = $objQuery->SQLQuery($sql);
		$res = mysql_fetch_array($dt);
		echo '<select id="usuario" name="usuario" class="form_estilo" style="width:298px;">' ."\n";
		echo '<option value="0"></option>' . "\n";
		while($res = mysql_fetch_array($dt)){
			echo '<option value="'.$res['id_usuario'].'">'.utf8_encode(ucwords(strtolower($res['nome']))).'</option>' . "\n";
		}
		echo '</select>';
	} else {
		require( "../includes/verifica_logado_safpostal.inc.php" );
		require( "../includes/funcoes.php" );
		require( "../includes/global.inc.php" );
		pt_register('GET','id_ficha');
		pt_register('GET','id_usuario');
		pt_register('GET','redirecionar');
		$dt  = new ListaInteressadosDAO();
		
		$arr = explode(',', $id_ficha);

		for($i = 0; $i < count($arr); $i++){
			$dt->direcionaUsuario($id_usuario, $arr[$i]);
		}
		$pagina = 'direcionamento.php';
		if($redirecionar){ $pagina .= '?redirecionar=1'; } ?>
      <script language="javascript" type="text/javascript">
	  	alert('Direcionamento atualizado com sucesso!');
		setTimeout("location.href='<?=$pagina?>'", 500);
	  </script>  
	<? }
?>