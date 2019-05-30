<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'alterar destino'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_destino.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Alterar_Destino extends CI_Model
{
    /**
     * Atualiza os dados de um destino cadastrado no banco de dados.
     *
     * @param $id_destino Id do destino.
     * @param $nome Nome do destino.
     * @param $descricao Descricao do destino.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_destino($id_destino, $nome, $descricao)
    {
        $sql = ' UPDATE '
            . Tabela::DESTINO
            . ' SET '
            . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ' = ?, '
            . Tabela::DESTINO . '.' . Tabela_Destino::DESCRICAO . ' = ? '
            . ' WHERE '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ?';

        $this->db->query($sql, array($nome, $descricao, $id_destino));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Checa se um destino existe.
     *
     * @param $id_destino Id do destino.
     * @return bool Retorna verdadeiro caso o destino exista, se não retorna falso.
     */
    public function checar_destino($id_destino)
    {
        $sql = ' SELECT '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO
            . ' FROM '
            . Tabela::DESTINO
            . ' WHERE '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ? ';

        $resultado = $this->db->query($sql, array($id_destino));

        if ($resultado->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Delete ou exclui um destino cadastrado no banco de dados.
     *
     * @param $id_destino ID do destino.
     * @return bool Retorna verdadeiro caso a exclusão tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function excluir_destino($id_destino)
    {
        $this->db->where('id_destino', $id_destino);
        $test = $this->db->get('saida');

        $sql = ' DELETE FROM '
            . Tabela::DESTINO
            . ' WHERE '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ?';

        if (empty($test->result_array())) {
          $this->db->query($sql, array($id_destino));
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de um destino cadastrado no banco de dados.
     *
     * @param $id_destino Id do destino.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_destino($id_destino)
    {
        $sql = ' SELECT '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ', '
            . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', '
            . Tabela::DESTINO . '.' . Tabela_Destino::DESCRICAO
            . ' FROM '
            . Tabela::DESTINO
            . ' WHERE '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ' = ? ';

        $resultado = $this->db->query($sql, array($id_destino));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna os dados de todos os destinos cadastrados no banco de dados.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_destinos()
    {
        $sql = ' SELECT '
            . Tabela::DESTINO . '.' . Tabela_Destino::ID_DESTINO . ', '
            . Tabela::DESTINO . '.' . Tabela_Destino::NOME . ', '
            . Tabela::DESTINO . '.' . Tabela_Destino::DESCRICAO
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

/* Fim do arquivo model_alterar_destino.php */
/* Localização: ./application/models/painel_editar/configuracoes/model_alterar_destino.php */
