<div>
    <h2>Modifica Password</h2>
    <?php echo validation_errors(); ?>
    <?php echo form_open('istituto/change_password.php'); ?>
        Vecchia password:
        <input type="password" name="vecchia_password" class="form-control" />
        <br />
        Nuova Password:
        <input type="password" name="nuova_password" class="form-control" />
        <br />
        Conferma nuova password:
        <input type="password" name="conferma_nuova_password" class="form-control" />
        <br />
        <button type="submit" class="btn btn-primary btn-lg btn-block">
            Cambia Password
        </button>
    </form>
</div>