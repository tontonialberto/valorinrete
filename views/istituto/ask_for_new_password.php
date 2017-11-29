<div>
    <h2>Richiedi una nuova password</h2>
    <h4>
        Inserisci il codice meccanografico del tuo istituto.
        Riceverai una mail con la nuova password all'indirizzo
        del referente del tuo istituto.
    </h4>
    <form action="<?php echo site_url('istituto/ask_for_new_password'); ?>" method="post">
        Codice Meccanografico:
        <input 
            type="text" 
            class="form-control" 
            name="cod_meccanografico" />
        <button type="submit" class="btn btn-primary btn-lg btn-block">Invia</button>
    </form>
</div>