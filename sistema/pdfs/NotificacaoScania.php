<?php

class NotificacaoScania extends PDF{

	private $pedido;
	private $data_atual;
	private $curr_item;
	private $certidao_numero_not;
	private $nome_arquivos;
	
	public function __construct($pedido){
		$this->pedido = $pedido;
		$this->curr_item = 0;
		$this->certidao_numero_not=null;
		
	}
	
	public function ln($h=0.3){
		parent::ln($h);
	}

	public function geraPDF($data_atual=null,$nome_arquivos=null){
		parent::__construct('P','cm', 'A4');
		$this->Open();
		$this->SetMargins(2, 2);
		$this->SetAuthor('Vsites 2009');
		$this->SetFont('Arial','', 7);
		$this->SetDisplayMode(100, 'continuous');
		$this->data_atual = $data_atual;
		$this->nome_arquivos = $nome_arquivos;
		$this->geraNotificacao();
	}
	
	private function geraNotificacao(){
		$this->AddPage();
		$this->Image('../images/scania.jpg',2,1,4.5,1.1,'JPG');
		$this->SetFont('','',8);
		$this->setY(3);

		$this->Write(0.5,"COTIA-SP, ".$this->data_atual,'.');$this->ln();
		$this->ln();
		$this->ln();
		$this->SetFont('','B',8);
		$this->Write(0.5,'Nº'.$this->pedido->itens[$this->curr_item]->certidao_numero_not,'');
		$this->ln();
		$this->ln();
		$this->SetFont('','',8);
		$this->Write(0.5,$this->pedido->itens[$this->curr_item]->certidao_nome,'');$this->ln();
		
		$this->Write(0.5,$this->pedido->itens[$this->curr_item]->certidao_endereco.',',' ');
		$this->Write(0.5,$this->pedido->itens[$this->curr_item]->certidao_numero.', ','');
		$this->Write(0.5,$this->pedido->itens[$this->curr_item]->certidao_campo_bairro.' ','');$this->ln();
		$this->Write(0.5,$this->pedido->itens[$this->curr_item]->certidao_cidade.'-','');
		$this->Write(0.5,$this->pedido->itens[$this->curr_item]->certidao_estado.' ','');
		$this->Write(0.5,'CEP - '.$this->pedido->itens[$this->curr_item]->certidao_campo_cep.' ','');
		$this->ln();
		
		$this->ln();
		$this->SetFont('','B',8);
		$this->Write(0.5,'Referência: Contrato de Consórcio relativo à Cota ');
		$this->Write(0.5,$this->pedido->itens[$this->curr_item]->controle_cliente);
		$this->SetFont('','',8);
		
		$this->ln();
		$this->ln();
		$this->Write(0.5,'Prezado(a) Senhor(a):
Encontram-se em aberto em nossos registros as parcelas em referência de sua responsabilidade, a saber:');

		$this->ln();
		$this->ln();

		$nome_arquivo = "../../sistema/anexos/".$this->nome_arquivos[$this->curr_item];

		$this->certidao_numero_not = $this->pedido->itens[$this->curr_item]->certidao_numero_not;
		$this->adicionaItens();

		$this->ln();
		$this->ln();
		$this->ln();

		$this->Write(0.5,'Caso essas parcelas estejam pagas, solicitamos o envio  dos respectivos comprovantes através do Fax: (011) 4613-5062 ou através do correio para o endereço abaixo.');
		$this->ln();
		$this->ln();
		$this->ln();
		$this->Write(0.5,'Se no entanto, não foram efetivamente pagas, e havendo interesse na solução amigável do débito, solicitamos entrar em contato telefônico ou pessoal, no prazo de 72 horas (setenta e duas) horas, do recebimento desta.');
		$this->ln();
		$this->ln();
		$this->ln();
		$this->Write(0.5,'Não efetuado o pagamento da quantia supra no prazo estabelecido, ficará V.S.a(s). automaticamente constituído(s) em mora nos termos do § 2º, do artigo 2º, do Decreto Lei 911 de 01.10.69, considerando-se vencidas todas as obrigações contratuais, inclusive as prestações vincendas, conforme dispõe o § 3º, do artigo 2º, do mesmo diploma Legal, o que ensejará a propositura da competente ação judicial.
');
		$this->ln();
		$this->ln();
		$this->Write(0.5,'Sem mais,');
			
		$this->ln();
		$this->ln();
		$this->Write(0.5,'Atenciosamente');
		
		$this->rodape();
		$this->Output($nome_arquivo);
		
		if(count($this->pedido->itens)>($this->curr_item+1))
		$this->geraPDF($this->data_atual,$this->nome_arquivos);
		
	}
	
	private function adicionaItens(){
		
		$this->ln();
		
		$this->SetFont('','B',8);
		$this->Cell(6,0.5,'Prestação',0,0);
		$this->Cell(6,0.5,'Vencimento',0,0);
		$this->Cell(5,0.5,'Valor com Acréscimo',0,1,'R');
		$this->SetFont('','',8);
		$total=0;
		for($n=$this->curr_item; $n<count($this->pedido->itens); $n++){
			$item = $this->pedido->itens[$n];
			
			if($this->certidao_numero_not!=$item->certidao_numero_not){
				$this->curr_item = $n;
				break;
			}
			$this->curr_item = $n+1;
			
			$this->Cell(6,0.5,$item->n_parcelas,0,0);
			$this->Cell(6,0.5,$item->certidao_vencimento,0,0);
			$this->Cell(4.8,0.5,$item->certidao_valor,0,1,'R');
			$total += str_replace(',','',$item->certidao_valor)*1;
		}
		
		$this->SetFont('','B',8);
		$this->ln();
		$this->Write(0.5,'Valor Total:');
		$this->SetFont('','',8);
		$this->Write(0.5,$total);
		
	}
	
	private function rodape(){
		$this->setY(-7);

		$this->Image('../images/ass_scania.jpg',$this->getX(),$this->getY()-2,2,2,'JPG');
		$this->SetFont('','B',8);
//		$this->Line($this->getX(),$this->getY(),6,$this->getY());
		$this->Write(0.5,'Scania Adm  de Consórcios   Ltda
    Departamento de Cobrança');

		$this->setY(-4.9);

		$this->Cell(19,0.5,'Em caso de dúvida, contate o Departamento de Cobrança através dos fones:',0,1,'C');
		$this->Cell(19,0.5,'(11) 4613-5021 / 5057 / 5059 / 5061 - Fax: (11) 4613-5107',0,1,'C');
		$this->SetFont('','B',8);
		$this->Cell(19,0.5,'Scania Administradora de Consórcios Ltda',0,1,'C');
		$this->SetFont('','',8);
		$this->Cell(19,0.5,'Matriz – Cotia: Rua Jose Félix de Oliveira, 630 - Granja Viana - Cotia/SP - CEP 06708-415',0,1,'C');
		$this->Cell(19,0.5,'CNPJ - 96.479.258/0001-91',0,1,'C');
	}
}

?>