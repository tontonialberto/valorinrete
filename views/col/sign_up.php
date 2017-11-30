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

                <label class="form-label">E-mail Referente*:</label>
                <input type="text" class="form-control form-field" name="email_referente" value="<?php echo set_value('email_referente'); ?>" />

                <label class="form-label">Conferma E-mail*:</label>
                <input type="text" class="form-control form-field" name="conferma_email_referente" value="<?php echo set_value('conferma_email_referente'); ?>" />
                
                <label class="form-label">Password*:</label>
                <input type="password" class="form-control form-field" name="password" placeholder="Inserisci almeno 6 caratteri" />

                <label class="form-label">Conferma Password*:</label>
                <input type="password" class="form-control form-field" name="conferma_password" />

                <label class="form-label">Regione*:</label>
                <?php 
                    // Crea una select con tante opzioni quante sono le regioni.
                    // Ogni option è strutturata così: <option value="Nome Regione">Nome Regione</option>
                    $options = array();
                    $options[''] = 'Seleziona Regione';
                    foreach($regioni as $regione)
                    {
                        $options[$regione['nome']] = $regione['nome'];
                    }
                    echo form_dropdown('regione', $options, set_value('regione'), 'class="form-control form-field fat"'); 
                ?>
                
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
                
                <label class="form-label">Indirizzo*:</label>
                <input type="text" class="form-control form-field" name="indirizzo" value="<?php echo set_value('indirizzo'); ?>" />
                
                <button type="submit" class="btn btn-success btn-block btn-fat">Prosegui</button>
            </form>
        </div>
        <h4><b>* Campo Obbligatorio</b></h4>
    </div>
</div>