<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model que manipulada os dados do menu 'alterar contrato'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
include_once APPPATH . '/models/tabelas/tabela_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_fornecedor.php';
include_once APPPATH . '/models/tabelas/tabela_entrada.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_item_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_tipo.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Alterar_Contrato extends CI_Model
{
    /**
     * Atualiza os dados de um contrato.
     *
     * @param $id_contrato Id do contrato.
     * @param $codigo Códgio do contrato.
     * @param $data_inicio Data de inicio do contrato (período de vigência.)
     * @param $data_fim Data de fim do contrato (período de vigência.)
     * @param $id_fornecedor Id do fornecedor do contrato.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_contrato($id_contrato, $codigo, $data_inicio, $data_fim, $id_fornecedor)
    {
        $sql = ' UPDATE '
            . Tabela::CONTRATO
            . ' SET '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' = ?, '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_INICIO . ' = ?, '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ' = ? , '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR . ' = ? '
            . ' WHERE '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ?';

        $this->db->query($sql, array($codigo, $data_inicio, $data_fim, $id_fornecedor, $id_contrato));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Atualiza um item do contrato.
     *
     * @param $id_item_contrato Id do item do contrato.
     * @return bool Retorna verdadeiro caso a atualização tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function atualizar_item_contrato($id_item_contrato, $id_item, $quantidade, $valor)
    {
        $sql = ' UPDATE '
            . Tabela::ITEM_CONTRATO
            . ' SET '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . ' = ?, '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE . ' = ?, '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' = ? '
            . ' WHERE '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ?';

        $this->db->query($sql, array($id_item, $quantidade, $valor, $id_item_contrato));

        if ($this->db->affected_rows()) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Checa se um contrato existe.
     *
     * @param $id_icontrato Id do contrato.
     * @return bool Retorna verdadeiro caso o contrato exista, se não retorna falso.
     */
    public function checar_contrato($id_contrato)
    {
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO
            . ' FROM '
            . Tabela::CONTRATO
            . ' WHERE '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ?';

        $resultado = $this->db->query($sql, array($id_contrato));

        if ($resultado->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Checa se um item do contrato existe.
     *
     * @param $id_item_contrato Id do item do contrato.
     * @return bool Retorna verdadeiro caso o item do contrato exista, se não retorna falso.
     */
    public function checar_item_contrato($id_item_contrato)
    {
        $sql = ' SELECT '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
            . ' FROM '
            . Tabela::ITEM_CONTRATO
            . ' WHERE '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ?';

        $resultado = $this->db->query($sql, array($id_item_contrato));

        if ($resultado->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Exclui um contrato do banco de dados.
     *
     * @param $id_contrato Id do contrato.
     * @return bool Retorna verdadeiro caso a exclusão tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function excluir_contrato($id_contrato)
    {

        $this->db->where('id_contrato', $id_contrato);
        $test = $this->db->get('item_contrato');


        $sql = ' DELETE FROM '
            . Tabela::CONTRATO
            . ' WHERE '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ?';

        if (empty($test->result_array())) {
            $this->db->query($sql, array($id_contrato));
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Exclui um item do contrato do banco de dados.
     *
     * @param $id_item_contrato Id do item do contrato.
     * @return bool Retorna verdadeiro caso a exclusão tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function excluir_item_contrato($id_item_contrato)
    {

      $this->db->where('id_item_contrato', $id_item_contrato);
      $test = $this->db->get('entrada');

        $sql = ' DELETE FROM '
            . Tabela::ITEM_CONTRATO
            . ' WHERE '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ?';

        if (empty($test->result_array())) {
            $this->db->query($sql, array($id_item_contrato));
            return TRUE;
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê os dados de um contrato.
     *
     * @param $id_contrato Id do contrato.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_contrato($id_contrato)
    {
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ', '
            . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_INICIO . ', "%d/%m/%Y") AS data_inicio, '
            . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%d/%m/%Y") AS data_fim, '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ', '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME . ' AS nome_fornecedor '
            . ' FROM '
            . Tabela::CONTRATO
            . ' INNER JOIN '
            . Tabela::FORNECEDOR
            . ' ON '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' WHERE '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ' = ? ';

        $resultado = $this->db->query($sql, array($id_contrato));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os contratos ordenando-os de acordo com a data de fim.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_contratos()
    {
        $sql = ' SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ', '
            . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_INICIO . ', "%d/%m/%y") AS data_inicio, '
            . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%d/%m/%y") AS data_fim, '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME . ' AS nome_fornecedor '
            . ' FROM '
            . Tabela::CONTRATO
            . ' INNER JOIN '
            . Tabela::FORNECEDOR
            . ' ON '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
            . ' ORDER BY '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM
            . ' DESC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

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
            . Tabela::ITEM . ' . ' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::ID_TIPO . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::NOME . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::QUANTIDADE_TOTAL . ', '
            . Tabela::ITEM . ' . ' . Tabela_Item::UNIDADE_PADRAO_ID
            . ' FROM '
            . Tabela::ITEM
            . ' ORDER BY ' . Tabela::ITEM . ' . ' . Tabela_Item::NOME . ' ASC ';
        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
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
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME
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

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê um item do contrato no banco de dados.
     *
     * @param $id_item_contrato Id do item do contrato.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_item_contrato($id_item_contrato)
    {
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . '.' . Tabela_Item::ID_TIPO . ', '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ' AS nome_tipo '
            . ' FROM '
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
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ' = ?';

        $resultado = $this->db->query($sql, array($id_item_contrato));

        if ($resultado) {
            return $resultado->row_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê todos os itens de um contrato.
     *
     * @param $id_contrato Id do contrato.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_itens_contrato($id_contrato)
    {
        $sql = ' SELECT '
            . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ', '
            . Tabela::ITEM . '.' . Tabela_Item::NOME . ' AS nome_item, '
            . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE . ', '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::ID_TIPO . ', '
            . Tabela::TIPO . '.' . Tabela_Tipo::NOME . ' AS nome_tipo '
            . ' FROM '
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
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ' = ? ';

        $resultado = $this->db->query($sql, array($id_contrato));

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Lê a quantidade de itens cadastrados na entrada.
     *
     * @param $id_item_contrato ID do item do contrato.
     * @return bool Retorna a quantidade de itens cadastradas na entrada para um item do contrato, se não retorna zero.
     */
    public function ler_quantidade_entrada_item($id_item_contrato)
    {
        $sql = ' SELECT '
            . ' SUM(' . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ') AS quantidade'
            . ' FROM '
            . Tabela::ENTRADA
            . ' WHERE '
            . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO . ' = ?';

        $resultado = $this->db->query($sql, array($id_item_contrato));

        if ($resultado) {
            $formatar = $resultado->row_array();

            return $formatar['quantidade'];
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
            . Tabela::TIPO . ' . ' . Tabela_Tipo::ID_TIPO . ', '
            . Tabela::TIPO . ' . ' . Tabela_Tipo::NOME
            . ' FROM '
            . Tabela::TIPO
            . ' ORDER BY '
            . Tabela::TIPO . ' . ' . Tabela_Tipo::NOME
            . ' ASC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }
}

/* Fim do arquivo model_alterar_contrato.php */
/* Localização: ./application/models/painel_editar/configuracoes/model_alterar_contrato.php */
