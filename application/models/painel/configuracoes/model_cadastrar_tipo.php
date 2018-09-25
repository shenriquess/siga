<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado no menu 'Cadastrar Tipo'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH.'/models/tabelas/tabela_tipo.php';
include_once APPPATH.'/models/tabelas/tabela.php';

class Model_Cadastrar_Tipo extends CI_Model
{
    /**
     * Insere um tipo no banco de dados.
     *
     * @access public
     * @param string $nome Nome do tipo.
     * @param string $descricao Descrição do tipo.
     * @return bool|int       Caso ocorra com sucesos a inserção, retorna o ID da linha
     *                        inserida e falso caso houve algum problema no momento da inserção.
     */
    public function inserir_tipo($nome, $descricao)
    {
        if ($nome != NULL) {
            $sql = 'INSERT INTO '
                . Tabela::TIPO
                . '(' . Tabela_Tipo::NOME . ', ' . Tabela_Tipo::DESCRICAO . ') '
                . 'VALUES (?, ?)';
            $this->db->query($sql, array($nome, $descricao));

            // Verificando se ocorreu inserção com sucesso.
            if ($this->db->affected_rows()) {
                return $this->db->insert_id();
            }
        }

        return FALSE;
    }
}

/* Fim do arquivo model_cadastrar_tipo.php */
/* Localização: ./application/models/painel/configuracoes/model_cadastrar_tipo.php */