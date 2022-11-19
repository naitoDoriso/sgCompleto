<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------
    public $login = [
        'LOGIN' => 'required|max_length[250]',
        'SENHA' => 'required|max_length[30]'
    ];

    public $login_errors = [
        'LOGIN' => [
            'required' => 'O campo USERNAME está em branco',
            'max_length' => 'O campo USERNAME excedeu o limite de caracteres'
        ],
        'SENHA' => [
            'required' => 'O campo SENHA está em branco',
            'max_length' => 'O campo SENHA excedeu o limite de caracteres'
        ]
    ];

    public $login_cadastro = [
        'LOGIN' => 'required|is_unique[usuario.LOGIN]|max_length[250]',
        'SENHA' => 'required|max_length[30]'
    ];

    public $login_cadastro_errors = [
        'LOGIN' => [
            'required' => 'O campo USERNAME está em branco',
            'is_unique' => 'O USERNAME inserido já está cadastrado',
            'max_length' => 'O campo USERNAME excedeu o limite de caracteres'
        ],
        'SENHA' => [
            'required' => 'O campo SENHA está em branco',
            'max_length' => 'O campo SENHA excedeu o limite de caracteres'
        ]
    ];
}
