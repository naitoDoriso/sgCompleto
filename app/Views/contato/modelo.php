<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="<?= base_urL('js/add.js') ?>"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title><?= $title; ?></title>
    <style>
        * {
            box-sizing: border-box;
        }
        
        .default {
            padding: 10px;
        }

        #add-btn-email, #add-btn-tel, #add-btn-end {
            color: darkgray;
            font-size: 20px;
            cursor: pointer;
        }

        .add-contact {
            text-decoration: none;
            color: darkgray;
            margin-left: 2.5rem;
            width: fit-content;
            background-color: white;
            padding: 0 12px;
        }

        .add-contact:hover, #add-btn-email:hover, #add-btn-tel:hover, #add-btn-end:hover {
            color: gray;
        }

        .add-contact::before {
            content: '';
            width: calc(100% - 1.2rem);
            height: 2px;
            background-color: gray;
            display: block;
            position: absolute;
            margin-top: 12px;
            z-index: -1;
        }

        .add-contact::after {
            content: '';
        }
    </style>
</head>
<body>
    <div class="default">
        <nav class="navbar d-flex flex-row-reverse align-items-center px-2" style="background-color: #d7b8b8">
            <div class="d-flex align-items-center float-end">
                <img src=<?= base_url('img/default_user.png') ?> alt="img" style="width: 48px; min-height: 48px; border-radius: 50%; border: 1px solid black;">
                <span class="mx-3"><?= $user->LOGIN; ?></span>
                <a href=<?= base_url('/logout'); ?>>Logout</a>
            </div>
        </nav>

        <?= $this->renderSection('contato'); ?>
        <?= $this->renderSection('form'); ?>
</body>
</html>