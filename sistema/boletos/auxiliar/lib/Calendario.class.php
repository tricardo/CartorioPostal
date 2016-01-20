<?
/***************************************************************************
 * Gerador de calend�rio em PHP
 * �ltima altera��o: 28/02/2005 �s 17:37                                   *
 * Autor: Raphael Ara�jo e Silva - khaotix_@hotmail.com                    *
 *                                                                         *
 * ATEN��O: VOC� TEM A COMPLETA PERMISS�O PARA ALTERA��O E REDISTRIBUI��O  *
 *          DO C�DIGO NESTE E EM QUALQUER ARQUIVO ACOMPANHANTE DESDE QUE O *
 *          AUTOR ORIGINAL SEJA CITADO.                                    *
 ***************************************************************************/

function calcularDiaSemana($dia,$mes,$ano) {
    $s=(int)($ano / 100);
    $a=$ano % 100;

    if($mes<=2) {
        $mes+=10;
        $a--;
    }
    else $mes-=2;

    $ival=(int)(2.6*$mes-0.1);
    $q1=(int)($s / 4);
    $q2=(int)($a / 4);

    $dia_semana=($ival + $dia + $a + $q1 + $q2 - 2 * $s) % 7;

    if($dia_semana<0) $dia_semana+=7;

    return($dia_semana);
}

class Calendario {

    private $mes;
    private $ano;
    private $nmeses;
    private $ncols;
    private $datas;
    private $rodapes;
    private $leg;

    public function __construct($datas=array(),$rodapes=array(),$leg=array(),$mes=0,$ano=0,$nmeses=1,$ncols=1) {
        $this->mes = ($mes>0 && $mes<=12)?$mes:date("m");
        $this->ano = ($ano>1990)?$ano:date("Y");
        $this->nmeses = ($nmeses>0 && $nmeses<=12)?$nmeses:1;
        $this->ncols = ($ncols>0)?$ncols:1;
        $this->datas = $datas;
        $this->rodapes = $rodapes;
        $this->leg = $leg;

        if(!($this->mes>0 && $this->mes<=12 && ($this->nmeses>0 && $this->nmeses<=12) &&
            ($this->ncols>0 && $this->ncols<=12) && ($this->mes+$this->nmeses<=13))) {
            throw new Exception("Erro ao gerar calend�rio: [m�s=".$mes."] [ano=".$ano.
                "] [número de meses=".$nmeses."] [tabelas por linha=".$ncols."]<br>");
        }
    }

    public function gerarCalendario()//$feriados,$marcados,$rodapes)
    {
    //Calcula em que dia da semana � o dia 1/$mes/$ano
        $dia_semana=calcularDiaSemana(1,$this->mes,$this->ano);
        $bisexto=(($this->ano % 4 ==0) || ($this->ano % 100==0)); //Verifica se o ano � bisexto
        $ndias=array(31,($bisexto ? 29 : 28),31,30,31,30,31,31,30,31,30,31); //Vetor com o n�mero de dias de cada m�s
        $meses=array("Janeiro","Fevereiro","Março","Abril","Maio","Junho",
            "Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
        $dias=array("D","S","T","Q","Q","S","S");

        $mes=$this->mes-1;
        $total=$mes+$this->nmeses; //Total de meses a serem considerados
        $dia=$daux=$dia_semana;

        $qtd=array();
        for($i=0;$i<count($this->datas);$i++) $qtd[$i]=count($this->datas[$i]);

        $nq=count($qtd);
        
//        $tabela="<table>"; //Inicia a tabela geral (que suportar� as demais tabelas de meses)
        while($mes<$total) {
//            $tabela.="<tr>";
            for($ms=0; $ms<$this->ncols && $mes<$total; $ms++) {
                $temp_tb='<td valign="top"><table class="tabela">';
                $temp_tb.='<tr class="cabecalho"><th><a href="#" class="mesAnt"><<</a></th>';
                $temp_tb.='<th colspan=5>'.$meses[$mes].'</th>';
                $temp_tb.='<th><a href="#" class="mesProx">>></a></th></tr><tr>'; //Cria uma tabela para o m�s atual

                for($idx2=0;$idx2<7;$idx2++) //Gera o cabe�alho da tabela do m�s atual
                    $temp_tb=$temp_tb."<td class='td_semana'>".$dias[$idx2]."</td>";
                $temp_tb=$temp_tb."</tr>"; //Fecha o cabe�alho

                $cnt_dias=1; //Inicializa o contador de dias
                $temp_ln="";
                $nl=0;

                while($cnt_dias<=$ndias[$mes]) {
                    $temp_ln=$temp_ln."<tr>"; //Cria uma linha da tabela do m�s atual
                    for($d=0;$d<7 && $cnt_dias<=$ndias[$mes];$d++) {
                        if($d>=$dia || $dia==0) {
                            $classe="";
                            $maux=$mes+1;

                            $classe = $this->verificaDia($maux,$cnt_dias,$ndias);
                            //Cria a c�lula referente ao dia atual
                            $temp_ln=$temp_ln."<td class='".$classe."'>
                                            ".$this->getDia($maux,$cnt_dias)."
                                              </td>";
                            $cnt_dias++;
                            $daux++;
                            if($daux>6) $daux=0;
                        }
                        else $temp_ln=$temp_ln."<td>&nbsp</td>";
                    }
                    $nl++;
                    $temp_ln=$temp_ln."</tr>";
                    $dia=0;
                }
//                if($nl==5) $temp_ln=$temp_ln."<tr><td colspan=7>&nbsp;</td></tr>";
                $temp_tb=$temp_tb.$temp_ln;

                $k=$mes-($mes);
                if(count($this->rodapes)>0) //Gera um rodap� para a tabela de m�s
                {
                    $temp_tb=$temp_tb."<tr><td colspan=7 class='rodape'>".$this->rodapes[$k]."</td></tr></table><br></td>";
                }
                else $temp_tb=$temp_tb."</table></td>";

                $tabela=$tabela.$temp_tb;
                $dia=$daux;
                $mes++; //Passa para o pr�ximo m�s
            }
//            $tabela.="</tr>";
        }

        if(count($this->leg)>1) {
            $legenda="<table class=table><tr><td class='cabecalho' colspan=2>Legenda</td></tr>";
            for($i=1;$i<=$nq;$i++)
                $legenda=$legenda."<tr><td class='td_marcado".$i."'>&nbsp;</td><td class='td_leg'>".$leg[$i-1]."</td></tr>";
            $tabela.=$legenda."</table>";
        }
//        $tabela.="</table>";

        return($tabela);
    }

    //A rotina abaixo verifica se o dia atual � um feriado ou um dia marcado
    //onde $datas cont�m os dois vetores $feriados e $marcados
    private function verificaDia($mes,$dia) {
        foreach($this->datas as $i=>$meses) {
            if(isset ($this->datas[$i][$mes][$dia])) {
                return "td_marcado".($i+1);
            }
        }
        return "td_marcado0";

    }

    private function getDia($mes,$dia){
        $str = '';
        foreach($this->datas as $i=>$meses) {
            if(isset ($this->datas[$i][$mes][$dia])) {
                $link = (isset($this->datas[$i][$mes][$dia]->link))?$this->datas[$i][$mes][$dia]->link:'#';
                $title= ($this->datas[$i][$mes][$dia]->desc!="")?'title="'.$this->datas[$i][$mes][$dia]->desc.'"':"";
                $str='<a href="'.$link.'" '.$title.'>'.$dia.'</a>';
            }
        }
        if($str=='') $str = $dia;
        return $str;
    }

    static public function getProxMes($mes){
        if($mes>=12) return 1;
        elseif($mes>=1) return $mes+1;
        else return 1;
    }

    static public function getAntMes($mes){
        if($mes<=1) return 12;
        elseif($mes<=12) return $mes-1;
        else return 1;
    }

    static public function getAntAnoMes($mes,$ano){
        if($mes<=1) return (int)$ano-1;
        elseif($mes>1 && $mes<=12) return $ano;
        else return $ano;
    }

    static public function getProxAnoMes($mes,$ano){
        if($mes>=12) return $ano+1;
        elseif($mes>=1 && $mes<12) return $ano;
        else return $ano;
    }
}
?>