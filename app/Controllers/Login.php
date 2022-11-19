<?php

namespace App\Controllers;

class Login extends BaseController
{
    public function index()
    {
        $session = \Config\Services::session();
        $user = $session->get('logged');

        if(!empty($user)){
            return redirect()->to('contatos');
        }

        $msg = "";
        if ($session->getFlashdata('msg')!==""){
            $msg = $session->getFlashdata('msg');
        }

        return view('login/login', [
            'title' => 'Login',
            'msg' => $msg
        ]);
    }

    public function criptografar($senha)
    {
        if (!defined('SECRET')) define('SECRET', pack('a16', 'senhamuitodificil'));
        if (!defined('SECRET_1')) define('SECRET_1', pack('a16', 'dificilmesmo'));
        $encrypted = openssl_encrypt($senha, 'aes-256-cbc', SECRET, 0, SECRET_1);

        return $encrypted;
    }

    public function verificar()
    {
        $msg = "";
        if (!empty($this->request->getPost()))
        {
            $encrypted = $this->criptografar($this->request->getPost('SENHA'));

            $dados = [
                'LOGIN' => $this->request->getVar('LOGIN'),
                'SENHA' => $encrypted
            ];

            $validation = \Config\Services::validation();
            $validation->run($dados, 'login');
            $msg = "*". implode( '<br>*', $validation->getErrors() );
            $msg = '<p class="alert alert-danger">'. $msg .'</p>';

            $usuarioModel = new \App\Models\usuarioModel();

            if (sizeof( $usuarioModel->verificarLogin($dados['LOGIN'], $dados['SENHA'])) > 0)
            {
                $session = \Config\Services::session();
                $session->set('logged', $usuarioModel->verificarLogin($dados['LOGIN'], $dados['SENHA'])[0]);
                return redirect()->to('contatos');
            } else {
                $msg = sizeof($validation->getErrors()) < 1 ? '<p class="alert alert-danger">*Login/Senha incorretos!</p>' : $msg;
                return view('login/login', [
                    'title' => 'Login',
                    'msg'   => $msg
                ]);
            }
        }   
    }

    public function logout()
    {
        $session = \Config\Services::session();
        $session->destroy();

        return redirect()->to('/');
    }

    public function cadastro()
    {
        $session = \Config\Services::session();
        $user = $session->get('logged');

        if(!empty($user)){
            return redirect()->to('contatos');
        }

        $msg = "";
        if ($session->getFlashdata('msg')!==""){
            $msg = $session->getFlashdata('msg');
        }

        return view('login/cadastro',[
            'title' => 'Cadastro',
            'msg' => $msg
        ]);
    }

    public function cadastrar()
    {
        $usuarioModel = new \App\Models\usuarioModel();

        $senha = $this->request->getPost('SENHA');
        $encrypted = $this->criptografar($senha);

        $dadosUsuario = [
            'LOGIN' => $this->request->getPost('LOGIN'),
            'SENHA' => $encrypted
        ];

        $validation = \Config\Services::validation();
        $validation->run($dadosUsuario, 'login_cadastro');
        $msg = "*". implode( '<br>*', $validation->getErrors() );
        $msg = '<p class="alert alert-danger">'. $msg .'</p>';
        if (empty($validation->getErrors())) {
            $usuarioModel->insert($dadosUsuario);
            return redirect()->to('/')->with('msg', '<p class="alert alert-success">Cadastrado com sucesso! Faça o login abaixo.</p>');
        } else {
            return redirect()->to('login/cadastro')->with('msg', $msg);
        } 
    }
}