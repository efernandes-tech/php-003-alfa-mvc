<?php

abstract class Model
{
    protected $bd;

    public function __construct($id=0) {
        $this->bd = new BD(
            BD_SERVIDOR,
            BD_USUARIO,
            BD_SENHA,
            BD_BANCO,
            BD_CHARSET
        );

        if ($id>0) {
            $this->CarregarId($id);
        }
    }

    public function __destruct() {
        $this->bd->Fechar();
    }

    abstract function CarregarId($id);
}

// system/class.Model.inc.php
