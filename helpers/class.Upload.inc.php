<?php

/**
* Classe para tratamento de Upload de arquivos.
*/
class Upload
{
    // Propridades da classe.
    public $Campo;
    public $Arquivo;
    public $PastaDestino;
    public $Sobrescrever;
    public $ehUpload;
    public $Erro = 0;

    // Extensões aceitas por default para upload.
    public $ExtValidas = array('jpeg', 'jpg', 'jpe', 'gif', 'png');

    /**
    * Construtor da classe.
    * @param string $campo : Nome do campo file que está enviando o arquivo.
    * @param string $pastaDestino : Pasta onde será guardado o arquivo.
    * @param bool $sobrescrever : Sobrescrever o arquivo caso ele já exista.
    * @param array $validos : Array com exensões aceitas para upload.
    */
    public function Upload($campo, $pastaDestino, $sobrescrever, $validos="") {
        // Recebe os parâmetros.
        $this->Campo = $campo;
        $this->PastaDestino = $pastaDestino;
        $this->Sobrescrever = $sobrescrever;
        $this->ehUpload = false;

        if (is_array($validos) && count($validos)>0) {
            $this->ExtValidas = $validos;
        }

        // Trata o upload, verificando se o arquivo foi enviado.
        if (isset($_FILES[$campo])) {
            if ($_FILES[$campo]['error']==UPLOAD_ERR_OK) {
                // Não houve erro de envio, verifica arquivo.
                $this->Arquivo = $_FILES[$campo]['name'];

                if ($this->ehArquivoPermitido($this->Arquivo)) {
                    // A extensão do arquivo é valida.
                    $arqDestino = $pastaDestino . '/' . $this->Arquivo;

                    if (!$sobrescrever) {
                        if (is_file($arqDestino)) {
                            // Renomeia arquivo de destino.
                            $this->Arquivo = uniqid() . '_' . $this->Arquivo;
                            $arqDestino = $pastaDestino . '/' . $this->Arquivo;
                        }
                    }

                    move_uploaded_file($_FILES[$campo]['tmp_name'], $arqDestino);
                }
            } else {
                // O PHP nos informa que algum erro ocorreu.
                $this->Erro = $_FILES[$campo]['error'];
            }
        }
    }

    /**
    * Verifica se o arquivo tem extensã válida.
    * @param string $arquivo : Nome do campo file que está enviando o arquivo.
    */
    function ehArquivoPermitido($arquivo)
    {
        // Separa as partes do nome do arquivo pelo ponto.
        $partes = explode(".", $arquivo);

        // Retorna o valor do último elemento do array gerado.
        $extensao = end($partes);

        if (array_search($extensao, $this->ExtValidas)) {
            // Arquivo OK.
            return true;
        }

        // Arquivo não permitido.
        return false;
    }
}

// helpers/class.Upload.inc.php
