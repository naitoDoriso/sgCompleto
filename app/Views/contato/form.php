<?= $this->extend('contato/modelo') ?>
<?= $this->section('form') ?>

<div class="default">
    <div class="w-100 mt-2">
        <h6 class="ms-auto"><a href="<?= base_url('/contatos'); ?>">Voltar</a></h6>
    </div>
    <form method="post" action="<?php echo base_url($action); ?>" enctype="multipart/form-data">
        <?= empty($subtitle) ? "" : "<h2>$subtitle</h2><hr>" ?>
        <div>
            <label for="NOME">NOME</label>
                <input type="text" name="NOME" id="NOME" <?= empty($dados) ? "" : "value='".$dados['CON']->NOME."'" ?>><br/>
            <label for="DATA_NASC">DATA DE NASCIMENTO</label>
                <input type="date" name="DATA_NASC" id="DATA_NASC" <?= empty($dados) ? "" : "value='".$dados['CON']->DATA_NASC."'" ?>><br/>
            <label for="IMAGEM">IMAGEM</label>
                <input type="file" name="IMAGEM" id="IMAGEM" accept="image/*"><br/>

<?php
if (empty( $emails )) $emails = [0 => (object)['END_EMAIL' => '']];
foreach ($emails as $i => $v) {
    $count = $i +1;
?>
            <div id="email-<?= $count ?>">
                <label for="EMAIL-<?= $count ?>">E-MAIL <?= $count ?>:</label>
                    <input type="text" name="EMAIL-<?= $count ?>" id="EMAIL-<?= $count ?>" <?= empty($dados) ? "" : "value='".$emails[$i]->END_EMAIL."'" ?>>
                <?php if ($i === sizeof($emails)-1) { ?>
                    <span id="add-btn-email">+</span>
                <?php } ?>
            </div>
<?php
}
?>
        </div>

<?php
if (empty( $enderecos )) $enderecos =
    [
        0 => (object)[
            'RUA' => '',
            'BAIRRO' => '',
            'NUMERO' => '',
            'CIDADE' => '',
            'CEP' => ''
        ]
    ];
foreach ($enderecos as $i => $v) {
    $count = $i +1;
?>        
        <div id="end-<?= $count ?>">
            <h5>ENDEREÇO <?= $count ?></h5>
            <label for="RUA-<?= $count ?>">RUA</label>
                <input type="text" name="RUA-<?= $count ?>" id="RUA-<?= $count ?>" <?= empty($dados) ? "" : "value='".$enderecos[$i]->RUA."'" ?>><br/>
            <label for="BAIRRO-<?= $count ?>">BAIRRO</label>
                <input type="text" name="BAIRRO-<?= $count ?>" id="BAIRRO-<?= $count ?>" <?= empty($dados) ? "" : "value='".$enderecos[$i]->BAIRRO."'" ?>><br/>
            <label for="NUMERO-<?= $count ?>">NUMERO</label>
                <input type="number" name="NUMERO-<?= $count ?>" id="NUMERO-<?= $count ?>" <?= empty($dados) ? "" : "value='".$enderecos[$i]->NUMERO."'" ?>><br/>
            <label for="CIDADE-<?= $count ?>">CIDADE</label>
                <input type="text" name="CIDADE-<?= $count ?>" id="CIDADE-<?= $count ?>" <?= empty($dados) ? "" : "value='".$enderecos[$i]->CIDADE."'" ?>><br/>
            <label for="CEP-<?= $count ?>">CEP</label>
                <input type="text" name="CEP-<?= $count ?>" id="CEP-<?= $count ?>" <?= empty($dados) ? "" : "value='".$enderecos[$i]->CEP."'" ?>>
            <span id="add-btn-end">+</span>
        </div>
<?php
}
?>

<?php
if (empty( $telefones )) $telefones = [0 => (object)['TELEFONE' => '']];
foreach ($telefones as $i => $v) {
    $count = $i +1;
?>
        <div id="tel-<?= $count ?>">
            <label for="TELEFONE-<?= $count ?>">TELEFONE <?= $count ?>:</label>
            <input type="number" name="TELEFONE-<?= $count ?>" id="TELEFONE-<?= $count ?>" <?= empty($dados) ? "" : "value='".$telefones[$i]->TELEFONE."'" ?>>
            <span id="add-btn-tel">+</span>
        </div>
<?php
}
?>
        <input type="submit" value="<?= $submit ?>">
    </form>
</div>

<?= $this->endSection() ?>