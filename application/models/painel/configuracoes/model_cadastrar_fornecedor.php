<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado no menu 'Cadastrar Fornecedor'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH.'/models/tabelas/tabela_fornecedor.php';
include_once APPPATH.'/models/tabelas/tabela.php';

class Model_Cadastrar_Fornecedor extends CI_Model
{
    /**
     * Insere um fornecedor no banco de dados.
     *
     * @param string $nome Nome do fornecedor.
     * @param string $descricao Descrição do fornecedor.
     * @return bool|int       Caso ocorra com sucesos a inserção, retorna o ID da linha
     *                        inserida e falso caso houve algum problema no momento da inserção.
     */
    public function inserir_fornecedor($nome, $descricao)
    {
        if ($nome != NULL) {
            // SQL Query
            $sql = 'INSERT INTO ' . Tabela::FORNECEDOR
                . '(' . Tabela_Fornecedor::NOME . ', ' . Tabela_Fornecedor::DESCRICAO . ') '
                . 'VALUES (?, ?)';
            $this->db->query($sql, array($nome, $descricao));

            // Verificando se ocorreu inserção com sucesso.
            if($this->db->affected_rows()) {
                return $this->db->insert_id();
            }
        }

        return FALSE;
    }
}

/* Fim do arquivo model_cadastrar_fornecedor.php */
/* Localização: ./application/models/model_cadastrar_fornecedor.php */

 