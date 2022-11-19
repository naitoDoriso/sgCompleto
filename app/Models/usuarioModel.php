<?php

namespace App\Models;

use CodeIgniter\Model;

class usuarioModel extends Model
{
    protected $table            = 'USUARIO';
    protected $primaryKey       = 'LOGIN';

    protected $allowedFields    = ['LOGIN', 'SENHA'];
    protected $returnType       = 'object';

    public function verificarLogin($login, $senha)
    {
        return $this->where('LOGIN', $login)
                    ->where('SENHA', $senha)
                    ->get()
                    ->getResult();
    }
}