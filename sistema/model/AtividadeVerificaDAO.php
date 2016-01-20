<?php

class AtividadeVerificaDAO extends Database {

    public function __construct() {
        parent::__construct();
        $this->table = 'vsites_pedido_status';
    }

    /*
     * verifica processos de uma atividade
     * @param Int $id_empresa
     * @param Int $id_atividade
     * @param Int $status_obs
     * @param Int $departamento_p
     * @param Int $departamento_s
     * @param Int $id_pedido_item
     */

    public function AtividadeVerifica($id_empresa, $id_atividade, $status_obs, $departamento_p, $departamento_s, $id_pedido_item) {
        $errors = array();
        $atividadeDAO = new AtividadeDAO();
        $pedidoverificaDAO = new PedidoVerificaDAO();
        $pedidoDAO = new PedidoDAO();
        
        global $controle_id_empresa;
        
        if($controle_id_usuario == 1 OR $controle_id_usuario == 3720){
			print_r($p_verifica);	
			
			exit;
		}

        #id_atividade n�o pode estar vazio
        if ($id_atividade == '') {
            $errors['error'].='<li><b>Selecione a atividade.</b></li>';
            return $errors;
        }

        #verifica se o departamento tem permiss�o de alterar o pedido
        if (COUNT(array_intersect($departamento_p, array(2, 3, 4, 5, 6, 8, 9, 10, 16, 19))) == 0) {
            $errors['error'].= '<li><b>Voc� n�o tem permiss�o para realizar essa opera��o!!!</strong></b></li>';
            return $errors;
        }

        $ativ = $atividadeDAO->selecionaPorID($id_atividade);

        #verifica permiss�o de alterar o pedido
        $pedido_ativ = $pedidoverificaDAO->verificaPermissaoEditPedidoItem($id_pedido_item, $id_empresa);
        if ($pedido_ativ->total == 0) {
            $errors['error'] .= '<li><b>Sequ�ncia inv�lida entre em contato com o administrador.</b></li>';
            return $errors;
        }

        #verifica se est� em cobran�a
        if ($pedido_ativ->id_status == 20 and in_array('19', $departamento_p) != 1) {
            $errors['error'].= '<li><b>Pedido s� pode ser alterado pelo departamento de Cobran�a!</strong></b></li>';
            return $errors;
        }

        #verifica se tem permiss�o de alterar o pedido do departamento
        if (in_array($pedido_ativ->id_departamento_resp, $departamento_p) != 1 and COUNT(array_intersect($departamento_p, array(2, 6, 10, 19))) == 0 and COUNT(array_intersect($departamento_p, array(3, 4, 5, 8, 9))) <> 0 and COUNT(array_intersect(array($pedido_ativ->id_status), array('3', '4', '7', '9', '10', '13', '14', '15', '17', '18'))) <> 0) {
            $errors['error'] .= '<li><b>Voc� n�o tem permiss�o para realizar essa opera��o, esse pedido pertence a outro departamento.</b></li>';
            return $errors;
        }

        #trava pedido se estiver no financeiro
        if ((in_array($pedido_ativ->id_status, array(5, 8, 19, 20)) == 1) and COUNT(array_intersect($departamento_p, array(2, 16, 19))) == 0 and $ativ->id_status != '0') {
            $errors['error'].='<li><b>O servi�o est� no financeiro.</b></li>';
            return $errors;
        }


        #verifica��es do operacional
        if ($ativ->id_status == '17') {
            #operacional
            #verifica se o pedido foi direcionado para a franquia executar
            #servi�os liberados - Pesquisa Detran, Certid�o de Prontu�rio do Detran, notifica��o eletronica
            if ($pedido_ativ->id_empresa_resp == 0 and ($pedido_ativ->id_empresa == 1 or $pedido_ativ->adendo == 1) and $pedido_ativ->id_empresa_dir = 0 and $pedido_ativ->id_empresa_dir != $pedido_ativ->id_empresa and ($pedido_ativ->operacional == '0000-00-00' or $pedido_ativ->operacional == '') AND $pedido_ativ->id_servico != 40 AND $pedido_ativ->id_servico != 47 AND $pedido_ativ->id_servico != 60 AND $pedido_ativ->id_servico != 16 AND $pedido_ativ->id_servico != 180 AND $pedido_ativ->id_servico != 131 AND $pedido_ativ->id_servico != 17 AND $pedido_ativ->id_servico != 8) {
                $errors['error'] .= '<li><b>Antes de aplicar Conclu�do Operacional � necess�rio enviar para a unidade ' . $pedido_ativ->certidao_cidade . ' executar.</b></li>';
                return $errors;
            }

            #operacional: verifica se o campo resultado foi preenchido (apenas imoveis)
            if ($pedido_ativ->id_servico == '11' and $pedido_ativ->certidao_resultado == '' and ($pedido_ativ->operacional == '0000-00-00' or $pedido_ativ->operacional == '')) {
                $errors['error'].='<li><b>Preencha o campo resultado antes de aplicar Conclu�do Operacional.</b></li>';
                return $errors;
            }

            #operacional
            #verifica se foi preenchido o campo custas para hsbc
            if ($pedido_ativ->custas == '' and ($pedido_ativ->operacional == '0000-00-00' or $pedido_ativ->operacional == '') and $pedido_ativ->id_departamento_resp == '8' and $pedido_ativ->id_conveniado == '635') {
                $errors['error'].='<li><b>Preencha o campo custas antes de aplicar conclu�do operacional.</b></li>';
                return $errors;
            }

            #operacional
            #verifica se o servico esta atrasado e se o motivo do atraso foi preenchido (apenas imoveis e protesto)
            $hoje_status = date('Y-m-d') . ' 23:59:59';
            if ($pedido_ativ->motivo_atraso == '' and ($pedido_ativ->operacional == '0000-00-00' or $pedido_ativ->operacional == '') and $hoje_status > $pedido_ativ->data_prazo) {
                $errors['error'].='<li><b>Preencha o motivo do atraso antes de aplicar "Conclu�do Operacional".</b></li>';
                return $errors;
            }

            #operacional
            #verifica se o documento foi anexado para hsbc ou anexo dos pedidos de imoveis para outros clientes
            if (($pedido_ativ->operacional == '0000-00-00' or $pedido_ativ->operacional == '') and ($pedido_ativ->id_departamento_resp == '5' and $pedido_ativ->id_conveniado == '635' or $pedido_ativ->id_departamento_resp == '8' or $pedido_ativ->id_departamento_resp == '9')) {
                $this->sql = "SELECT COUNT(0) as total from vsites_pedido_anexo as pa where pa.id_pedido_item=? and anexo_nome!='Comprovante de Dep�sito'";
                $this->values = array($id_pedido_item);
                $num_anexo = $this->fetch();
                if ($num_anexo[0]->total == '0') {
                    $errors['error'].='<li><b>� preciso anexar a c�pia da certid�o antes de aplicar a atividade.</b></li>';
                    return $errors;
                }
            }
        }

        #atendimento
        #valida cpf ou cnpj
        if (in_array($ativ->id_status, array(2, 3)) == 1 and ($pedido_ativ->cpf == '000.000.000-00' or $pedido_ativ->cpf == '00.000.000/0000-00')) {
            $errors['error'].='<li><b>Preencha corretamente o Campo CPF/CNPJ do solicitante.</b></li>';
            return $errors;
        }

        #atendimento: verifica se o atendimento ainda pode alterar o pedido
        if (in_array('6', $departamento_p) == 1 and in_array($pedido_ativ->id_status, array(1, 2, 11, 12, 14, 16)) != 1 and in_array($pedido_ativ->id_departamento_resp, $departamento_p) != 1 and COUNT(array_intersect($departamento_p, array(2, 10, 16, 19))) == 0 and $id_atividade != 110 and $id_atividade != 217) {
            $errors['error'].="<li><b>Esse servi�o j� foi enviado para o departamento operacional e voc� n�o pode mais alter�-lo</b></li>";
            return $errors;
        }

        #financeiro
        #trava pedido caso ainda n�o tenha sido enviado ao financeiro
        #if(in_array($pedido_ativ->id_status,array(2,6,8,11,14,19,20))!=1 and COUNT(array_intersect($departamento_p, array('2','3','4','5','6','8','9','10','15','19')))==0){
        #	$errors['error'].='<li><b>O servi�o est� no operacional e o financeiro n�o pode mexer.</b></li>';
        #	return $errors;
        #}
        #financeiro
        #trava liberado para faturamento caso n�o de conclu�do operacional
        if (in_array($ativ->id_status, array(8, 18)) == 1 and ($pedido_ativ->operacional == '0000-00-00' or $pedido_ativ->operacional == '')) {
            $errors['error'].='<li><b>Antes de enviar o pedido para faturamento ou entrega franquia � preciso aplicar a atividade "Conclu�do Operacional".</b></li>';
            return $errors;
        }

        #financeiro/expedicao
        #trava conclu�do caso n�o de conclu�do operacional
        if ($ativ->id_status == '10' and in_array($pedido_ativ->id_status, array(8, 9, 10, 18)) != 1 and $pedido_ativ->encerramento == '0000-00-00 00:00:00' and $pedido_ativ->operacional == '0000-00-00') {
            $errors['error'].='<li><b>Antes de concluir o pedido � preciso enviar o servi�o para Faturamento ou Entrega ou Entrega Franquia.</b></li>';
            return $errors;
        }

        #pedido direcionado para outra franquia
        if ($pedido_ativ->id_empresa_resp <> 0) {
            #bloqueia a conclus�o do pedido quando pertence a outra franquia
            if ($id_atividade == '119' and $pedido_ativ->id_empresa_resp == $id_empresa) {
                $errors['error'].='<li><b>Voc� n�o pode concluir essa ordem porque pertence a outra franquia.</b></li>';
                return $errors;
            }

            #verifica se o pedido estiver no pendente
            if ($pedido_ativ->id_status == 12 and $pedido_ativ->id_empresa_resp != $id_empresa and ($pedido_ativ->operacional == '0000-00-00' or $pedido_ativ->operacional == '') and $id_atividade != 140 and $id_atividade != 217) {
                $errors['error'] .= '<li><b>Outra franquia est� executando o pedido, voc� s� tem permiss�o para aplicar a atividade "Informa��o Recebida".</b></li>';
                return $errors;
            }

            #pedido direcionado
            #verifica se o pedido foi direcionado para outra franquia e ainda est� em execu��o
            if ($pedido_ativ->id_status != 12 and $pedido_ativ->id_empresa_resp != $id_empresa and ($pedido_ativ->operacional == '0000-00-00' or $pedido_ativ->operacional == '') and $id_atividade != 155 and $id_atividade != 110 and $id_atividade != 217) {
                $errors['error'] .= '<li><b>Outra franquia est� executando o pedido, entre em contato com a franquia.</b></li>';
                return $errors;
            }

            #pedido direcionado
            #verifica se o pedido j� foi conclu�do operacional por outra unidade
            if ($pedido_ativ->id_status != 17 and $pedido_ativ->id_empresa_resp == $id_empresa and $id_empresa != '1' and ($pedido_ativ->operacional <> '0000-00-00' or $pedido_ativ->operacional == '')) {
                $errors['error'] = '<li><b>Esse pedido j� foi conclu�do por sua unidade e foi liberado para a franquia respons�vel pelo cadastro.</b></li>';
                return $errors;
            }
        }

        #verifica se tem desembolso pendente ou se foi recebido algum valor antes de cancelar
        if ($ativ->id_status == '14') {
            #motivo de cancelamento precisa preencher o campo obs
            if ($status_obs == "") {
                $errors['error'].="<li><b>Para cancelar um pedido � preciso preencher o campo de observa��o.</b></li>";
                return $errors;
            }

            $this->sql = "SELECT COUNT(0) as total, financeiro_autorizacao from vsites_financeiro as f where financeiro_tipo='Desembolso' and (financeiro_autorizacao='Pendente' or financeiro_autorizacao='Aprovado') and id_pedido_item=? group by id_pedido_item, financeiro_autorizacao order by financeiro_autorizacao";
            $this->values = array($id_pedido_item);
            $num = $this->fetch();
            if (($pedido_ativ->valor_rec <> 0 or $num[0]->total<>'' and $num[0]->financeiro_autorizacao=='Aprovado') and in_array('2', $departamento_p) != 1) {
                $errors['error'].='<li><b>J� houve movimenta��o financeira nesse pedido, somente o financeiro pode cancelar o pedido.</b></li>';
                return $errors;
            }

			$num = $this->fetch();
            if ($num[0]->total <> '' and $num[0]->financeiro_autorizacao=='Pendente') {
                $errors['error'].='<li><b>O pedido n�o pode ser cancelado porque existem solicita��es de desembolso pendente.</b></li>';
                return $errors;
            }
			if($id_empresa!=1 and $pedido_ativ->id_empresa!=$id_empresa){
                $errors['error'].='<li><b>Somente a franquia respons�vel pelo atendimento pode cancelar o pedido.</b></li>';
                return $errors;				
			}

        }

		
		#verifica se estado e cidade est�o vazios
		if($id_atividade == 137){ 
			$servicoDAO = new ServicoDAO();
			$serv = $servicoDAO->listaCampos($pedido_ativ->id_servico);
			$cont = 0;
			for($i = 0; $i < count($serv); $i++){
				if($serv[$i]->campo == 'certidao_estado' && $serv[$i]->obrigatorio == 1){
					$cont++;
				}
			}
			if($cont > 0){
				if(strlen($pedido_ativ->certidao_cidade) == 0 OR strlen($pedido_ativ->certidao_estado) == 0){
					$errors['error'].="<li><b>Na aba 'Dados do Servi�o' o campo Cidade ou UF devem estar em branco.</b></li>";
					return $errors;
				}
			}
		}
		
		#verifica se � do suporte e se � retomar servico;
		global $pagina_acessada;
		global $controle_id_empresa;
		if(substr_count($pagina_acessada, 'pedido_edit_franquia.php') > 0 && $id_atividade == 146 && $controle_id_empresa == 1){
			global $id_pedido_item;
			if($id_pedido_item > 0){
				$this->sql = "UPDATE vsites_pedido_item SET operacional = '0000-00-00', data_status = '0000-00-00 00:00:01' 
					WHERE vsites_pedido_item.id_pedido_item = ".$id_pedido_item;
				$this->exec();
			}
			
		}
        return $errors;
    }

}

?>
