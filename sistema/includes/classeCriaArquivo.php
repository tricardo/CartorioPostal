<?

/* Inicio da classe */
class Arquivo {

   /* Vari�veis */
   
   /* Fim vari�veis da classe */

   /* M�todo construtor */
   function Arquivo() {
      
   }
   /* Fim m�todo construtor */

   /* Gets e Sets */
   
   /* Fim Gets e Sets */

   /* M�todos */
   function criaArquivo($arquivoDiretorio,$arquivoConteudo) {
      
      $vetorArquivo = explode("/",$arquivoDiretorio);
      //print_r($vetorArquivo);exit;
      $nomeArquivo = array_pop($vetorArquivo);
      //print_r($vetorArquivo);exit;
      foreach($vetorArquivo as $indice => $valor) {
         
         $diretorio .= $valor."/";
      }
      
      echo $this->validaDiretorio($diretorio);
      //echo $nomeArquivo;exit;
      
      if(!is_file($arquivoDiretorio)) {
         
         if(fopen($arquivoDiretorio,"w+")) {
            
            if (!$handle = fopen($arquivoDiretorio, 'w+')) {
               return("<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />");
            }
            
            if(!fwrite($handle, $arquivoConteudo)) {
               return("<BR><font style='color: blue;'>&nbsp;&nbsp;FALHA AO ESCREVER NO ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />");
            }
            return("");
         }
         else {
            return("<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIAR O ARQUIVO: <b>".$nomeArquivo."</b>.</font><br />");
         }
      }
      else {
         return("<BR><font style='color: blue;'>&nbsp;&nbsp;O ARQUIVO <b>".$nomeArquivo."</b> J� EXISTE.</font><br />");
      }
   }
   
   function validaDiretorio($validarDiretorio) {
      
      /* O if a seguir � para caso ainda n�o exista o diret�rio ir� cri�-lo conforme os passos abaixo: */
      if(!is_dir($validarDiretorio)) {
         
         $vetorDiretorio = explode("/", $validarDiretorio);
         
         foreach($vetorDiretorio as $codigo => $valor) {
            $diretorio .= $valor."/";
            
            if(!is_dir($diretorio)) {
               
               if(mkdir ($diretorio, 777)) {
                  chmod ($diretorio, 0777);
               }
               else {
                  return("<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIA O DIRET�RIO.</font><br />");
               }
            }
         }
      }
      else {
         return("<BR><font style='color: blue;'>&nbsp;&nbsp;O DIRET�RIO: ".$validarDiretorio." J� EXISTE, VERIFIQUE O CONTE�DO DO MESMO.</font><br />");
      }
   }
   /* Fim m�todos */
}
/* Fim da classe */
?>
