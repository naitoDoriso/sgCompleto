<?php

namespace App\Models;

use CodeIgniter\Model;

class enderecosModel extends Model
{
    protected $table         = 'ENDERECOS';
    protected $primaryKey    = 'ID_ENDERECO';

    protected $allowedFields = ['ID_ENDERECO', 'RUA', 'NUMERO', 'BAIRRO', 'CIDADE', 'CEP'];
    protected $returnType    = 'object';
}