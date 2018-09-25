<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado no menu 'Cadastrar Item'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Cadastrar_Item extends CI_Model
{
    /**
     * Insere um item no banco de dados.
     *
     * @param int $id_tipo ID do tipo.
     * @param string $nome_item Nome do Item.
     * @param int $unidade_padrao_id ID da Unidade Padrão utilizada para o item.
     * @param string $descricao Descrição do fornecedor.
     * @return bool|int       Caso ocorra com sucesos a inserção, retorna o ID da linha
     *                        inserida e falso caso houve algum problema no momento da inserção.
     */
    public function inserir_item($id_tipo, $nome_item, $unidade_padrao_id, $descricao)
    {
        if ($id_tipo >= 0 && $nome_item != NULL && $unidade_padrao_id >= 0) {
            // SQL Query
            $sql = 'INSERT INTO ' . Tabela::ITEM
                . '(' . Tabela_Item::ID_TIPO . ', '
                . Tabela_Item::NOME . ', '
                . Tabela_Item::UNIDADE_PADRAO_ID . ', '
                . Tabela_Item::DESCRICAO . ', '
                . Tabela_Item::QUANTIDADE_TOTAL . ') ' // Sempre insere valor 0 na quantidade.
                . 'VALUES (?, ?, ?, ?, ?)';
            $this->db->query($sql, array($id_tipo, $nome_item, $unidade_padrao_id, $descricao, 0));

            // Verificando se ocorreu inserção com sucesso.
            if ($this->db->affected_rows()) {
                return $this->db->insert_id();
            }
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Pega todos os tipos cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_todos_tipos()
    {
        // Query SQL
        $sql = 'SELECT * FROM ' . Tabela::TIPO
            . ' ORDER BY ' . Tabela_Tipo::NOME . ' ASC ';
        $resultado = $this->db->query($sql);

        if ($resultado->num_rows() > 0) {
            return $resultado->result_array();
        }

        return FALSE;
    }
}

/* Fim do arquivo model_cadastrar_item.php */
/* Localização: ./application/models/painel/configuracoes/model_cadastrar_item.php */
