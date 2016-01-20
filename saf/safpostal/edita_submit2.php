<?
$errors = 0;
foreach($_POST as $cp => $valor){ $c->$cp = valida($valor); }

$erro_dt= 0;

if($c->id_status == 0){
	$errors++;
	$error  = 'Você deve selecionar um Status para prosseguir!';
	$cp     = 'id_status'; 
} elseif(($c->id_status == 5 || $c->id_status == 10 || $c->id_status == 12) && $errors == 0){
		
	if($c->data_reuniao == '//' || $c->data_reuniao == '' && $errors == 0){
		$errors++;
		$error = 'Data digitada é inválida!';
		$cp    = 'data_reuniao';
		$erro_dt= 1;
	} else {
		$data = explode("/", $c->data_reuniao); 
		$d = $data[0];
		$m = $data[1];
		$y = $data[2];
		
		if(checkdate($m,$d,$y) == 0){
			$errors++;
			$error = 'Data digitada é inválida!'.$m.','.$d.','.$y;
			$cp    = 'data_reuniao';
			$erro_dt= 1;
		}
	}
	
	$dt_comp1 = $y.'-'.$m.'-'.$d;
	$dt_ver1  = strtotime($dt_comp1);
	
	$dt_comp2 = date('Y-m-d');
	$dt_ver2  = strtotime($dt_comp2);
	
	if($errors == 0 && ($dt_ver1 < $dt_ver2)){
		$errors++;
		$error = 'A data digitada não pode ser inferior a data atual!';
		$cp    = 'data_reuniao';
		$erro_dt= 1;
	}
}

$erro_sb = 0;
if(($c->id_status == 2 || $c->id_status == 3 || $c->id_status == 16 || $c->id_status == 17 || $c->id_status == 20) &&
	strlen($c->observacao_expansao) == 0 && $errors == 0){
	if(strlen($c->observacao_expansao) == 0){
		$errors++;
		$error = 'O Campo Anotações Sobre Este Cadastro, não pode ser vazio!';
		$cp    = 'observacao_expansao';
		$erro_sb= 1;
	}
}

if($errors == 0){
	$e = $dt->buscaIDStatus($id);
	$id_status_anterior 			= $e->id_status;
	$data_reuniao_anterior 			= $e->data_reuniao;
	$data_reuniao_inclusao_anterior = $e->data_reuniao_inclusao;
	$id_user_alt_anterior 			= $e->id_user_alt;
	$observacao_anterior 			= $e->observacao_expansao;
	if($data_reuniao){$data = explode("/", $data_reuniao);}
	
	$d = $data[0]; $m = $data[1]; $y = $data[2];
	if($id_status == 19){
		$lista = array(
			'id_user_alt'=>$safpostal_id_usuario, 'observacao_expansao'=>$c->observacao_expansao, 
			'data_reuniao'=>$y.'-'.$m.'-'.$d, 'data_reuniao_inclusao'=>date ('Y-m-j') . ' ' . date ('H:i:s'), 
			'id_ficha'=>$id
		);	
	
	} else {
		$lista = array(
			'id_user_alt'=>$safpostal_id_usuario,'id_status'=>$c->id_status, 'observacao_expansao'=>$c->observacao_expansao, 		
			'data_reuniao'=>$y.'-'.$m.'-'.$d, 'data_reuniao_inclusao'=>date ('Y-m-j') . ' ' . date ('H:i:s'), 
			'id_ficha'=>$id
		);	
	}

	$dt->editaModificaStatus($lista);

	$lista = array(
		'id_ficha'=>$id, 'id_user_alt'=>$id_user_alt_anterior, 
		'id_status'=>$id_status_anterior, 'data_reuniao'=>$data_reuniao_anterior, 'data_inclusao'=>$data_reuniao_inclusao_anterior,
		'observacao'=>$observacao_anterior
	);
	$dt1->insereHistorico($lista);
	if($c->id_status != 20){
		
		$e = $dt->buscaFichaCadastros($id); foreach($e as $cp => $valor){ $c->$cp = $valor; }
		$e = $dt->buscaCadastroAdicionais($id); foreach($e as $cp => $valor){ $c->$cp = $valor; }
		$e = $dt->buscaConjuge($id); foreach($e as $cp => $valor){ $c->$cp = $valor; }
		$e = $dt->buscaEndereco2($id); foreach($e as $cp => $valor){ $c->$cp = $valor; }
		$e = $dt->buscaReferenciaBancaria($id); foreach($e as $cp => $valor){ $c->$cp = $valor; }
		$e = $dt->buscaDemonstrativoRendimento($id); foreach($e as $cp => $valor){ $c->$cp = $valor; }
		$e = $dt->buscaBensConsumo($id); foreach($e as $cp => $valor){ $c->$cp = $valor; }
		$e = $dt->buscaDadosAdinistrativo($id); foreach($e as $cp => $valor){ $c->$cp = $valor; }
	
		#require( '../includes/classQuery.php' );
		require( '../includes/browser.php' );
		$sql= "SELECT * FROM vsites_user_usuario as uu 
		WHERE uu.status='Ativo' AND uu.id_empresa=".$safpostal_id_empresa." AND uu.id_usuario = ".$c->id_usuario." ORDER BY uu.nome";
	
		$dt = $objQuery->SQLQuery($sql);
		$res = mysql_fetch_array($dt);
		
		switch($c->id_status){
			case 4: require "envia_email_elaborar_cof.php"; break;
			case 9: require "envia_email_emitir_contrato.php"; break;
			#case 12: require "envia_email_segunda_reuniao.php"; break;
			case 14: require "envia_email_finalizar.php"; break;
		}
	}
	//recarregar página
	echo "<script>location.href='interessados_edit.php?id=".$id."&aba=2';</script>";
	exit();
}
?>