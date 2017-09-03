<?php

// Classes base.
require_once 'system/class.Controller.inc.php';
require_once 'system/class.Model.inc.php';
require_once 'system/class.View.inc.php';

// Models.
require_once 'app/model/class.LoginModel.inc.php';
require_once 'app/model/class.ProdutoModel.inc.php';
require_once 'app/model/class.FabricanteModel.inc.php';
require_once 'app/model/class.LinhaModel.inc.php';

// Controllers.
require_once("app/controller/class.IndexController.inc.php");
require_once("app/controller/class.ProdutoController.inc.php");
require_once("app/controller/class.LoginController.inc.php");

// Classes obrigatórias.
require_once 'helpers/class.BD.inc.php';
require_once 'helpers/class.TemplatePower.inc.php';
require_once 'helpers/class.Upload.inc.php';

// Configuração do sistema.
require_once 'system/config.inc.php';

// Controlador e método default.
$classe = "IndexController";
$metodo = "Index";

// Controlador e método que forem informados.
if (isset($_REQUEST['controlador'])) {
    $controlador = $_REQUEST['controlador'];
    $classe = $controlador . 'Controller';

    if (isset($_REQUEST['metodo'])) {
        $metodo = $_REQUEST['metodo'];
    }
}

// Executa o controlador.
$controlador = new $classe();
$controlador->$metodo();

// index.php
