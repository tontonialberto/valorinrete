<?php
class Istituto extends CI_Controller {

    /* 
        ## PUBLIC METHODS ##

        1. __construct()
        2. index()
        3. login()
        4. login_process()
        5. logout()
        6. sign_up()
        7. select_projects()
        8. subscribe()
        9. activate_account()
        10. profile_overview()
        11. ask_for_new_password()
        12. change_password()

------------------------------------

        ## PRIVATE METHODS ##

        13. send_mail()
        14. send_new_password_mail()
        15. form_validation_sign_up()
        16. form_validation_select_projects()
        17. form_validation_subscribe()
        18. create_istituto()
        19. password_is_correct()
        20. _send_mail_giococalciando()
    */


    /* 1. __construct() */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('istituto_model');
        $this->load->library('debug');

        // Utile in fase di debug, stampa
        // in modo ordinato tutte le variabili
        // di sessione.
        
        $this->debug->print_session();

        // Utile in fase di debug, stampa tutti
        // i dati passati tramite HTTP.
        
        $this->debug->print_request();
    }

    

    /* 2. index() */
    // Se l'utente è loggato, carica la view della home page,
    // altrimenti reindirizza alla pagina di login.

    public function index()
    {
        $this->load->helper('url');
        $this->load->library('session');

        // Se l'utente non è loggato, viene reindirizzato al login
        if(!isset($this->session->istituto)) return redirect('istituto/login');

        // L'array $data viene passato alle views per poter visualizzare
        // alcuni dati in modo dinamico.
        
        $data['title'] = 'Pannello di Controllo';
        $data['user'] = $this->session->istituto;

        $this->load->view('header', $data);
        $this->load->view('menu', $data);
        $this->load->view('istituto/index', $data);
        $this->load->view('footer');
    }

    /* 3. login() */
    // Carica la view che consente di accedere
    // al back-end. Se l'utente è già connesso
    // viene reindirizzato all'index.
    
    public function login()
    {
        // Libreria utilizzata nella view.
        $this->load->helper('url');

        $this->load->library('session');
        if(isset($this->session->istituto)) return redirect('istituto/index');

        $this->session->sess_destroy(); // Evita di portarsi dietro dati di sessioni precedenti

        $data['title'] = 'Login Istituto';

        $this->load->view('header', $data);
        $this->load->view('istituto/login', $data);
        $this->load->view('footer');
    }

    /* 4. login_process() */
    // Processa i dati che gli sono stati inviati
    // dalla view del login.
    
    public function login_process()
    {
        $this->load->helper('url');
        
        $istituto = $this->istituto_model->login($this->input->post('email'), $this->input->post('password'));
        
        // Se il login fallisce..
        if($istituto === FALSE)
        {
            // Ricarica la pagina di login con un messaggio di errore.
            $data['error'] = 'Indirizzo e-mail e/o password errati.';
            $data['title'] = 'Login Istituto';

            redirect('istituto/login');
        }
        else
        {
            // ..altrimenti viene creata una nuova sessione utente.
            $this->load->library('session');
            $this->session->istituto = array(
                'email' => $istituto->email_referente,
                'nome_referente' => $istituto->nome_referente,
                'cognome_referente' => $istituto->cognome_referente,
                'cod_meccanografico' => $istituto->cod_meccanografico,
                'nome_istituto' => $istituto->nome_istituto,
                'lv' => 'istituto'
            );

            redirect('istituto/index');
        }
    }

    /* 5. logout() */
    // Distrugge la sessione utente e reindirizza alla Home.
    
    public function logout()
    {
        $this->load->helper('url');
        $this->load->library('session');
        $this->session->sess_destroy();

        return redirect('istituto/login');
    }

    /* 6. sign_up() */
    // Registrazione di un nuovo Istituto(Fase 1: Inserimento dati Istituto)
    
    public function sign_up()
    {
        // Se è già esistente una sessione(ovvero se l'utente ha
        // già effettuato l'accesso), si viene reindirizzati
        // alla Home.
        
        $this->load->helper('url');
        $this->load->library('session');
        if(isset($this->session->istituto)) return redirect('istituto/index');

        $this->load->model('common_model');

        // Opzioni(prese dal database) da inserire nelle selectbox per selezionare
        // regione, provincia e comune dell'Istituto.
        
        $data['regioni'] = $this->common_model->get_regioni();
        $data['province'] = $this->common_model->get_province();
        $data['comuni'] = $this->common_model->get_comuni();

        // Titolo della pagina di iscrizione
        $data['title'] = 'Registrazione Istituto';

        // Se i dati inseriti non soddisfano le regole sopra descritte..
        if($this->form_validation_sign_up() === FALSE)
        {
            // ..si viene reindirizzati alla stessa pagina
            // che questa volta presenta le cause dell'errore
            // nell'inserimento dei dati.
            
            $this->load->view('header', $data);
            $this->load->view('istituto/sign_up');
            $this->load->view('footer');
        }
        else
        {
            // Salva in una sessione tutti i dati inseriti,
            // verranno inseriti nel db alla fine dello step 3.
            
            $this->load->library('session');
            $this->session->dati_istituto = array(
                'cod_meccanografico' => $this->input->post('cod_meccanografico'),
                'nome_referente' => $this->input->post('nome_referente'),
                'cognome_referente' => $this->input->post('cognome_referente'),
                'email_referente' => $this->input->post('email_referente'),
                'password' => $this->input->post('password'),
                'comune' => $this->input->post('comune'),
                'provincia' => $this->input->post('provincia'),
                'regione' => $this->input->post('regione'),
                'indirizzo' => $this->input->post('indirizzo'),
                'cap' => $this->input->post('cap'),
                'nome_istituto' => $this->input->post('nome_istituto'),
                'email_istituto' => $this->input->post('email_istituto'),
                'telefono_referente' => $this->input->post('telefono_referente')
            );

            // Crea una variabile di sessione che consente
            // di proseguire alla selezione progetti.
            
            $this->session->go_to_select_projects = TRUE;

            // Inoltre si viene reindirizzati alla pagina successiva,
            // cioè quella di selezione dei progetti.
            
            return redirect('istituto/select_projects');
        }
    }

    /* 7. select_projects() */
    // Fase 2 della registrazione(selezione dei progetti),
    // raggiungibile soltanto se si ha completato la prima parte
    
    public function select_projects()
    {
        $this->load->library('session');
        $this->load->helper('url');

        // Consente di accedere al pannello di selezione progetti
        // solamente se prima è stato compilato il modulo con
        // i dati dell'istituto.
        
        if(!$this->session->go_to_select_projects) return show_404();

        $data['title'] = 'Selezione Progetti';
        $data['dati_istituto'] = $this->session->dati_istituto;

        // Se ci sono errori di inserimento oppure nessun progetto
        // è stato selezionato..

        if($this->form_validation_select_projects() === FALSE ||
            (!$this->input->post('gc') && !$this->input->post('rg') &&
                !$this->input->post('col') && !$this->input->post('cs')))
        {
            // ..si viene reindirizzati alla stessa pagina.
            $this->load->view('header', $data);
            $this->load->view('istituto/select_projects');
            $this->load->view('footer');
        }
        else
        {
            $_SESSION['dati_istituto']['grado_istituto'] = intval($this->input->post('grado_istituto'));

            // Salva in una sessione tutte le candidature ricevute in input.
            // Verranno salvati nel db alla fine dello step 3.
            
            if($this->input->post('gc'))
            {
                $this->session->dati_gc = array(
                    'nome_referente' => $this->input->post('gc_nome_referente'),
                    'cognome_referente' => $this->input->post('gc_cognome_referente'),
                    'telefono_referente' => $this->input->post('gc_telefono_referente'),
                    'email_referente' => $this->input->post('gc_email_referente'),
                    'id_progetto' => 1, // id del progetto di riferimento(nel database)
                    'id_istituto' => $this->session->dati_istituto['cod_meccanografico'],
                    'data_incontro' => $this->input->post('gc_data_incontro[]')[0],
                );
            }
            if($this->input->post('rg'))
            {
                $this->session->dati_rg = array(
                    'nome_referente' => $this->input->post('rg_nome_referente'),
                    'cognome_referente' => $this->input->post('rg_cognome_referente'),
                    'telefono_referente' => $this->input->post('rg_telefono_referente'),
                    'email_referente' => $this->input->post('rg_email_referente'),
                    'impianti_gioco_disponibili' => $this->input->post('rg_impianti_gioco_disponibili'),
                    'societa_affiliate' => $this->input->post('rg_istituto_convenzionato'),
                    'iscrizione_categoria_cadette' => $this->input->post('rg_iscrizione_categoria_cadette'),
                    'id_progetto' => 3, // id del progetto di riferimento(nel database)
                    'id_istituto' => $this->session->dati_istituto['cod_meccanografico'],
                    'data_incontro' => $this->input->post('rg_data_incontro')[0]
                );
            }
            if($this->input->post('col'))
            {
                $this->session->dati_col = array(
                    'nome_referente' => $this->input->post('col_nome_referente'),
                    'cognome_referente' => $this->input->post('col_cognome_referente'),
                    'telefono_referente' => $this->input->post('col_telefono_referente'),
                    'email_referente' => $this->input->post('col_email_referente'),
                    'id_progetto' => 2, // id del progetto di riferimento(nel database)
                    'id_istituto' => $this->session->dati_istituto['cod_meccanografico'],
                    'data_incontro' => $this->input->post('col_data_incontro[]')[0]
                );
            }
            if($this->input->post('cs'))
            {
                $this->session->dati_cs = array(
                    'nome_referente' => $this->input->post('cs_nome_referente'),
                    'cognome_referente' => $this->input->post('cs_cognome_referente'),
                    'telefono_referente' => $this->input->post('cs_telefono_referente'),
                    'email_referente' => $this->input->post('cs_email_referente'),
                    'id_progetto' => 4, // id del progetto di riferimento(nel database)
                    'id_istituto' => $this->session->dati_istituto['cod_meccanografico']
                );
            }

            // Fa in modo che l'utente non possa compilare nuovamente
            // il form appena compilato correttamente.
            
            $this->session->go_to_select_projects = NULL;

            // Abilita l'accesso alla pagina
            // che permette di effettuare l'ultima fase dell'iscrizione.
            
            $this->session->go_to_subscribe = TRUE;

            // Consente di saltare lo step 3 della registrazione se viene cliccato un bottone.
            if($this->input->post('skip_subscribe')) $this->session->skip_subscribe = TRUE;

            // Reindirizza alla pagina di registrazione classi e studenti.
            return redirect('istituto/subscribe');
        }
    }

    /* 8. subscribe() */
    // Fase 3(ed ultima) di iscrizione di un Istituto.
    // In questa pagina vengono inserite le classi e gli studenti
    // che parteciperanno ai progetti scelti nella fase 2.
    
    public function subscribe()
    {
        $this->load->library('session');
        $this->load->library('date');
        $this->load->library('account');
        $this->load->database();

        // Consente di accedere al pannello di iscrizione studenti
        // solamente se prima è stato compilato il modulo di selezione dei progetti.
        
        if(!$this->session->go_to_subscribe) return show_404();

        // Dati da passare alla view, relativi agli inserimenti precedenti.
        $data['dati_istituto'] = $this->session->dati_istituto;
        $data['dati_gc'] = $this->session->dati_gc;
        $data['dati_rg'] = $this->session->dati_rg;
        $data['dati_col'] = $this->session->dati_col;
        $data['dati_cs'] = $this->session->dati_cs;
        $data['title'] = 'Registrazione Classi e Studenti';

        if($this->session->skip_subscribe === TRUE)
        {
            // Consente di registrare gli Istituti, le candidature e gli incontri anche se non
            // hanno completato lo step 3(Registrazione Studenti e Classi)
            
            // Inserimento Istituto
            $this->create_istituto($this->session->dati_istituto);
            
            if($this->session->dati_gc)
            {
                // Inserimento candidatura GiocoCalciando
                $id_candidatura = $this->istituto_model->create_candidatura($this->session->dati_gc);

                // Inserimento date incontri GiocoCalciando
                for($i=0; $i<sizeof($this->session->dati_gc['data_incontro']); $i++)
                {
                    $data_incontro = $this->session->dati_gc['data_incontro'];

                    // Inserisce i dati dell'incontro nel database.
                    $this->db->insert('tab_incontri', array(
                        'data_incontro' => $this->date->to_mysql_date($data_incontro),
                        'id_candidatura' => $id_candidatura
                    ));
                }
            }
            if($this->session->dati_rg)
            {
                // Inserimento candidatura Ragazze in Gioco
                $id_candidatura = $this->istituto_model->create_candidatura($this->session->dati_rg);

                // Inserimento date incontri GiocoCalciando
                for($i=0; $i<sizeof($this->session->dati_rg['data_incontro']); $i++)
                {
                    $data_incontro = $this->session->dati_rg['data_incontro'];

                    // Inserisce i dati dell'incontro nel database.
                    $this->db->insert('tab_incontri', array(
                        'data_incontro' => $this->date->to_mysql_date($data_incontro),
                        'id_candidatura' => $id_candidatura
                    ));
                }
            }
            if($this->session->dati_col)
            {
                // Inserimento candidatura Il Calcio e le Ore di Lezione
                $id_candidatura = $this->istituto_model->create_candidatura($this->session->dati_col);

                // Inserimento date incontri GiocoCalciando
                for($i=0; $i<sizeof($this->session->dati_col['data_incontro']); $i++)
                {
                    $data_incontro = $this->session->dati_col['data_incontro'];

                    // Inserisce i dati dell'incontro nel database.
                    $this->db->insert('tab_incontri', array(
                        'data_incontro' => $this->date->to_mysql_date($data_incontro),
                        'id_candidatura' => $id_candidatura
                    ));
                }
            }
            if($this->session->dati_cs)
            {
                // Inserimento candidatura Campionati Studenteschi
                $id_candidatura = $this->istituto_model->create_candidatura($this->session->dati_cs);
            }
            
            // Se tutti i dati dell'iscrizione(dei primi 2 step) sono stati inseriti
            // con successo, reindirizza ad una pagina che comunica all'utente
            // l'effettivo completamento della registrazione.
            
            $this->session->sess_destroy();

            $data['title'] = 'Registrazione completata';

            $this->load->view('header', $data);
            $this->load->view('sign_up_success', $data);
            $this->load->view('footer');

            // Esce dalla funzione per evitare
            // che venga mostrata la pagina
            // di registrazione delle classi/studenti
            
            return;
            
        }
        else if($this->form_validation_subscribe() === FALSE)
        {
            $this->load->view('header', $data);
            $this->load->view('istituto/subscribe', $data);
            $this->load->view('footer');
        }
        else
        {
            // Se tutti i dati delle classi e degli studenti sono stati
            // inseriti correttamente, inserisce i dati nel database:
            // 1)Inserimento Istituto
            // 2)Inserimento Candidatura/e
            // 3)Inserimento classi/studenti

            // Inserimento Istituto
            $this->create_istituto($this->session->dati_istituto);

            // Invia una mail al referente dell'Istituto
            // con le istruzioni per confermare l'account.
            
            $this->send_mail($this->session->dati_istituto['email_referente']);

            if($this->session->dati_gc)
            {
                // Inserimento candidatura GiocoCalciando
                $id_candidatura = $this->istituto_model->create_candidatura($this->session->dati_gc);

                // Inserimento date incontri GiocoCalciando
                for($i=0; $i<sizeof($this->session->dati_gc['data_incontro']); $i++)
                {
                    $data_incontro = $this->session->dati_gc['data_incontro'];

                    // Inserisce l'incontro nel db.
                    $this->db->insert('tab_incontri', array(
                        'data_incontro' => $this->date->to_mysql_date($data_incontro),
                        'id_candidatura' => $id_candidatura
                    ));
                }

                // Inserimento Studenti GiocoCalciando
                $studenti = array();
                $gc_accounts = array(); // Usato per registrare gli account degli studenti
                for($i=0; $i<sizeof($this->input->post('gc_nome_studente[]')); $i++)
                {
                    // Mappa tutti gli studenti per poterli inserire nel db.
                    $studenti[$i]['nome'] = $this->input->post('gc_nome_studente[]')[$i];
                    $studenti[$i]['cognome'] = $this->input->post('gc_cognome_studente[]')[$i];
                    $studenti[$i]['data_nascita'] = $this->date->to_mysql_date($this->input->post('gc_data_nascita[]')[$i]);
                    $studenti[$i]['sesso'] = $this->input->post('gc_sesso_studente[]')[$i];
                    $studenti[$i]['classe'] = $this->input->post('gc_classe[]')[$i];
                    $studenti[$i]['sezione'] = $this->input->post('gc_sezione[]')[$i];
                    $studenti[$i]['id_istituto'] = $this->session->dati_istituto['cod_meccanografico'];
                    $studenti[$i]['grado_istituto'] = 1;
                    $studenti[$i]['nickname'] = $this->account->generate_username(array(
                        $studenti[$i]['nome'],
                        $studenti[$i]['cognome'],
                        $studenti[$i]['classe'],
                        $studenti[$i]['sezione']
                    )); // Username dello studente per GiocoCalciando
                    $studenti[$i]['password'] = $this->account->generate_password();

                    $id_studente = $this->istituto_model->create_studente($studenti[$i]);

                    // Crea il collegamento tra lo studente e la candidatura
                    // inserendo un nuovo record nella tabella tab_studenti_candidature.
                    
                    $this->db->insert('tab_studenti_candidature', array(
                        'id_studente' => $id_studente,
                        'id_candidatura' => $id_candidatura
                    ));

                    // Aggiunge un elemento all'array $accounts,
                    // generando username e password.

                    $gc_accounts[$i]['username'] = $studenti[$i]['nickname'];
                    $gc_accounts[$i]['password'] = $studenti[$i]['password'];
                    $gc_accounts[$i]['classe'] = $studenti[$i]['classe'];
                    $gc_accounts[$i]['sezione'] = $studenti[$i]['sezione'];
                }

                // Invia una mail al referente dell'istituto,
                // specificando i dati di accesso per GiocoCalciando.

                $this->_send_mail_giococalciando($this->session->dati_istituto['email_referente'], $gc_accounts);
            }
            if($this->session->dati_rg)
            {
                // Inserimento candidatura Ragazze in Gioco
                $id_candidatura = $this->istituto_model->create_candidatura($this->session->dati_rg);

                // Inserimento date incontri Ragazze in Gioco
                for($i=0; $i<sizeof($this->session->dati_rg['data_incontro']); $i++)
                {
                    $data_incontro = $this->session->dati_rg['data_incontro'];

                    // Inserisce l'incontro nel db.
                    $this->db->insert('tab_incontri', array(
                        'data_incontro' => $this->date->to_mysql_date($data_incontro),
                        'id_candidatura' => $id_candidatura
                    ));
                }

                // Inserimento Studenti Ragazze in Gioco
                $studenti = array();
                for($i=0; $i<sizeof($this->input->post('rg_nome_studente[]')); $i++)
                {
                    // Mappa tutti gli studenti per poterli inserire nel db.
                    $studenti[$i]['nome'] = $this->input->post('rg_nome_studente[]')[$i];
                    $studenti[$i]['cognome'] = $this->input->post('rg_cognome_studente[]')[$i];
                    $studenti[$i]['data_nascita'] = $this->date->to_mysql_date($this->input->post('rg_data_nascita[]')[$i]);
                    $studenti[$i]['sesso'] = $this->input->post('rg_sesso_studente[]')[$i];
                    $studenti[$i]['classe'] = $this->input->post('rg_classe[]')[$i];
                    $studenti[$i]['sezione'] = $this->input->post('rg_sezione[]')[$i];
                    $studenti[$i]['id_istituto'] = $this->session->dati_istituto['cod_meccanografico'];
                    $studenti[$i]['grado_istituto'] = 2;

                    $id_studente = $this->istituto_model->create_studente($studenti[$i]);

                    // Crea il collegamento tra lo studente e la candidatura
                    // inserendo un nuovo record nella tabella tab_studenti_candidature.
                    
                    $this->db->insert('tab_studenti_candidature', array(
                        'id_studente' => $id_studente,
                        'id_candidatura' => $id_candidatura
                    ));
                }
            }
            if($this->session->dati_col)
            {
                // Inserimento candidatura Il Calcio e le Ore di Lezione
                $id_candidatura = $this->istituto_model->create_candidatura($this->session->dati_col);

                // Inserimento date incontri Il Calcio e le Ore di Lezione
                for($i=0; $i<sizeof($this->session->dati_col['data_incontro']); $i++)
                {
                    $data_incontro = $this->session->dati_col['data_incontro'];

                    // Inserisce l'incontro nel db
                    $this->db->insert('tab_incontri', array(
                        'data_incontro' => $this->date->to_mysql_date($data_incontro),
                        'id_candidatura' => $id_candidatura
                    ));
                }

                // Inserimento Classi partecipanti al progetto
                $classi = array();
                for($i=0; $i<sizeof($this->input->post('col_classe[]')); $i++)
                {
                    $classi[$i]['classe'] = $this->input->post('col_classe[]')[$i];
                    $classi[$i]['sezione'] = $this->input->post('col_sezione[]')[$i];
                    $classi[$i]['n_studenti'] = $this->input->post('col_n_studenti[]')[$i];
                    $classi[$i]['id_istituto'] = $this->session->dati_istituto['cod_meccanografico'];
                    $classi[$i]['grado_istituto'] = $this->session->dati_istituto['grado_istituto'];

                    $id_classe = $this->istituto_model->create_classe($classi[$i]);

                    // Crea il collegamento tra la classe e la candidatura
                    // inserendo un nuovo record nella tabella tab_classi_candidature.
                    
                    $this->db->insert('tab_classi_candidature', array(
                        'id_classe' => $id_classe,
                        'id_candidatura' => $id_candidatura
                    ));
                }
            }
            if($this->session->dati_cs)
            {
                // Inserimento candidatura Campionati Studenteschi
                $id_candidatura = $this->istituto_model->create_candidatura($this->session->dati_cs);

                // Inserimento Studenti Campionati Studenteschi
                $studenti = array();
                for($i=0; $i<sizeof($this->input->post('cs_nome_studente[]')); $i++)
                {
                    // Mappa tutti gli studenti per poterli inserire nel db.
                    $studenti[$i]['nome'] = $this->input->post('cs_nome_studente[]')[$i];
                    $studenti[$i]['cognome'] = $this->input->post('cs_cognome_studente[]')[$i];
                    $studenti[$i]['data_nascita'] = $this->date->to_mysql_date($this->input->post('cs_data_nascita[]')[$i]);
                    $studenti[$i]['sesso'] = $this->input->post('cs_sesso_studente[]')[$i];
                    $studenti[$i]['classe'] = $this->input->post('cs_classe[]')[$i];
                    $studenti[$i]['sezione'] = $this->input->post('cs_sezione[]')[$i];
                    $studenti[$i]['id_istituto'] = $this->session->dati_istituto['cod_meccanografico'];
                    $studenti[$i]['grado_istituto'] = $this->session->dati_istituto['grado_istituto'];
                    $studenti[$i]['tipo_campionato'] = $this->input->post('cs_tipo_campionato[]')[$i];

                    $id_studente = $this->istituto_model->create_studente($studenti[$i]);

                    // Crea il collegamento tra lo studente e la candidatura
                    // inserendo un nuovo record nella tabella tab_studenti_candidature.
                    
                    $this->db->insert('tab_studenti_candidature', array(
                        'id_studente' => $id_studente,
                        'id_candidatura' => $id_candidatura
                    ));
                }
            }

            // Se tutti i dati dell'iscrizione sono stati inseriti
            // con successo, reindirizza ad una pagina che comunica all'utente
            // l'effettivo completamento della registrazione.
            
            $this->session->sess_destroy();

            $data['title'] = 'Registrazione completata';

            $this->load->view('header', $data);
            $this->load->view('sign_up_success', $data);
            $this->load->view('footer');
        }
    }

    /* 9. activate_account() */
    // Utilizza il token presente nell'URL per attivare
    // l'account dell'istituto e carica la view per stampare
    // l'esito della procedura.
    
    public function activate_account()
    {
        if(!$this->input->get('token')) return redirect('istituto/index');

        $token = $this->input->get('token');

        $this->istituto_model->activate($token) ?
            $data['message'] = 'Account attivato con successo' :
            $data['message'] = 'Errore nell\'attivazione dell\'account';

        $data['title'] = 'Esito attivazione account';

        $this->load->view('header', $data);
        $this->load->view('activate_account', $data);
        $this->load->view('footer');
    }

    /* 10. profile_overview() */
    // Fa parte del pannello di controllo:
    // mostra il riepilogo dei dati inseriti dall'istituto
    // durante le fasi di registrazione.
    
    public function profile_overview()
    {
        $this->load->library('session');
        $this->load->helper('url');

        // Impedisce di accedere al pannello di controllo
        // agli utenti non autorizzati.
        
        if(!$this->session->istituto) return redirect('istituto/index');

        // Estrazione dati istituto
        $dati_istituto = $this->istituto_model->get($this->session->istituto['email']);
        // Estrazione dati candidature
        $dati_candidature = $this->istituto_model->get_candidature_by_istituto($dati_istituto);

        $data['title'] = 'Riepilogo Dati';
        $data['user'] = $this->session->istituto;
        $data['istituto'] = (array)$dati_istituto[0];
        $data['candidature'] = (array)$dati_candidature;

        $this->load->view('header', $data);
        $this->load->view('menu', $data);
        $this->load->view('istituto/profile_overview', $data);
    }

    /* 11. ask_for_new_password() */
    // Mostra una pagina che chiede all'utente di
    // inserire il suo codice meccanografico per 
    // poter ricevere via email la nuova password.
    
    public function ask_for_new_password()
    {
        $in_cod_meccanografico = $this->input->post('cod_meccanografico');

        // Se il codice meccanografico è stato inserito..
        if($in_cod_meccanografico)
        {
            // ..imposta una nuova password per l'account corrispondente.
            $new_password = $this->istituto_model->set_random_password($in_cod_meccanografico);

            // Se l'operazione ha successo..
            if($new_password)
            {
                // ..ricerca l' indirizzo email dell' istituto nel db..
                $istituto = $this->istituto_model
                    ->get_by_id($in_cod_meccanografico);
                
                if($istituto)
                {
                    $email_istituto = $istituto['email_referente'];

                    // ..ed invia una mail all'indirizzo, con le informazioni
                    // riguardanti la nuova password.
                    
                    $this->send_new_password_mail($email_istituto, $new_password);

                    // Carica la pagina che comunica all'utente
                    // che l'operazione ha avuto successo.
                    
                    $data['title'] = 'Nuova Password Inviata';
                    $this->load->view('header', $data);
                    $this->load->view('istituto/ask_password_result');
                    $this->load->view('footer');

                    return;
                }
            }
        }
        
        // Se i dati per l'invio della password non sono stati
        // inseriti o sono incorretti, ricarica il modulo per
        // reinserire gli stessi dati.
        
        $data['title'] = 'Reinvia Password';

        $this->load->view('header', $data);
        $this->load->view('istituto/ask_for_new_password');
        $this->load->view('footer');
    }

    /* 12. change_password() */
    // Fa parte del Pannello di Controllo.
    // Mostra all'utente il modulo per cambiare la propria
    // password. Se l'inserimento dei dati è corretto,
    // reindirizza l'utente ad una pagina che gli comunica
    // il risultato dell'operazione.
    
    public function change_password()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('vecchia_password', 'Vecchia Password', 'required|callback_password_is_correct');
        $this->form_validation->set_rules('nuova_password', 'Nuova Password', 'required|min_length[6]');
        $this->form_validation->set_rules('conferma_nuova_password', 'Conferma Nuova Password', 'required|min_length[6]|matches[nuova_password]');

        if($this->form_validation_run() === FALSE)
        {
            $data['user'] = $this->session->istituto;

            $this->load->view('menu', $data);
            $this->load->view('istituto/change_password');
        }
        else
        {
            $change_password_result = $this->istituto_model
                ->set_password($this->session->istituto['cod_meccanografico'], $this->input->post('nuova_password'));
            
            $data['user'] = $this->session->istituto;
            $data['title'] = 'Esito Modifica Password';
            $data['result'] = $change_password_result ? 
                'Password modificata con successo' : 'Si è verificato un errore nella modifica della password';
            
            $this->load->view('menu', $data);
            $this->load->view('change_password_result', $data);
        }
    }

    /* 13. send_mail() */
    // Invia una mail (all'indirizzo ricevuto come parametro)
    // contenente il link per attivare il suo account.
    
    private function send_mail($to)
    {
        $istituto_row = $this->istituto_model->get($to);
        $istituto_row = $istituto_row[0];

        $this->load->library('email');

        $this->email->from('info@go2mkt.com', 'Portale Valorinrete');
        $this->email->to($to);
        $this->email->subject('Valorinrete - Conferma Registrazione');
        $this->email->message('
        Gentile referente Istituto,
        clicca sul seguente link per attivare il tuo account: http://go2mkt.com/valorinrete/istituto/activate_account/?token='
        .$istituto_row->token_attiva_account);
        $this->email->send();
    }

    /* 14. send_new_password_mail() */
    // Invia all'indirizzo email dell'istituto(passato come parametro)
    // la nuova password, generata automaticamente dal sistema.
    
    private function send_new_password_mail($to, $password)
    {
        $this->load->library('email');

        $this->email->from('info@go2mkt.com', 'Portale Valorinrete');
        $this->email->to($to);
        $this->email->subject('Valorinrete - Nuova Password');
        $this->email->message('
        Gentile referente Istituto,
        abbiamo provveduto a cambiare la tua password.
        I tuoi nuovi dati di accesso sono
        Email: '.$to.' Password: '.$password.'.
        Ricorda che puoi modificare la tua password
        all\' interno del pannello di controllo.
        Grazie del tuo tempo,
        Buona Giornata');
        $this->email->send();
    }

    /* 15. form_validation_sign_up() */
    // Funzione richiamata da /sign_up per applicare
    // le regole di validazione della form di registrazione.
    // L'ho esternalizzata per diminuire il codice all'interno della funzione chiamante.
    
    private function form_validation_sign_up()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        // regole per la validazione della form di iscrizione
        $this->form_validation->set_rules('cod_meccanografico', 'Codice Meccanografico', 'required|exact_length[10]|is_unique[tab_istituti.cod_meccanografico]');
        $this->form_validation->set_rules('nome_referente', 'Nome Referente', 'required');
        $this->form_validation->set_rules('cognome_referente', 'Cognome Referente', 'required');
        $this->form_validation->set_rules('email_referente', 'Email Referente', 'required|valid_email|matches[conferma_email_referente]|is_unique[tab_istituti.email_referente]');
        $this->form_validation->set_rules('conferma_email_referente', 'Conferma Email Referente', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[conferma_password]');
        $this->form_validation->set_rules('conferma_password', 'Conferma Password', 'required|min_length[6]');
        $this->form_validation->set_rules('comune', 'Comune', 'required');
        $this->form_validation->set_rules('provincia', 'Provincia', 'required');
        $this->form_validation->set_rules('regione', 'Regione', 'required');
        $this->form_validation->set_rules('indirizzo', 'Indirizzo', 'required');
        $this->form_validation->set_rules('cap', 'CAP', 'required|exact_length[5]');
        $this->form_validation->set_rules('nome_istituto', 'Nome Istituto', 'required');
        $this->form_validation->set_rules('email_istituto', 'Email Istituto', 'required|valid_email|matches[conferma_email_istituto]|is_unique[tab_istituti.email_istituto]');
        $this->form_validation->set_rules('conferma_email_istituto', 'Conferma Email Istituto', 'required|valid_email');
        $this->form_validation->set_rules('telefono_referente', 'Telefono Referente', 'required|is_unique[tab_istituti.telefono_referente]|min_length[9]|max_length[11]');

        return $this->form_validation->run();
    }

    /* 16. form_validation_select_projects() */
    // Funzione richiamata da /select_projects per applicare
    // le regole di validazione della form di registrazione.
    // L'ho esternalizzata per diminuire il codice all'interno della funzione chiamante.
    
    private function form_validation_select_projects()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Poichè, al caricamento della pagina dei progetti,
        // non è visibile alcun form, le regole di validazione
        // vengono applicate in base ai progetti scelti.
        // gc  = GiocoCalciando
        // rg  = Ragazze in Gioco
        // col = Il Calcio e le Ore di Lezione
        // cs  = Campionati Studenteschi
        
        $this->form_validation->set_rules('grado_istituto', 'Grado Istituto', 'required');

        if($this->input->post('gc'))
        {
            $this->form_validation->set_rules('gc_nome_referente', 'GiocoCalciando - Nome Referente', 'required');
            $this->form_validation->set_rules('gc_cognome_referente', 'GiocoCalciando - Cognome Referente', 'required');
            $this->form_validation->set_rules('gc_telefono_referente', 'GiocoCalciando - Telefono Referente', 'required|min_length[9]|max_length[11]');
            $this->form_validation->set_rules('gc_email_referente', 'GiocoCalciando - Email Referente', 'required|valid_email|matches[gc_conferma_email_referente]');
            $this->form_validation->set_rules('gc_conferma_email_referente', 'GiocoCalciando - Conferma Email Referente', 'required|valid_email');
            $this->form_validation->set_rules('gc_data_incontro[]', 'GiocoCalciando - Data Incontro', 'required');
        }
        if($this->input->post('rg'))
        {
            $this->form_validation->set_rules('rg_nome_referente', 'Ragazze in Gioco - Nome Referente', 'required');
            $this->form_validation->set_rules('rg_cognome_referente', 'Ragazze in Gioco - Cognome Referente', 'required');
            $this->form_validation->set_rules('rg_telefono_referente', 'Ragazze in Gioco - Telefono Referente', 'required|min_length[9]|max_length[11]');
            $this->form_validation->set_rules('rg_email_referente', 'Ragazze in Gioco - Email Referente', 'required|valid_email|matches[rg_conferma_email_referente]');
            $this->form_validation->set_rules('rg_conferma_email_referente', 'Ragazze in Gioco - Conferma Email Referente', 'required|valid_email');
            $this->form_validation->set_rules('rg_impianti_gioco_disponibili', 'Ragazze in Gioco - Impianti da Gioco Disponibili', 'required');
            $this->form_validation->set_rules('rg_istituto_convenzionato', 'Ragazze in Gioco - Istituto convenzionato', 'required');
            $this->form_validation->set_rules('rg_iscrizione_categoria_cadette', 'Ragazze in Gioco - Iscrizione Categoria Cadette', 'required');
            $this->form_validation->set_rules('rg_data_incontro[]', 'Ragazze in Gioco - Data Incontro', 'required');
        }
        if($this->input->post('col'))
        {
            $this->form_validation->set_rules('col_nome_referente', 'Il Calcio e le Ore di Lezione - Nome Referente', 'required');
            $this->form_validation->set_rules('col_cognome_referente', 'Il Calcio e le Ore di Lezione - Cognome Referente', 'required');
            $this->form_validation->set_rules('col_telefono_referente', 'Il Calcio e le Ore di Lezione - Telefono Referente', 'required|min_length[9]|max_length[11]');
            $this->form_validation->set_rules('col_email_referente', 'Il Calcio e le Ore di Lezione - Email Referente', 'required|valid_email|matches[col_conferma_email_referente]');
            $this->form_validation->set_rules('col_conferma_email_referente', 'Il Calcio e le Ore di Lezione - Conferma Email Referente', 'required|valid_email');
            $this->form_validation->set_rules('col_data_incontro[]', 'Il Calcio e le Ore di Lezione - Data Incontro', 'required');
        }
        if($this->input->post('cs'))
        {
            $this->form_validation->set_rules('cs_nome_referente', 'Campionati Studenteschi - Nome Referente', 'required');
            $this->form_validation->set_rules('cs_cognome_referente', 'Campionati Studenteschi - Cognome Referente', 'required');
            $this->form_validation->set_rules('cs_telefono_referente', 'Campionati Studenteschi - Telefono Referente', 'required|min_length[9]|max_length[11]');
            $this->form_validation->set_rules('cs_email_referente', 'Campionati Studenteschi - Email Referente', 'required|valid_email|matches[cs_conferma_email_referente]');
            $this->form_validation->set_rules('cs_conferma_email_referente', 'GiocoCalciando - Conferma Email Referente', 'required|valid_email');
        }

        $this->form_validation->set_rules('adesione_progetti', 'Adesione Progetti', 'required');
        $this->form_validation->set_rules('privacy_policy', 'Privacy Policy', 'required');

        return $this->form_validation->run();
    }

    /* 17. form_validation_subscribe() */
    // Funzione richiamata da /subscribe per applicare
    // le regole di validazione della form di registrazione.
    // L'ho esternalizzata per diminuire il codice all'interno della funzione chiamante.
    
    private function form_validation_subscribe()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Poichè, al caricamento della pagina dei progetti,
        // non è visibile alcun form, le regole di validazione
        // vengono applicate in base ai progetti scelti in precedenza.
        // gc  = GiocoCalciando
        // rg  = Ragazze in Gioco
        // col = Il Calcio e le Ore di Lezione
        // cs  = Campionati Studenteschi
        
        if(isset($this->session->dati_gc))
        {
            $this->form_validation->set_rules('gc_nome_studente[]', 'GiocoCalciando - Nome Studente', 'required');
            $this->form_validation->set_rules('gc_cognome_studente[]', 'GiocoCalciando - Cognome Studente', 'required');
            $this->form_validation->set_rules('gc_sesso_studente[]', 'GiocoCalciando - Sesso Studente', 'required');
            $this->form_validation->set_rules('gc_classe[]', 'GiocoCalciando - Classe', 'required');
            $this->form_validation->set_rules('gc_sezione[]', 'GiocoCalciando - Sezione', 'required');
            $this->form_validation->set_rules('gc_data_nascita[]', 'GiocoCalciando - Data di Nascita', 'required');
        }
        if(isset($this->session->dati_rg))
        {
            $this->form_validation->set_rules('rg_nome_studente[]', 'Ragazze In Gioco - Nome Studente', 'required');
            $this->form_validation->set_rules('rg_cognome_studente[]', 'Ragazze In Gioco - Cognome Studente', 'required');
            $this->form_validation->set_rules('rg_classe[]', 'Ragazze In Gioco - Classe', 'required');
            $this->form_validation->set_rules('rg_sezione[]', 'Ragazze In Gioco - Sezione', 'required');
            $this->form_validation->set_rules('rg_data_nascita[]', 'Ragazze in Gioco - Data di Nascita', 'required');
        }
        if(isset($this->session->dati_cs))
        {
            $this->form_validation->set_rules('cs_nome_studente[]', 'Campionati Studenteschi - Nome Studente', 'required');
            $this->form_validation->set_rules('cs_cognome_studente[]', 'Campionati Studenteschi - Cognome Studente', 'required');
            $this->form_validation->set_rules('cs_sesso_studente[]', 'Campionati Studenteschi - Sesso Studente', 'required');
            $this->form_validation->set_rules('cs_classe[]', 'Campionati Studenteschi - Classe', 'required');
            $this->form_validation->set_rules('cs_sezione[]', 'Campionati Studenteschi - Sezione', 'required');
            $this->form_validation->set_rules('cs_data_nascita[]', 'Campionati Studenteschi - Data di Nascita', 'required');
            $this->form_validation->set_rules('cs_tipo_campionato[]', 'Campionati Studenteschi - Campionato', 'required');
        }
        if(isset($this->session->dati_col))
        {
            $this->form_validation->set_rules('col_classe[]', 'Il Calcio e le Ore di Lezione - Classe', 'required');
            $this->form_validation->set_rules('col_sezione[]', 'Il Calcio e le Ore di Lezione - Sezione', 'required');
            $this->form_validation->set_rules('col_n_studenti[]', 'Il Calcio e le Ore di Lezione - N°Studenti', 'required');
        }

        return $this->form_validation->run();
    }
    
    /* 18. create_istituto() */
    // Inserisce un nuovo Istituto nel database, usando un array
    // passato come parametro.
    
    private function create_istituto($istituto)
    {
        $this->istituto_model->create($this->session->dati_istituto);
    }

    /* 19. password_is_correct() */
    // Utilizzato come form validator.
    // Verifica che una password, associata ad un account,
    // sia corretta.
    
    private function password_is_correct($password)
    {
        $this->load->library('session');

        return $this->istituto_model->login($this->session->istituto['email'], $password);
    }

    /* 20. _send_mail_giococalciando() */
    // Invia una mail all'indirizzo specificato
    // indicando i dati di accesso al GiocoCalciando.

    private function _send_mail_giococalciando($to, array $accounts) // $account: ['username', 'password', 'classe', 'sezione']
    {
        $message = "";

        foreach($accounts as $account)
        {
            $message .= "Classe: " . $account['classe'] . $account['sezione'] . " <br />";
            $message .= "Username: " . $account['username'] . "<br />";
            $message .= "Password: " . $account['password'] . "<br />";
            $message .= "<br />";
        }

        $this->email->from('info@go2mkt.com', 'Portale Valorinrete');
        $this->email->to($to);
        $this->email->subject('Dati GiocoCalciando');
        $this->email->message($message);
        $this->email->send();

        var_dump($message);
    }
}
