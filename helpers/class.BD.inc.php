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
        $this->Link = mysql_connect($servidor, $usuario, $senha) or die(
            "Não foi possível conectar ao servidor " . $servidor
            . " com o usuario " . $usuario . " e senha *****.<br>".
            "Erro: " . mysql_error()
        );

        // Seleciona o banco de dados.
        mysql_select_db($banco, $this->Link) or die(
            "Não foi possível abrir o banco " . $banco
            . " no servidor " . $servidor . "<br>" . mysql_error()
        );

        // Acerta o cjto de caracteres da conexão:
        // utf8 (UTF-8), latin1 (ISO-5589-1/europeu ocidental)
        mysql_set_charset($charset);

        $this->Servidor = $servidor;
        $this->Usuario = $usuario;
        $this->Banco = $banco;
        $this->Charset = $charset;
    }

    public function Fechar() {
        if ($this->Link!=null) {
            @mysql_close($this->Link);

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

        $this->resultado = mysql_query($sql, $bd->Link);

        if ($this->resultado) {
            // Comando executado com sucesso.
        } else {
            die("Erro ao executar comando " . $sql . "<br>" . mysql_error());
        }

        $this->BD = $bd;
    }

    // Retorna a quantidade de registros resultante do comando SQL.
    public function Linhas() {
        return mysql_num_rows($this->resultado);
    }

    // Retorna um valor de um campo específico.
    // Ex.: $obj->Campo(0, 'titulo')
    public function Campo($linha, $campo) {
        return mysql_result($this->resultado, $linha, $campo);
    }

    public function InsertId() {
        return mysql_insert_id($this->BD->Link);
    }
}

// helpers/class.BD.inc.php
