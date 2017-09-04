<?php

/**
* Classe mãe para os Controladores.
* Aqui vão as definições comuns a todos os controladores.
* @author edersonlrf
*
*/
class Controller
{
    public $tpl;

    /**
    * Inicializa a VIEW do Controlador.
    * @param string $master Nome da Master Page.
    * @param string $include Nome do include block se houver.
    */
    public function InicializaView($include = "", $master = "master.html") {
        $this->tpl = new TemplatePower("app/view/$master");

        if ($include != "") {
            $this->tpl->assignInclude("conteudo", "app/view/$include");
        }

        $this->tpl->prepare();

        if (isset($_SESSION['logado'])) {
            $this->tpl->newBlock('menu-logado');
        } else {
            $this->tpl->newBlock('menu-login');
        }

        if (isset($_SESSION['mensagem'])) {
            $this->tpl->newBlock('mensagem');
            $this->tpl->assign('mensagem', $_SESSION['mensagem']);
            unset($_SESSION['mensagem']);
        }
    }

    /**
    * Responsável por exibir a VIEW.
    */
    public function Exibe() {
        $this->tpl->printToScreen();
    }

    /**
    * Restringe o acesso, se o usuário não estiver logado,
    * exibe a tela de login e suspende a execução do restante do programa.
    */
    public function RestringeAcesso() {
        if (!isset($_SESSION['logado'])) {
            $log = new LoginController();

            $log->Index();

            exit;
        }
    }

    /**
    * Converte um valor no formato '1.234,56' em FLOAT.
    * @param string $valor
    */
    public function ConverteParaFloat($valor) {
        // Supondo que a entrada seja: 3.400,25
        // Remove o ponto: 3400,25
        $nro = str_replace('.', '', $valor);

        // Troca a virgula por ponto: 3400.25
        $nro = str_replace(',', '.', $nro);

        // Converte para float.
        $nro = (float) $valor;

        return $nro;
    }

    /**
    * Converte um float em uma string no formato '1.234,56'.
    * @param float $valor Valor a ser convertido.
    * @param int $casas decimais.
    */
    public function FormataNumero($valor, $casas=2) {
        return number_format($valor, $casas, ',', '.');
    }
}

// system/class.Controller.inc.php
