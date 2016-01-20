<?
pt_register('POST','estado');
pt_register('POST','cidade');
pt_register('POST','cep_i');
pt_register('POST','cep_f');
pt_register('POST','cont_outro_cep');
pt_register('POST','cep_i2');
pt_register('POST','cep_f2');

$errors = 0;
$error  = "Os campos s?o obrigat?rios.";
if(
	strlen($estado) == 0 ||
	strlen($cidade) == 0 ||
	strlen($cep_i) == 0 ||
	strlen($cep_f) == 0
){ $errors = 1; }

if($errors == 0){
	$sist_conn = mysql_connect("localhost", "cartorio_user", "flavio1991clau");
	mysql_select_db("cartorio_banco2", $sist_conn);

	$query  = "SELECT id_empresa FROM vsites_user_empresa WHERE cidade = '".$cidade."' AND estado = '".$estado."'";
	$res    = mysql_query($query, $sist_conn) or die(mysql_error());
	$linhas = mysql_num_rows($res);
	if($linhas == 0){
		$error = '';
		$e = $dt->buscaFichaCadastros($id);
		$query =  "INSERT INTO vsites_user_empresa( ";
		$query .= "empresa, fantasia, ";
		$query .= "tipo, cpf, rg, nome, cel, tel, tel_err, email, ";
		$query .= "endereco, complemento, numero, cidade, ";
		$query .= "estado, bairro, cep, data, chat, ultima_acao, status, ramal, franquia, ";
		$query .= "ip, imposto, royalties, fax, modalidade, ";
		$query .= "sigla_cidade, id_banco, agencia, conta, favorecido, ";
		$query .= "imagem, interrede, adendo_data, adendo, inicio, sem1, sem2, sem3, ";
		$query .= "inauguracao_data, validade_contrato, modalidade_c, data_cof, precontrato, ";
		$query .= "aditivo, exclusividade, notificacao) VALUES (";	
		$query .= "'Cart?rio Postal - ".ucwords($cidade)." - ".strtoupper($estado)."', 'Cart?rio Postal - ".ucwords($cidade)." - ".strtoupper($estado)."', ";
		$query .= "'cpf', '".$e->cpf."', '".$e->rg."', '".ucwords($e->nome)."', '".$e->tel_cel."', '".$e->tel_res."', '', '".strtolower($e->email)."', ";
		$query .= "'".ucwords($e->endereco)."', '".ucwords($e->complemento)."', '".$e->numero."', '".ucwords($e->cidade)."', ";
		$query .= "'".strtoupper($e->estado)."', '".ucwords($e->bairro)."', '".$e->cep."', '', '', '0000-00-00 00:00:00', 'Inativo', '', 'Sim', ";
		$query .= "'', '0.00', '5.00', '', '', ";
		$query .= "'', 0, '', '', '', ";
		$query .= "'', 0, '', 0, '0000-00-00', '0.00', '0.00', '0.00', ";
		$query .= "'', '0000-00-00', '', '0000-00-00', '0000-00-00', ";		
		$query .= "'0000-00-00', 0, '')";
		mysql_query($query) or $error = die(mysql_error()); $errors = 1;
		if($error == ''){
			$f = $dt->alteraStatus($id);
			$query  = "SELECT id_empresa FROM vsites_user_empresa ORDER BY id_empresa DESC LIMIT 0, 1";
			$res    = mysql_query($query, $sist_conn) or die(mysql_error());
			while ($linha = mysql_fetch_array($res)) {
				$id_empresa = $linha["id_empresa"];
			}
			
			$dsp1 = 'block';
			$dsp2 = 'none';
			$dsp3 = 'none';

			$errors = 0;
			for($i = 0; $i < count($cep_i2); $i++){
				$correto = 1;
				if($cep_i2[$i] == '' && $cep_f2[$i] == ''){ 
					$error .= ($i+1).', não foi adicionado porque os campos estavam em branco!<br />';
					$errors++;
					$correto = 0;
				}
				
				if(($cep_i2[$i] == '' || $cep_f2[$i] == '') && $correto  == 1){ 
					$$error .= ($i+1).', não foi adicionado porque um dos campos estava em branco!<br />';
					$errors++;
					$correto = 0;
				}
				
				if((strlen($cep_i2[$i]) != 9 || strlen($cep_f2[$i]) != 9) && $correto  == 1){
					$error .= ($i+1).', não foi adicionado porque um dos campos ou ambos, estavam com formato de CEP válido!<br />';
					$errors++;
					$correto = 0;
				}
				
				if(($cep_i2[$i][5] != '-' || $cep_f2[$i][5] != '-') && $correto  == 1){
					$error .= ($i+1).', n?o foi adicionado porque um dos campos ou ambos, estavam com formato de CEP válido!<br />';
					$errors++;
					$correto = 0;
				}
				
				$query = "SELECT id_empresa FROM vsites_franquia_regiao WHERE (";
				$query .= "(('".$cep_i2[$i]."' >= cep_i) AND ('".$cep_i2[$i]."' <= cep_f)) OR ";
				$query .= "(('".$cep_f2[$i]."' >= cep_i) AND ('".$cep_f2[$i]."' <= cep_f))";
				$query .= ")";
				$res    = mysql_query($query, $sist_conn) or die(mysql_error());
				$linhas = mysql_num_rows($res);
				if($linhas > 0 && $correto  == 1){
					$error .= ($i+1).', não foi adicionado, porque já existe CEP nesta faixa, entre '.$cep_i2[$i].' e '.$cep_f2[$i].'!<br />';
					$errors++;
					$correto = 0;
				}
		
				if($correto == 1){			
					$query = "INSERT INTO vsites_franquia_regiao (";
					$query .= "id_empresa, cep_i, cep_f, ";
					$query .= "cidade, estado, loja) VALUES (".$id_empresa.", '".$cep_i2[$i]."', ";
					$query .= "'".$cep_f2[$i]."', '".$cidade."', '".$estado."', '0')";
					mysql_query($query) or $error = die(mysql_error()); $errors = 1;
				}
			}
		} else {
			$errors = 1;
			$error  = "A inclusão da Empresa falhou. Verifique os campos e tente novamente.";
		}
	} else {
		$errors = 1;
		$error  = "Já existe um usuário cadastrado com este Estado e Cidade.";
	}
}
?>