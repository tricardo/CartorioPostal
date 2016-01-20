<?

/* Inicio da classe */
class Arquivo {

   /* Variáveis */
   
   /* Fim variáveis da classe */

   /* Método construtor */
   function Arquivo() {
      
   }
   /* Fim método construtor */

   /* Gets e Sets */
   
   /* Fim Gets e Sets */

   /* Métodos */
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
         return("<BR><font style='color: blue;'>&nbsp;&nbsp;O ARQUIVO <b>".$nomeArquivo."</b> JÁ EXISTE.</font><br />");
      }
   }
   
   function validaDiretorio($validarDiretorio) {
      
      /* O if a seguir é para caso ainda não exista o diretório irá criá-lo conforme os passos abaixo: */
      if(!is_dir($validarDiretorio)) {
         
         $vetorDiretorio = explode("/", $validarDiretorio);
         
         foreach($vetorDiretorio as $codigo => $valor) {
            $diretorio .= $valor."/";
            
            if(!is_dir($diretorio)) {
               
               if(mkdir ($diretorio, 777)) {
                  chmod ($diretorio, 0777);
               }
               else {
                  return("<BR><font style='color: blue;'>&nbsp;&nbsp;ERRO AO CRIA O DIRETÓRIO.</font><br />");
               }
            }
         }
      }
      else {
         return("<BR><font style='color: blue;'>&nbsp;&nbsp;O DIRETÓRIO: ".$validarDiretorio." JÁ EXISTE, VERIFIQUE O CONTEÚDO DO MESMO.</font><br />");
      }
   }
   /* Fim métodos */
}
/* Fim da classe */
?>
