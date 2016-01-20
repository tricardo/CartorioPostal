<?
header( "Content-type: text" );
header( "Content-Disposition: inline, filename=oficio.txt");
require('../includes/classQuery.php');
$p_valor ='';

$sql = "select * from vsites_user_cliente as uc where tipo='CPF'";
$query = $objQuery->SQLQuery($sql);

$p_valor .= '001T';
$NOMEEMPRESA = 'CARTORIO POSTAL';
$num = strlen($NOMEEMPRESA);
while($num<50){
	$NOMEEMPRESA = $NOMEEMPRESA.' ';
	$num++;
}
$p_valor .= $NOMEEMPRESA;

$NOMEEMPRESA = 'METLIFE';
$num = strlen($NOMEEMPRESA);
while($num<50){
	$NOMEEMPRESA = $NOMEEMPRESA.' ';
	$num++;
}
$p_valor .= $NOMEEMPRESA;

#data
$p_valor .= date('Ymd');

#Sequencia do lote
$p_valor .= '00000001';

#Brancos
$num=0;
$outros = '';
while($num<1880){
	$outros .= ' ';
	$num++;
}
$p_valor .= $outros.'
';

$num=0;
$outrosbrancos = '';
while($num<1184){
	$outrosbrancos .= ' ';
	$num++;
}

echo $p_valor;
while($res = mysql_fetch_array($query)){
	#campo1
	$p_valor = '1';
	
	#campo2
	$p_valor .= '000';

	#campo3
	$nome = substr($res['nome'],0,60);
	$num = strlen($res['nome']);
	while($num<60){
		$nome .= ' ';
		$num++;
	}
	$p_valor .= $nome;
	
	#campo4
	$res['cpf'] = substr(str_replace('/','',str_replace('-','',str_replace('.','',$res['cpf']))),0,11);
	$num = strlen($res['cpf']);	
	while($num<11){
		$res['cpf'] = '0'.$res['cpf'];
		$num++;
	}
	$p_valor .= $res['cpf'];

	#campo5
	$p_valor .= '7';

	#campo6
	$p_valor .= '00000000';

	#campo7
	$res['endereco'] = substr($res['endereco'],0,100);
	$num = strlen($res['endereco']);
	while($num<100){
		$res['endereco'] = $res['endereco'].' ';
		$num++;
	}
	$p_valor .= $res['endereco'];
	
	#campo8
	$res['numero'] = substr($res['numero'],0,10);
	$num = strlen($res['numero']);
	while($num<10){
		$res['numero'] = $res['numero'].' ';
		$num++;
	}
	$p_valor .= $res['numero'];

	#campo9
	$res['complemento'] = substr($res['complemento'],0,25);
	$num = strlen($res['complemento']);
	while($num<25){
		$res['complemento'] = $res['complemento'].' ';
		$num++;
	}
	$p_valor .= $res['complemento'];

	#campo10
	$res['bairro'] = substr($res['bairro'],0,25);
	$num = strlen($res['bairro']);
	while($num<25){
		$res['bairro'] = $res['bairro'].' ';
		$num++;
	}
	$p_valor .= $res['bairro'];

	#campo11
	$res['cidade'] = substr($res['cidade'],0,25);
	$num = strlen($res['cidade']);
	while($num<25){
		$res['cidade'] = $res['cidade'].' ';
		$num++;
	}
	$p_valor .= $res['cidade'];

	#campo12
	$res['estado'] = substr($res['estado'],0,2);
	$num = strlen($res['estado']);
	while($num<2){
		$res['estado'] = $res['estado'].' ';
		$num++;
	}
	$p_valor .= $res['estado'];

	#campo13
	$res['cep'] = substr($res['cep'],0,8);
	$num = strlen($res['cep']);
	while($num<8){
		$res['cep'] = $res['cep'].' ';
		$num++;
	}
	$p_valor .= $res['cep'];
	
	#campo14 e 15
	$res['tel'] = '0'.(int)(substr(str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('-','',str_replace('.','',$res['tel']))))),0,12));
	$res['tel'] = substr($res['tel'],0,7).substr($res['tel'],7,4).' ';
	$num = strlen($res['tel']);
	if($num!=12){
		$res['tel']='00000000000 ';
	}
	$p_valor .= $res['tel'];

	#campo16 e 17
	$res['tel2'] = '0'.(int)(substr(str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('-','',str_replace('.','',$res['tel2']))))),0,12));
	$res['tel2'] = substr($res['tel2'],0,7).substr($res['tel2'],7,4).' ';
	$num = strlen($res['tel2']);
	if($num!=12){
		$res['tel2']='00000000000 ';
	}
	$p_valor .= $res['tel2'];


	#campo18 e 19
	$res['cel'] = '0'.(int)(substr(str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('-','',str_replace('.','',$res['cel']))))),0,12));
	$res['cel'] = substr($res['cel'],0,7).substr($res['cel'],7,4).' ';
	$num = strlen($res['cel']);
	if($num!=12){
		$res['cel']='00000000000 ';
	}
	$p_valor .= $res['cel'];

	#campo20 a 33
	$num=0;
	$outros = '';
	while($num<301){
		$outros .= ' ';
		$num++;
	}
	$p_valor .= $outros;
	
	#campo41 e 42
	$res['email'] = substr($res['email'],0,200);
	$email = explode(';',$res['email']);
	if(COUNT($email)>=2){
		$num = strlen($email[0]);
		while($num<100){
			$email[0] = $email[0].' ';
			$num++;
		}
		$num = strlen($email[1]);
		while($num<100){
			$email[1] = $email[1].' ';
			$num++;
		}
		$res['email'] = $email[0].$email[1];
	} else {
		$email = explode('/',$res['email']);
		if(COUNT($email)>=2){
			$num = strlen($email[0]);
			while($num<100){
				$email[0] = $email[0].' ';
				$num++;
			}
			$num = strlen($email[1]);
			while($num<100){
				$email[1] = $email[1].' ';
				$num++;
			}	
			$res['email'] = $email[0].$email[1];
		}else{
			$num = strlen($res['email']);
			while($num<200){
				$res['email'] = $res['email'].' ';
				$num++;
			}		
		}
	}
	
	$p_valor .= $res['email'];

	$p_valor .= $outrosbrancos;
	
	$p_valor .= '
';
echo $p_valor;
$cont++;
}
#trailler
$p_valor = '9';


$num=strlen($cont);
while($num<9){
	$cont = '0'.$cont;
	$num++;
}
$p_valor .= $cont;

#campo3
$num=0;
$outros = '';
while($num<1990){
	$outros .= ' ';
	$num++;
}
$p_valor .= $outros;

echo $p_valor;
?>