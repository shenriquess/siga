<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model utilizado no menu 'Inserir Entrada'.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */

include_once APPPATH . '/models/tabelas/tabela_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_entrada.php';
include_once APPPATH . '/models/tabelas/tabela_item.php';
include_once APPPATH . '/models/tabelas/tabela_item_contrato.php';
include_once APPPATH . '/models/tabelas/tabela_fornecedor.php';
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Inserir_Entrada extends CI_Model
{

    /**
     * Pega os contratos com o nome do forneceodr.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_contrato_fornecedor()
    {
        // TODO considerar a data atual.
        // SQL Query
        $sql = 'SELECT '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR . ', '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ', '
            . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_INICIO . ', "%d/%m/%Y") AS data_inicio, '
            . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%d/%m/%Y") AS data_fim, '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME
            . ' FROM '
            . Tabela::CONTRATO . ', '
            . Tabela::FORNECEDOR
            . ' WHERE '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR . '=' . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR
            . ' ORDER BY '
            . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME
            . ' ASC, '
            . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM
            . ' ASC ';
        $resultado = $this->db->query($sql);

        if ($resultado->num_rows() > 0) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Pega todos os itens de todos os contratos
     *
     * @return bool|array Caso houve alguns resultados retornam eles, se não retorna falso.
     */
    public function ler_itens_contratos()
    {
        // TODO considerar data.
        // SQL Query
        $sql = 'SELECT '
            . Tabela_Item_Contrato::ID_ITEM_CONTRATO . ', '
            . Tabela_Item_Contrato::ID_CONTRATO . ', '
            . Tabela_Item::NOME . ', '
            . Tabela_Item::UNIDADE_PADRAO_ID
            . ' FROM '
            . Tabela::ITEM . ', '
            . Tabela::ITEM_CONTRATO
            . ' WHERE '
            . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM . '=' . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM
            . ' ORDER BY '
            . Tabela::ITEM . '.' . Tabela_Item::NOME
            . ' ASC ';
        $resultado = $this->db->query($sql);

        // Verificando a existência de algum resultado.
        if ($resultado->num_rows() > 0) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Verifica a quantidade de itens que restam para completar a quantidade de item contratado.
     *
     * @param int
     * @return bool|int Retorna a quantidade de item que falta para completar o contrato, caso ocorra erros retorna falso.
     */
    public function verifica_quantidade_contrato($id_item_contrato)
    {
        if ($id_item_contrato != 0) {
            // SQL Query 1
            $sql1 = ' SELECT '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE . ' AS quantidade1 '
                . ' FROM '
                . Tabela::ITEM_CONTRATO
                . ' WHERE '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO . '=?';

            $sql2 = ' SELECT '
                . ' SUM(' . Tabela::ENTRADA . ' . ' . Tabela_Entrada::QUANTIDADE . ')  AS quantidade2 '
                . ' FROM '
                . Tabela::ENTRADA
                . ' WHERE '
                . Tabela::ENTRADA . ' . ' . Tabela_Entrada::ID_ITEM_CONTRATO . ' =?';

            $select1 = $this->db->query($sql1, array($id_item_contrato));
            $select2 = $this->db->query($sql2, array($id_item_contrato));

            $resultado1 = $select1->result_array();
            $resultado2 = $select2->result_array();

            $quantidade1 = $resultado1[0]['quantidade1'];
            $quantidade2 = $resultado2[0]['quantidade2'];

            return ($quantidade1 - $quantidade2);
        }

        return FALSE;
    }
}

/* Fim do arquivo model_inserir_entrada.php */
/* Localização: ./application/models/painel/entrada/model_inserir_entrada.php */