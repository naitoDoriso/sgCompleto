<?php

namespace App\Controllers;

class Contatos extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();
        $user = $session->get('logged');

        if(empty($user)){
            return redirect()->to('/');
        }

        $contatoModel = new \App\Models\contatoModel();
        $pessoas = $contatoModel->where('LOGIN', $user->LOGIN)->get()->getResult();
        $msg = "";

        if ($session->getFlashdata('msg')!==""){
            $msg = $session->getFlashdata('msg');
        }

        return view('contato/index', [
            'title'   => 'Contatos',
            'user'    => $user,
            'pessoas' => $pessoas,
            'msg'     => $msg
        ]);
    }

    public function contato($id)
    {
        $session = \Config\Services::session();
        $user = $session->get('logged');

        if(empty($user)){
            return redirect()->to('/');
        }

        $contatoModel = new \App\Models\contatoModel();
        $pessoa = $contatoModel->where('LOGIN', $user->LOGIN)->find(['ID_CONTATO' => $id]);

        if (sizeof($pessoa) < 1) {
            return redirect()->to('/contatos');
        }

        $enderecos = $contatoModel->infoEnderecos($id);
        $telefones = $contatoModel->infoTelefones($id);
        $emails = $contatoModel->infoEmails($id);

        if (sizeof($pessoa) > 0)
        {
            $pessoa = $pessoa[0];
            return view('contato/pessoa', [
                'title'     => "$pessoa->NOME | Contato",
                'user'      => $user,
                'pessoa'    => $pessoa,
                'emails'    => $emails,
                'enderecos' => $enderecos,
                'telefones' => $telefones
            ]);
        }
    }

    public function inserir()
    {
        $session = \Config\Services::session();
        $user = $session->get('logged');

        if(empty($user)){
            return redirect()->to('/');
        }

        if (!empty($this->request->getPost()))
        {
            $contatoModel = new \App\Models\contatoModel();
            $enderecoModel = new \App\Models\enderecosModel();

            $dadosContato = [
                'NOME' => $this->request->getPost('NOME'),
                'DATA_NASC' => $this->request->getPost('DATA_NASC'),
                'LOGIN' => $user->LOGIN,
                'IMAGEM' => ""
            ];

            $emails = [];
            foreach ($this->request->getPost() as $i => $v) {
                if (strpos($i, "EMAIL-") === 0) {
                    $explode = explode('-', $i);
                    $emails["EMAIL-".$explode[1]] = ["END_EMAIL" => $v];
                }
            }

            $enderecos = [];
            foreach ($this->request->getPost() as $i => $v) {
                if (strpos($i, "RUA-") === 0 || strpos($i, "BAIRRO-") === 0 || strpos($i, "NUMERO-") === 0 || strpos($i, "CIDADE-") === 0 || strpos($i, "CEP-") === 0) {
                    $explode = explode('-', $i);
                    !empty( $enderecos["ENDERECO-".$explode[1]] ) ? $enderecos["ENDERECO-".$explode[1]][$explode[0]] = $v : $enderecos["ENDERECO-".$explode[1]] = [$explode[0] => $v];
                }
            }

            $telefones = [];
            foreach ($this->request->getPost() as $i => $v) {
                if (strpos($i, "TELEFONE-") === 0) {
                    $explode = explode('-', $i);
                    $telefones["TELEFONE-".$explode[1]] = ["TELEFONE" => $v];
                }
            }

            try {
                $contatoModel->save($dadosContato);

                // Dando upload na imagem e editando a coluna IMAGEM para o path criado
                $img = $this->request->getFile('IMAGEM');
                if ($img->isValid()) {
                    $path = 'img';
                    $id_contato = $contatoModel->get()->getResult()[sizeof($contatoModel->get()->getResult())-1]->ID_CONTATO;
                    $name = $id_contato . "." . $img->getClientExtension();
                    $fullpath = $path.'/'.$name;
                    if ($img->hasMoved() === false) {
                        $img->move($path, $name);
                    }
                } else {
                    $id_contato = $contatoModel->get()->getResult()[sizeof($contatoModel->get()->getResult())-1]->ID_CONTATO;
                    $fullpath = 'img/default_user.png';
                }
                $contatoModel->update($id_contato, ['IMAGEM' => $fullpath]);

                foreach ($enderecos as $dadosEndereco){
                    $enderecoModel->save($dadosEndereco);
                    $contatoModel->insertContEnd();
                }

                foreach ($telefones as $dadosTelefone) {
                    $contatoModel->insertTelefone($dadosTelefone);
                }

                foreach ($emails as $dadosEmail) {
                    $contatoModel->insertEmail($dadosEmail);
                }

                $msg = "<p class='alert alert-success'>Contato { <b>$dadosContato[NOME]</b> } inserido com sucesso!</p>";
            } catch (\Exception $e) {
                $msg = "<p class='alert alert-danger'>Error! $e</p>";
            }

            return redirect()->to('contatos')->with('msg', $msg);
        }
        return view('contato/form', [
            'title' => 'Adicionar Contato',
            'subtitle' => 'Adicionar Contato',
            'submit' => 'SALVAR',
            'action' => 'contato/adicionar',
            'user' => $user
        ]);
    }

    public function remover($id="null")
    {
        $session = \Config\Services::session();
        $user = $session->get('logged');

        if(empty($user)){
            return redirect()->to('/');
        }

        if ($id === "null") {
            return redirect()->to('/contatos');
        }

        $contatoModel = new \App\Models\contatoModel();

        $nome = $contatoModel->find($id) === NULL ? "" : $contatoModel->find($id)->NOME;

        if ($contatoModel->find($id) !== NULL)
        {
            if ($contatoModel->find($id)->IMAGEM !== "" && $contatoModel->find($id)->IMAGEM !== "img/default_user.png") {
                unlink($contatoModel->find($id)->IMAGEM);
            }
        }

        if ($contatoModel->deleteEndereco($id)  && $contatoModel->delete($id) ) {
            $msg = "<p class='alert alert-success'>Contato { <b>$nome</b> } removido com sucesso!</p>";
        }

        return redirect()->to('contatos')->with('msg', $msg);
    }

    public function editar($id="null")
    {
        $session = \Config\Services::session();
        $user = $session->get('logged');

        if(empty($user)){
            return redirect()->to('/');
        }

        if ($id === "null") {
            return redirect()->to('/contatos');
        }

        $contatoModel = new \App\Models\contatoModel();
        $dados = $contatoModel->getValue($id);

        if (!empty($this->request->getPost()))
        {
            $edit = $this->request->getPost();
            $edit["LOGIN"] = $user->LOGIN;
            if ($contatoModel->updateContato($edit, $id)) {
                $dados = $contatoModel->getValue($id);

                $img = $this->request->getFile('IMAGEM');
                if ($img->isValid()) {
                    $path = 'img';
                    $name = $id . "." . $img->getClientExtension();

                    if (file_exists('img/'.$name)) unlink('img/'.$name);

                    $fullpath = $path.'/'.$name;
                    if ($img->hasMoved() === false) {
                        $img->move($path, $name);
                    }
                    $contatoModel->update($id, ['IMAGEM' => $fullpath]);
                } /*else {
                     $fullpath = 'img/default_user.png';
                 }*/
            }
        }

        return view('contato/form', [
            'title' => 'Editar Contato',
            'subtitle' => 'Editar Contato <span class="text-danger">{ '. $dados['CON']->NOME .' }</span>',
            'submit' => 'EDITAR',
            'action' => 'contato/editar/'.$id,
            'user' => $user,
            'dados' => $dados,
            'emails' => $contatoModel->infoEmails($id),
            'telefones' => $contatoModel->infoTelefones($id),
            'enderecos' => $contatoModel->infoEnderecos($id)
        ]);
    }
}