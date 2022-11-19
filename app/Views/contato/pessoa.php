<?= $this->extend('contato/modelo') ?>
<?= $this->section('contato') ?>

    <div id="pessoa-<?= $pessoa->ID_CONTATO ?>" class="d-flex flex-row flex-wrap">
        <div class="w-100 mt-3 ms-1">
            <h6 class="ms-auto"><a href="<?= base_url('/contatos'); ?>">Voltar</a></h6>
        </div>
        <div class="d-flex align-items-center w-100 my-2">
            <img src="<?= base_url($pessoa->IMAGEM) ?>" alt="icon" style="width: 128px; height: 128px; object-fit: cover; border: 1px solid black; border-radius: 50%">
            <h3 class="ms-3"><?= $pessoa->NOME ?></h3>
        </div>
        <ul class="list-group text-center w-50 ms-5 mt-5">
            <li class="list-group-item list-group-item-secondary">INFORMAÇÕES</li>
            <li class="list-group-item"><b>DATA DE NASCIMENTO</b>: <?= $pessoa->DATA_NASC ?></li>

<?php
            if (sizeof($emails)>0)
            foreach($emails as $i=>$email)
            {
                $nro = $i+1;
?>
                <li class="list-group-item"><?= "<b>EMAIL $nro</b>: $email->END_EMAIL" ?></li>
<?php
            }
?>

<?php
            if (sizeof($enderecos)>0)
            foreach($enderecos as $i=>$endereco)
            {
                $nro = $i+1;
?>
                <li class="list-group-item"><?= "<b>ENDEREÇO $nro</b>: $endereco->RUA, $endereco->NUMERO - $endereco->BAIRRO, $endereco->CIDADE" ?></li>
<?php
            }
?>

<?php
            if (sizeof($telefones)>0)
            foreach($telefones as $i=>$telefone)
            {
                $nro = $i+1;
?>
                <li class="list-group-item"><?= "<b>TELEFONE $nro</b>: $telefone->TELEFONE" ?></li>
<?php
            }
?>
        </ul>
    </div>
</div>

<?= $this->endSection() ?>