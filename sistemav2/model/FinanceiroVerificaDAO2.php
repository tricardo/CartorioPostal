<?php
class FinanceiroVerificaDAO extends Database{

	public function __construct(){
		parent::__construct();
	}

	/**
	 * verifica permiss�o de solicitar desembolso
	 * @param int $id_pedido_item
	 * @param int $id_empresa
	 * @param array $departamento_p
	 * @param array $departamento_s
	 * @param array $f
	 */
	public function inserir($id_pedido_item,$id_empresa,$departamento_p,$departamento_s,$f){
		$p_valor = new stdClass();

		$this->sql = "SELECT sd.id_departamento_resp , pi.des, pi.id_usuario, pi.id_usuario_op, pi.id_status, pi.operacional, pi.id_empresa_resp, pi.inicio
		from vsites_user_usuario as uu, vsites_servico_departamento as sd, vsites_pedido_item as pi where 
		pi.id_pedido_item=? and 
		sd.id_servico_departamento=pi.id_servico_departamento and
		pi.id_usuario= uu.id_usuario and
		(uu.id_empresa = ? or pi.id_empresa_resp=?) limit 1";
		$this->values = array($id_pedido_item,$id_empresa,$id_empresa);
		$cont = $this->fetch();
		$p_valor->des2 = $cont[0]->des;
		#verifica se tem permiss�o de alterar o pedido do departamento
		if(in_array($cont[0]->id_departamento_resp,$departamento_p)!=1 and in_array('2',$departamento_p)!=1 and in_array('10',$departamento_p)!=1){
			$p_valor->error .= '<li><b>Voc� n�o tem permiss�o para realizar essa opera��o, esse pedido pertence a outro departamento.</b></li>';
			return $p_valor;
		}

		#verifica se a franquia tem permiss�o de alterar o pedido que est� em execu��o por outra unidade
		if($cont[0]->inicio=='0000-00-00 00:00:00' or $cont[0]->inicio==''){
			$p_valor->error .= '<li><b>Antes de solicitar desembolso, aplique a atividade "Servi�o Conferido" e depois "Iniciar Servi�o" consecutivamente.</b></li>';
			return $p_valor;
		}

		#verifica se a franquia tem permiss�o de alterar o pedido que est� em execu��o por outra unidade
		if($cont[0]->operacional=='0000-00-00' and $cont[0]->id_empresa_resp!='0' and $cont[0]->id_empresa_resp!=$id_empresa and $cont[0]->id_status!='12'){
			$p_valor->error .= '<li><b>Para solicitar desembolso, solicite que a franquia que est� executando coloque no pendente.</b></li>';
			return $p_valor;
		}

		#verifica se a franquia pode solicitar desembolso de custas  e honor�rios
		if($cont[0]->operacional=='0000-00-00' and $cont[0]->id_empresa_resp!='0' and $cont[0]->id_empresa_resp!=$id_empresa and $cont[0]->id_status=='12' and $f->financeiro_classificacao!=38){
			$p_valor->error .= '<li><b>Para solicitar complemento de custas e honor�rios selecione a classifica��o correta.</b></li>';
			return $p_valor;
		}

		#verifica se o pedido foi concluido operacional e se a franquia pode alterar
		if($cont[0]->operacional<>'0000-00-00' and $cont[0]->id_empresa_resp!='0' and $cont[0]->id_empresa_resp==$id_empresa and $id_empresa!='1'){
			$p_valor->error .= '<li><b>Esse pedido j� foi conclu�do por sua unidade e foi liberado para a franquia respons�vel pelo cadastro.</b></li>';
			return $p_valor;
		}

		if($f->financeiro_classificacao == '' or $f->financeiro_descricao == '' or ($f->financeiro_valor=='' && $f->financeiro_sedex=='' && $f->financeiro_rateio=='') or $f->financeiro_forma == ''){
			if($f->financeiro_classificacao=='') $p_valor->financeiro_classificacao = 1;
			if($f->financeiro_descricao=='') $p_valor->financeiro_descricao = 1;
			if($f->financeiro_valor=='' && $f->financeiro_sedex=='' && $f->financeiro_rateio=='')
				$p_valor->financeiro_valor = 1;
			if($f->financeiro_forma=='') $p_valor->financeiro_forma = 1;
			$p_valor->error .= '<li>Os campos com * s�o obrigat�rios</li>';
		}

		if(!is_numeric($f->financeiro_rateio) and $f->financeiro_rateio<>''){
			$p_valor->financeiro_rateio = 1;
			$p_valor->error .= '<li>O campo "Outras despesas" n�o � v�lido</li>';
		}

		if(!is_numeric($f->financeiro_sedex) and $f->financeiro_sedex<>''){
			$p_valor->financeiro_sedex = 1;
			$p_valor->error .= '<li>O campo "Sedex" n�o � v�lido</li>';
		}

		if(!is_numeric($f->financeiro_valor) and $f->financeiro_valor<>''){
			$p_valor->financeiro_valor = 1;
			$p_valor->error .= '<li>O campo "Valor" n�o � v�lido</li>';
		}

		if($f->financeiro_forma=='Dep�sito' and $f->financeiro_banco==''){
			$p_valor->financeiro_banco = 1;
			$p_valor->error .= '<li>Para dep�sito banc�rio � preciso selecionar o banco</li>';
		}

		return $p_valor;

	}

	public function editar($id_pedido_item,$id_financeiro,$id_empresa,$departamento_p,$departamento_s,$f){
		$p_valor = new stdClass();

		if(!is_numeric($f->financeiro_valor) and $f->financeiro_valor<>''){
			$p_valor->financeiro_valor = 1;
			$p_valor->error .= '<li>O campo "Valor" n�o � v�lido</li>';
		}

		$data = gmdate('Y-m-d',strtotime('-2 month',strtotime(date('Y-m-d'))));
		$this->sql = "SELECT COUNT(*) as total, operacional, id_empresa_resp from vsites_user_usuario as uu, vsites_financeiro as f, vsites_pedido_item as pi where 
		f.id_financeiro=? and
		f.id_usuario=uu.id_usuario and
		(f.financeiro_autorizacao_data>=? or f.financeiro_autorizacao_data='0000-00-00 00:00:00') and
		uu.id_empresa=? and
		f.id_pedido_item=pi.id_pedido_item
		group by f.id_financeiro";
		
		$this->values = array($id_financeiro,$data,$id_empresa);
		$cont = $this->fetch();
		
		#verifica permiss�o e alterar
		if($cont[0]->total==0 or $cont[0]->total==''){
			$p_valor->error .= '<li>Voc� n�o tem permiss�o para alterar esse pedido de desembolso porque ele foi feito por outra Unidade ou o desembolso j� foi aprovado a mais de 30 dias.</li>';
		}

		#verifica se foi enviado para outra franquia
		if($cont[0]->operacional=='0000-00-00' and $cont[0]->id_empresa_resp!='0' and $cont[0]->id_empresa_resp!=$id_empresa){
			$p_valor->error .= '<li>Voc� n�o tem permiss�o para realizar essa opera��o, porque outra franquia foi selecionada para executar o servi�o.</li>';
		}

		#verifica se a unidade j� liberou para a franquia de atendimento
		if($cont[0]->operacional<>'0000-00-00' and $cont[0]->id_empresa_resp!='0' and $cont[0]->id_empresa_resp==$id_empresa and $id_empresa!='1'){
			$p_valor->error .= '<li>Esse pedido j� foi conclu�do por sua unidade e foi liberado para a franquia respons�vel pelo cadastro.</li>';
		}
		
		if($f->financeiro_nossa_conta=='' or $f->financeiro_classificacao == '' or $f->financeiro_descricao == '' or $f->financeiro_valor == '' or $f->financeiro_forma == ''){
			$p_valor->error .= '<li>Os campos com * s�o obrigat�rios</li>';
			if($f->financeiro_nossa_conta) $p_valor->financeiro_nossa_conta = 1;
			if($f->financeiro_classificacao) $p_valor->financeiro_classificacao = 1;
			if($f->financeiro_descricao) $p_valor->financeiro_descricao = 1;
			if($f->financeiro_valor) $p_valor->financeiro_valor = 1;
			if($f->financeiro_forma) $p_valor->financeiro_forma = 1;
		}

		if(!is_numeric($f->financeiro_rateio) and $f->financeiro_rateio<>''){
			$p_valor->error .= '<li>O campo "Outras despesas" n�o � v�lido</li>';
			$p_valor->financeiro_rateio = 1;
		}

		if(!is_numeric($f->financeiro_sedex) and $f->financeiro_sedex<>''){
			$p_valor->error .= '<li>O campo "Sedex" n�o � v�lido</li>';
			$p_valor->financeiro_sedex = 1;
		}

		if(!is_numeric($f->financeiro_valor) and $f->financeiro_valor<>''){
			$p_valor->error .= '<li>O campo "Valor" n�o � v�lido</li>';
			$p_valor->financeiro_valor = 1;
		}

		if($f->financeiro_forma=='Dep�sito' and $f->financeiro_banco == ''){
			$p_valor->error .= '<li>Para dep�sito banc�rio � preciso selecionar o banco</li>';
			$p_valor->financeiro_banco = 1;
		}

		#somente o financeiro pode alterar pedidos de desembolso
		$permissao = verifica_permissao('Financeiro Pedido Edit',implode(',',$departamento_p),implode(',',$departamento_s));
		if($permissao=='FALSE'){
			$errors->error .= '<li>Voc� n�o tem permiss�o para alterar esse pedido de desembolso</li>';
		}
		
		#verifica permiss�o de alterar o status, caso tenha sido reprovado ninguem mexe caso ainda esteja no pendente somente o financeiro mexe
		if($f->financeiro_autorizacao!=$f->financeiro_old_autorizacao and (in_array('2', $departamento_p)!=1 and $f->financeiro_old_autorizacao=="Pendente" or $f->financeiro_old_autorizacao=="Reprovado")){
			$p_valor->error .= '<li>Voc� n�o tem permiss�o para alterar esse pedido de desembolso.</li>';
		}

		#n�o permite colocar no pendente um pedido que j� est� aprovado ou reprovado
		if($f->financeiro_old_autorizacao!='Pendente' and $f->financeiro_autorizacao=='Pendente' or $f->financeiro_autorizacao=='Aprovado' and in_array('2', $departamento_p)!=1){
			$p_valor->error .= '<li>Voc� n�o pode colocar esse desembolso em pendente porque ele j� foi '.$f->financeiro_old_autorizacao.'.</li>';
		}

		return $p_valor;
	}
	
	/**
	 * verifica permiss�o de deletar recebimento
	 * @param int $id_financeiro
	 * @param int $id_empresa
	 * @param array $departamento_p
	 * @param array $departamento_s
	 */
	public function verificaDeletaReceb($id_financeiro,$id_empresa,$departamento_p,$departamento_s){
		$p_valor = new stdClass();
		if(in_array('2', $departamento_s)!=1 and in_array('1', $departamento_s)!=1){
			$p_valor->error .= '<li>Voc� n�o tem permiss�o para deletar recebimentos</li>';
			return $p_valor;
		}
		#n�o deixa deletar se o recebimento tiver sido lan�ado a mais de 1 mes
		$data = gmdate('Y-m-d',strtotime('-1 month',strtotime(date('Y-m-d'))));
		$this->sql = "select COUNT(0) as total, id_pedido_item, financeiro_valor from vsites_financeiro as f, vsites_user_usuario as uu where f.id_financeiro=? and f.financeiro_tipo='Recebimento' and date_format(financeiro_data,'%Y-%m-%d')>=? and f.id_usuario=uu.id_usuario and uu.id_empresa=? group by f.id_pedido_item";
		$this->values = array($id_financeiro,$data,$id_empresa);
		$cont = $this->fetch();

		if($cont[0]->total==0){
			$p_valor->error .= '<li>Voc� n�o tem permiss�o para deletar esse registro ou j� faz mais de 30 dias que ele foi lan�ado no sistema</li>';
		}
		$p_valor->id_pedido_item = $cont[0]->id_pedido_item;
		$p_valor->valor = $cont[0]->financeiro_valor;
		
		return $p_valor;
	}

	/**
	 * verifica se pode editar o recebimento
	 * @param int $id_financeiro
	 * @param int $id_pedido_item
	 * @param int $id_empresa
	 * @param array $departamento_p
	 * @param array $departamento_s
	 * @param array $f
	 */
	public function verificaEditaReceb($id_financeiro,$id_pedido_item,$id_empresa,$departamento_p,$departamento_s,$f){
		$p_valor = new stdClass();

		if(in_array('2', $departamento_p)!=1 and in_array('1', $departamento_p)!=1){
			$p_valor->error .= '<li>Voc� n�o tem permiss�o editar recebimentos</li>';
			return $p_valor;
		}

		if($f->financeiro_data_p=="--" or $f->financeiro_data_p>date('Y-m-d') or strlen($f->financeiro_data_p)!=10){
			$p_valor->error .= '<li>Preencha a data do recebimento corretamente</li>';
			return $p_valor;
		}

		if($f->financeiro_nossa_conta=='' or $f->financeiro_classificacao == '' or $f->financeiro_valor == '' or $f->financeiro_forma == ''){
			$p_valor->error .= '<li>Os campos com * s�o obrigat�rios</li>';
			return $p_valor;
		}

		#n�o deixa editar se o desembolso tiver sido aprovado e conferido a mais de 1 mes
		$data = gmdate('Y-m-d',strtotime('-1 month',strtotime(date('Y-m-d'))));
		$this->sql = "SELECT COUNT(0) as total from vsites_user_usuario as uu, vsites_financeiro as f where f.id_financeiro=? and f.financeiro_tipo='Recebimento' and date_format(f.financeiro_data,'%Y-%m-%d')>=? and f.id_usuario=uu.id_usuario and uu.id_empresa=?";
		$this->values = array($id_financeiro,$data,$id_empresa);
		$cont = $this->fetch();

		if($cont[0]->total==0){
			$p_valor->error .= '<li>Voc� n�o tem permiss�o para alterar esse recebimento porque foi lan�ado no sistema a mais de 30 dias.</li>';
		}

		$f->financeiro_valor=number_format(str_replace(',','.',$f->financeiro_valor),2,".","");
		
		return $p_valor;
	}
}
?>