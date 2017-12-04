<div>
    <h2>Richiedi una nuova password</h2>
    <h4>
        Inserisci il codice meccanografico del tuo istituto.
        Riceverai una mail con la nuova password all'indirizzo
        del referente del tuo istituto.
    </h4>
    <form action="<?php echo site_url('istituto/ask_for_new_password'); ?>" method="post">
        <div class="row">
            <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <label class="form-label">
                    Codice Meccanografico:
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <input 
                type="text" 
                class="form-control form-field" 
                name="cod_meccanografico" />
            </div> 
            <div class="col-md-10 col-lg-10 col-md-offset-1 col-lg-offset-1">
                <button type="submit" class="btn btn-primary btn-lg btn-block form-field">Invia</button>
            </div>
        </div>
    </form>
</div>