<?php
class ListaInteressadosDAO extends Database{
	public function somaListaInteressadosDataReuniao($acao, $id_status, $uf, $cidade, $nome, $d1, $d2){
		if($uf != ''){ $where .= "AND c.estado_interesse = '".$uf."' "; }
		if($cidade != ''){ $where .= "AND c.cidade_interesse = '".$cidade."' "; }
		if($nome != ''){ $where .= "AND c.nome LIKE '".$nome."%' "; }
		if($data1 != ''){ $where .= "AND (c.data_reuniao BETWEEN '".$data1."' AND '".$data2."') "; }
		switch($acao){
			case 1: $where .= 'AND id_status<>18 AND id_usuario=0 '; break;
			case 2:
				$where .= 'AND id_status<>18 AND id_usuario>0 ';
				if($id_status <> 12 && $id_status > 0){
					$where .= 'AND id_status='.$id_status.' ';
				}else if($id_status == 12){
					$where .= 'AND id_status=12 ';
				}
				if($usuario > 0){
					$where .= 'AND id_usuario='.$usuario.' ';
				}
			break;
			case 3: $where .= 'AND id_status=18 '; break;
		}


		$this->sql = "
		SELECT COUNT( id_ficha ) AS total
		FROM site_ficha_cadastro
		WHERE (id_status = 5 OR id_status = 12) ".$where."";
		$ret = $this->fetch();
		return $ret[0];
	}

	public function somaListaInteressados($acao, $id_status, $uf, $cidade, $id_status, $nome, $usuario){
		switch($acao){
			case 1: $where .= 'AND c.id_status<>18 AND c.id_usuario=0 '; break;
			case 2:
				$where .= 'AND c.id_status<>18 AND c.id_usuario>0 ';
				if($id_status <> 12 && $id_status > 0){
					$where .= 'AND c.id_status='.$id_status.' ';
				}else if($id_status == 12){
					$where .= 'AND id_status=12 ';
				}
				if($usuario > 0){
					$where .= 'AND c.id_usuario='.$usuario.' ';
				}
			break;
			case 3: $where .= 'AND c.id_status=18 '; break;
		}
		if($uf != ''){ $where .= "AND c.estado_interesse = '".$uf."' "; }
		if($cidade != ''){ $where .= "AND c.cidade_interesse = '".$cidade."' "; }
		if($nome != ''){ $where .= "AND c.nome LIKE '".$nome."%' "; }
		$this->sql = "		
			SELECT COUNT( c.id_ficha ) AS total
			FROM site_ficha_cadastro AS c
			WHERE 1 = 1 ".$where."";
		$this->values = array();
		$ret = $this->fetch();
		return $ret[0];		
	}
	
	public function somaListaInteressados2($acao, $id_status, $uf, $cidade, $id_status, $nome, $usuario){
		$this->sql = "		
			SELECT COUNT( c.id_ficha ) AS total
			FROM site_ficha_cadastro AS c
			WHERE 1 = 1 AND c.id_status<>18 AND c.id_usuario<>0";
		$this->values = array();
		$ret = $this->fetch();
		return $ret[0];		
	}

	public function listaInteressados($acao, $id_status, $ini, $fim, $uf, $cidade, $id_status, $nome, $usuario){
		switch($acao){
			case 1: $where .= 'AND c.id_status<>18 AND c.id_usuario=0 '; break;
			case 2:
				if($id_status == 12){
					$where .= 'AND c.id_status=12 ';
				} else {
					$where .= 'AND c.id_status<>18 AND c.id_usuario>0 ';
					if($id_status <> 12 && $id_status > 0){
						$where .= 'AND c.id_status='.$id_status.' ';
					}
				}
				if($usuario > 0){
					$where .= 'AND c.id_usuario='.$usuario.' ';
				}
			break;
			case 3: $where .= 'AND c.id_status=18 '; break;
		}
		if($uf != ''){ $where .= "AND c.estado_interesse = '".$uf."' "; }
		if($cidade != ''){ $where .= "AND c.cidade_interesse = '".$cidade."' "; }
		if($nome != ''){ $where .= "AND c.nome LIKE '".$nome."%' "; }
		
		$this->sql = "SELECT c.id_ficha, c.nome, c.email, c.tel_res, c.estado_interesse, c.cidade_interesse, c.data, s.status,
			c.id_usuario FROM site_ficha_cadastro AS c
			INNER JOIN site_ficha_cadastro_status AS s ON c.id_status = s.id_status
			WHERE 1 = 1 ".$where."
			ORDER BY c.id_ficha DESC
			LIMIT ".$ini.", ".$fim;
		$ret = $this->fetch();
		return $ret;
	}
	
	public function listaInteressados2($acao, $id_status, $ini, $fim, $uf, $cidade, $id_status, $nome, $usuario){
		$this->sql = "SELECT c.id_ficha, c.nome, c.email, c.tel_res, 
			c.estado_interesse, c.cidade_interesse, c.data, s.status,
			c.id_usuario FROM site_ficha_cadastro AS c
			INNER JOIN site_ficha_cadastro_status AS s ON c.id_status = s.id_status
			WHERE 1 = 1 AND c.id_status<>18 AND c.id_usuario<>0
			ORDER BY c.nome ASC
			LIMIT ".$ini.", ".$fim;
		$ret = $this->fetch();
		return $ret;
	}
	
	public function listaInteressadosDataReuniao($acao, $id_status, $ini, $fim, $uf, $cidade, $nome, $data1, $data2, $usuario){

		if($uf != ''){ $where .= "AND c.estado_interesse = '".$uf."' "; }
		if($cidade != ''){ $where .= "AND c.cidade_interesse = '".$cidade."' "; }
		if($nome != ''){ $where .= "AND c.nome LIKE '".$nome."%' "; }
		if($data1 != ''){ $where .= "AND (c.data_reuniao BETWEEN '".$data1."' AND '".$data2."') "; }
		switch($acao){
			case 1: $where .= 'AND c.id_status<>18 AND c.id_usuario=0 '; break;
			case 2:
				if($id_status == 12){
					$where .= 'AND c.id_status=12 ';
				} else {
					$where .= 'AND c.id_status<>18 AND c.id_usuario>0 ';
					if($id_status <> 12 && $id_status > 0){
						$where .= 'AND c.id_status='.$id_status.' ';
					}
				}
				if($usuario > 0){
					$where .= 'AND c.id_usuario='.$usuario.' ';
				}
			break;
			case 3: $where .= 'AND c.id_status=18 '; break;
		}
		
		$this->sql = "
		SELECT DISTINCT c.id_ficha, c.nome, c.email, c.tel_res, c.estado_interesse, c.cidade_interesse, c.data, s.status, c.data_reuniao,
		c.id_usuario FROM site_ficha_cadastro_historico AS h
		INNER JOIN site_ficha_cadastro AS c ON c.id_ficha = h.id_ficha
		INNER JOIN site_ficha_cadastro_status AS s ON c.id_status = s.id_status
		WHERE (c.id_status =5 OR c.id_status =12) ".$where."
		ORDER BY c.data_reuniao DESC
		LIMIT ".$ini.", ".$fim."";
		$ret = $this->fetch();
		return $ret;
	}
	
	public function alteraStatus($id){
		$this->sql= "
					UPDATE site_ficha_cadastro SET 
					id_status=18 WHERE id_ficha=?
		";	
		$this->values = array($id);
		$this->exec();
	}
	
	public function direcionaUsuario($id_ficha, $id_usuario){
		$this->sql= "UPDATE site_ficha_cadastro SET id_usuario=? WHERE id_ficha =?";	
		$this->values = array($id_ficha, $id_usuario);
		$this->exec();
	}
		
	public function buscaFichaCadastros($id){
		$this->sql = "SELECT * FROM site_ficha_cadastro WHERE id_ficha= ?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}	
		
	public function editaFichaCadastros($lista){
		$this->sql= "
					UPDATE site_ficha_cadastro SET 
					nome=?, rg=?, cpf=?, nascimento=?, email=?, 
					tel_res=?, tel_rec=?, tel_cel=?, id_operadora=?, estado_civil=?,	
					filhos=?, filhos_quant=?, endereco=?, numero=?,
					complemento=?, bairro=?, cep=?, estado=?, cidade=?,
					cargo=?, empresa_t=?, historico=?, escolaridade=?, cursos=?,
					formado=?, negocios=?, empresa_p=?, ramo_at=?, periodo=?,
					funcionarios=?, faturamento=?, capital=?, valor_disp=?, emprestimo=?,
					capital_terc=?, inicio_neg=?, dedicado_franq=?, fonte_renda=?, socios=?,
					caixa_empresa=?, conheceu_cp=?, unidades=?, unidades_valor=?, comunicados=?,
					interesse=?, estado_interesse=?, cidade_interesse=?, observacao=?, 
					data_impressao=?, num_cof=?, cof_emitido=?, origem=? WHERE id_ficha=?
		";	
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	//---> Modifica status
	public function editaModificaStatus($lista){
		$sql = "UPDATE site_ficha_cadastro SET  id_user_alt=".$lista['id_user_alt'].", ";
		if($lista['id_status']){
			$sql .= "id_status=".$lista['id_status'].",";
		} 
		if($lista['data_reuniao'] != '--'){
			$sql .= "data_reuniao='".$lista['data_reuniao']."', ";
		}
		$sql .= " observacao_expansao='".$lista['observacao_expansao']."', ";
		$sql .= "data_reuniao_inclusao='".$lista['data_reuniao_inclusao']."' WHERE id_ficha=".$lista['id_ficha']."";
		$this->sql= $sql;
		$this->values = $arr;
		$this->exec();
	}
	
	
	//Cadastro Adicionais
	public function buscaCadastroAdicionais($id){
		$this->sql = "SELECT * FROM site_ficha_cadastro_adicionais WHERE id_ficha= ?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function editaCadastroAdicionais($lista){
		$this->sql = " 
					UPDATE site_ficha_cadastro_adicionais SET
					nacionalidade = ?, local_nascimento = ?, regime = ?, data_casamento = ?,
					nome_pai = ?, nome_mae = ?, tip_imovel = ?, reside_praca=?, franqueado = ?, experiencia = ?,
					motivo = ?, qual_franquia = ?, opiniao = ?, contato = ?, faculdade = ?,
					conclusao = ?, orgao_emissor=?, nome_socio=?, faturamento2=?, 
					funcionarios2=?, profissao=? WHERE id_ficha =?;
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereCadastroAdicionais($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_adicionais (
					nacionalidade, local_nascimento, regime, data_casamento,
					nome_pai, nome_mae, tip_imovel, reside_praca, franqueado, experiencia, motivo,
					qual_franquia, opiniao, contato, faculdade, conclusao, orgao_emissor, 
					nome_socio, faturamento2, funcionarios2, profissao, id_ficha)
					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?);
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereAnexo($lista){
		$this->sql = "INSERT INTO site_ficha_anexos (id_ficha, arquivo, nome, ativo) VALUES (?,?,?,1)";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function listaAnexo($id){
		$this->sql="SELECT * FROM site_ficha_anexos WHERE id_ficha=? AND ativo=1";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret;	
	}
	
	public function excluiAnexo($id){
		$this->sql = "UPDATE site_ficha_anexos SET ativo = 0 WHERE id_anexo=".$id;
		$this->exec();
	}
	
	//Bens de Consumo
	public function buscaBensConsumo($id){
		$this->sql="SELECT * FROM site_ficha_cadastro_bens_consumo WHERE id_ficha=?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];		
	}
	
	public function editaCadastroBensConsumo($lista){
		$this->sql = "
					UPDATE site_ficha_cadastro_bens_consumo SET 
					modelo_veiculo = ?, marca_veiculo = ?, ano_veiculo = ?, placa_veiculo = ?,
					valor_veiculo = ?, financiado = ?, imovel = ?, valor_venal = ?, somatoria = ? 
					WHERE id_ficha = ?
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereCadastroBensConsumo($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_bens_consumo (
					modelo_veiculo, marca_veiculo, ano_veiculo, placa_veiculo, 
					valor_veiculo, financiado, imovel, valor_venal, somatoria, id_ficha) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	
	//Conjuge
	public function buscaConjuge($id){
		$this->sql = "SELECT nome AS conjuge_nome, rg AS conjuge_rg, cpf AS conjuge_cpf, email AS conjuge_email,
		nascimento AS conjuge_nascimento, nome_pai AS conjuge_nome_pai, nome_mae AS conjuge_nome_mae,
		profissao AS conjuge_profissao, cargo AS conjuge_cargo, empresa AS conjuge_empresa, 
		telefone AS conjuge_telefone, admissao AS conjuge_admissao, end_empresa AS conjuge_end_empresa,
		numero AS conjuge_numero, complemento AS conjuge_complemento, bairro AS conjuge_bairro,
		estado AS conjuge_estado, cidade AS conjuge_cidade, cep AS conjuge_cep 
		FROM site_ficha_cadastro_conjuge WHERE id_ficha= ?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function editaConjuge($lista){
		$this->sql = "
					UPDATE site_ficha_cadastro_conjuge SET 
					nome = ?, rg=?, cpf = ?, email = ?, nascimento = ?, nome_pai = ?,
					nome_mae = ?, profissao = ?, cargo = ?, empresa = ?, telefone = ?,
					admissao = ?, end_empresa = ?, numero = ?, complemento = ?, bairro = ?,
					estado = ?, cidade = ?, cep = ?  
					WHERE id_ficha =?;
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereConjuge($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_conjuge(
					nome, rg, cpf, email, nascimento, nome_pai,
					nome_mae, profissao, cargo, empresa, telefone, admissao, end_empresa,
					numero, complemento, bairro, estado, cidade, cep, id_ficha)
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}

	
	//Demonstrativo de Rendimentos
	public function buscaDemonstrativoRendimento($id){
		$this->sql="SELECT * FROM site_ficha_cadastro_demonstrativo_rendimento WHERE id_ficha=?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function editaDemonstrativoRendimento($lista){
		$this->sql = "
					UPDATE site_ficha_cadastro_demonstrativo_rendimento SET 
					honorarios = ?, salarios = ?, comissoes = ?, salario_conjuge = ?, renda_alugueis = ?,
					emprestimo_financeiro = ? WHERE id_ficha =?
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereDemonstrativoRendimento($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_demonstrativo_rendimento (
					honorarios, salarios, comissoes, salario_conjuge, renda_alugueis, emprestimo_financeiro, id_ficha)
					VALUES (?, ?, ?, ?, ?, ?, ?);
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}

	
	//Endereço 2
	public function buscaEndereco2($id){
		$this->sql = "SELECT endereco AS anterior_endereco, numero AS anterior_numero, complemento AS anterior_complemento, 
		bairro AS anterior_bairro, estado AS anterior_estado, cidade AS anterior_cidade, cep AS anterior_cep 
		FROM site_ficha_cadastro_endereco2 WHERE id_ficha= ?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function editaEndereco2($lista){
		$this->sql = "
					UPDATE site_ficha_cadastro_endereco2 SET 
					endereco = ?, numero = ?, complemento = ?, bairro = ?, estado = ?, cidade = ?, cep = ? 
					WHERE site_ficha_cadastro_endereco2.id_ficha =?;

		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereEndereco2($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_endereco2 (
					endereco, numero, complemento, bairro,
					estado, cidade, cep, id_ficha )
					VALUES ( ?, ?, ?, ?, ?, ?, ?, ? );
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	
	//Referências Bancárias
	public function buscaReferenciaBancaria($id){
		$this->sql="SELECT banco, cartao_credito, vencimento, limite, telefone AS telefone_banco,
		nome_gerente, agencia_conta FROM site_ficha_cadastro_referencias_bancarias WHERE id_ficha = ?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function editaReferenciaBancaria($lista){
		$this->sql = "
					UPDATE site_ficha_cadastro_referencias_bancarias SET 
					banco = ?, cartao_credito = ?, vencimento = ?, limite = ?, telefone = ?,
					nome_gerente = ?, agencia_conta = ? WHERE id_ficha =?
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereReferenciaBancaria($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_referencias_bancarias (
					banco, cartao_credito, vencimento, limite, telefone, nome_gerente, 
					agencia_conta, id_ficha)
					VALUES ( ?, ?, ?, ?, ?, ?, ?, ? );
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	
	//Cadastro Lazer
	public function Lazer(){
		$this->sql = "SELECT id_lazer, lazer FROM site_ficha_cadastro_lazer WHERE (ativo = 1) ORDER BY lazer";	
		$this->values = array();
		return $this->fetch();
	}
	
	public function relFichaLazer($id){
		$this->sql="SELECT * FROM site_ficha_rel_cadastro_lazer WHERE id_ficha= ?";
		$this->values = array($id);
		return $this->fetch();
	}
	
	public function relNomeFichaLazer($id){
		$this->sql="SELECT rlz.*, olz.* FROM site_ficha_rel_cadastro_lazer AS rlz 
		INNER JOIN site_ficha_cadastro_lazer AS olz ON olz.id_lazer = rlz.id_lazer
		WHERE id_ficha= ?";
		$this->values = array($id);
		return $this->fetch();
	}
	
		
	//Enum Pergunta
	public function EnumPergunta(){
		$this->sql="SELECT * FROM site_ficha_cadastro_enum_perguntas WHERE (ativo=1) ORDER BY ordem";
		$this->values = array();
		return $this->fetch();
	}
	
	public function buscaRelEnumPergunta($id, $id2){
		$this->sql="SELECT * FROM site_ficha_cadastro_rel_enum_pergunta WHERE id_ficha= ? AND id_enum_perg = ?";
		$this->values = array($id, $id2);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function editaRelEnumPergunta($lista){
		$this->sql = "
					UPDATE site_ficha_cadastro_rel_enum_pergunta SET 
					valor=? WHERE id_enum_perg=? AND id_ficha =?
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereRelEnumPergunta($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_rel_enum_pergunta 
					( valor, id_enum_perg ,id_ficha ) VALUES ( ?, ?, ? );					
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}

	
	//Rel Cad Lazer
	public function buscaRelFichaLazer($id, $id2){
		$this->sql="SELECT * FROM site_ficha_rel_cadastro_lazer WHERE id_ficha= ? AND id_lazer = ?";
		$this->values = array($id, $id2);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function deleteRelFichaLazer($id){
		$this->sql = "DELETE FROM site_ficha_rel_cadastro_lazer WHERE id_ficha = ?";
		$this->values = array($id);
		$this->exec();
	}
	
	public function insereRelFichaLazer($id, $id2){
		$this->sql = "INSERT INTO site_ficha_rel_cadastro_lazer (id_ficha, id_lazer) VALUES (?, ?)";
		$this->values = array($id, $id2);
		$this->exec();
	}
	
	public function buscaIDStatus($id){
		$this->sql = "
			SELECT id_user_alt, id_status, observacao_expansao, data_reuniao, 
			data_reuniao_inclusao FROM site_ficha_cadastro WHERE id_ficha =?
		";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function buscaDataInclude($id){
		$this->sql = "
			SELECT data FROM site_ficha_cadastro WHERE id_ficha = ?
		";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function buscaEstadoInteresse($id){
		$where= 'AND id_status = 18'; 
		if($id != 18){ $where= 'AND id_status <> 18'; }
		$this->sql = "SELECT DISTINCT estado_interesse FROM site_ficha_cadastro
			WHERE 1 = 1 ". $where ." AND estado_interesse <> '' ORDER BY estado_interesse";
		$this->values = array();
		return $this->fetch();
	}
	
	public function buscaCidadeInteresse($acao, $id, $uf){
		switch($acao){
			case 1: $where .= 'AND id_status<>18 AND id_usuario=0 '; break;
			case 2: $where .= 'AND id_status<>18 AND id_usuario>0 '; break;
			case 3: $where .= 'AND id_status=18 '; break;
		}		
		$this->sql = "SELECT DISTINCT cidade_interesse FROM site_ficha_cadastro 
		WHERE estado_interesse = '".$uf."' AND cidade_interesse <> '' ".$where."
		ORDER BY cidade_interesse";
		return $this->fetch();	
	}
	
	public function buscaLazerFicha($id){
		$this->sql = "SELECT lazer FROM site_ficha_rel_cadastro_lazer AS r 
			INNER JOIN site_ficha_cadastro_lazer as s ON r.id_lazer = s.id_lazer
			WHERE id_ficha=".$id."
			ORDER BY lazer";
		return $this->fetch();
	}
	
	public function buscaDadosAdinistrativo($id){
		$this->sql = "SELECT * FROM site_ficha_cadastro_dados_administrativos WHERE id_ficha=?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	public function editaDadosAdministrativo($lista){
		$this->sql = "
					UPDATE site_ficha_cadastro_dados_administrativos SET
					tipo_franquia=?, num_cof=?,	valor_cof=?, forma_pagto=?,
					origem=?, num_cof_emitida=?, valor_efetivo=?
					WHERE id_ficha =?
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function insereDadosAdministrativo($lista){
		$this->sql = "
					INSERT INTO site_ficha_cadastro_dados_administrativos 
					( tipo_franquia, num_cof, valor_cof, forma_pagto, origem, 
					num_cof_emitida, valor_efetivo, id_ficha  ) VALUES ( ?,?,?,?,?,?,?,? );					
		";
		$arr = array_values($lista);
		$this->values = $arr;
		$this->exec();
	}
	
	public function buscaDadosAdministrativo($id){	
		$this->sql="SELECT * FROM site_ficha_cadastro_dados_administrativos WHERE id_ficha = ?";
		$this->values = array($id);
		$ret = $this->fetch();
		return $ret[0];
	}
}
?>