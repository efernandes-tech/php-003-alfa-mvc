<?php

class ProdutoModel extends Model
{
    public $Id;
    public $Nome;
    public $Descricao;
    public $Preco;
    public $Peso;
    public $Destaque;
    public $QtdEstoque;
    public $Fabricante;
    public $Linha;
    public $Imagem;
    public $Ativo;
    public $TotalLidas=0;
    private $c;

    public function Ler($n) {
        if ($n>$this->TotalLidas) {
            return false;
        }

        $this->Id = $this->c->Campo($n, 'id');
        $this->Nome = $this->c->Campo($n, 'nome');
        $this->Descricao = $this->c->Campo($n, 'descricao');
        $this->Preco = $this->c->Campo($n, 'preco');
        $this->Peso= $this->c->Campo($n, 'peso');
        $this->Destaque = $this->c->Campo($n, 'destaque');
        $this->QtdEstoque = $this->c->Campo($n, 'qtd_estoque');
        $this->Imagem = $this->c->Campo($n, 'imagem');
        $this->Ativo = $this->c->Campo($n, 'ativo');
        $fabId = $this->c->Campo($n, 'fabricante_id');
        $this->Fabricante = new FabricanteModel($fabId);
        $linId = $this->c->Campo($n, 'fabricante_id');
        $this->Linha = new LinhaModel($linId);

        return true;
    }

    /**
    * Carrega um registro.
    * @param int $id Id a ser carregado.
    */
    public function CarregarId($id) {
        $id = (int) $id;

        if ($id>0) {
            $sql = " SELECT * FROM produto WHERE id=$id ";

            $this->c = new Consulta($sql, $this->bd);

            if ($this->c->Linhas()>0) {
                $this->TotalLidas=1;
                $this->Ler(0);
            }
        }
    }

    public function CarregarTodas() {
        $sql = " SELECT * FROM produto ORDER BY nome ";

        $this->c = new Consulta($sql, $this->bd);

        if ($this->c->Linhas()>0) {
            // Lê o primeiro registro.
            $this->TotalLidas = $this->c->Linhas();
            $this->Ler(0);
        }
    }

    public function Salvar() {
        $nom = addslashes($this->Nome);
        $des = addslashes($this->Descricao);
        $pre = (float) $this->Preco;
        $pes = (float) $this->Peso;
        $est = (int) $this->QtdEstoque;
        $dtq = (int) $this->Destaque;
        $ati = (int) $this->Ativo;
        $img = addslashes($this->Imagem);
        $fab = (int) $this->Fabricante->Id;
        $lin = (int) $this->Linha->Id;

        if ($this->Id>0) {
            $sql = " UPDATE produto SET "
                . "nome='$nom' , "
                . "descricao='$des' , "
                . "fabricante_id=$fab , "
                . "linha_id=$lin , "
                . "preco=$pre , "
                . "peso=$pes , "
                . "qtd_estoque=$est , "
                . "destaque=$dtq , "
                . "ativo=$ati , "
                . "imagem='$img' "
                . "WHERE id=".$this->Id;
        } else {
            $sql = "
                INSERT INTO produto "
                ."(nome, descricao, fabricante_id, linha_id,
                    preco, peso, qtd_estoque, destaque, ativo, imagem) VALUES "
                . "( '$nom' , '$des' , $fab, $lin, $pre,
                    $pes, $est, $dtq, $ati, '$img' )
            ";
        }

        $c = new Consulta($sql, $this->bd);
    }

    public function Excluir() {
        $id = (int) $this->Id;

        if ($id>0) {
            $sql = " DELETE FROM produto WHERE id=$id ";

            $c = new Consulta($sql, $this->bd);
        }
    }
}

// app/model/class.ProdutoModel.inc.php
