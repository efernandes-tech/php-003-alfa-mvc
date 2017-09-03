<?php

class LoginModel extends Model
{
    public function Validar($usu, $sen) {
        $usu = addslashes($usu);
        $sen = md5($sen);

        $sql = " SELECT * FROM usuario WHERE login='$usu' AND senha='$sen' ";

        $c = new Consulta($sql, $this->bd);

        if ($c->Linhas()>0) {
            return true;
        }

        return false;
    }

    public function CarregarId($id) {
        // ...
    }
}

// app/model/class.LoginModel.inc.php
