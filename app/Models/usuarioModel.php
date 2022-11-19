<?php

namespace App\Models;

use CodeIgniter\Model;

class usuarioModel extends Model
{
    protected $table            = "usuario";
    protected $primaryKey       = "login";

    protected $allowedFields    = ["login", "senha"];
    protected $returnType       = "object";

    public function verificarLogin($login, $senha)
    {
        return $this->where("login", $login)
                    ->where("senha", $senha)
                    ->get()
                    ->getResult();
    }
}