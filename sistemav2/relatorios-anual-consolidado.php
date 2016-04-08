<?php
require("includes.php");

$permissao = verifica_permissao('Rel_supervisores',$controle_id_departamento_p,$controle_id_departamento_s);
if(verifica_permissao('Franquia',$controle_id_departamento_p,$controle_id_departamento_s)=='FALSE' and verifica_permissao('Rel_gerencial',$controle_id_departamento_p,$controle_id_departamento_s) == 'FALSE' or $controle_id_empresa!=1){
    header('location:pagina-erro.php');
    exit;
}

if($_POST){
    require("classes/spreadsheet_excel_writer/Writer.php");
    
    $relatorioDAO = new RelatorioDAO();
    
    pt_register('POST','ano');
    
    $arquivo = "exporta/anual-consol-".(md5($controle_id_empresa.$controle_id_usuario.date('YmdHis'))).".xls";
    

    $royalties = $relatorioDAO->listaRoyaltiesAnual($ano, (isset($_POST['cancel']) ? 2 : 1));
    
    //setando variaveis dinamicas
    $id 	  = 0;
    $contador = 0;
    $dt = array();
    $dt1= array();
    
    
    //pega os dados da base
    foreach($royalties as $i => $roy){
        if($roy->roy_rec == null) {
            $roy->roy_rec=0;			
        }
        if($id != $roy->id_empresa){
            if($id!=0){
                $contador2=$contador-1;
                $dt[$contador2] = array(
                'id_empresa'      => $id_empresa,
                'valor_royalties' => $valor_royalties,
                'despesa' 		  => $despesa,
                'franquia'  	  => $franquia,
                'faturamento'  	  => $faturamento,
                'fixo' 			  => $fixo,
                'imposto'  		  => $imposto,
                'royalties'  	  => $royalties1,
                'fpp'  	  		  => $fpp,
                'data' 			  => $data,
                'roy_rec'         => $roy_rec,
                'fpp_rec'         => $fpp_rec
                );
            }

            $id_empresa 	 = $roy->id_empresa;
            $franquia   	 = $roy->franquia;

            $valor_royalties = $roy->valor_royalties . ';';
            $despesa         = $roy->despesa 		  . ';';
            $fixo 			 = $roy->fixo;
            $faturamento     = $roy->faturamento 	  . ';';
            $imposto 		 = $roy->imposto;
            $royalties1		 = $roy->royalties;
            $fpp			 = $roy->fpp 			  . ';';
            $data			 = $roy->data			  . ';';
            $roy_rec         = $roy->roy_rec          . ';';
            $fpp_rec         = $roy->fpp_rec          . ';';

            $mes_ant 		 = substr($roy->data,5,2);
            //incrementar contador
            $contador++;
        } else {	

            $mes_atual     = substr($roy->data,5,2);
            $mes_ant++;
            while($mes_ant<$mes_atual){
                $valor_royalties .= ';';
                $despesa         .= ';';
                $faturamento     .= ';';
                $fpp			 .= ';';
                $data			 .= '2013-'.$mes_ant.'-01;';
                $roy_rec         .= ';';
                $fpp_rec         .= ';';
                $mes_ant++;
            }
            $valor_royalties .= $roy->valor_royalties . ';';
            $despesa         .= $roy->despesa 		  . ';';
            $faturamento     .= $roy->faturamento 	  . ';';
            $fpp             .= $roy->fpp 			  . ';';
            $data            .= $roy->data			  . ';';
            $roy_rec         .= $roy->roy_rec         . ';';
            $fpp_rec         .= $roy->fpp_rec         . ';';

        }
        $id = $roy->id_empresa;		
    }
	
    //retorna o ultimo resultado
    if($id!=0){
        $contador2=$contador-1;
        $dt[$contador2] = array(
        'id_empresa'      => $id_empresa,	
        'valor_royalties' => $valor_royalties, 	
        'despesa' 		  => $despesa,	
        'franquia'  	  => $franquia, 	
        'faturamento'  	  => $faturamento, 	
        'fixo' 			  => $fixo,	
        'imposto'  		  => $imposto, 	
        'royalties'  	  => $royalties1, 
        'fpp'  	  		  => $fpp, 				
        'data' 			  => $data,
        'roy_rec'         => $roy_rec,
        'fpp_rec'         => $fpp_rec
        );
    }
    
    
    $workbook =& new Spreadsheet_Excel_Writer();
	
    //seta o nome do arquivo e coloca send para ir para download
    $workbook->send($arquivo);

    //monta as abas da planilha
    $abas = array('ROYALTIES', 'FPP', 'FATURAMENTO', 'DESPESAS', 'ROYALTIES FPP');

    //estilos
    $style1 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1
    ));

    $style2 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1, 
            'Top'=>2, 'Bottom'=>2, 'Left'=>2, 'Right'=>2, 'BorderColor'=>'black'
    ));

    $style3 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1, 
            'Top'=>2, 'Bottom'=>2, 'Left'=>2, 'Right'=>2, 'BorderColor'=>'black'
    ));

    $style4 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1, 
            'Top'=>2, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black'
    ));

    $style5 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
            'Top'=>2, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black', 'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style6 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1,  
            'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black'
    ));

    $style7 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri',
            'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black', 'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style8 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Width'=>14,  
            'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>2, 'BorderColor'=>'black'
    ));

    $style9 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'right',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri',   
            'Top'=>1, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black', 'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style10 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'right',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri',   
            'Top'=>1, 'Bottom'=>1, 'Left'=>2, 'Right'=>1, 'BorderColor'=>'black', 'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style11 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'right',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri',   
            'Top'=>2, 'Bottom'=>1, 'Left'=>1, 'Right'=>1, 'BorderColor'=>'black', 'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style12 =& $workbook->addFormat( array(
            'Size'=>8, 'FgColor'=>'red', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign' => 'vcenter', 'FontFamily'=>'Calibri'
    ));

    $style13 =& $workbook->addFormat( array(
            'Size'=>8, 'FgColor'=>'red', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri',
            'Bottom'=>2, 'BorderColor'=>'black'
    ));

    $style14 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1, 
            'Left'=>2, 'BorderColor'=>'black'
    ));

    $style15 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1, 
            'Left'=>2, 'BorderColor'=>'black'
    ));

    $style16 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1, 
            'Left'=>2, 'Right'=>2, 'BorderColor'=>'black'
    ));

    $style17 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri',
            'Left'=>2, 'Right'=>2, 'Top'=>2, 'Bottom'=>1, 'BorderColor'=>'black'
    ));

    $style18 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri',
            'Left'=>2, 'Right'=>2, 'Bottom'=>1, 'BorderColor'=>'black'
    ));

    $style19 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri',
            'Left'=>2, 'Right'=>2, 'Bottom'=>2, 'BorderColor'=>'black'
    ));

    $style20 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
            'Top'=>1, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black',
            'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style21 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
            'Top'=>2, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black',
            'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style22 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
            'Top'=>2, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black',
            'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style23 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
            'Top'=>2, 'BorderColor'=>'black'
    ));

    $style24 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
            'Top'=>2, 'Left'=>1, 'BorderColor'=>'black'
    ));

    $style25 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
            'Top'=>1, 'Left'=>1, 'Right'=>2, 'Bottom'=>1, 'BorderColor'=>'black',
            'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style26 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
            'Top'=>2, 'Left'=>1, 'Right'=>2, 'Bottom'=>1, 'BorderColor'=>'black',
            'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style27 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'center',
            'vAlign'=>'vcenter', 'FontFamily'=>'Calibri', 
            'Top'=>1, 'Left'=>1, 'Right'=>1, 'Bottom'=>1, 'BorderColor'=>'black',
            'NumFormat'=>'_*R$ #,##0.00'
    ));

    $style28 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1
    ));

    $style29 =& $workbook->addFormat( array(
            'Size'=>11, 'FgColor'=>'black', 'BgColor'=>'white', 'Align'=>'left',
            'vAlign' => 'vcenter', 'FontFamily'=>'Calibri', 'Bold'=>1,
            'Top'=>1, 'Left'=>1, 'Right'=>1, 'Bottom'=>1
    ));

    //variaveis	
    $ref = array('Referência','jan/','fev/','mar/','abr/','mai/','jun/','jul/','ago/','set/','out/','nov/','dez/','TOTAL');
    $size   = 13;
	
    
    //monta o objeto
	for($i = 0; $i < count($abas); $i++){
	//for($i = 4; $i < count($abas); $i++){
		//planilha
		$worksheet =& $workbook->addWorksheet(str_replace(' ', '_', $abas[$i]).'_'.$ano);
		
		if($i <= 3){
			//1ª linha
			$worksheet->setMerge(0, 0, 0, 13);
			$worksheet->write(0, 0, $abas[$i] . ' ' . $ano . ' - SISTEMA', $style1);
			
			//2ª linha
			for($j = 0; $j < count($ref); $j++){
				$texto  = $ref[$j] . $ano;
				$size   = 11;
				$estilo = $style3;
				switch($j){
					case 0: 
						$size = 40; 
						$texto  = $ref[$j];
						$estilo = $style2;
						break;
					case count($ref)-1: 
						$texto  = $ref[$j];
						break;
				}
				$worksheet->write(1, $j, $texto, $estilo);
				$worksheet->setColumn(1, $j, $size); 
			}
		
			//3ª linha
			$worksheet->setMerge(2, 1, 2, count($ref)-1);
			$worksheet->write(2, 0, 'Franquia', $style2);
			
			$total = 3;
			$total_xy = array();
			
			//retorna resultados da base
			for($k = 0; $k < count($dt); $k++){
				//pega data
				$inicio = 1;
				$fim    = 12;
				$flag_inicio = 1;
				$soma_xy   = array();
				$str_valor = '';
				
				switch($i){
					case 0: 
						$str_valor = explode(';',$dt[$k]['valor_royalties']);
						break; 
					case 1:			
						$str_valor = explode(';',$dt[$k]['fpp']);
						break;
					case 2:	
						$str_valor = explode(';',$dt[$k]['faturamento']);
						break;
					case 3: 	
						$str_valor = explode(';',$dt[$k]['despesa']);
						break;
				}
				
				if(!is_null($dt[$k]['data']) OR $dt[$k]['data'] != ''){
					$d 		= explode(';', $dt[$k]['data']);
					for($j = 0; $j < count($d); $j++){
						if(!is_null($d[$j]) OR $d[$j] != '')
							$di     = explode('-', $d[$j]);
							if(!is_null($di[1]) AND $flag_inicio == 1){
								$inicio = (int)$di[1];
								$fim    = (int)$di[1];
								$flag_inicio = 0;
								$soma_xy[$inicio] = $str_valor[$j];
							} else if(!is_null($di[1])){
								$fim    = (int)$di[1];
								$soma_xy[$fim] = $str_valor[$j];
							}
					}
				}
				
				$linha_x = (float)0;
				$linha_y = (float)0;
				
				for($j = 0; $j < 14; $j++){
					if($j == 0){
						$worksheet->write($total, $j, $dt[$k]['franquia'], $style8);
					}elseif($j == 13){
						$worksheet->write($total, $j, (float)($linha_x), $style10);
						$soma_xy[$k][$j] = $linha_x;
					}else{
						$estilo = $style11;
						if($k != 0){ $estilo = $style9; }
						if($soma_xy[$j]){
							if(!$total_xy[$j]) $total_xy[$j] = 0;
							$total_xy[$j] = (float)($total_xy[$j]) + (float)($soma_xy[$j]);
							
							$linha_x = (float)$linha_x + (float)($soma_xy[$j]);
							$worksheet->write($total, $j, (float)($soma_xy[$j]), $estilo);
						} else {
							if(!$total_xy[$j]) $total_xy[$j] = 0;
							$total_xy[$j] = (float)$total_xy[$j] + 0;
							
							$worksheet->write($total, $j, (float)($soma_xy[$j]), $estilo);
						}
					}
				}
				$total = $total + 1;
			}
			$soma_xy = '';
			
			//Total
			$worksheet->write($total, 0, 'Total', $style4);
			$total_anual = 0;
			for($j = 1; $j <= count($ref)-2; $j++){
				$total_anual = (float)$total_anual + (float)($total_xy[$j]);
				$worksheet->write($total, $j, $total_xy[$j], $style5);
			}
			
			//Total Anual
			$total = $total + 1;
			$worksheet->write($total, 0, 'Total Anual', $style6);
			$worksheet->write($total, 1, $total_anual, $style7);
			$worksheet->setMerge($total, 2, $total, 13);
			
			//Média
			$media = count($dt);
			if($ano == date('Y')){
				$media = (int)(date('m'));
			}
			$total = $total + 1;
			$worksheet->write($total, 0, 'Média', $style6);
			$worksheet->write($total, 1, ((float)($total_anual / $media)), $style7);	
			$worksheet->setMerge($total, 2, $total, 13);
		} else {
			
			$total=0;
			//1ª linha
			$worksheet->setMerge(0, 0, 0, 52);
			$worksheet->write($total, 53, '', $style1);
			$worksheet->write($total, 0, $abas[$i] . ' ' . $ano . ' - SISTEMA', $style28);
			
			//2ª linha
			#$worksheet->setMerge(1, 0, 1, 52);
			#$worksheet->write(1, 53, '', $style1);
			#$worksheet->write(1, 0, '1 - RYRC = Royalties á Receber', $style12);
			
			//3ª linha
			#$worksheet->setMerge(2, 0, 2, 52);
			#$worksheet->write(2, 53, '', $style1);
			#$worksheet->write(2, 0, '2 - FPPR = FPP á Receber', $style12);
			
			//4ª linha
			#$worksheet->setMerge(3, 0, 3, 52);
			#$worksheet->write(3, 53, '', $style1);
			#$worksheet->write(3, 0, '3 - RYRD = Royalties Recebido', $style12);
			
			//5ª linha
			#$worksheet->setMerge($total, 0, $total, 52);
			$total++;
			for($j = 0; $j < 53; $j++){
			#	if($j == 0)
			#		$worksheet->write(4, 0, '4 - FPRC - FPP Recebido', $style13);
			#	else
					$worksheet->write($total, $j, '', $style13);
			}
			$worksheet->write($total, 53, '', $style1);
			
			//6ª linha
			$cont = 1;
			$total++;
			for($j = 0; $j < count($ref); $j++){
				if($j > 0){
					$txt = ($j < (count($ref) - 1)) ? $txt = $ref[$j] . $ano : $txt = $ref[$j];
					$worksheet->setMerge($total, $cont, $total, ($cont + 3));
					$worksheet->write($total, $cont, $txt, $style15);
					$cont = $cont + 4;
				} else {		
					$worksheet->write($total, 0, $ref[$j], $style14);
				}
			}	
			
			$worksheet->write($total, 53, '', $style15);
			
			//7ª linha
			$roy_type = array('ROYALTIES Á RECEBER','FPP Á RECEBER','ROYALTIES RECEBIDO','FPP RECEBIDO');
			$k = 0;
			$total++;
			$worksheet->write($total, 0, '', $style3);
			for($j = 1; $j <= 52; $j++){
				$worksheet->write($total, $j, $roy_type[$k], $style3);
				$teste = ($k == 3) ? $k = 0 : $k++;
			}
			$worksheet->write($total, 53, '', $style15);
			
			//8ª linha
			$cont = 1;
			$total++;
			for($j = 0; $j < count($ref); $j++){
				if($j > 0){
					$worksheet->setMerge($total, $cont, $total, ($cont + 3));
					$worksheet->write($total, $cont, '', $style15);
					$cont = $cont + 4;
				} else {
					$worksheet->write($total, 0, 'Franquia', $style2);
				}
			}
			$worksheet->write($total, 53, '', $style15);
			
			//9ª linha
			#laço de fechamento dos royalties mensais
			for($k = 0; $k < count($dt); $k++){	
				$total++;
				#pega o mes de inicio da franquia no ano
				$rydata  = explode(';', $dt[$k]['data']);
				$mes     = substr($rydata[0],5,2);
				
				#cria campos no array caso tenha inaugurado depois do mes 01
				$iArr = 0;
				$inicioArr = array();
				while($iArr<$mes) {
					$iArr++;
					$inicioArr[$iArr] = 0;
				}

				#volta para o mes 1
				$mes = 1;
				$resArr = explode(';', $dt[$k]['valor_royalties']);
				$ryrc  	 = array_merge($inicioArr,$resArr);
				$fppr    = array_merge($inicioArr,explode(';', $dt[$k]['fpp']));
				$ryrd    = array_merge($inicioArr,explode(';', $dt[$k]['roy_rec']));
				$fprc    = array_merge($inicioArr,explode(';', $dt[$k]['fpp_rec']));

				$ryrc_x  = (float)0;
				$fppr_x  = (float)0;
				$ryrd_x  = (float)0;
				$fprc_x  = (float)0;

				for($j = 0; $j <= 48; $j++){
					$teste = ($k == 0) ? $estilo1 = $style17 : $estilo1 = ($k == (count($dt) - 1)) ? $estilo1 = $style19 : $estilo = $style18;
					if($j == 0){
						$worksheet->write($total, $j, $dt[$k]['franquia'], $estilo1);
					} else {
						($k == 0) ? $estilo1 = $style22 : $estilo1 = $style20;
						($ryrc[$mes] == '') ? $ryrc[$mes] = (float)0 : $ryrc[$mes] = (float)$ryrc[$mes];
						($fppr[$mes] == '') ? $fppr[$mes] = (float)0 : $fppr[$mes] = (float)$fppr[$mes];
						($ryrd[$mes] == '') ? $ryrd[$mes] = (float)0 : $ryrd[$mes] = (float)$ryrd[$mes];
						($fprc[$mes] == '') ? $fprc[$mes] = (float)0 : $fprc[$mes] = (float)$fprc[$mes];
						switch(fmod($j, 4)){
							case 1:
								#royalty a receber
								$total_roy_r = ($ryrc[$mes] - $ryrd[$mes]<0)?$total_roy_r=0:$total_roy_r=$ryrc[$mes] - $ryrd[$mes];
								$worksheet->write($total, $j, $total_roy_r, $estilo1);
								$ryrc_x = (float)$ryrc_x + (float)($total_roy_r );
								$ryrc_y[$j] = (float)$ryrc_y[$j] + (float)($total_roy_r );
							break;
							case 2: 
								#fpp a receber
								$total_fpp_r = ($fppr[$mes] - $fprc[$mes]<0)?$total_fpp_r=0:$total_fpp_r=$fppr[$mes] - $fprc[$mes];
								$worksheet->write($total, $j, $total_fpp_r, $estilo1);
								$fppr_x = (float)$fppr_x + (float)($total_fpp_r );
								$fppr_y[$j] = (float)$fppr_y[$j] + (float)($total_fpp_r );
							break;
							case 3: 
								#royalty recebido
								$worksheet->write($total, $j, $ryrd[$mes], $estilo1); 
								$ryrd_x = (float)$ryrd_x + (float)$ryrd[$mes];
								$ryrd_y[$j] = (float)$ryrd_y[$j] + (float)$ryrd[$mes];
							break;
							case 0: 
								#royalty recebido
								if($k == 0){
									$worksheet->write($total, $j, $fprc[$mes], $style26);
								} else {
									$worksheet->write($total, $j, $fprc[$mes], $style25);
								}
								$fprc_x = (float)$fprc_x + (float)$fprc[$mes];
								$fprc_y[$j] = (float)$fprc_y[$j] + (float)$fprc[$mes];
								$mes++;	
							break;
						}
					}	
				}
				$worksheet->write($total, 49, $ryrc_x, $estilo1); 
				$worksheet->write($total, 50, $fppr_x, $estilo1); 
				$worksheet->write($total, 51, $ryrd_x, $estilo1); 
				$worksheet->write($total, 52, $fprc_x, $estilo1); 
				$ryrc_y[49] = (float)$ryrc_y[49] + (float)$ryrc_x;
				$fppr_y[50] = (float)$fppr_y[50] + (float)$fppr_x;
				$ryrd_y[51] = (float)$ryrd_y[51] + (float)$ryrd_x;
				$fprc_y[52] = (float)$fprc_y[52] + (float)$fprc_x;
				$worksheet->write($total, 53, '', $style15);
			}
			
			//10ª linha
			$total++;
			for($j = 0; $j <= 48; $j++){
				if($j == 0){
					$worksheet->write($total, $j, 'Total', $style29);
				} else {
					$estilo1 = $style21;
					switch(fmod($j, 4)){
						case 1: 
							$worksheet->write($total, $j, $ryrc_y[$j], $style21);
						break;
						
						case 2: 
							$worksheet->write($total, $j, $fppr_y[$j], $style21);
						break;
						
						case 3: 
							$worksheet->write($total, $j, $ryrd_y[$j], $style21);
						break;
						
						case 0: 
							$worksheet->write($total, $j, $fprc_y[$j], $style21);
						break;
					}
				}
			}
			$worksheet->write($total, 49, '', $style24); 
			$worksheet->write($total, 50, '', $style23); 
			$worksheet->write($total, 51, '', $style23); 
			$worksheet->write($total, 52, '', $style23); 
			
			//11ª linha
			$total++;
			$worksheet->write($total, 0, 'Total Anual', $style29); 
			$worksheet->write($total, 1, $ryrc_y[49], $style27); 
			$worksheet->write($total, 2, $fppr_y[50], $style27); 
			$worksheet->write($total, 3, $ryrd_y[51], $style27); 
			$worksheet->write($total, 4, $fprc_y[52], $style27); 
			for($j = 5; $j <= 53; $j++){
				$worksheet->write($total, $j, '', $style1); 
			}	
			
			//12ª linha	
			$total++;
			$media = count($dt);
			if($ano == date('Y')){
				$media = (int)(date('m'));
			}
			$worksheet->write($total, 0, 'Média', $style29); 
			$worksheet->write($total, 1, ($ryrc_y[49]  / $media), $style27); 
			$worksheet->write($total, 2, ($fppr_y[50] / $media), $style27); 
			$worksheet->write($total, 3, ($ryrd_y[51] / $media), $style27); 
			$worksheet->write($total, 4, ($fprc_y[52] / $media), $style27); 
			for($j = 5; $j <= 53; $j++){
				$worksheet->write($total, $j, '', $style1); 
			}		
		}
	}
	$workbook->close(); 
	
} else {

    pt_register('GET','pg');
    pt_register('POST','ano');
    $pagina = RelTipTit($pg);
    
    $c = new stdClass();
    $c->ano        = isset($mes) ? $mes : date('Y');
    
    include('header2.php'); ?>
    <script>
        menu(3,'bt-05');
        $('#titulo').html('relatórios &rsaquo;&rsaquo; <a href="<?=$pagina['retorno']?>" id="voltar"><?=$pagina['titulo']?></a> &rsaquo;&rsaquo; Mensal Consolidado');
        $('#sub-<?=$pagina['sub']?>').css({'font-weight':'bold'});
    </script>
    <div class="content-list-forms">
        <form method="post" target="blank">
            <dl>
                <legend>Relatório Mensal Consolidado</legend>
                <dt>Ano:</dt>
                <dd>
                    <select id="ano" name="ano" class="chzn-select">
                        <?php foreach(DataAno(2) AS $p => $f){ ?>
                        <option value="<?=$p?>"<?=$p==$c->ano ? ' selected="selected"' : ''?>><?=$f?></option>
                        <?php } ?>
                    </select>
                </dd>
                <dt>Canceladas?</dt>
                <dd class="checks">
                    <input type="checkbox" name="cancel" id="cancel">
                    <span>Sim</span>
                </dd>
                <div class="buttons">
                    <input type="button" value="&lsaquo;&lsaquo; voltar" onclick="location.href=$('#voltar').attr('href')">
                    <input type="button" value="&lsaquo;&lsaquo; limpar" onclick="location.href=window.location.pathname+'?pg=<?=$pg?>'">
                    <input type="submit" value="buscar &rsaquo;&rsaquo;">
                </div>
            </dl>
        </form>
        <script>preencheCampo()</script>
    </div>
    <div class="content-list-table">
        <?php if($_POST){
            RetornaVazio();
        } else {
            RetornaVazio(2); } ?>
    </div>
    <?php include('footer.php'); 
}?>