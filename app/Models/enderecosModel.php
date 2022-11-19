<?php

namespace App\Models;

use CodeIgniter\Model;

class enderecosModel extends Model
{
    protected $table         = 'enderecos';
    protected $primaryKey    = 'id_endereco';

    protected $allowedFields = ['id_endereco', 'rua', 'numero', 'bairro', 'cidade', 'cep'];
    protected $returnType    = 'object';
}