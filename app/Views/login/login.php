<?= $this->extend('login/modelo') ?>
<?= $this->section('login') ?>

<div class="default text-center login">
    <?= !empty($msg) ? $msg : "" ?>

    <h2>SAUDAÇÃO<br>(BEM-VINDO(A) DE VOLTA)</h2>
    <h6>Entre na sua conta</h6><br><br>

    <form action=<?= base_url('verificar') ?> method="post">
        <label for="LOGIN">Username:</label><br>
        <input type="text" name="LOGIN" id="LOGIN">

        <br><br>

        <label for="SENHA">Senha:</label><br>
        <input type="password" name="SENHA" id="SENHA">
        <br>

        <input type="submit" value="Logar">
    </form>
    <span>Ainda não tem um login? <a href="<?= base_url('login/cadastro') ?>">Cadastre-se aqui.</a></span>
</div>

<?= $this->endSection() ?>