<div class="container">
    <div style="margin-top: 30px" class="panel panel-info">
        <div class="panel panel-heading">
            <h4><?php echo $title; ?></h4>
        </div>
        <div class="panel-body">
            <div class="progress">
                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                    aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" style="width: 33%">
                    Passo 1/3
                </div>
            </div>

            <?php echo validation_errors(); ?>

            <div class="spacer"></div>

            <?php echo form_open('istituto/sign_up'); ?>
                <label class="form-label">Codice Meccanografico*:</label>
                <input type="text" class="form-control form-field" name="cod_meccanografico" value="<?php echo set_value('cod_meccanografico'); ?>" />

                <label class="form-label">Nome dell'Istituto*:</label>
                <input type="text" class="form-control form-field" name="nome_istituto" value="<?php echo set_value('nome_istituto'); ?>" />

                <label class="form-label">Email Istituto*:</label>
                <input type="text" class="form-control form-field" name="email_istituto" value="<?php echo set_value('email_istituto'); ?>" />

                <label class="form-label">Conferma Email Istituto*:</label>
                <input type="text" class="form-control form-field" name="conferma_email_istituto" value="<?php echo set_value('conferma_email_istituto'); ?>" />

                <label class="form-label">CAP*:</label>
                <input type="text" class="form-control form-field" name="cap" value="<?php echo set_value('cap'); ?>" />

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
                <?php
                    // Crea una select con tante opzioni quante sono i comuni.
                    // Ogni option è strutturata così: <option value="Nome Comune">Nome Comune</option>
                    $options = array();
                    $options[''] = 'Seleziona Comune';
                    foreach($comuni as $comune)
                    {
                        $options[$comune['nome']] = $comune['nome'];
                    }
                    $comuni = array_column($options, 'nome');
                    echo form_dropdown('comune', $options, set_value('comune'), 'class="form-control form-field fat"');
                ?>

                <label class="form-label">Indirizzo*:</label>
                <input type="text" class="form-control form-field" name="indirizzo" value="<?php echo set_value('indirizzo'); ?>" />

                <label class="form-label">Nome Referente*:</label>
                <input type="text" class="form-control form-field" name="nome_referente" value="<?php echo set_value('nome_referente'); ?>" />

                <label class="form-label">Cognome Referente*:</label>
                <input type="text" class="form-control form-field" name="cognome_referente" value="<?php echo set_value('cognome_referente'); ?>" />

                <label class="form-label">Telefono Referente*:</label>
                <input type="text" class="form-control form-field" name="telefono_referente" value="<?php echo set_value('telefono_referente'); ?>" />

                <label class="form-label">E-mail Referente*:</label>
                <input type="text" class="form-control form-field" name="email_referente" value="<?php echo set_value('email_referente'); ?>" />

                <label class="form-label">Conferma E-mail*:</label>
                <input type="text" class="form-control form-field" name="conferma_email_referente" value="<?php echo set_value('conferma_email_referente'); ?>" />
                
                <label class="form-label">Password*:</label>
                <input type="password" class="form-control form-field" name="password" placeholder="Inserisci almeno 6 caratteri" />

                <label class="form-label">Conferma Password*:</label>
                <input type="password" class="form-control form-field" name="conferma_password" />
                
                <button type="submit" class="btn btn-info btn-block btn-fat">Prosegui</button>
            </form>
        </div>
        <h4><b>* Campo Obbligatorio</b></h4>
    </div>
</div>