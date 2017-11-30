<div class="container">
    <div class="panel panel-info" style="margin-top: 30px">
        <div class="panel-heading">
            <h4><?php echo $title; ?></h4>
        </div>
        <div class="panel-body">
            <div class="progress">
                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                    aria-valuenow="66" aria-valuemin="0" aria-valuemax="100" style="width: 66%">
                    Passo 2/3
                </div>
            </div>

            <?php echo validation_errors(); ?>

                <?php echo form_open('istituto/select_projects'); ?>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="text-center">
                                <label for="gc" class="btn btn-primary form-field">GiocoCalciando</label>
                            </div>
                            <input id="gc" type="checkbox" class="form-check-input display-controller" name="gc" />
                            <div class="display-item panel panel-default" hidden="true">
                                <div class="panel-heading">GiocoCalciando</div>
                                <div class="panel-body">
                                    <label class="form-label">Nome Referente:*</label>
                                    <input type="text" class="form-control form-field" name="gc_nome_referente" value="<?php echo set_value('gc_nome_referente'); ?>" />

                                    <label class="form-label">Cognome Referente:*</label>
                                    <input type="text" class="form-control form-field" name="gc_cognome_referente" value="<?php echo set_value('gc_cognome_referente'); ?>" />

                                    <label class="form-label">Telefono Referente:*</label>
                                    <input type="text" class="form-control form-field" name="gc_telefono_referente" value="<?php echo set_value('gc_telefono_referente'); ?>" />

                                    <label class="form-label">Email Referente:*</label>
                                    <input type="text" class="form-control form-field" name="gc_email_referente" value="<?php echo set_value('gc_email_referente'); ?>" />

                                    <label class="form-label">Conferma Email Referente:*</label>
                                    <input type="text" class="form-control form-field" name="gc_conferma_email_referente" value="<?php echo set_value('gc_conferma_email_referente'); ?>" />
                                    
                                    <label class="form-label">Agenda disponibilità primo incontro:</label>
                                    <div class="incontro">
                                        <div class="input-group date form-field datepicker" data-provide="datepicker">
                                            <input type="text" class="form-control" name="gc_data_incontro[]" />
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="text-center">
                                <label for="rg" class="btn btn-primary form-field">Ragazze in Gioco</label>
                            </div>
                            <input id="rg" type="checkbox" class="form-check-input display-controller" name="rg" />
                            <div class="display-item panel panel-default" hidden="true">
                                <div class="panel-heading">Ragazze in Gioco</div>
                                <div class="panel-body">
                                    <label class="form-label">Nome Referente:*</label>
                                    <input type="text" class="form-control form-field" name="rg_nome_referente" value="<?php echo set_value('rg_nome_referente'); ?>" />

                                    <label class="form-label">Cognome Referente:*</label>
                                    <input type="text" class="form-control form-field" name="rg_cognome_referente" value="<?php echo set_value('rg_cognome_referente'); ?>" />

                                    <label class="form-label">Telefono Referente:*</label>
                                    <input type="text" class="form-control form-field" name="rg_telefono_referente" value="<?php echo set_value('rg_telefono_referente'); ?>" />

                                    <label class="form-label">Email Referente:*</label>
                                    <input type="text" class="form-control form-field" name="rg_email_referente" value="<?php echo set_value('rg_email_referente'); ?>" />

                                    <label class="form-label">Conferma Email Referente:*</label>
                                    <input type="text" class="form-control form-field" name="rg_conferma_email_referente" value="<?php echo set_value('rg_conferma_email_referente'); ?>" />
                                    
                                    <label class="form-label">Impianti da gioco disponibili(in caso negativo, scrivere 'nessuno'):*</label>
                                    <input type="text" class="form-control form-field" name="rg_impianti_gioco_disponibili" value="<?php echo set_value('rg_impianti_gioco_disponibili'); ?>" />
                                    
                                    <label class="form-label">L'Istituto e' convenzionato con società di calcio affiliate FIGC?(Se sì indicare quale/i, in caso negativo scrivere 'no'):*</label>
                                    <input type="text" class="form-control form-field" name="rg_istituto_convenzionato" value="<?php echo set_value('rg_istituto_convenzionato'); ?>" />
                                    
                                    <label class="form-label">
                                        Scuola Secondaria di 1° grado iscritta a Valorinrete - Campionati Studenteschi
                                        per la categoria Cadette?
                                    </label>
                                    <?php 
                                        echo form_dropdown('rg_iscrizione_categoria_cadette', array(
                                            '' => 'Seleziona',
                                            TRUE => 'Sì',
                                            FALSE => 'No'
                                        ), set_value('rg_iscrizione_categoria_cadette'), 'class="form-control form-field fat"');
                                    ?>
                                    <label class="form-label">Agenda disponibilità primo incontro:</label>
                                    <div class="incontro">
                                        <div class="input-group date form-field datepicker" data-provide="datepicker">
                                            <input type="text" class="form-control" name="rg_data_incontro[]" />
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="text-center">
                                <label for="col" class="btn btn-primary form-field">Il Calcio e le Ore di Lezione</label>
                            </div>
                            <input id="col" type="checkbox" class="form-check-input display-controller" name="col" />
                            <div class="display-item panel panel-default" hidden="true">
                                <div class="panel-heading">Il Calcio e le Ore di Lezione</div>
                                <div class="panel-body">
                                    <label class="form-label">Nome Referente:*</label>
                                    <input type="text" class="form-control form-field" name="col_nome_referente" value="<?php echo set_value('col_nome_referente'); ?>" />
                                    
                                    <label class="form-label">Cognome Referente:*</label>
                                    <input type="text" class="form-control form-field" name="col_cognome_referente" value="<?php echo set_value('col_cognome_referente'); ?>" />
                                    
                                    <label class="form-label">Telefono Referente:*</label>
                                    <input type="text" class="form-control form-field" name="col_telefono_referente" value="<?php echo set_value('col_telefono_referente'); ?>" />
                                    
                                    <label class="form-label">Email Referente:*</label>
                                    <input type="text" class="form-control form-field" name="col_email_referente" value="<?php echo set_value('col_email_referente'); ?>" />
                                    
                                    <label class="form-label">Conferma Email Referente:*</label>
                                    <input type="text" class="form-control form-field" name="col_conferma_email_referente" value="<?php echo set_value('col_conferma_email_referente'); ?>" />
                                    
                                    <label class="form-label">Agenda disponibilità primo incontro:</label>
                                    <div class="incontro">
                                        <div class="input-group date form-field datepicker" data-provide="datepicker">
                                            <input type="text" class="form-control" name="col_data_incontro[]" />
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="text-center">
                                <label for="cs" class="btn btn-primary form-field">Campionati Studenteschi</label>
                            </div>
                            <input id="cs" type="checkbox" class="form-check-input display-controller" name="cs" />
                            <div class="display-item panel panel-default" hidden="true">
                                <div class="panel-heading">Campionati Studenteschi</div>
                                <div class="panel-body">
                                    <label class="form-label">Nome Referente:*</label>
                                    <input type="text" class="form-control form-field" name="cs_nome_referente" value="<?php echo set_value('cs_nome_referente'); ?>" />
                                    
                                    <label class="form-label">Cognome Referente:*</label>
                                    <input type="text" class="form-control form-field" name="cs_cognome_referente" value="<?php echo set_value('cs_cognome_referente'); ?>" />
                                    
                                    <label class="form-label">Telefono Referente:*</label>
                                    <input type="text" class="form-control form-field" name="cs_telefono_referente" value="<?php echo set_value('cs_telefono_referente'); ?>" />
                                    
                                    <label class="form-label">Email Referente:*</label>
                                    <input type="text" class="form-control form-field" name="cs_email_referente" value="<?php echo set_value('cs_email_referente'); ?>" />
                                    
                                    <label class="form-label">Conferma Email Referente:*</label>
                                    <input type="text" class="form-control form-field" name="cs_conferma_email_referente" value="<?php echo set_value('cs_conferma_email_referente'); ?>" />
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="spacer"></div>

                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="adesione_progetti" />
                        Aderisco ai progetti e al loro regolamento
                    </label>
                    <br />
                    <label class="form-label">
                        <input type="checkbox" class="form-check-input" name="privacy_policy" />
                        Acconsento al trattamento dei dati personali
                    </label>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <button type="submit" name="go_to_subscribe" class="btn btn-primary btn-block btn-fat">Vai allo step 3</button>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <button type="submit" name="skip_subscribe" class="btn btn-primary btn-block btn-fat">Salta lo step 3(Potrai completarlo in seguito)</button>
                        </div>
                    </div>
                    <h4>* Campo Obbligatorio</h4>
                </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(() => {
        // cicla tutti i checkbox con classe display-controller
        // ed al variare di uno di loro, mostra o nasconde 
        // il div(con classe display-item) direttamente successivo ad esso.
        $('input[type="checkbox"].display-controller').change(function() {
            if($(this).prop('checked')) {
                // per mostrare/nascondere i div, viene mostrato/nascosto
                // l'elemento direttamente successivo al checkbox.display-controller
                // avente la classe display-item
                $(this).next('.display-item').show();
                return;
            }
            $(this).next('.display-item').hide();
        });

        // Applica il formato Giorno/Mese/Anno
        // a tutti gli input datepicker nella pagina
        $('.datepicker').datepicker({ 
            format: 'dd/mm/yyyy', 
            autoclose: true 
        });
    });
</script>