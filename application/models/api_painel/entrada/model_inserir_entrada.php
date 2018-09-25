<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado na API REST do menu 'Inserir Entrada'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH . '/models/tabelas/tabela_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_entrada.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_item_contrato.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Inserir_Entrada extends CI_Model
{
    /**
     * Inseri uma linha na tabela entrada no banco de dados.
     *
     * @param int $id_item_contrato ID do item do contrato.
     * @param int $id_usuario ID do Usuário.
     * @param int $numero_nota Número da nota.
     * @param int $quantidade Quantidade de itens.
     * @param date $data Data da inserção.
     * @param float $valor Valor do item do contrato no momento.
     * @return bool|int       Caso ocorra com sucesos a inserção, retorna o ID da linha
     *                        inserida e falso caso houve algum problema no momento da inserção.
     */
    public function inserir_entrada($id_item_contrato, $id_usuario, $numero_nota, $quantidade, $data, $valor)
    {
        if ($id_item_contrato != 0 && $id_usuario > 0 && $numero_nota != NULL && $quantidade != 0 && $data != NULL) {
            // SQL Query
            $sql = 'INSERT INTO ' . Tabela::ENTRADA
                . '( '
                . Tabela_Entrada::ID_ITEM_CONTRATO . ', '
                . Tabela_Entrada::ID_USUARIO . ', '
                . Tabela_Entrada::NUMERO_NOTA . ', '
                . Tabela_Entrada::QUANTIDADE . ', '
                . Tabela_Entrada::DATA . ', '
                . Tabela_Entrada::VALOR
                . ')'
                . ' VALUES '
                . '(?, ?, ?, ?, ?, ?)';
            $this->db->query($sql, array($id_item_contrato, $id_usuario, $numero_nota, $quantidade, $data, $valor));

            if ($this->db->affected_rows()) {
                return $this->db->insert_id();
            }
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o período do de vigência de um contrato.
     *
     * @param $id_contrato ID do contrato.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_vigencia_contrato($id_contrato)
    {
        // SQL Query
        $sql = ' SELECT '
            . 'DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_INICIO . ', "%d/%m/%Y") AS data_inicio, '
            . 'DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%d/%m/%Y") AS data_fim '
            . ' FROM '
            . Tabela::CONTRATO
            . ' WHERE '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ?';

        $resultado = $this->db->query($sql, array($id_contrato));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê o valor de um item do contrato cadastrado no banco de dados.
     *
     * @param $id_item_contrato ID do item do contrato.
     * @return bool|int Caso houve algum resultado retorna o valor atual do item, se não
     *                  retorna falso.
     */
    public function ler_valor_item_contrato($id_item_contrato)
    {
        // SQL Query
        $sql = ' SELECT '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR
            . ' FROM '
            . Tabela::ITEM_CONTRATO
            . ' WHERE '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ?';

        $resultado = $this->db->query($sql, array($id_item_contrato));

        if ($resultado) {
            $formatar = $resultado->row_array();
            return $formatar['valor'];
        }

        return FALSE;
    }


    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os itens de um contrato.
     *
     * @param $id_contrato Id do contrato
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_itens_contrato($id_contrato)
    {
        if ($id_contrato != NULL) {
            // SQL Query
            // Caso a quantidade das entradas seja null, é setado 0.
            $sql_quantidade_entrada = ' IFNULL(( SELECT SUM(' . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ') '
                . ' FROM '
                . Tabela::ENTRADA
                . ' WHERE '
                . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
                . '), 0)';

            // SQL Query
            $sql = 'SELECT '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ', '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE . ' - ' . $sql_quantidade_entrada . ' AS quantidade_faltante '
                . ' FROM '
                . Tabela::CONTRATO . ', '
                . Tabela::ITEM_CONTRATO
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
                . ' WHERE '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO
                . ' AND '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ' = ?'
                . ' ORDER BY '
                . Tabela::ITEM . '.' . Tabela_Item::NOME
                . ' ASC ';

            $resultado = $this->db->query($sql, array($id_contrato));

            if ($resultado->num_rows() > 0) {
                return $resultado->result_array();
            }
        }

        return FALSE;
    }
}

/* Fim do arquivo model_cadastrar_contrato.php */
/* Localização: ./application/models/api_painel/configuracoes/model_cadastrar_contrato.php */