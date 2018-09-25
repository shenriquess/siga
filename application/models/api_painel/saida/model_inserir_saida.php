<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado na API REST do menu 'Inserir Saída'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH . '/models/tabelas/tabela_destino.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_saida.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Inserir_Saida extends CI_Model
{
    /**
     * Insere um destino no banco de dados.
     *
     * @access public
     * @param string $nome Nome do destino.
     * @param string $descricao Descrição do destino.
     * @return bool|int       Caso ocorra com sucesso a inserção, retorna o ID da linha
     *                        inserida e falso caso houve algum problema no momento da inserção.
     */
    public function inserir_saida($id_destino, $id_item, $id_item_contrato, $id_usuario, $data, $quantidade)
    {
        if ($id_destino > 0 && $id_item > 0 && $id_item_contrato > 0 && $id_usuario >= 0 && $data != NULL && $quantidade > 0) {
            // SQL Query
            $sql = 'INSERT INTO ' . Tabela::SAIDA
                . '( ' . Tabela_Saida::ID_DESTINO
                . ', ' . Tabela_Saida::ID_ITEM
                . ', ' . Tabela_Saida::ID_ITEM_CONTRATO
                . ', ' . Tabela_Saida::ID_USUARIO
                . ', ' . Tabela_Saida::DATA
                . ', ' . Tabela_Saida::QUANTIDADE . ')'
                . ' VALUES '
                . '(?, ?, ?, ?, ?, ?)';
            $this->db->query($sql, array($id_destino, $id_item, $id_item_contrato, $id_usuario, $data, $quantidade));

            if ($this->db->affected_rows()) {
                return $this->db->insert_id();
            }
        }

        return false;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê a quantidade total de um item no banco de dados.
     *
     * @param $id_item Id do item.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_itens()
    {
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ', '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ', '
            . Tabela::ITEM . '.' . Tabela_Item::QUANTIDADE_TOTAL . ', '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID
            . ' FROM '
            . Tabela::ITEM
            . ' ORDER BY '
            . Tabela::ITEM . '.' . Tabela_Item::NOME
            . ' ASC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }
}

/* Fim do arquivo model_inserir_saida.php */
/* Localização: ./application/models/api_painel/saida/model_inserir_saida.php */
