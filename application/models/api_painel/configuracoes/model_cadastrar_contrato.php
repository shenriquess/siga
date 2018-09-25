<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado na API REST do menu 'Cadastrar Contrato'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH . '/models/tabelas/tabela_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_item_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_fornecedor.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Cadastrar_Contrato extends CI_Model
{
    /**
     * Insere um contrato no banco de dados.
     *
     * @param int $id_fornecedor ID do Fornecedor.
     * @param int $codigo Código do Contrato.
     * @param string $data_inicio Data de Início do contrato.
     * @param string $data_fim Data de Fim do Contrato.
     * @return bool|array   Retorna verdadeiro caso a inserção tenha sido realizada com sucesso, e falso
     *                      caso houve algum problema no momento da inserção.
     */
    public function inserir_contrato($id_fornecedor, $codigo, $data_inicio, $data_fim)
    {
        if ($id_fornecedor >= 0 && $codigo != NULL && $data_inicio != NULL && $data_fim != NULL) {
            // SQL Query
            $sql = 'INSERT INTO ' . Tabela::CONTRATO
                . '('
                . Tabela_Contrato::ID_FORNECEDOR . ', '
                . Tabela_Contrato::CODIGO . ', '
                . Tabela_Contrato::DATA_INICIO . ', '
                . Tabela_Contrato::DATA_FIM
                . ') '
                . 'VALUES(?, ?, ?, ?)';
            $this->db->query($sql, array($id_fornecedor, $codigo, $data_inicio, $data_fim));

            // Verificando se ocorreu inserção com sucesso.
            if ($this->db->affected_rows()) {
                return $this->db->insert_id();
            }
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Insere um item do contrato no banco de dados.
     *
     * @param int $id_contrato ID do contrato.
     * @param int $id_item ID do item.
     * @param int $valor Valor do item do contrato.
     * @param int $quantidade Quantidade de itens que serão entregues.
     * @return bool|int       Caso ocorra com sucesos a inserção, retorna o ID da linha
     *                        inserida e falso caso houve algum problema no momento da inserção.
     */
    public function inserir_item_contrato($id_contrato, $id_item, $valor, $quantidade)
    {
        if ($id_contrato > 0 && $id_item > 0 && $valor >= 0 && $quantidade >= 0) {
            // SQL Query
            $sql = 'INSERT INTO ' . Tabela::ITEM_CONTRATO
                . '('
                . Tabela_Item_Contrato::ID_CONTRATO . ', '
                . Tabela_Item_Contrato::ID_ITEM . ', '
                . Tabela_Item_Contrato::VALOR . ', '
                . Tabela_Item_Contrato::QUANTIDADE
                . ') '
                . 'VALUES (?, ?, ?, ?)';
            $this->db->query($sql, array($id_contrato, $id_item, $valor, $quantidade));

            // Verificando se ocorreu inserção com sucesso.
            if ($this->db->affected_rows()) {
                return $this->db->insert_id();
            }
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê os dados de um contrato.
     *
     * @param $codigo_contrato Codigo do Contrato
     * @return bool|array Retorna os dados de um contrato, senão retorna falso.
     */
    public function ler_dados_contrato($codigo_contrato)
    {
        if ($codigo_contrato != NULL) {
            $sql = ' SELECT '
                . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR . ', '
                . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_INICIO . ', "%d/%m/%Y") AS data_inicio, '
                . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%d/%m/%Y") AS data_fim, '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . ', '
                . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ', '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
                . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ' AS nome_tipo, '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE
                . ' FROM '
                . Tabela::CONTRATO . ', '
                . Tabela::ITEM_CONTRATO
                . ' INNER JOIN '
                . Tabela::ITEM
                . ' ON '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
                . ' INNER JOIN '
                . Tabela::TIPO
                . ' ON '
                . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ' = ' . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO
                . ' WHERE '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO
                . ' AND '
                . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' = ?';

            $resultado = $this->db->query($sql, array($codigo_contrato));

            if ($resultado) {
                return $resultado->result_array();
            }
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Verifica se existe um contrato com o mesmo código.
     *
     * @param $codigo_contrato Código do contrato.
     * @return bool Retorna verdadeiro caso o código do contrato exista, senão retorna falso.
     */
    public function ler_id_contrato($codigo_contrato)
    {
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO
            . ' FROM '
            . Tabela::CONTRATO
            . ' WHERE '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' = ?';

        $resultado = $this->db->query($sql, array($codigo_contrato));

        if ($resultado->num_rows() > 0) {
            $formatar = $resultado->row_array();
            return $formatar['id_contrato'];
        }

        return FALSE;
    }
}

/* Fim do arquivo model_cadastrar_contrato.php */
/* Localização: ./application/models/api_painel/configuracoes/model_cadastrar_contrato.php */