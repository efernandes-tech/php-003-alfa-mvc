<?php

class ProdutoController extends Controller
{
    public function Index() {
        $this->Listar();
    }

    public function Listar() {
        // Somente para usuários logados.
        $this->RestringeAcesso();

        $this->InicializaView("produto_listar.htm");

        $pro = new ProdutoModel();

        $pro->CarregarTodas();

        $this->tpl->assign("total", $pro->TotalLidas);

        for($i=0; $i < $pro->TotalLidas; $i++) {
            $pro->Ler($i);

            $this->tpl->newBlock("item");

            $this->tpl->assign("id", $pro->Id);
            $this->tpl->assign("nome", $pro->Nome);
            $this->tpl->assign("preco", $pro->Preco);
            $this->tpl->assign("qtd_estoque", $pro->QtdEstoque);
        }

        if ($pro->TotalLidas==0) {
            $this->tpl->newBlock("semregistros");
        }

        $this->Exibe();
    }

    public function Editar() {
        // Somente para usuários logados.
        $this->RestringeAcesso();

        $this->InicializaView("produto_editar.htm");

        // Inicializa.
        $fabId = 0;
        $linId = 0;
        // Se for edição, carrega produto salvo.
        if (isset($_GET['id'])) {
            $proId = (int)$_GET['id'];

            $pro = new ProdutoModel($proId);

            $this->tpl->gotoBlock('_ROOT');
            $this->tpl->assign('id', $proId);
            $this->tpl->assign('nome', $pro->Nome);
            $this->tpl->assign('descricao', $pro->Descricao);
            $this->tpl->assign('preco', $pro->Preco);
            $this->tpl->assign('peso', $pro->Peso);
            $this->tpl->assign('qtd_estoque', $pro->QtdEstoque);
            $this->tpl->assign('ativo', ($pro->Ativo==1 ? 'checked="checked"' : ""));
            $this->tpl->assign('destaque', ($pro->Destaque==1 ? 'checked="checked"' : ""));
            $fabId = $pro->Fabricante->Id;
            $linId = $pro->Linha->Id;

            if ($pro->Imagem != "") {
                $this->tpl->newBlock('imagem');
                $this->tpl->assign('imagem', $pro->Imagem);
            }
        }

        // Preenche selects.
        $fab = new FabricanteModel();

        $fab->CarregarTodas();

        for($i=0; $i < $fab->TotalLidas; $i++) {
            $fab->Ler($i);
            $this->tpl->newBlock('item-fabricante');
            $this->tpl->assign('id', $fab->Id);
            $this->tpl->assign('nome', $fab->Nome);
            // Se for edição, marca o item selecionado.
            if ($fab->Id==$fabId)
                $this->tpl->assign('sel', 'selected');
        }

        // Preenche selects.
        $lin = new LinhaModel();
        $lin->CarregarTodas();

        for($i=0; $i < $lin->TotalLidas; $i++) {
            $lin->Ler($i);
            $this->tpl->newBlock('item-linha');
            $this->tpl->assign('id', $lin->Id);
            $this->tpl->assign('nome', $lin->Nome);
            // Se for edição, marca o item selecionado.
            if ($lin->Id==$linId)
                $this->tpl->assign('sel', 'selected');
        }

        $this->Exibe();
    }

    public function Salvar() {
        // Somente para usuários logados.
        $this->RestringeAcesso();

        if (isset($_POST['bt_salvar'])) {
            $id = (int)$_POST['id'];
            $mod = new ProdutoModel($id);
            $mod->Nome = $_POST['nome'];
            $mod->Descricao = $_POST['descricao'];
            $mod->Fabricante = new FabricanteModel((int) $_POST['fabricante']);
            $mod->Linha = new LinhaModel((int) $_POST['linha']);
            $mod->QtdEstoque = $this->ConverteParaFloat($_POST['qtd_estoque']);
            $mod->Peso = $this->ConverteParaFloat($_POST['peso']);
            $mod->Preco = $this->ConverteParaFloat($_POST['preco']);
            $mod->Ativo = (isset($_POST['ativo']) ? 1 : 0);
            $mod->Destaque = (isset($_POST['destaque']) ? 1 : 0);
            $up = new Upload('imagem', 'images', false);

            if ($up->ehUpload) {
                $mod->Imagem = $up->Arquivo;
            }

            $mod->Salvar();
        }

        $this->Listar();
    }

    public function Excluir()
    {
        // Somente para usuários logados.
        $this->RestringeAcesso();

        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];
            $mod = new ProdutoModel($id);
            $mod->Excluir();
            $this->Listar();
        }
    }
}

// app/controller/class.ProdutoController.inc.php
