<div class="corpo"> 
    <div class="panel panel-info" style="margin-top: 30px">
        <div class="panel-heading">
            <h4>Aggiungi Classi e Studenti</h4>
        </div>
        <div class="panel-body">

            <?php if(validation_errors()): ?>
                <div class="alert alert-danger">
                    <?php echo validation_errors(); ?>
                </div>
            <?php endif; ?>

            <?php if(isset($insert_success)): ?>
                <div class="alert alert-success">
                    Modifiche salvate con successo!
                </div>
            <?php endif; ?>

            <div class="spacer"></div>

            <?php echo form_open('istituto/add_subscriptions'); ?>

                <?php foreach($progetti as $progetto): ?>
                    <?php if($progetto['progetto'] === 'GiocoCalciando'): ?>
                    <label for="gc" class="btn btn-info form-field">GiocoCalciando</label>
                    <input id="gc" type="checkbox" hidden="true" name="gc" class="display-controller" />
                    <div class="panel panel-default display-item" hidden="true">
                        <div class="panel-heading"><h5>GiocoCalciando</h5></div>
                        <div id="gc_div" class="panel-body">
                            <div id="gc_studente">
                                <div class="row box">
                                    <div class="col-md-12 col-lg-12">
                                        <label class="form-label">Nome Studente:*</label>
                                        <input type="text" class="form-control form-field" name="gc_nome_studente[]" />

                                        <label class="form-label">Cognome Studente:*</label>
                                        <input type="text" class="form-control form-field" name="gc_cognome_studente[]" />

                                        <label class="form-label">Sesso:*</label><br />
                                        <select class="form-control form-field" name="gc_sesso_studente[]">
                                            <option value="M">M</option>
                                            <option value="F">F</option>
                                        </select>

                                        <label class="form-label">Data di nascita:</label>
                                        <div class="input-group date form-field datepicker" data-provide="datepicker">
                                            <input type="text" class="form-control" name="gc_data_nascita[]" />
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <label class="form-label">Classe:*</label>
                                                <select class="form-control" name="gc_classe[]">
                                                    <option value="">Seleziona</option>
                                                    <option value="4">4°</option>
                                                    <option value="5">5°</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-lg-6">
                                                <label class="form-label">Sezione:*</label>
                                                <select class="form-control" name="gc_sezione[]">
                                                    <option value="">Seleziona</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="gc_add_studente" class="btn btn-primary">Aggiungi Studente</button>
                    </div>
                    <?php endif; ?>

                    <?php if($progetto['progetto'] === 'Ragazze in Gioco'): ?>
                    <label for="rg" class="btn btn-info form-field">Ragazze in Gioco</label>
                    <input id="rg" type="checkbox" hidden="true" name="rg" class="display-controller" />
                    <div class="panel panel-default display-item" hidden="true">
                        <div class="panel-heading"><h5>Ragazze in Gioco</h5></div>

                        <div id="rg_div" class="panel-body">
                            <div id="rg_studente">
                                <div class="row box">
                                    <div class="col-md-12 col-lg-12">
                                        <label class="form-label">Nome Studente:*</label>
                                        <input type="text" class="form-control form-field" name="rg_nome_studente[]" />

                                        <label class="form-label">Cognome Studente:*</label>
                                        <input type="text" class="form-control form-field" name="rg_cognome_studente[]" />

                                        <input type="hidden" name="rg_sesso_studente[]" value="F" />

                                        <label class="form-label">Data di nascita:</label>
                                        
                                        <div class="input-group date form-field datepicker" data-provide="datepicker">
                                            <input type="text" class="form-control" name="rg_data_nascita[]" />
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <label class="form-label">Classe:*</label>
                                                <select class="form-control form-field" name="rg_classe[]">
                                                    <option value="">Seleziona</option>
                                                    <option value="1">1°</option>
                                                    <option value="2">2°</option>
                                                    <option value="3">3°</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-lg-6">
                                                <label class="form-label">Sezione:*</label>
                                                <select class="form-control form-field" name="rg_sezione[]">
                                                    <option value="">Seleziona</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="rg_add_studente" class="btn btn-primary">Aggiungi Studente</button>
                    </div>
                    <?php endif; ?>

                    <?php if($progetto['progetto'] === 'Il Calcio e le Ore di Lezione'): ?>
                    <label for="col" class="btn btn-info form-field">Il Calcio e le Ore di Lezione</label>
                    <input id="col" type="checkbox" hidden="true" name="col" class="display-controller" />
                    <div class="panel panel-default display-item" hidden="true">
                        <div class="panel-heading"><h5>Il Calcio e le Ore di Lezione</h5></div>
                        <div id="col_div" class="panel-body">
                            <div id="col_classe">
                                <div class="row box">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <label class="form-label">Classe:*</label>
                                                <select class="form-control form-field" name="col_classe[]">
                                                    <option value="">Seleziona</option>
                                                    <option value="1">1°</option>
                                                    <option value="2">2°</option>
                                                    <option value="3">3°</option>
                                                    <option value="4">4°</option>
                                                    <option value="5">5°</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-lg-6">
                                                <label class="form-label">Sezione:*</label>
                                                <select class="form-control form-field" name="col_sezione[]">
                                                    <option value="">Seleziona</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                </select>
                                            </div>
                                        </div>

                                        <label class="form-label">Numero di studenti:*</label>
                                        <input type="number" class="form-control form-field" name="col_n_studenti[]" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="col_add_classe" class="btn btn-primary">Aggiungi Classe</button>
                    </div>
                    <?php endif; ?>

                    <?php if($progetto['progetto'] === 'Campionati Studenteschi'): ?>
                    <label for="cs" class="btn btn-info form-field">Campionati Studenteschi</label>
                    <input id="cs" type="checkbox" hidden="true" name="cs" class="display-controller" /> 
                    <div class="panel panel-default display-item" hidden="true">
                        <div class="panel-heading"><h5>Campionati Studenteschi</h5></div>
                        <div id="cs_div" class="panel-body">
                            <div id="cs_studente">
                                <div class="row box">
                                    <div class="panel-body col-md-12 col-lg-12">
                                        <label class="form-label">Nome Studente:*</label>
                                        <input type="text" class="form-control form-field" name="cs_nome_studente[]" />

                                        <label class="form-label">Cognome Studente:*</label>
                                        <input type="text" class="form-control form-field" name="cs_cognome_studente[]" />

                                        <label class="form-label">Sesso Studente:*</label>
                                        <select class="form-control form-field" name="cs_sesso_studente[]">
                                            <option value="">Seleziona</option>
                                            <option value="M">M</option>
                                            <option value="F">F</option>
                                        </select>

                                        <label class="form-label">Data di nascita:</label>
                                        <input class="datepicker form-control form-field" type="text" name="cs_data_nascita[]" />

                                        <div class="row">
                                            <div class="col-md-6 col-lg-6">
                                                <label class="form-label">Classe:*</label>
                                                <select class="form-control form-field" name="cs_classe[]">
                                                    <option value="">Seleziona</option>
                                                    <option value="1">1°</option>
                                                    <option value="2">2°</option>
                                                    <option value="3">3°</option>
                                                    <option value="4">4°</option>
                                                    <option value="5">5°</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-lg-6">
                                                <label class="form-label">Sezione:*</label>
                                                <select class="form-control form-field" name="cs_sezione[]">
                                                    <option value="">Seleziona</option>
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                    <option value="E">E</option>
                                                    <option value="F">F</option>
                                                    <option value="G">G</option>
                                                    <option value="H">H</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12 col-lg-12">
                                                <select name="cs_tipo_campionato[]" class="form-control form-field">
                                                    <option value="">Seleziona Campionato</option>
                                                    <option value="Calcio a 5">Calcio a 5</option>
                                                    <option value="Calcio a 11">Calcio a 11</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="cs_add_studente" class="btn btn-primary">Aggiungi Studente</button>
                    </div>
                    <?php endif; ?>
                <?php endforeach; ?>

                <button type="submit" class="btn btn-primary btn-block btn-fat">Salva Modifiche</button>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    const gc_studente = $('#gc_studente').html();
    const rg_studente = $('#rg_studente').html();
    const cs_studente = $('#cs_studente').html();
    const col_classe = $('#col_classe').html();
    
    const datepicker_options = {
        language: 'it-IT',
        format: 'dd/mm/yyyy',
        autoclose: true
    };

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

        $('#gc_add_studente').on('click', () => {
            $('#gc_div').append(gc_studente);
            $('.datepicker').datepicker(datepicker_options);
        });

        $('#rg_add_studente').on('click', () => {
            $('#rg_div').append(rg_studente);
            $('.datepicker').datepicker(datepicker_options);
        });

        $('#cs_add_studente').on('click', () => {
            $('#cs_div').append(cs_studente);
            $('.datepicker').datepicker(datepicker_options);
        });

        $('#col_add_classe').on('click', () => {
            $('#col_div').append(col_classe);
            $('.datepicker').datepicker(datepicker_options);
        });

        $('.datepicker').datepicker({ 
            format: 'dd/mm/yyyy', 
            autoclose: true 
        });
    });
</script>