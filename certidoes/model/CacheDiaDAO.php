<?php

class CacheDiaDAO extends Database{

	#verifica validade da cache
	public function VerificaCache($filename) {
		$caminho = '../../sistema/cache_dia/';
		#if (!file_exists($caminho.$filename)) 		$caminho = '../sistema/cache_dia/';
		$filename = $caminho.$filename;

		if (file_exists($filename)) {
			$data_arquivo = date ("d", filemtime($filename));
			if($data_arquivo != date('d')){
				unlink($filename);
			}	
		}
		if($data_arquivo != date('d')) return false;
		else return true;
	}

	#grava csv
	public function ConvertArrayToCsv($filename,$ret, $campos) {
		$caminho = '../../sistema/cache_dia/';
		#if (!file_exists($caminho.$filename)) 		$caminho = '../sistema/cache_dia/';
		$filename = $caminho.$filename;

		$campo = explode(';',$campos);

		$arquivoConteudo = $campos."\n";
		#$ret = $options['delimiter'];
		$cont = count($campo);
		$i = 1;
		foreach($ret as $r){
			$arquivoConteudo .= $r->{$campo[0]};
			while($i<$cont){
				$arquivoConteudo .= ";".$r->{$campo[$i]};
				$i++;
			}
			$i=1;
			$arquivoConteudo .= "\n";
		}
		if(fopen($filename,"w+")) {
			if (!$handle = fopen($filename, 'w+')) {
				echo "<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO DE WEB CACHE</font><br />";
				exit;
			}

			if(!fwrite($handle, $arquivoConteudo)) {
				echo"<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO DE WEB CACHE.</font><br />";
				exit;
			}
		} else {
			echo"<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ABRIR ARQUIVO DE WEB CACHE.</font><br />";
			exit;
		}
		return true;
	}
	
	#converte arquivo csv em array ou objeto
	public function ConvertCsvToArray($filename, $options = null) {
		$caminho = '../../sistema/cache_dia/';
		#if (!file_exists($caminho.$filename)) 		$caminho = '../sistema/cache_dia/';
		$filename = $caminho.$filename;
		
		$delimiter = empty($options['delimiter']) ? ";" : $options['delimiter'];
		$to_object = empty($options['to_object']) ? false : true;
		$str = file_get_contents($filename);

		$lines = explode("\n", $str);
		$field_names = explode($delimiter, array_shift($lines));
		foreach ($lines as $line) {
			// Skip the empty line
			if (empty($line)) continue;
			$fields = explode($delimiter, $line);
			$_res = $to_object ? new stdClass : array();
			foreach ($field_names as $key => $f) {
				if ($to_object) {
					$_res->{$f} = $fields[$key];
				} else {
					$_res[$f] = $fields[$key];
				}
			}
			$res[] = $_res;
		}
		return $res;
	}	
}

?>