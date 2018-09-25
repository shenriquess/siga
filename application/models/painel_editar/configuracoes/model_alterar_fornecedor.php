<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'alterar fornecedor'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_fornecedor.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Alterar_Fornecedor extends CI_Model
{
    /**
     * Atualiza os dados de um fornecedor cadastrado no banco de dados.
     *
     * @param $id_fornecedor Id do fornecedor.
     * @param $nome Nome do fornecedor.
     * @param $descricao Descricao do fornecedor.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_fornecedor($id_fornecedor, $nome, $descricao)
    {
        $sql = ' UPDATE '
            . Tabela::FORNECEDOR
            . ' SET '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME . ' = ?, '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::DESCRICAO . ' = ? '
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ?';

        $this->db->query($sql, array($nome, $descricao, $id_fornecedor));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Checa se um fornecedor existe.
     *
     * @param $id_fornecedor Id do fornecedor.
     * @return bool Retorna verdadeiro caso o fornecedor exista, se não retorna falso.
     */
    public function checar_fornecedor($id_fornecedor)
    {
        $sql = ' SELECT '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR
            . ' FROM '
            . Tabela::FORNECEDOR
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ? ';

        $resultado = $this->db->query($sql, array($id_fornecedor));

        if ($resultado->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Delete ou exclui um fornecedor cadastrado no banco de dados.
     *
     * @param $id_fornecedor ID do fornecedor.
     * @return bool Retorna verdadeiro caso a exclusão tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function excluir_fornecedor($id_fornecedor)
    {
        $sql = ' DELETE FROM '
            . Tabela::FORNECEDOR
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ?';

        if ($this->db->query($sql, array($id_fornecedor))) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de um fornecedor cadastrado no banco de dados.
     *
     * @param $id_fornecedor Id do fornecedor.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_fornecedor($id_fornecedor)
    {
        $sql = ' SELECT '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ', '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME . ', '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::DESCRICAO
            . ' FROM '
            . Tabela::FORNECEDOR
            . ' WHERE '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ? ';

        $resultado = $this->db->query($sql, array($id_fornecedor));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de todos os fornecedores cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_fornecedores()
    {
        $sql = ' SELECT '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ', '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME . ', '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::DESCRICAO
            . ' FROM '
            . Tabela::FORNECEDOR
            . ' ORDER BY '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME
            . ' ASC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }
}

/* Fim do arquivo model_alterar_fornecedor.php */
/* Localização: ./application/models/painel_editar/configuracoes/model_alterar_fornecedor.php */