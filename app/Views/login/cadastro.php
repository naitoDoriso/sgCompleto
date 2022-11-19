<?= $this->extend('login/modelo')?>
<?= $this->section('form')?>

<div class="default text-center">
<?= !empty($msg) ? $msg : "" ?>

<h2>SAUDAÇÃO<br>(SEJA BEM-VINDO(A))</h2>
<h6>cadastre-se</h6><br><br>

    <form method="post" action="<?= base_url('login/cadastrar')?>">
    <label>
        E-mail:
    </label><br/>
    <input type="text" name="LOGIN" id="LOGIN" autocomplete="login"><br/>
    <label>
        Senha:
    </label><br/>
    <input type="password" name="SENHA" id="SENHA" autocomplete="senha"><br/>
    <input type="submit" value="ENVIAR">
    </form>
</div>

<?= $this->endSection()?>