<?= $this->extend('contato/modelo'); ?>
<?= $this->section('contato'); ?>

    <?= !empty($msg) ? $msg : ""; ?>
    <h2>Contatos</h2>

    <p>Bem-vindo(a), <?= $user->LOGIN; ?>.</p>
    <a class="add-contact" href="<?= base_url("contato/adicionar") ?>">+ Adicionar Contato</a>
    <hr>
    <?php
        foreach($pessoas as $pessoa)
        {
        ?>
            <div id="pessoa-<?= $pessoa->ID_CONTATO ?>" class="d-flex flex-row align-items-center">
                <img src="<?= $pessoa->IMAGEM ?>" alt="icon" style="width: 82px; height: 82px; object-fit: cover; border: 1px solid black; border-radius: 50%">
                <h3 class="ms-3"><a href="<?= base_url('/contatos/'.$pessoa->ID_CONTATO) ?>"><?= $pessoa->NOME ?></a></h3>
                <div class="ms-auto">
                    <a href="<?= base_url('/contato/remover/'.$pessoa->ID_CONTATO) ?>">REMOVER</a>
                    <a href="<?= base_url('/contato/editar/'.$pessoa->ID_CONTATO) ?>">EDITAR</a>
                </div>
            </div>
            <hr id="hr-<?= $pessoa->ID_CONTATO ?>">
        <?php
        }
    ?>
</div>

<?= $this->endSection(); ?>