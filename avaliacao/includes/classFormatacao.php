<?php
/**********************************************************/
  Data de cria��o : 03/02/2009
  Autor           : Daniel Flores Bastos
  Proposta        : Formatar dados para serem inseridos no Banco de Dados e para a visualiza��o
                  setData     = Envia DATA formatada (aaaa-mm-dd).
                  setCPF      = Envia CPF formatado(###########).
                  setCNPJ     = Envia CNPJ formatado(#############).
                  setCEP      = Envia CEP formatado(########).
                  setTelefone = Envia Telefone formatado(#########).

                  getMoney     = Retorna um VALOR formatado (###.###,##)
                  getToUpper   = Retorna o texto todo em mai�scula(AAAAAAAAAA)
                  getToLower   = Retorna o texto todo em min�scula(aaaaaaaaaa)
                  getSmallText = Retorna um texto at� determinado n�mero de caracter
                  getData      = Retorna DATA formatada(dd/mm/aaaa).
                  getCPF       = Retorna CPF formatado(###.###.###-##).
                  getCNPJ      = Retorna CNPJ formatado(##.###.###/####-#).
                  getCEP       = Retorna CEP formatado(#####-###).
                  getTelefone  = Retorna Telefone formatado((##) ####-####).
/**********************************************************/

class FormataString
{

  private $cpf_cnpj;
  private $data;
  private $dataHora;
  private $telefone;
  private $cep;
  private $nr_zero;
  private $zeros;

  function setData($valor)
  {
   if(!empty($valor))
   {
     $this->data = explode('/',$valor);
     $this->data = $this->data[2] . '-' . $this->data[1] . '-' . $this->data[0];
     return $this->data;
   }
  }

  function getData($valor)
  {

    if(!empty($valor))
    {
      $this->data = substr($valor,8,2);
      $this->data .= '/' . substr($valor,5,2);
      $this->data .= '/' . substr($valor,0,4);
      return $this->data;

    }

  }

  function setCPF($valor)
  {

    if(!empty($valor))
    {

      $this->cpf_cnpj = explode('.',$valor);
      $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1] . $this->cpf_cnpj[2];
      $this->cpf_cnpj = explode('-',$this->cpf_cnpj);
      $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1];
      if(is_numeric($this->cpf_cnpj) && strlen($this->cpf_cnpj) == 11)
        return $this->cpf_cnpj;
    }

  }

  function setCNPJ($valor)
  {
     $this->cpf_cnpj = explode('.',$valor);
     $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1] . $this->cpf_cnpj[2];
     $this->cpf_cnpj = explode('/',$this->cpf_cnpj);
     $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1];
     $this->cpf_cnpj = explode('-',$this->cpf_cnpj);
     $this->cpf_cnpj = $this->cpf_cnpj[0] . $this->cpf_cnpj[1];
     return $this->cpf_cnpj;
  }

  function getCPF($valor)
  {
    $this->cpf_cnpj = substr($valor,0,3);
    $this->cpf_cnpj .= '.' . substr($valor,3,3);
    $this->cpf_cnpj .= '.' . substr($valor,6,3);
    $this->cpf_cnpj .= '-' . substr($valor,-2);
    return $this->cpf_cnpj;
  }

  function getCNPJ($valor)
  {
    $this->cpf_cnpj  = substr($valor,0,2);
    $this->cpf_cnpj .= '.' . substr($valor,2,3);
    $this->cpf_cnpj .= '.' . substr($valor,5,3);
    $this->cpf_cnpj .= '/' . substr($valor,8,4);
    $this->cpf_cnpj .= '-' . substr($valor,-1);
    return $this->cpf_cnpj;
  }

  function setTelefone($valor)
  {
    $this->telefone = explode('(',$valor);
    $this->telefone = $this->telefone[0].$this->telefone[1];
    $this->telefone = explode(')',$this->telefone);
    $this->telefone = $this->telefone[0].$this->telefone[1];
    $this->telefone = explode('-',$this->telefone);
    $this->telefone = $this->telefone[0].$this->telefone[1];
    $this->telefone = explode(' ',$this->telefone);
    $this->telefone = $this->telefone[0].$this->telefone[1];
    return $this->telefone;
  }

  function getTelefone($valor)
  {
    $this->telefone  = '(' . substr($valor,0,2) . ') ';
    $this->telefone .= substr($valor,2,4) . '-';
    $this->telefone .= substr($valor,6,8);
    return $this->telefone;
  }

  function setCEP($valor)
  {
    if(!empty($valor))
    {
      $this->cep = explode('-',$valor);
      $this->cep = $this->cep[0] . $this->cep[1];
      return $this->cep;
    }
  }

  function getCEP($valor)
  {
    if(!empty($valor))
    {
      $this->cep  = substr($valor,0,5) . '-';
      $this->cep .= substr($valor,5,3);
      return $this->cep;
    }
  }

  function getSmallText($nr_caracter, $texto)
  {

    if(strlen($texto) > $nr_caracter)
    {
      $_text = substr($texto, 0, ($nr_caracter - 3)) . "...";
    }
    else
    {
      $_text = $texto;
    }

    return $_text;

  }

  function getMoney($valor)
  {
    if(empty($valor))
      $valor = 0;

    return number_format($valor, 2, ',', '.');
  }

  function getToUpper($valor)
  {
    if(!empty($valor))
      $_valor = strtoupper($valor);

    return $_valor;
  }

  function getToLower($valor)
  {
    if(!empty($valor))
      $_valor = strtolower($valor);

    return $_valor;
  }

}
?>
E aqui est� um exemplo de utiliza��o para voc� usar como modelo para come�ar:

<?php
  //Incluir a classe onde est�o todos os metodos que ser�o chamados
  include_once 'class.FormataString().php';

  //Inst�nciando a classe FormataString
  $formata = new FormataString();

  $setData     = $formata->setData(date('d/m/Y'));
  $setCPF      = $formata->setCPF('012.345.678-90');
  $setCNPJ     = $formata->setCNPJ('11.444.777/0001-61');
  $setCEP      = $formata->setCEP('01234-567');
  $setTelefone = $formata->setTelefone('(01) 2345-6789');

  echo 'Valores que ser�o inseridos no banco, j� formatados:<br />';
  echo 'Data -     ' . $setData     . '<br />';
  echo 'CPF -      ' . $setCPF      . '<br />';
  echo 'CNPJ -     ' . $setCNPJ     . '<br />';
  echo 'CEP -      ' . $setCEP      . '<br />';
  echo 'Telefone - ' . $setTelefone . '<br />';

  $getData      = $formata->getData($setData);
  $getCPF       = $formata->getCPF($setCPF);
  $getCNPJ      = $formata->getCNPJ($setCNPJ);
  $getCEP       = $formata->getCEP($setCEP);
  $getTelefone  = $formata->getTelefone($setTelefone);
  $getMoney     = $formata->getMoney('10020050');
  $getToUpper   = $formata->getToUpper('texto todo em mai�culo');
  $getToLower   = $formata->getToLower('TEXTO TODO EM MIN�SCULO');
  $getSmallText = $formata->getSmallText(50, 'Este texto vai conter mais de 50 caracteres, porem a fun��o vai exibir apernas at� o 7� caractere e acrescentando ...');

  echo '<br />Valores que ser�o retornados no banco, j� formatados:<br />';
  echo 'Data -      ' . $getData      . '<br />';
  echo 'CPF -       ' . $getCPF       . '<br />';
  echo 'CNPJ -      ' . $getCNPJ      . '<br />';
  echo 'CEP -       ' . $getCEP       . '<br />';
  echo 'Telefone -  ' . $getTelefone  . '<br />';
  echo 'Money -     ' . $getMoney     . '<br />';
  echo 'Mai�culo -  ' . $getToUpper   . '<br />';
  echo 'Min�sculo - ' . $getToLower   . '<br />';
  echo 'SmallText - ' . $getSmallText . '<br />';
?>