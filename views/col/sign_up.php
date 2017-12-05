<div class="container">
    <div style="margin-top: 30px" class="panel panel-success">
        <div class="panel panel-heading">
            <h4><?php echo $title; ?></h4>
        </div>
        <div class="panel-body">
            <div class="progress">
                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    Passo 1/1
                </div>
            </div>

            <span class="form-errors">
                <?php echo validation_errors(); ?>
            </span>

            <div class="spacer"></div>

            <?php echo form_open('col/sign_up'); ?>
                <label class="form-label">Nome Referente*:</label>
                <input type="text" class="form-control form-field" name="nome_referente" value="<?php echo set_value('nome_referente'); ?>" />

                <label class="form-label">Cognome Referente*:</label>
                <input type="text" class="form-control form-field" name="cognome_referente" value="<?php echo set_value('cognome_referente'); ?>" />

                <label class="form-label">Regione*:</label>
                <?php 
                    // Crea una select con tante opzioni quante sono le regioni.
                    // Ogni option è strutturata così: <option value="Nome Regione">Nome Regione</option>
                    $options = array();
                    $options[''] = 'Seleziona Regione';
                    foreach($regioni as $regione)
                    {
                        if($regione['nome'] == 'Trentino-Alto Adige')
                        {
                            $options['Trentino-Alto Adige - Bolzano'] = 'Trentino-Alto Adige - Bolzano';
                            $options['Trentino-Alto Adige - Trento'] = 'Trentino-Alto Adige - Trento';
                            continue;
                        }
                        $options[$regione['nome']] = $regione['nome'];
                    }
                    $options["Piemonte - Valle d'Aosta"] = "Piemonte - Valle d'Aosta";
                    echo form_dropdown('regione', $options, set_value('regione'), 'class="form-control form-field fat"'); 
                ?>

                <label class="form-label">E-mail Referente*:</label>
                <input type="text" class="form-control form-field" name="email_referente" value="<?php echo set_value('email_referente'); ?>" />

                <label class="form-label">Conferma E-mail*:</label>
                <input type="text" class="form-control form-field" name="conferma_email_referente" value="<?php echo set_value('conferma_email_referente'); ?>" />
                
                <label class="form-label">Password*:</label>
                <input type="password" class="form-control form-field" name="password" placeholder="Inserisci almeno 6 caratteri" />

                <label class="form-label">Conferma Password*:</label>
                <input type="password" class="form-control form-field" name="conferma_password" />
                
                <?php /*
                <label class="form-label">Provincia*:</label>
                <?php
                    // Crea una select con tante opzioni quante sono le province.
                    // Ogni option è strutturata così: <option value="Nome Provincia">Nome Provincia</option>
                    $options = array();
                    $options[''] = 'Seleziona Provincia';
                    foreach($province as $provincia)
                    {
                        $options[$provincia['nome']] = $provincia['nome'];
                    }
                    echo form_dropdown('provincia', $options, set_value('provincia'), 'class="form-control form-field fat"');
                ?>

                <label class="form-label">Comune*:</label>
                <input type="text" class="form-control form-field" name="comune" />
                */ ?>

                <label class="form-label">Indirizzo*:</label>
                <input type="text" class="form-control form-field" name="indirizzo" value="<?php echo set_value('indirizzo'); ?>" />
                
                <div class="row">
                    <div id="error_logger" class="text-center col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2" style="color: rgb(220, 100, 100)">

                    </div>
                </div>
                <button type="submit" class="btn btn-success btn-block btn-fat">Prosegui</button>
            </form>
        </div>
        <h4><b>* Campo Obbligatorio</b></h4>
    </div>
</div>

<script type="text/javascript">
    const inputEmailReferente = $('input[name="email_referente"]');
    const selectRegione = $('select[name="regione"]');
    const errorLogger = $('#error_logger');
    const buttonSubmit = $('button[type="submit"]');

    // Controlla che ci sia una corrispondenza tra l'email
    // inserita dall'utente e la regione di appartenenza del COL.
    // Se ci sono errori di inserimento, blocca l'invio della form
    // disabilitando il bottone submit.

    function applyEmailControl() {
        buttonSubmit.attr('disabled', true);
        const regione = selectRegione.val();
        const email = inputEmailReferente.val();
        console.log('Applicando controllo email..');
        $.post({
            url: '<?php echo base_url(); ?>' + 'col/controllo_email',
            dataType: 'JSON',
            data: {
                regione: regione,
                email: email
            },
            success: (response) => {
                console.log(response);
                if(!response.ok) {
                    errorLogger.html("L'email da te inserita non corrisponde alla regione");
                    return buttonSubmit.attr('disabled', true);
                }
                errorLogger.html("");
                buttonSubmit.attr('disabled', false);
            },
            error: () => {
                console.error('Errore di connessione al server');
            }
        });
    }

    // Ogni volta che il valore degli input cambia,
    // applica il controllo tra email e regione.
    $('input[name="email_referente"], select[name="regione"]').focusout(function() {
        applyEmailControl();
    });
</script>