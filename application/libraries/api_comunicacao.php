<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Classe para manipular a resposta da API Restfull e realizar
 * algumas verificações.
 *
 * @author rhskiki <rhskiki@gmail.com>
 * @package SiGAv1
 * @since Version 1.0
 */
class Api_Comunicacao
{
    /**
     * Armazena se houve erros na comunicação com a API
     *
     * @var bool
     */
    private $erro;
    /**
     * Mensagem de erro.
     *
     * @var string
     */
    private $erro_mensagem;
    /**
     * Resposta da requisição a API.
     *
     * @var array
     */
    private $resposta;
    /**
     * Caso houve sucesso na comunicação é armazenado true, se não false.
     *
     * @var bool
     */
    private $sucesso;
    /**
     * Mensagem de sucesso.
     *
     * @var string
     */
    private $sucesso_mensagem;

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Atribuindo valores padrões para as variáveis.
     */
    public function __construct()
    {
        $this->erro = FALSE;
        $this->erro_mensagem = NULL;
        $this->resposta = NULL;
        $this->sucesso = FALSE;
        $this->sucesso_mensagem = NULL;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Checa se todos os campos requiridos estão presentes.
     *
     * @param $chavesJson Chaves obrigatórias no JSON da requisão.
     * @param $dados Dados recebidos.
     * @return bool Retorna verdadeiro caso a checagem tenha sido realizada com sucesso,
     *              senão retorna falso.
     */
    public function checarFormatacao($chavesJson, $dados)
    {
        foreach ($chavesJson as $chaveJson) {
            if (!array_key_exists($chaveJson, $dados)) {
                return FALSE;
            }
        }
        return TRUE;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Cria o array de resposta.
     *
     * @return array Retorna o array da resposta da API.
     */
    public function criarArray()
    {
        $jsonArray['erro'] = $this->erro;
        $jsonArray['erro_mensagem'] = $this->erro_mensagem;
        $jsonArray['sucesso'] = $this->sucesso;
        $jsonArray['sucesso_mensagem'] = $this->sucesso_mensagem;
        $jsonArray['resposta'] = $this->resposta;

        return $jsonArray;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna o valor da variável $erro.
     *
     * @return boolean
     */
    public function isErro()
    {
        return $this->erro;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Seta um valor para variável $erro.
     *
     * @param boolean $erro
     */
    public function setErro($erro)
    {
        $this->erro = $erro;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna o valor da variável $erro_mensagem.
     *
     * @return string
     */
    public function getErroMensagem()
    {
        return $this->erro_mensagem;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Seta um valor para variável $erro_mensagem.
     *
     * @param string $erro_mensagem
     */
    public function setErroMensagem($erro_mensagem)
    {
        $this->erro_mensagem = $erro_mensagem;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna o valor da variável $resposta.
     *
     * @return string
     */
    public function getResposta()
    {
        return $this->resposta;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Seta um valor para variável $resposta.
     *
     * @param string $resposta
     */
    public function setResposta($resposta)
    {
        $this->resposta = $resposta;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna o valor da variável $sucesso.
     *
     * @return boolean
     */
    public function isSucesso()
    {
        return $this->sucesso;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Seta um valor para variável $sucesso.
     *
     * @param boolean $sucesso
     */
    public function setSucesso($sucesso)
    {
        $this->sucesso = $sucesso;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Retorna o valor da variável $sucesso_mensagem.
     *
     * @return string
     */
    public function getSucessoMensagem()
    {
        return $this->sucesso_mensagem;
    }

    //------------------------------------------------------------------------------------------------------------------

    /**
     * Seta um valor para variável $sucesso_mensagem.
     *
     * @param string $sucesso_mensagem
     */
    public function setSucessoMensagem($sucesso_mensagem)
    {
        $this->sucesso_mensagem = $sucesso_mensagem;
    }

    //------------------------------------------------------------------------------------------------------------------
}

/* Fim do arquivo api_comunicacao.php */
/* Localização: ./application/library/api_comunicacao.php */