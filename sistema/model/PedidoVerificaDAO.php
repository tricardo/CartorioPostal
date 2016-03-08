<?php
class PedidoVerificaDAO extends Database{

	public function __construct(){
		parent::__construct();
		$this->table = 'vsites_pedido_pedido';
	}

	/**
	 * verifica permissão de alterar solicitante (dependendo do status do pedido)
	 * @param array $deoartamento_p
	 * @param array $departamento_s
	 * @param array $id_status
	 * @param array $inicio
	 */
	public function verificaAlteracaoSolicitante($departamento_p,$departamento_s,$id_status,$inicio){
		if(in_array('2',$departamento_s)==1 or in_array('1',$departamento_s)==1 or (in_array('6',$departamento_p)==1 and ($id_status=='1' or $id_status=='2' or $id_status=='11' or $id_status=='12' or $id_status=='14' or $id_status=='16'))){
			return true;
		} else {
			return false;
		}
	}

	/**
	 * verifica permissão de alterar pedido
	 * @param int $id_pedido_item
	 * @param int $id_empresa
	 * @param array $departamento_p
	 * @param array $departamento_s
	 * @param array $p
	 */
	public function verificaPermissaoEdit($id_pedido_item,$id_empresa,$departamento_p,$departamento_s,$p){

		$p_valor = array();
		$this->sql = "SELECT pi.inicio, pi.dias, sd.id_departamento_resp, pi.id_status, pi.encerramento, pi.id_empresa_resp, pi.operacional, pi.id_usuario, pi.id_usuario_op from
				vsites_pedido_item as pi, vsites_servico_departamento as sd where
					pi.id_pedido_item=? and
					pi.id_servico_departamento = sd.id_servico_departamento";
		$this->values = array($id_pedido_item);
		
		$cont = $this->fetch();

		$id_status = $cont[0]->id_status;
		$operacional = $cont[0]->operacional;
		$dias_old = $cont[0]->dias;
		$inicio = $cont[0]->inicio;
		$encerramento = $cont[0]->encerramento;
		$id_departamento_resp = $cont[0]->id_departamento_resp;
		$id_usuario = $cont[0]->id_usuario;
		$id_usuario_op = $cont[0]->id_usuario_op;
		$id_empresa_resp = $cont[0]->id_empresa_resp;

		#verifica se o departamento tem permissão de alterar o pedido
		if(in_array('6',$departamento_p)!=1 and in_array('2',$departamento_p)!=1 and in_array('3',$departamento_p)!=1 and in_array('4',$departamento_p)!=1 and in_array('5',$departamento_p)!=1 and in_array('8',$departamento_p)!=1 and in_array('9',$departamento_p)!=1 and in_array('11',$departamento_p)!=1 and in_array('12',$departamento_p)!=1 and in_array('15',$departamento_p)!=1 and in_array('16',$departamento_p)!=1){
			$p_valor['error'] .= '<li><b>Você não tem permissão para realizar essa operação!</b></li>';
			return $p_valor;
		}

		#verifica se tem permissão de alterar o pedido do departamento
		if(in_array($id_departamento_resp,$departamento_p)!=1 and in_array('6',$departamento_p)!=1 and in_array('2',$departamento_p)!=1){
			$p_valor['error'] .= '<li><b>Você não tem permissão para realizar essa operação, esse pedido pertence a outro departamento.</b></li>';
			return $p_valor;
		}

		#verifica se a franquia tem permissão de alterar o pedido que está em execução por outra unidade
		if($operacional=='0000-00-00' and $id_empresa_resp!='0' and $id_empresa_resp!=$id_empresa and $id_status!=12){
			$p_valor['error'] .= '<li><b>Você não tem permissão para realizar essa operação, porque outra franquia foi selecionada para executar o serviço.</b></li>';
			return $p_valor;
		}

		#verifica se o pedido foi concluido operacional e se a franquia pode alterar
		if($operacional<>'0000-00-00' and $id_empresa_resp!='0' and $id_empresa_resp==$id_empresa and $id_empresa!='1'){
			$p_valor['error'] .= '<li><b>Esse pedido já foi concluído por sua unidade e foi liberado para a franquia responsável pelo cadastro.</b></li>';
			return $p_valor;
		}

		#verifica se o pedido foi concluido a mais de 30 dias
		$data_atual = invert(SubtrairData(date('d/m/Y'), 30, 0, 0),'-','SQL').' 00:00:00';
		if($encerramento!="0000-00-00 00:00:00" and $encerramento<=$data_atual and $id_empresa!=1){
			$p_valor['error'] .= "<li><b>Esse pedido não pode ser alterado porque foi concluído a mais de 30 dias.</b></li>";
			return $p_valor;
		}

		#verifica alteração do valor
		if($id_empresa_resp!='0' and $id_empresa_resp==$id_empresa  and $p->valor!=$p->old_valor){
			$p_valor['error'] .= "<li><b>O campo \"valor\" não pode ser alterado porque o pedido já foi enviado para outra franquia. O valor deve ser cadastrado corretamente antes de enviar para a franquia.</b></li>";
			return $p_valor;
		}

		#verifica alteração do valor caso tenha sido liberado para o financeiro
		if($p->valor!=$p->old_valor and $operacional!='0000-00-00' and in_array('2',$departamento_p)!=1 and in_array('1',$departamento_p)!=1){
			$p_valor['error'] .= "<li><b>O campo \"valor\" não pode ser alterado porque o pedido já foi concluído pelo operacional.</b></li>";
			return $p_valor;
		}

		#verifica alteração do valor caso tenha sido liberado para o financeiro
		if($p->valor!=$p->old_valor and $inicio!='0000-00-00 00:00:00' and in_array($id_departamento_resp,$departamento_s)!=1 and in_array('2',$departamento_p)!=1 and in_array('1',$departamento_p)!=1){
			$p_valor['error'] .= "<li><b>O campo \"valor\" só pode ser alterado pelo supervisor do operacional ou financeiro.</b></li>";
			return $p_valor;
		}
		
		#verifica campo valor caso já tenha sido faturado .
		if($p->valor!=$p->old_valor and $p->id_fatura==1){
			$p_valor['error'] .= "<li><b>Essa ordem já foi faturada.<br>O campo \"valor\" não pode ser alterado.</b></li>";
			return $p_valor;			
		}
		#verifica se o atendimento ainda pode alterar o pedido
		if($id_status!=1 and $id_status!=2 and $id_status!=11 and $id_status!=12 and $id_status!=16 and in_array($id_departamento_resp,$departamento_p)!=1 and in_array('6',$departamento_p)==1 and in_array('2',$departamento_p)!=1){
			$p_valor['error'] .= "<li><b>Esse serviço já foi enviado para o departamento operacional e você não pode mais alterá-lo</b></li>";
			return $p_valor;
		}

		#verifica se o campo valor foi preenchido
		if($p->valor=="" or $p->valor=="0"){
			$p_valor['error'] .= "<li><b>O campo \"valor\" precisa ser preenchido.</b></li>";
		}

		#verifica se a variação foi selecionada
		if($p->id_servico_var=='' or $p->id_servico_var=='0') {
			$p_valor['error'] .= "<li><b>Selecione a variação do serviço.</b></li>";
		}
		
		#verifica se campo estado e cidade foram selecionados - 07/02/2013 - Rafael
		if(isset($p->certidao_estado)){
			$erros_servico = 0;
			switch($p->id_servico){
				case 17:
					$erros_servico = 1;
					break;
			}
			if($erros_servico == 0){
				if(strlen($p->certidao_estado) == 0 OR strlen($p->certidao_cidade) == 0){
					if(strlen($p->certidao_estado) == 0){
						$p_valor['error'] .= "<li><b>Preencha o campo UF.</b></li>";
					}
					if(strlen($p->certidao_cidade) == 0){
						$p_valor['error'] .= "<li><b>Preencha o campo Cidade.</b></li>";
					}
				}
			}
		}

		$p_valor['data_prazo'] = somar_dias_uteis($inicio,$p->dias);

		return $p_valor;

	}

	/**
	 * verifica permissão de alterar solicitante
	 * @param int $id_pedido_item
	 * @param int $id_empresa
	 * @param array $departamento_p
	 * @param array $departamento_s
	 * @param array $p
	 */
	public function verificaPermissaoEditSolicitante($id_pedido_item,$id_empresa,$departamento_p,$departamento_s,$p){
		global $controle_id_pais;
		$errors=array();
		$this->sql = "SELECT pi.id_empresa_atend as id_empresa, pi.operacional, pi.id_status, pi.inicio, pi.id_pedido_item, pi.id_empresa_resp, sd.id_departamento_resp from
					vsites_pedido_item as pi, vsites_servico_departamento as sd where
					pi.id_pedido_item=? and 
					pi.id_servico_departamento = sd.id_servico_departamento";
		$this->values = array($id_pedido_item);
		$cont = $this->fetch();

		$id_departamento_resp 	= $cont[0]->id_departamento_resp;
		$operacional 			= $cont[0]->operacional;
		$id_empresa_e 			= $cont[0]->id_empresa;
		$id_empresa_resp 		= $cont[0]->id_empresa_resp;
		$inicio 				= $cont[0]->inicio;
		$id_status 				= $cont[0]->id_status;
		$id_pedido_item 		= $cont[0]->id_pedido_item;

		if($id_pedido_item==""){
			$errors['error'].="<li><b>Você não tem permissão de alterar o pedido.</b></li>";
		}

		if($p->origem=="" or $p->cpf=="" or $p->nome=="" or $p->forma_pagamento=="" or $p->cep=="" or $p->numero=="" or $p->bairro=="" or $p->estado=="" or $p->cidade=="" or $p->endereco==""){
			if($p->cpf=="") 			$errors['cpf']=1;
			if($p->nome=="") 			$errors['nome']=1;
			if($p->origem=="") 			$errors['origem']=1;
			if($p->forma_pagamento=="") $errors['forma_pagamento']=1;
			if($p->cep=="") 			$errors['cep']=1;
			if($p->numero=="")   		$errors['numero']=1;
			if($p->endereco=="") 		$errors['endereco']=1;
			if($p->cidade=="")   		$errors['cidade']=1;
			if($p->estado=="")   		$errors['estado']=1;
			if($p->bairro=="")   		$errors['bairro']=1;
			$errors['error'].="<li><b>Os campos com * são obrigatórios.</b></li>";
		}

		#verifica se o atendimento ainda pode alterar o pedido
		if($id_status!=1 and $id_status!=2 and $id_status!=11 and $id_status!=12 and $id_status!=16 and in_array($id_departamento_resp,$departamento_p)!=1 and in_array('6',$departamento_p)==1 and in_array('2',$departamento_p)!=1){
			$errors['error'].="<li><b>Esse serviço já foi enviado para o departamento operacional e você não pode mais alterá-lo</b></li>";
		}

		#verifica se pertence a empresa
		if($id_empresa_e!=$id_empresa){
			$errors['error'].="<li><b>Somente o responsável pelo pedido pode realizar alterações nos dados do solicitante.</b></li>";
		}

		if($p->email<>''){
			$valida = validaEMAIL($p->email);
			if($valida=='false'){
				$errors['email']=1;
				$errors['error'].= "<li><b>E-mail Inválido, digite corretamente.</b></li>";
			}
		}

		if($p->tipo=='cpf'){
			$valida = validaCPF($p->cpf);
			if($valida=='false'){
				$errors['cpf']=1;
				$errors['error'].="<li><b>CPF Inválido, digite corretamente.</b></li>";
			}
		} else {
			$valida = validaCNPJ($p->cpf);
			if($valida=='false' and $controle_id_pais){
				$errors['cpf']=1;
				$errors['error'].="<li><b>CNPJ Inválido, digite corretamente.".$controle_id_pais."</b></li>";
			}
		}

		#verifica se tem permissão de alterar o pedido do departamento
		if(in_array($id_departamento_resp,$departamento_p)!=1 and in_array('6',$departamento_p)!=1 and in_array('2',$departamento_p)!=1){
			$errors['error'] .= '<li><b>Você não tem permissão para realizar essa operação, esse pedido pertence a outro departamento.</b></li>';
		}

		#verifica se o concluido operacional foi concluído, caso tenha sido concluído o operacional e o atendimento não pode mais mexer.
		if(in_array('1',$departamento_p)!=1 and in_array('2',$departamento_p)!=1 and $operacional<>'0000-00-00'){
			$errors['error'] .= '<li><b>Você não tem permissão para realizar essa operação, esse pedido pertence a outro departamento.</b></li>';
		}

		return $errors;

	}

	public function verificaPermissaoEditPedido($id_pedido,$ordem,$id_empresa){
        if($id_empresa!=0){
            $onde = " and (pi.id_empresa_atend='".$id_empresa."' or pi.id_empresa_resp='".$id_empresa."')";
        } else {
            $onde = '';
        }
		$this->sql = "SELECT pi.ordem, pi.id_pedido_item, pi.id_servico, pi.encerramento, pi.id_empresa_atend as id_empresa
		from vsites_pedido_item as pi 
		where pi.id_pedido=? and pi.ordem=? ".$onde;
		$this->values = array($id_pedido,$ordem);
		$ret = $this->fetch();
		return $ret[0];
	}

	public function verificaPermissaoEditPedidoItem($id_pedido_item,$id_empresa){
		$this->sql = "SELECT (1) as total, ue.id_empresa, ue.adendo, p.cpf, p.id_pacote, p.forma_pagamento, p.origem, p.id_conveniado, sd.id_departamento_resp,
		pi.id_empresa_dir, pi.valor_rec, pi.data_prazo, pi.certidao_resultado, pi.custas, pi.motivo_atraso, pi.id_pedido, pi.certidao_nome, 
		pi.certidao_devedor, pi.id_servico,  pi.id_usuario, pi.id_usuario_op, pi.id_status, pi.id_empresa_resp, pi.data_atividade, pi.atendimento, pi.dias, 
		pi.id_atividade, pi.operacional, pi.encerramento, pi.inicio, pi.certidao_devedor_cpf, pi.certidao_cidade, pi.certidao_estado
		from vsites_pedido_item as pi, vsites_pedido as p, vsites_servico_departamento as sd, vsites_user_empresa as ue where 
		pi.id_pedido_item=? and
		(pi.id_empresa_resp=? or pi.id_empresa_atend=?) and
		pi.id_empresa_atend=ue.id_empresa and
		pi.id_pedido=p.id_pedido and
		pi.id_servico_departamento = sd.id_servico_departamento limit 1";
		$this->values = array($id_pedido_item,$id_empresa,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}

	public function verificaPermissaoAnexo($id_pedido_item,$id_empresa){
		$this->sql = "SELECT sd.id_departamento_resp, pi.id_empresa_resp, pi.operacional, pi.id_pedido_item
		from vsites_pedido_item as pi, vsites_servico_departamento as sd where 
		pi.id_pedido_item=? and
		(pi.id_empresa_resp=? or pi.id_empresa_atend=?) and
		pi.id_servico_departamento = sd.id_servico_departamento limit 1";
		$this->values = array($id_pedido_item,$id_empresa,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}
	
	#verifica se o pedido precisa ser direcionado para a franquia
	public function verificaDirecionamentoFranquia($cidade,$estado){
		$this->sql = "SELECT ue.id_empresa as total, ue.id_empresa, ue.adendo_data, ue.cidade
		from vsites_user_empresa as ue, vsites_franquia_regiao as fr where 
		trim(fr.cidade)=? and 
		trim(fr.estado)=? and 
		fr.id_empresa=ue.id_empresa and 
		ue.status in ('Ativo', 'Renovação') and
		ue.adendo=1
		limit 1";
		$this->values = array(trim($cidade),trim($estado));
		$ret = $this->fetch();
		return $ret[0];
	}

	#verifica se o pedido precisa ser direcionado para a franquia
	public function verificaDirFranquia($id_empresa,$id_pedido_item){
		$this->sql = "SELECT pi.ordem, pi.id_pedido_item, pi.id_empresa_resp, pi.valor, 
                    pi.id_usuario_op2, pi.id_usuario_op, pi.dias, pi.operacional, sd.id_departamento_resp from
		vsites_pedido_item as pi, 
		vsites_servico_departamento as sd where
		pi.id_pedido_item = ? and 
		pi.id_empresa_atend = ? and
		pi.id_servico_departamento 	= sd.id_servico_departamento";

		$this->values = array($id_pedido_item,$id_empresa);
		$ret = $this->fetch();
		return $ret[0];
	}
        
	/**
	 * verifica permissão de deletar cartorio
	 * @param int $id_pedido_item
	 * @param int $id_empresa
	 * @param array $departamento_p
	 * @param array $departamento_s
	 */
	public function verificaPermissaoCart($id_pedido_item,$id_empresa,$departamento_p,$departamento_s){

		$this->sql = "SELECT pi.inicio, pi.dias, sd.id_departamento_resp, pi.id_status, pi.encerramento, pi.id_empresa_resp, pi.operacional, pi.id_usuario, pi.id_usuario_op from
				vsites_pedido_item as pi, vsites_servico_departamento as sd where
					pi.id_pedido_item=? and
					sd.id_servico_departamento= pi.id_servico_departamento";
		$this->values = array($id_pedido_item);
		$cont = $this->fetch();

		$id_status = $cont[0]->id_status;
		$operacional = $cont[0]->operacional;
		$dias_old = $cont[0]->dias;
		$inicio = $cont[0]->inicio;
		$encerramento = $cont[0]->encerramento;
		$id_departamento_resp = $cont[0]->id_departamento_resp;
		$id_usuario = $cont[0]->id_usuario;
		$id_usuario_op = $cont[0]->id_usuario_op;
		$id_empresa_resp = $cont[0]->id_empresa_resp;

		#verifica se o departamento pode mexer no cartorio
		if(in_array('6',$departamento_p)!=1 and in_array('3',$departamento_p)!=1 and in_array('4',$departamento_p)!=1 and in_array('5',$departamento_p)!=1 and in_array('8',$departamento_p)!=1 and in_array('9',$departamento_p)!=1 and in_array('12',$departamento_p)!=1 and in_array('15',$departamento_p)!=1){
			return '<li><b>Você não tem permissão para realizar essa operação!</b></li>';
		}

		#verifica se a franquia tem permissão de alterar o pedido que está em execução por outra unidade
		if($operacional=='0000-00-00' and $id_empresa_resp!='0' and $id_empresa_resp!=$id_empresa){
			return '<li><b>Você não tem permissão para realizar essa operação, porque outra franquia foi selecionada para executar o serviço.</b></li>';
		}

		#verifica se o pedido foi concluido operacional e se a franquia pode alterar
		if($operacional<>'0000-00-00' and $id_empresa_resp!='0' and $id_empresa_resp==$id_empresa and $id_empresa!='1'){
			return '<li><b>Esse pedido já foi concluído por sua unidade e foi liberado para a franquia responsável pelo cadastro.</b></li>';
		}

		#verifica se tem permissão de alterar o pedido do departamento
		if(in_array($id_departamento_resp,$departamento_p)!=1 and in_array('6',$departamento_p)!=1){
			return '<li><b>Você não tem permissão para realizar essa operação, esse pedido pertence a outro departamento.</b></li>';
		}

		#verifica se o atendimento ainda pode alterar o pedido
		if($id_status!=1 and $id_status!=2 and $id_status!=11 and $id_status!=12 and $id_status!=16 and in_array($id_departamento_resp,$departamento_p)!=1 and in_array('6',$departamento_p)==1 and in_array('2',$departamento_p)!=1){
			return "<li><b>Esse serviço já foi enviado para o departamento operacional e você não pode mais alterá-lo</b></li>";
		}
		return '';
	}

}
?>