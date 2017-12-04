<div class="container"> 
    <div class="panel panel-info" style="margin-top: 30px">
        <div class="panel-heading">
            <h4>Iscrizione Classi e Studenti</h4>
        </div>
        <div class="panel-body">
            <div class="progress">
                <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    Passo 3/3
                </div>
            </div>

            <?php echo validation_errors(); ?>

            <div class="spacer"></div>

            <?php echo form_open('istituto/subscribe'); ?>

                <?php if($dati_gc): ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><h5>GiocoCalciando</h5></div>
                    <div id="gc_div" class="panel-body">
                        <div id="gc_studente">
                            <div class="row box">
                                <div class="col-md-4 col-lg-4">
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

                <?php if($dati_rg): ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><h5>Ragazze in Gioco</h5></div>

                    <?php if(!$dati_cs && !$dati_col): // Se Ragazze in Gioco è l'unico progetto selezionato, allora l'Istituto è una Scuola Secondaria di Primo Grado ?>
                    <?php endif; ?>

                    <div id="rg_div" class="panel-body">
                        <div id="rg_studente">
                            <div class="row box">
                                <div class="col-md-4 col-lg-4">
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

                <?php if($dati_col): ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><h5>Il Calcio e le Ore di Lezione</h5></div>
                    <div id="col_div" class="panel-body">
                        <div id="col_classe">
                            <div class="row box">
                                <div class="col-md-4 col-lg-4">
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

                <?php if($dati_cs): ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><h5>Campionati Studenteschi</h5></div>
                    <div id="cs_div" class="panel-body">
                        <div id="cs_studente">
                            <div class="row box">
                                <div class="panel-body col-md-4 col-lg-4">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="cs_add_studente" class="btn btn-primary">Aggiungi Studente</button>
                </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary btn-block btn-fat">Prosegui</button>
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