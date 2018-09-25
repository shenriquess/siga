<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classe que armazenas as medidas padrões e também suas conversões.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Unidades
{
    /**
     * Unidades de medida disponíveis no sistema.
     * Atenção! Deixar os arrays na mesma sequência dos IDs.
     *
     * @var array $unidade_padrao
     */
    private $unidades_padrao = array(
        array('unidade_id' => 0,
              'nome'       => 'Escolha a Unidade'),
        array('unidade_id' => 1,
              'nome'       => 'Caixa(s)'),
        array('unidade_id' => 2,
              'nome'       => 'Kg(s)'),
        array('unidade_id' => 3,
              'nome'       => 'Litro(s)'),
        array('unidade_id' => 4,
              'nome'       => 'Metro(s)'),
        array('unidade_id' => 5,
              'nome'       => 'ML'),
        array('unidade_id' => 6,
              'nome'       => 'Pacote(s)'),
        array('unidade_id' => 7,
              'nome'       => 'Rolo(s)'),
        array('unidade_id' => 8,
              'nome'       => 'Unidade(s)')
    );

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna todas as unidades de medida disponíveis no sistema.
     *
     * @return array Retorna todas as unidades de medida disponíveis no sistema.
     */
    public function ler_unidades_padrao()
    {
        return $this->unidades_padrao;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna uma unidade padrão.
     *
     * @param $id_unidade_padrao ID da unidade padrão.
     * @return retorna os valores de uma unidade padrão.
     */
    public function ler_unidade_padrao($id_unidade_padrao)
    {
        return $this->unidades_padrao[$id_unidade_padrao];
    }
}

/* Fim do arquivo unidades.php */
/* Localização: ./application/libraries/unidades.php */