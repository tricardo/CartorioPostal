<?php
require("includes.php"); 

$permissao = verifica_permissao('Pedido Import',$controle_id_departamento_p,$controle_id_departamento_s);
if($permissao == 'FALSE' or $controle_id_empresa!='1'){
    header('location:pagina-erro.php');
    exit;
}

$usuarioDAO = new UsuarioDAO();
$servicoDAO = new ServicoDAO();
$remessaCartDAO = new RemessaCartDAO();

$departamento_s = explode(',' ,$controle_id_departamento_s);
$departamento_p = explode(',' ,$controle_id_departamento_p);

if(isset($_GET['download']) AND isset($_GET['id']) AND !$_POST){
    require( "includes/zip/zip.php" );

    $remessaDAO = new RemessaCartDAO();
    pt_register('GET','id');

    $anexo = $remessaCartDAO->selectPorId($id,$controle_id_empresa);
    if(is_null($anexo)){
	header('location:pagina-erro.php');
	exit;
    }

    $zipfile = new zipfile(md5($controle_id_usuario.'_'.date("d-m-Y H:i:s")).".zip");

    if(file_exists('../sistema/controle/remessa_cart/'.$anexo->arquivo)){
        $arquivo = '../sistema/controle/remessa_cart/'.$anexo->arquivo;
    } else {
        $arquivo = 'remessa_cart/'.$anexo->arquivo;
    }
    
    $zipfile->addFileAndRead($arquivo);

    echo $zipfile->file();
    exit;
}

if($_POST){
    pt_register('POST','id_cliente');
    pt_register('POST','id_servico');
    
    $data_hora = date('YmdHis');
    $arquivoDiretorio = "remessa_cart/R".$data_hora.$controle_id_usuario."_".$id_cliente.".TXT";
    $nomeArquivo = "R".$data_hora.$controle_id_usuario."_".$id_cliente.".TXT";
    
    $res = $remessaCartDAO->remessaCliente($id_cliente);
    if(count($res) > 0){
        $res = ObjToArray($res[0]);
        
        
        $h_ddd = '';
        $h_telefone = '';
        if($id_cliente==49117 or $id_cliente==89607){
            $h_codregistro = '0';#1
            $h_tipo = "REMESSA";#7
            if($id_servico=='17') $h_produto = utf8_decode("NOTIFICAÇÃO ELETRONICA        "); #30
            $h_livre1 = "99999999999999";#14

            $carac = strlen($res['nome']);
            $ESQUERDA = '';
            while($carac<40){
		$ESQUERDA .= ' ';
		$carac++;
            }
            $h_cliente = $res['nome'].$ESQUERDA;#40

            $carac = strlen($res['endereco']);
            $ESQUERDA = '';
            while($carac<40){
                $ESQUERDA .= ' ';
                $carac++;
            }
            $h_endereco = $res['endereco'].$ESQUERDA;#40

            $carac = strlen($res['numero']);
            $ESQUERDA = '';
            while($carac<10){
                $ESQUERDA .= ' ';
                $carac++;
            }
            $h_numero = $res['numero'].$ESQUERDA;#10

            $carac = strlen($res['complemento']);
            $ESQUERDA = '';
            while($carac<10){
                $ESQUERDA .= ' ';
                $carac++;
            }
            $h_complemento = $res['complemento'].$ESQUERDA;#10

            $carac = strlen($res['bairro']);
            $ESQUERDA = '';
            while($carac<30){
                $ESQUERDA .= ' ';
                $carac++;
            }
            $h_bairro = $res['bairro'].$ESQUERDA;#30

            $carac = strlen($res['cidade']);
            $ESQUERDA = '';
            while($carac<30){
                $ESQUERDA .= ' ';
                $carac++;
            }
            $h_cidade = $res['cidade'].$ESQUERDA;#30

            $cep=str_replace('-','',$res['cep']);
            $carac = strlen($cep);
            $ESQUERDA = '';
            while($carac<8){
                $ESQUERDA .= ' ';
                $carac++;
            }
            $h_cep = $ESQUERDA.$cep;#8

            $carac = strlen($cep);
            $ESQUERDA = '';
            while($carac<8){
                $ESQUERDA .= ' ';
                $carac++;
            }
            $h_estado = $res['estado'].$ESQUERDA;#2

            $tel=str_replace('-','',str_replace(')','',str_replace('(','',$res['tel'])));
            $carac = strlen($tel);
            $ESQUERDA = '';
            while($carac<10){
                $ESQUERDA .= ' ';
                $carac++;
            }
            $h_tel = $ESQUERDA.$tel;#10

            $carac = strlen($res['nome']);
            $ESQUERDA = '';
            while($carac<40){
		$ESQUERDA .= ' ';
		$carac++;
            }
            $h_responsavel = $res['nome'].$ESQUERDA;#40

            $carac = isset($res['cargo']) ? strlen($res['cargo']) : 0;
            $ESQUERDA = '';
            while($carac<40){
		$ESQUERDA .= ' ';
		$carac++;
            }
            $h_cargo = $carac = isset($res['cargo']) ? $res['cargo'].$ESQUERDA : ''.$ESQUERDA;#40

            $h_datagravacao = date('dmY');#8

            $h_livre3 = '                                                                                                                                                                                                                                                                                                                                                                                                ';#384 BRANCOS

            $h_sequencial = '000001';#6
        
            #header
            $arquivoConteudo  = $h_codregistro.$h_tipo.$h_produto.$h_livre1.$h_cliente.$h_endereco.$h_numero.$h_complemento.$h_bairro.$h_cidade.$h_cep.$h_estado.$h_ddd.$h_telefone.$h_responsavel.$h_cargo.$h_datagravacao.$h_livre3.$h_sequencial.'
    ';

            $R_CODREGISTRO = '1';#1
            $cont='1';
            while($res = $remessaCartDAO->remessaPedido($id_cliente)){
		$R_COD_AGENCIA = $res['certidao_cod_agencia'];
		$carac = strlen($R_COD_AGENCIA);
		$ESQUERDA = '';
		while($carac<3){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_COD_AGENCIA = $ESQUERDA.$R_COD_AGENCIA;

		$R_NUMERO_DA_CONTA = $res['certidao_conta'];
		$carac = strlen($R_NUMERO_DA_CONTA);
		$ESQUERDA = '';
		while($carac<9){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NUMERO_DA_CONTA = $ESQUERDA.$R_NUMERO_DA_CONTA;

		$R_IDENTIFICACAO = $res['certidao_modelo'];
		$carac = strlen($R_IDENTIFICACAO);
		$ESQUERDA = '';
		while($carac<15){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_IDENTIFICACAO = $R_IDENTIFICACAO.$ESQUERDA;

		$R_CLIENTE_NOME = $res['certidao_requerente'];
		$carac = strlen($R_CLIENTE_NOME);
		$ESQUERDA = '';
		while($carac<40){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_CLIENTE_NOME = $R_CLIENTE_NOME.$ESQUERDA;

		$R_NOT_CPF = $res['certidao_cpf'];
		if($R_NOT_CPF=='')$R_NOT_CPF = $res['certidao_cnpj'];
		$carac = strlen($R_NOT_CPF);
		$ESQUERDA = '';
		while($carac<15){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NOT_CPF = $ESQUERDA.$R_NOT_CPF;

		$R_NOT_NOME = $res['certidao_nome'];
		$carac = strlen($R_NOT_NOME);
		$ESQUERDA = '';
		while($carac<40){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NOT_NOME = $R_NOT_NOME.$ESQUERDA;

		$R_NOT_ENDERECO = str_replace('  ',' ',str_replace('  ',' ',$res['certidao_endereco']));
		$carac = strlen($R_NOT_ENDERECO);
		$ESQUERDA = '';
		while($carac<40){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NOT_ENDERECO = $R_NOT_ENDERECO.$ESQUERDA;

		$R_NOT_PRACA = str_replace('  ',' ',$res['certidao_cidade']);
		$carac = strlen($R_NOT_PRACA);
		$ESQUERDA = '';
		while($carac<40){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NOT_PRACA = $R_NOT_PRACA.$ESQUERDA;

		$R_NOT_CEP = $res['certidao_campo_cep'];
		$carac = strlen($R_NOT_CEP);
		$ESQUERDA = '';
		while($carac<8){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NOT_CEP = $ESQUERDA.$R_NOT_CEP;

		$R_NOT_UF = $res['certidao_estado'];
		$carac = strlen($R_NOT_UF);
		$ESQUERDA = '';
		while($carac<2){
                    $ESQUERDA .= ' ';
                    $carac++;
                }
		$R_NOT_UF = $ESQUERDA.$R_NOT_UF;

		$R_NOT_NUMERO = $res['certidao_numero_not'];
		$carac = strlen($R_NOT_NUMERO);
		$ESQUERDA = '';
		while($carac<5){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NOT_NUMERO = $ESQUERDA.$R_NOT_NUMERO;

		$R_SEQUENCIA_DO_DOC = $res['certidao_sequencia'];
		$carac = strlen($R_SEQUENCIA_DO_DOC);
		$ESQUERDA = '';
		while($carac<5){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_SEQUENCIA_DO_DOC = $ESQUERDA.$R_SEQUENCIA_DO_DOC;

		$R_NOSSO_NUMERO = $res['certidao_nosso_numero'];
		$carac = strlen($R_NOSSO_NUMERO);
		$ESQUERDA = '';
		while($carac<8){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NOSSO_NUMERO = $ESQUERDA.$R_NOSSO_NUMERO;

		$R_DUPLICATA = $res['certidao_duplicata'];
		$carac = strlen($R_DUPLICATA);
		$ESQUERDA = '';
		while($carac<12){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_DUPLICATA = $R_DUPLICATA.$ESQUERDA;

		$R_EMISSAO_TITULO = $res['certidao_emissao'];
		$carac = strlen($R_EMISSAO_TITULO);
		$ESQUERDA = '';
		while($carac<8){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_EMISSAO_TITULO = $ESQUERDA.$R_EMISSAO_TITULO;

		$R_AGENCIA_COBRADORA = $res['certidao_agencia'];
		$carac = strlen($R_AGENCIA_COBRADORA);
		$ESQUERDA = '';
		while($carac<3){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_AGENCIA_COBRADORA = $ESQUERDA.$R_AGENCIA_COBRADORA;

		$R_BANCO_COBRADOR = $res['certidao_banco'];
		$carac = strlen($R_BANCO_COBRADOR);
		$ESQUERDA = '';
		while($carac<20){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_BANCO_COBRADOR = $R_BANCO_COBRADOR.$ESQUERDA;

		$R_VENCIMENTO_TITULO = $res['certidao_vencimento'];
		$carac = strlen($R_VENCIMENTO_TITULO);
		$ESQUERDA = '';
		while($carac<8){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_VENCIMENTO_TITULO = $ESQUERDA.$R_VENCIMENTO_TITULO;

		$R_VALOR_TITULO = $res['certidao_valor'];
		$carac = strlen($R_VALOR_TITULO);
		$ESQUERDA = '';
		while($carac<17){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_VALOR_TITULO = $ESQUERDA.$R_VALOR_TITULO;

		$R_CARTEIRA_TITULO = $res['certidao_cart_titulo'];
		$carac = strlen($R_CARTEIRA_TITULO);
		$ESQUERDA = '';
		while($carac<2){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_CARTEIRA_TITULO = $ESQUERDA.$R_CARTEIRA_TITULO;

		$R_NUMERO_CONTRATO = $res['certidao_n_contrato'];
		$carac = strlen($R_NUMERO_CONTRATO);
		$ESQUERDA = '';
		while($carac<20){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NUMERO_CONTRATO = $R_NUMERO_CONTRATO.$ESQUERDA;

		$R_EMISSAO_DIREITO_CRED = $res['certidao_emissao_dir_cred'];
		$carac = strlen($R_EMISSAO_DIREITO_CRED);
		$ESQUERDA = '';
		while($carac<8){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_EMISSAO_DIREITO_CRED = $ESQUERDA.$R_EMISSAO_DIREITO_CRED;

		$R_NUMERO_DIREITO_CRED = $res['certidao_num_dir_cred'];
		$carac = strlen($R_NUMERO_DIREITO_CRED);
		$ESQUERDA = '';
		while($carac<10){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NUMERO_DIREITO_CRED = $ESQUERDA.$R_NUMERO_DIREITO_CRED;

		$R_NUMERO_CONTRATO_DIREITO_CRED = $res['certidao_num_contrato_dir_cred'];
		$carac = strlen($R_NUMERO_CONTRATO_DIREITO_CRED);
		$ESQUERDA = '';
		while($carac<12){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NUMERO_CONTRATO_DIREITO_CRED = $R_NUMERO_CONTRATO_DIREITO_CRED.$ESQUERDA;

		$R_EMISSAO_CONTRATO_BIC = $res['certidao_emissao_contrato'];
		$carac = strlen($R_EMISSAO_CONTRATO_BIC);
		$ESQUERDA = '';
		while($carac<8){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_EMISSAO_CONTRATO_BIC = $ESQUERDA.$R_EMISSAO_CONTRATO_BIC;

		$R_MODALIDADE = $res['certidao_modalidade'];
		$carac = strlen($R_MODALIDADE);
		$ESQUERDA = '';
		while($carac<6){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_MODALIDADE = $ESQUERDA.$R_MODALIDADE;

		$R_NOT_BAIRRO = $res['certidao_campo_bairro'];
		$carac = strlen($R_NOT_BAIRRO);
		$ESQUERDA = '';
		while($carac<60){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NOT_BAIRRO = $R_NOT_BAIRRO.$ESQUERDA;

		$R_OBJETO_CONTRATO_DIR_CRED = $res['certidao_objeto_contrato_cred'];
		$carac = strlen($R_OBJETO_CONTRATO_DIR_CRED);
		$ESQUERDA = '';
		while($carac<240){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_OBJETO_CONTRATO_DIR_CRED = $R_OBJETO_CONTRATO_DIR_CRED.$ESQUERDA;

		$R_CPF_CONTRATADO = $res['certidao_cpf_contratado'];
		$carac = strlen($R_CPF_CONTRATADO);
		$ESQUERDA = '';
		while($carac<15){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_CPF_CONTRATADO = $ESQUERDA.$R_CPF_CONTRATADO;

		$R_NUMEROPEDIDO = $res['id_pedido'].'-'.$res['ordem'];
		$carac = strlen($R_NUMEROPEDIDO);
		$ESQUERDA = '';
		while($carac<10){
                    $ESQUERDA .= ' ';
                    $carac++;
		}
		$R_NUMEROPEDIDO = $R_NUMEROPEDIDO.$ESQUERDA;

		$cont++;
		$carac = strlen($cont);
		$cont_='';
		while($carac<6){
                    $cont_ .= '0';
                    $carac++;
		}
		$cont_ .= $cont;

		$arquivoConteudo  .= $R_CODREGISTRO.$R_COD_AGENCIA.$R_NUMERO_DA_CONTA.$R_IDENTIFICACAO.$R_CLIENTE_NOME.$R_NOT_CPF.$R_NOT_NOME.$R_NOT_ENDERECO.$R_NOT_PRACA.$R_NOT_CEP.$R_NOT_UF.$R_NOT_NUMERO.$R_SEQUENCIA_DO_DOC.$R_NOSSO_NUMERO.$R_DUPLICATA.$R_EMISSAO_TITULO.$R_AGENCIA_COBRADORA.$R_BANCO_COBRADOR.$R_VENCIMENTO_TITULO.$R_VALOR_TITULO.$R_CARTEIRA_TITULO.$R_NOT_BAIRRO.$R_NUMERO_CONTRATO.$R_EMISSAO_DIREITO_CRED.$R_NUMERO_DIREITO_CRED.$R_NUMERO_CONTRATO_DIREITO_CRED.$R_EMISSAO_CONTRATO_BIC.$R_MODALIDADE.$R_OBJETO_CONTRATO_DIR_CRED.$R_CPF_CONTRATADO.$R_NUMEROPEDIDO.'    '.$cont_;
                if($id_cliente==89607){
                    $arquivoConteudo  .= invert($res['data'],'','PHP');
                }
                $arquivoConteudo  .= '
';
}
            #quantidade de registros
            $qtdd = $cont-1;
            $carac = strlen($qtdd);
            $qtdd_='';
            while($carac<6){
                $qtdd_ .= '0';
                $carac++;
            }
            $qtdd_ .= $qtdd;

            $cont++;
            $carac = strlen($cont);
            $cont_='';
            while($carac<6){
                $cont_ .= '0';
                $carac++;
            }
            $cont_ .= $cont;
            $brancos = "                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               "; #

            $arquivoConteudo  .= '9'.$qtdd_.$brancos.$cont_.'
    ';
        } else {
            #arquivo para helbor e bradesco
            $remessacartDAO = new RemessaCartDAO();
            $arquivoConteudo  = 'Cliente;Tipo;Obra;Unidade;Data do Contrato;Notificante;Notificado;Endereço;Bairro;Cidade;Estado;CEP;Telefone;Empreendimento;Mensalidade;Vencimento;Valor;Juros;Multa;Correção
        ';
            $lista = $remessacartDAO->selectNotificacoes($id_cliente);
            foreach($lista as $l){
                $rr = explode('/',$l->certidao_numero_not);
                $arquivoConteudo  .= $id_cliente.';'.$l->certidao_modelo.';'.$rr[0].';'.$rr[1].';'.$l->certidao_emissao_contrato.';'.$l->certidao_requerente.';'.$l->certidao_nome.';'.$l->certidao_endereco.';'.$l->certidao_campo_bairro.';'.$l->certidao_cidade.';'.$l->certidao_estado.';'.$l->certidao_campo_cep.';'.$l->certidao_nosso_numero.';'.$l->certidao_modalidade.';'.$l->certidao_duplicata.';'.$l->certidao_vencimento.';'.$l->certidao_nome.';'.$l->certidao_valor.';'.$l->certidao_n_contribuinte.';'.$l->certidao_n_deposito.';'.$l->conce_nome.'
    ';
            }
        }
        
        if(is_file($arquivoDiretorio)) {
            unlink($arquivoDiretorio);
        }

        if(fopen($arquivoDiretorio,"w+")) {

            if (!$handle = fopen($arquivoDiretorio, 'w+')) {
                header('location:pagina-erro.php?erro=3');
                exit;
            }
            if(!fwrite($handle, $arquivoConteudo)) {
                header('location:pagina-erro.php?erro=4');
                exit;
            }

            $remessaCartDAO->inserir($id_cliente, $controle_id_usuario, $nomeArquivo);	
            $remessaCartDAO->editarPedidoRem($id_cliente);

            header ("Content-type: octet/stream");
            header ("Content-disposition: attachment; filename=remessa_cart/".$nomeArquivo.";");
            header ("Content-Length: ".filesize($arquivoDiretorio));
            readfile($arquivoDiretorio);
	 
        } else {
            if (!$handle = fopen($arquivoDiretorio, 'w+')) {
                header('location:pagina-erro.php?erro=3');
                exit;
            }
        }

        
        
    } else {
        header('location:pagina-erro.php?erro=1');
    }
    exit;
}
include('header2.php'); ?>

<script>
    menu(3,'bt-06');
    $('#titulo').html('arquivos &rsaquo;&rsaquo; remessa do cartório');
    $('#sub-41').css({'font-weight':'bold'});
</script>
<div class="content-forms">
    <?php CamposObrigatorios(); ?>  

    <form enctype="multipart/form-data" method="post" action="remessa-do-cartorio-editar.php" target="_blank">
    <h3>informações</h3>
    <dl>
        <dt>Cliente <span>*</span>:</dt>
        <dd class="line1">
            <select id="id_cliente" name="id_cliente" class="chzn-select required line1">
                <?php foreach($usuarioDAO->combo_cliente_user() AS $f){ ?>
                <option value="<?=$f->id_cliente?>"><?=utf8_encode($f->nome)?></option>
                <?php } ?>
            </select>
        </dd>
        <dt>Serviço <span>*</span>:</dt>
        <dd class="line1">
            <select id="id_servico" name="id_servico" class="chzn-select required line1">
                <?php foreach($servicoDAO->remessa() AS $f){ ?>
                <option value="<?=$f->id_servico?>"><?=utf8_encode($f->descricao)?></option>
                <?php } ?>
            </select>
        </dd>
        <div class="buttons">
            <input type="submit" value="gerar &rsaquo;&rsaquo;" onclick="Validar(1)" name="f_cadastro">
        </div>
    </dl>
   </form>
    <script>
        preencheCampo();
    </script>
</div>
<div class="content-list-table"> 
    <table>
            <thead>
                <tr>
                    <th class="buttons size100">data</th>
                    <th>arquivo</th>
                    <th class="buttons">download</th>
                </tr>
            </thead>
            <tbody>
                <?php $color = '#FFFEEE';
                foreach ($remessaCartDAO->listartodasRemessas() as $f) {
                     $color = $color == '#FFF' ? '#FFFFEE' : '#FFF';  ?>
                    <tr <?=TRColor($color)?>>
                        <td class="buttons size100"><?=invert($f->data,'/','PHP')?></td>
                        <td><?=$f->arquivo?></td>
                        <td class="buttons">
                            <a href="remessa-do-cartorio-editar.php?id=<?=$f->id_remessa_cart?>&download=1" target="_blank"><img src="images/bt-download.png"></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    
</div>
<?php include('footer.php'); ?>
