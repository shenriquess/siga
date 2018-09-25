<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado no menu 'Cadastrar Destino'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH.'/models/tabelas/tabela_destino.php';
include_once APPPATH.'/models/tabelas/tabela.php';

class Model_Cadastrar_Destino extends CI_Model
{
    /**
     * Insere um destino no banco de dados.
     *
     * @param string $nome Nome do destino.
     * @param string $descricao Descrição do destino.
     * @return bool|int       Caso ocorra com sucesos a inserção, retorna o ID da linha
     *                        inserida e falso caso houve algum problema no momento da inserção.
     */
    public function inserir_destino($nome, $descricao)
    {
        if ($nome != NULL) {
            $sql = 'INSERT INTO ' . Tabela::DESTINO
                . '(' . Tabela_Destino::NOME . ', ' . Tabela_Destino::DESCRICAO . ') '
                . 'VALUES (?, ?)';
            $this->db->query($sql, array($nome, $descricao));

            // Verificando se ocorreu inserção com sucesso.
            if($this->db->affected_rows()) {
                return $this->db->insert_id();
            }
        }

        return false;
    }
}

/* Fim do arquivo model_cadastrar_destino.php */
/* Localização: ./application/models/model_cadastrar_destino.php */