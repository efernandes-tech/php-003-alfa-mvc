<?php

class LinhaModel extends Model
{
    public $Id;
    public $Nome;
    public $TotalLidas;
    private $c;

    public function Ler($n) {
        // Limpa.
        $this->Id = null;
        $this->Nome = null;

        if ($n<$this->c->Linhas()) {
            $this->Id = $this->c->Campo($n, 'id');
            $this->Nome = $this->c->Campo($n, 'nome');
        }
    }

    public function CarregarId($id) {
        $id = (int)$id;

        if ($id>0) {
            $sql = " SELECT * FROM linha WHERE id=$id ";

            $this->c = new Consulta($sql, $this->bd);

            if ($this->c->Linhas()>0) {
                $this->TotalLidas=1;
                $this->Ler(0);
            }
        }
    }

    public function CarregarTodas() {
        $sql = " SELECT * FROM linha ORDER BY nome ";

        $this->c = new Consulta($sql, $this->bd);

        $this->TotalLidas = $this->c->Linhas();

        if ($this->c->Linhas()>0) {
            $this->c->Linhas();
            // Lê o primeiro registro.
            $this->Ler(0);
        }
    }
}

// app/model/class.LinhaModel.inc.php
