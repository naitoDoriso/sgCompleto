<?php

namespace App\Models;

use CodeIgniter\Model;

class contatoModel extends Model
{
    protected $table         = 'contato';
    protected $primaryKey    = 'id_contato';

    protected $allowedFields = ['id_contato', 'nome', 'data_nasc', 'login', 'imagem'];
    protected $returnType    = 'object';

    public function infoEnderecos($id)
    {
        $db = db_connect();
        return $db->table('contato_endereco')
                  ->where(['id_contato' => $id])
                  ->join('enderecos', 'enderecos.id_endereco = contato_endereco.id_endereco')
                  ->get()
                  ->getResult();
        $db->close();
    }

    public function infoTelefones($id)
    {
        $db = db_connect();
        return $db->table('telefones')
                  ->orderBy('id_contato')
                  ->where(['id_contato' => $id])
                  ->get()
                  ->getResult();
        $db->close();
    }

    public function infoEmails($id)
    {
        $db = db_connect();
        return $db->table('emails')
                  ->orderBy('id_contato', 'desc')
                  ->where(['id_contato' => $id])
                  ->get()
                  ->getResult();
        $db->close();
    }

    public function insertEmail($dados)
    {
        $table = db_connect()->table('emails');

        $dados['id_contato'] = $this->find()[sizeof($this->find())-1]->id_contato;
        return $table->insert($dados);
    }

    public function insertContEnd()
    {
        $table = db_connect()->table('contato_endereco');
        $db = db_connect();
        $enderecoModel = $db->table('enderecos');
        $contatoModel = $db->table('contato');

        $dados = [
            'ID_ENDERECO' => $enderecoModel->get()->getResult()[sizeof($enderecoModel->get()->getResult())-1]->ID_ENDERECO,
            'ID_CONTATO' => $contatoModel->get()->getResult()[sizeof($contatoModel->get()->getResult())-1]->ID_CONTATO
        ];
        $db->close();

        return $table->insert($dados);
    }

    public function insertTelefone($dados)
    {
        $table = db_connect()->table('telefones');

        $dados['id_contato'] = $this->find()[sizeof($this->find())-1]->id_contato;
        return $table->insert($dados);
    }

    public function deleteEndereco($id_contato)
    {
        $db = db_connect();
        $endereco = $db->table('enderecos');
        $contEnd = $db->table('contato_endereco');

        $rows = $contEnd->where('id_contato', $id_contato)
                ->get()
                ->getResult();
        
        foreach ($rows as $row) {
            $endereco->where('id_endereco', $row->id_endereco)
                     ->delete();
        }

        $db->close();
        return true;
    }

    public function getValue($id)
    {
        $pessoa = [
            'CON' => $this->find($id),
            'TEL' => $this->infoTelefones($id),
            'END' => $this->infoEnderecos($id)[0],
            'EMA' => $this->infoEmails($id)[0] // Tirar pos 0 de todos quando implementar JS
        ];

        return $pessoa;
    }

    public function updateContato($data_edit, $id)
    {
        $db = db_connect();
        $contato = $this;
        $emails = $db->table('emails');
        $telefones = $db->table('telefones');
        $enderecos = $db->table('enderecos');
        $id_end = $db->table('contato_endereco')->where('id_contato', $id)->orderBy('id_contato')->get()->getResult();
        $id_email = $emails->where('id_contato', $id)->orderBy('id_contato')->get()->getResult();
        $id_tel = $telefones->where('id_contato', $id)->orderBy('id_contato')->get()->getResult();

        $dataCON = [
            'nome' => $data_edit["nome"],
            'data_nasc' => $data_edit["data_nasc"],
            'login' => $data_edit["login"]
        ];

        $dataEMAILS = [];
        foreach ($data_edit as $i => $v) {
            if (strpos($i, "EMAIL-") === 0) {
                $explode = explode('-', $i);
                $dataEMAILS["EMAIL-".$explode[1]] = ["END_EMAIL" => $v];
            }
        }
        /*$dataEMA = [
            'END_EMAIL' => $data_edit["EMAIL"]
        ];*/

        $dataENDERECOS = [];
        foreach ($data_edit as $i => $v) {
            if (strpos($i, "RUA-") === 0 || strpos($i, "BAIRRO-") === 0 || strpos($i, "NUMERO-") === 0 || strpos($i, "CIDADE-") === 0 || strpos($i, "CEP-") === 0) {
                $explode = explode('-', $i);
                !empty( $dataENDERECOS["ENDERECO-".$explode[1]] ) ? $dataENDERECOS["ENDERECO-".$explode[1]][$explode[0]] = $v : $dataENDERECOS["ENDERECO-".$explode[1]] = [$explode[0] => $v];
            }
        }
        /*$dataEND = [
            'RUA' => $data_edit["RUA"],
            'NUMERO' => $data_edit["NUMERO"],
            'BAIRRO' => $data_edit["BAIRRO"],
            'CIDADE' => $data_edit["CIDADE"],
            'CEP' => $data_edit["CEP"]
        ];*/

        $dataTELEFONES = [];
        foreach ($data_edit as $i => $v) {
            if (strpos($i, "TELEFONE-") === 0) {
                $explode = explode('-', $i);
                $dataTELEFONES["TELEFONE-".$explode[1]] = ["TELEFONE" => $v];
            }
        }
        /*$dataTEL = [
            'TELEFONE' => $data_edit["TELEFONE"]
        ];*/

        $contato->update($id, $dataCON);

        foreach ($dataEMAILS as $i => $dataEMA) {
            $emails->where('END_EMAIL', $id_email[explode('-', $i)[1]-1]->END_EMAIL)->update($dataEMA);
        }

        foreach ($dataENDERECOS as $i => $dataEND){
            $enderecos->where('ID_ENDERECO', $id_end[explode('-', $i)[1]-1]->ID_ENDERECO)->update($dataEND);
        }

        foreach ($dataTELEFONES as $i => $dataTEL) {
            $telefones->where('TELEFONE', $id_tel[explode('-', $i)[1]-1]->TELEFONE)->update($dataTEL);
        }

        $db->close();
        return true;
    }
}