<?

class RoyaltieFixoDAO extends Database
{

    public function listar_franquia($id_empresa)
    {
        $this->sql = "SELECT * FROM vsites_royaltie_fixo WHERE id_empresa = ?";
        $this->values = array($id_empresa);
        return $this->fetch();
    }

    public function atualizar($c)
    {
        $this->sql = "SELECT * FROM vsites_user_empresa WHERE id_empresa = ?";
        $this->values = array($c->id_empresa);
        $dt = $this->fetch();

        $valor = array();

        $SQL = "UPDATE vsites_royaltie_fixo SET ";
        for ($i = 1; $i <= $c->total_mes; $i++) {
            $SQL .= "mes_" . $i . "=?,";
            $mes = 'mes_' . $i;
            $valor[] = $c->$mes;
        }
        $SQL .= "semestre=? WHERE id_empresa=?";
        $semestre = 0;
        if (count($dt) > 0) {
            $semestre = (($dt[0]->sem1 + $dt[0]->sem2 + $dt[0]->sem3) > 0) ? 1 : 0;
        }
        $valor[] = $semestre;
        $valor[] = $c->id_empresa;
        $this->sql = $SQL;
        $this->values = $valor;
        $this->exec();
    }

    /*
     * ADICIONADO POR THAUAN FRUCTUOZO RICARDO
     * DATA: 10/12/2015
     * DESCRIÇÃO: REALIZA A ALTERAÇÃO DAS INFORMAÇÕES COMPLEMENTARES. APENAS UM VALOR DE ROYALTIE.
     * */
    public function altera_royalties_fixo($c)
    {
        $this->sql = "UPDATE vsite_royaltie_fixo_franquiado SET valor = ?, data = ?, alterado_por = ?, observacao = ? WHERE id_empresa =?";
        $this->values = array($c->valor_royalties, date("Y-m-d"), $c->id_usuario, empty($c->observacoes_royalties) ? null : $c->observacoes_royalties, $c->id_empresa);
        return $this->exec();
    }

    /*
     * ADICIONADO POR THAUAN FRUCTUOZO RICARDO
     * DATA: 10/12/2015
     * DESCRIÇÃO: REALIZA A INSERÇÃO DAS INFORMAÇÕES COMPLEMENTARES. APENAS UM VALOR DE ROYALTIE.
     * */
    public function insert_royalties_fixo($c)
    {
        $this->sql = 'INSERT INTO vsite_royaltie_fixo_franquiado
			(id_empresa, valor, data, alterado_por, observacao)
			VALUES (?,?,?,?,?)';
        $this->values = array($c->id_empresa, $c->valor_royalties, date("Y-m-d"), $c->id_usuario, null);
        $this->exec();
    }

    public function lista_royalties_fixo($id_empresa)
    {

        $this->sql = "SELECT
rofi.*,
usus.nome
FROM vsite_royaltie_fixo_franquiado rofi
INNER JOIN vsites_user_usuario usus
ON rofi.alterado_por = usus.id_usuario
WHERE rofi.id_empresa = ?";
        $this->values = array($id_empresa);
        $row = $this->fetch();
        return $row[0];
    }

    public function inserir($c)
    {
        $this->sql = "SELECT * FROM vsites_user_empresa WHERE id_empresa = ?";
        $this->values = array($c->id_empresa);
        $dt = $this->fetch();

        $valor = array();
        $SQL = "INSERT INTO vsites_royaltie_fixo (";
        for ($i = 1; $i <= $c->total_mes; $i++) {
            $SQL .= "mes_" . $i . ",";
            $mes = 'mes_' . $i;
            $valor[] = $c->$mes;
        }
        $SQL .= "id_empresa,semestre) VALUES (";
        for ($i = 1; $i <= $c->total_mes; $i++) {
            $SQL .= "?,";
        }
        $SQL .= "?,?)";
        $semestre = 0;
        if (count($dt) > 0) {
            $semestre = (($dt[0]->sem1 + $dt[0]->sem2 + $dt[0]->sem3) > 0) ? 1 : 0;
        }
        $valor[] = $c->id_empresa;
        $valor[] = $semestre;
        $this->sql = $SQL;
        $this->values = $valor;
        $this->exec();
    }

    public function listar_franquia_royalties($pagina)
    {
        $this->pagina = ($pagina == NULL) ? 1 : $pagina;

        $this->sql = "SELECT
count(*) as total
FROM vsites_user_empresa usem
INNER JOIN vsite_royaltie_fixo_franquiado rofi
ON usem.id_empresa = rofi.id_empresa
WHERE status in ('Ativo', 'Renovação')";
        $cont = $this->fetch();

        $this->total = $cont[0]->total;

        $this->sql = "SELECT
*
FROM vsites_user_empresa usem
INNER JOIN vsite_royaltie_fixo_franquiado rofi
ON usem.id_empresa = rofi.id_empresa
WHERE usem.status in ('Ativo', 'Renovação') and usem.id_empresa!=1 ORDER BY fantasia LIMIT " . $this->getInicio() . "," . $this->maximo . " ";
        return $this->fetch();
    }

    public function gerar_royalties_franquia($id_empresa, $data, $valor_royalties)
    {
        $this->sql = "INSERT INTO vsites_rel_royalties (id_empresa, data, valor_royalties, valor_propaganda, faturamento, despesa, imposto, roy, fixo, roy_rec, fpp_rec) VALUES (?,?,?,0.0,0.0,0.0,0.0,0.0,'',0.0,0.0)";
        $this->values = array($id_empresa, $data, $valor_royalties);
        $this->exec();
    }

    public function royalties_gerados_por_mes($mes, $ano, $id_empresa){
        $this->sql = "SELECT COUNT(*) as qnt FROM vsites_rel_royalties WHERE YEAR(DATA) = ? AND MONTH(DATA) = ? AND ID_EMPRESA = ?";
        $this->values = array($ano, $mes, $id_empresa);
        $row = $this->fetch();
        return $row[0];
    }

    public function seleciona_royalties_gerados_por_id($id_rel_royalties){
        $this->sql = "SELECT * FROM vsites_rel_royalties where id_rel_royalties = ";
        $this->values = array($id_rel_royalties);
        $row = $this->fetch();
        return $row[0];
    }

}

?>