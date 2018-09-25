<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipula os dados da tabela entrada.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH . '/models/tabelas/tabela_destino.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_item_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_saida.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela_contrato.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Inserir_Saida extends CI_Model
{
    /**
     * Lê os dados de um saída.
     *
     * @param $id_saida Id da saída.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_dado_saida($id_saida)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ', '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_DESTINO . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ' AS nome_tipo, '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::SAIDA . '.' . Tabela_Saida::QUANTIDADE . ', '
            . Tabela::SAIDA . '.' . Tabela_Saida::DATA . ', '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID
            . ' FROM '
            . Tabela::SAIDA
            . ' INNER JOIN '
            . Tabela::ITEM
            . ' ON '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::SAIDA . '.' . Tabela_Saida::ID_ITEM
            . ' INNER JOIN '
            . Tabela::TIPO
            . ' ON '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ' . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO
            . ' WHERE '
            . Tabela::SAIDA . '.' . Tabela_Saida::ID_SAIDA . ' = ?';

        $resultado = $this->db->query($sql, array($id_saida));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o nome de um destino no banco de dados.
     *
     * @param $id_destino Id do destino.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_destino($id_destino)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::DESTINO . '.' . Tabela_Destino::NOME
            . ' FROM '
            . Tabela::DESTINO
            . ' WHERE '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ?';

        $resultado = $this->db->query($sql, array($id_destino));

        if ($resultado) {
            return $resultado->row_array();
        }
        echo $sql;
        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os itens cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_itens()
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ', '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ', '
            . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . ', '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID
            . ' FROM '
            . Tabela::ITEM
            . ' ORDER BY ' . Tabela::ITEM . '.' . Tabela_Item::NOME . ' ASC ';
        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }


    public function ler_item_contratos()
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO
            . ' FROM '
            . Tabela::ITEM_CONTRATO
            . ' INNER JOIN '
            . Tabela::CONTRATO
            . ' ON '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO

            . ' ORDER BY ' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_INICIO . ' DESC ';
        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }
    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os tipos cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_tipos()
    {
        $sql = ' SELECT '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME
            . ' FROM '
            . Tabela::TIPO
            . ' ORDER BY '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME
            . ' ASC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os destinos cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_todos_destinos()
    {
        $sql = ' SELECT '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ', '
            . Tabela::DESTINO . '.' . Tabela_Destino::NOME
            . ' FROM '
            . Tabela::DESTINO
            . ' ORDER BY '
            . Tabela::DESTINO . '.' . Tabela_Destino::NOME
            . ' ASC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }
}

/* Fim do arquivo model_inserir_saida.php */
/* Localização: ./application/models/painel/saida/model_inserir_saida.php */
