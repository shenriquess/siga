<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Model do menu de relatórios 'Balanço de Contratos'.
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
include_once APPPATH . '/models/tabelas/tabela.php';

class Model_Balanco_Contratos extends CI_Model
{
    /**
     * Retorna periodo final de vigência dos contratos.
     *
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_anos_contratos()
    {
        $sql = ' SELECT '
            . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%Y") AS anos_contratos '
            . ' FROM '
            . Tabela::CONTRATO
            . ' GROUP BY '
            . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%Y") '
            . ' ORDER BY '
            . ' DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%Y") '
            . ' DESC ';

        $resultado = $this->db->query($sql);

        if ($resultado) {
            return $resultado->result_array();
        }

        return FALSE;
    }

    /**
     * Retorna o fornecedor com seu respectivo número de contrato, listando os contratatos válidos
     * de acordo com a data final do ano de vigência escolhido.
     *
     * campos:
     * - fornecedor
     * - codigo
     *
     * @param $ano_fim Ano final da vigência do contrato.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_fornecedor_contrato($ano_fim)
    {
        if ($ano_fim !== NULL) {
            // Selecionar todos os contratos.
            if ($ano_fim == 0) {
                $sql = 'SELECT '
                    . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME . ' AS fornecedor, '
                    . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO
                    . ' FROM '
                    . Tabela::FORNECEDOR . ', '
                    . Tabela::CONTRATO
                    . ' WHERE '
                    . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR . ' = ' . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR;

                $resultado = $this->db->query($sql, array($ano_fim));
            } // Selecionar contratos com a data de final de vigência do ano escolhido.
            else {
                $sql = 'SELECT '
                    . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME . ' AS fornecedor, '
                    . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO
                    . ' FROM '
                    . Tabela::FORNECEDOR . ', '
                    . Tabela::CONTRATO
                    . ' WHERE '
                    . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR . ' = ' . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR
                    . ' AND '
                    . 'DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%Y") = ?';

                $resultado = $this->db->query($sql, array($ano_fim));
            }

            if ($resultado->num_rows() > 0) {
                return $resultado->result_array();
            }
        }

        return FALSE;
    }

    /**
     * Retorna os dados de um contrato (nome, codigo, data_inicio, data_fim).
     *
     * Campos:
     * - nome
     * - codigo
     * - data_inicio (formato dd/mm/aaaa)
     * - data_fim (formato dd/mm/aaaa)
     *
     * @param $codigo_contrato Código do contrato.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_contrato($codigo_contrato)
    {
        if ($codigo_contrato != NULL) {
            // SQL Query
            $sql = ' SELECT '
                . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::NOME . ', '
                . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ', '
                . 'DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_INICIO . ', "%d/%m/%Y") AS ' . Tabela_Contrato::DATA_INICIO . ', '
                . 'DATE_FORMAT(' . Tabela::CONTRATO . '.' . Tabela_Contrato::DATA_FIM . ', "%d/%m/%Y") AS ' . Tabela_Contrato::DATA_FIM
                . ' FROM '
                . Tabela::FORNECEDOR . ','
                . Tabela::CONTRATO
                . ' WHERE '
                . Tabela::FORNECEDOR . '.' . Tabela_Fornecedor::ID_FORNECEDOR . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_FORNECEDOR
                . ' AND '
                . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' = ?';

            $resultado = $this->db->query($sql, array($codigo_contrato));

            if ($resultado->num_rows() > 0) {
                $linha = $resultado->result_array();

                return $linha[0];
            }
        }

        return FALSE;
    }

    /**
     * Retorna os itens de um contrato com os campos (nome do item, quantidade contratada, valor unitário e
     * quantidade entregue).
     *
     * campos:
     * - nome
     * - unidade_padrao_id
     * - valor
     * - quantidade_entregue
     *
     * @param $codigo_contrato Código do contrato a ser analisado.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_itens_contrato($codigo_contrato)
    {
        if ($codigo_contrato != NULL) {
            // SQL Query
            // Caso a quantidade das entradas seja null, é setado 0.
            $sql_quantidade_entrada = ' IFNULL(( SELECT SUM(' . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ') '
                . ' FROM '
                . Tabela::ENTRADA
                . ' WHERE '
                . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
                . '), 0)';

            // SQL Query
            $sql = 'SELECT '
                . Tabela::ITEM . '.' . Tabela_Item::NOME . ', '
                . Tabela::ITEM . '.' . Tabela_Item::UNIDADE_PADRAO_ID . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE . ', '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ', '
                . $sql_quantidade_entrada . ' AS quantidade_entregue '
                . ' FROM '
                . Tabela::ITEM . ', '
                . Tabela::ITEM_CONTRATO . ', '
                . Tabela::CONTRATO
                . ' WHERE '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO
                . ' AND '
                . Tabela::ITEM . '.' . Tabela_Item::ID_ITEM . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM
                . ' AND '
                . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' = ?'
                . ' ORDER BY '
                . Tabela::ITEM . '.' . Tabela_Item::NOME
                . ' ASC ';

            $resultado = $this->db->query($sql, array($codigo_contrato));

            if ($resultado->num_rows() > 0) {
                return $resultado->result_array();
            }
        }

        return FALSE;
    }


    /**
     * Lê o valor total de um contrato.
     *
     * Campos:
     * - valor_total
     *
     * @param $id_contrato ID do Contrato.
     * @return bool|array Caso houve algum resultado retorna ele, se não retorna falso.
     */
    public function ler_valor_total_contrato($codigo_contrato)
    {
        if ($codigo_contrato != NULL) {
            $sql = 'SELECT '
                . ' SUM( IFNULL(' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' * ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::QUANTIDADE . ', 0)) AS valor_total_contrato '
                . ' FROM '
                . Tabela::ITEM_CONTRATO . ', '
                . Tabela::CONTRATO
                . ' WHERE '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO
                . ' AND '
                . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' = ?';

            $resultado = $this->db->query($sql, array($codigo_contrato));

            if ($resultado->num_rows() > 0) {
                $formatar = $resultado->row_array();

                return $formatar['valor_total_contrato'];
            }
        }

        return FALSE;
    }

    public function ler_valor_total_entregue($codigo_contrato)
    {
        if ($codigo_contrato != NULL) {
            $sql = 'SELECT '
                . 'IFNULL(SUM(IFNULL(' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::VALOR . ' * ' . Tabela::ENTRADA . '.' . Tabela_Entrada::QUANTIDADE . ', 0)), 0) AS valor_total_entrada '
                . ' FROM '
                . Tabela::CONTRATO . ', '
                . Tabela::ENTRADA . ', '
                . Tabela::ITEM_CONTRATO
                . ' WHERE '
                . Tabela::ENTRADA . '.' . Tabela_Entrada::ID_ITEM_CONTRATO . ' = ' . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_ITEM_CONTRATO
                . ' AND '
                . Tabela::ITEM_CONTRATO . '.' . Tabela_Item_Contrato::ID_CONTRATO . ' = ' . Tabela::CONTRATO . '.' . Tabela_Contrato::ID_CONTRATO
                . ' AND '
                . Tabela::CONTRATO . '.' . Tabela_Contrato::CODIGO . ' = ?';

            $resultado = $this->db->query($sql, array($codigo_contrato));

            if ($resultado->num_rows() > 0) {
                $formatar = $resultado->row_array();

                return $formatar['valor_total_entrada'];
            }
        }

        return FALSE;
    }
}

/* Fim do arquivo: model_balanco_contratos.php */
/* Localização: ./application/models/painel/relatorio/model_balanco_contratos.php */