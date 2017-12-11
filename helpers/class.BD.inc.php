<?php

class BD
{
    public $Servidor;
    public $Usuario;
    public $Link;
    public $Banco;
    public $Charset;

    // Para iniciar automaticamente meu objeto com a conexão aberta.
    public function __construct($servidor, $usuario, $senha, $banco, $charset) {
        $this->Abrir($servidor, $usuario, $senha, $banco, $charset);
    }

    // Para encerrar a conexão ao banco.
    public function __destruct()
    {
        $this->Fechar();
    }

    public function Abrir($servidor, $usuario, $senha, $banco, $charset) {
        // Conecta ao servidor.
        $this->Link = mysqli_connect($servidor, $usuario, $senha, $banco) or die(
            "Não foi possível conectar ao servidor " . $servidor
            . " com o usuario " . $usuario . " e senha *****.<br>".
            "Erro: " . mysqli_error($this->Link)
        );

        // Seleciona o banco de dados.
        mysqli_select_db($this->Link, $banco) or die(
            "Não foi possível abrir o banco " . $banco
            . " no servidor " . $servidor . "<br>" . mysqli_error($this->Link)
        );

        // Acerta o cjto de caracteres da conexão:
        // utf8 (UTF-8), latin1 (ISO-5589-1/europeu ocidental)
        mysqli_set_charset($this->Link, $charset);

        $this->Servidor = $servidor;
        $this->Usuario = $usuario;
        $this->Banco = $banco;
        $this->Charset = $charset;
    }

    public function Fechar() {
        if ($this->Link!=null) {
            @mysqli_close($this->Link);

            $this->Link = null;
        }
    }
}

class Consulta
{
    public $resultado;
    public $BD;

    public function __construct($sql, $bd) {
        if (!$bd->Link) {
            $bd->Abrir();

            die("entrou");
        }

        $this->resultado = mysqli_query($bd->Link, $sql);

        if ($this->resultado) {
            // Comando executado com sucesso.
        } else {
            die("Erro ao executar comando " . $sql . "<br>" . mysqli_error($this->Link));
        }

        $this->BD = $bd;
    }

    // Retorna a quantidade de registros resultante do comando SQL.
    public function Linhas() {
        return mysqli_num_rows($this->resultado);
    }

    // Retorna um valor de um campo específico.
    // Ex.: $obj->Campo(0, 'titulo')
    public function Campo($linha, $campo) {
        $this->resultado->data_seek($linha);
        $data = $this->resultado->fetch_assoc();
        return $data[$campo];
    }

    public function InsertId() {
        return mysqli_insert_id($this->BD->Link);
    }
}

// helpers/class.BD.inc.php
