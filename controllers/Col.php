<?php
class Col extends CI_Controller {

    /* 
        ## PUBLIC METHODS ##

        1. __construct()
        2. index()
        3. login()
        4. login_process()
        5. logout()
        6. sign_up()
        7. activate_account()
        8. subscriptions()
        9. download_anagrafiche()
        
---------------------------------------

        ## PRIVATE METHODS ##

        10. send_mail()
        11. xls_subscription_table()
        12. redirect_if_not_logged_in()
        13. redirect_if_logged_in()
        14. form_validation_sign_up()
    */

    /* 1. __construct() */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('col_model');
    }

    /* 2. index() */
    // Se l'utente è loggato, carica la view della home page,
    // altrimenti reindirizza alla pagina di login.
    public function index()
    {
        // Se l'utente non è loggato, viene reindirizzato al login
        $this->redirect_if_not_logged_in('col/login');

        return redirect('col/subscriptions');
    }

    /* 3. login() */
    // Carica la view che consente di accedere
    // al back-end. Se l'utente è già connesso
    // viene reindirizzato all'index.
    public function login()
    {
        // Libreria utilizzata nella view.
        $this->load->helper('url');

        $this->redirect_if_logged_in('col/index');

        $data['title'] = 'Login COL';

        $this->load->view('header', $data);
        $this->load->view('col/login', $data);
        $this->load->view('footer');
    }

    /* 4. login_process() */
    // Processa i dati della view del login.
    public function login_process()
    {
        $this->load->helper('url');
        // Se il login fallisce..
        $col = $this->col_model->login();
        if($col === FALSE)
        {
            // Ricarica la pagina di login con un messaggio di errore.
            $data['error'] = 'Indirizzo e-mail e/o password errati.';
            $data['title'] = 'Login COL';

            redirect('col/login');
        }
        else
        {
            // ..altrimenti viene creata una nuova sessione utente.
            $this->load->library('session');
            $this->session->col = array(
                'email' => $col->email_referente,
                'nome' => $col->nome_referente,
                'cognome' => $col->cognome_referente,
                'regione' => $col->regione,
                'provincia' => $col->provincia
                'lv' => 'col'
            );

            redirect('col/index');
        }
    }

    /* 5. logout() */
    // Distrugge la sessione utente e reindirizza alla Home.
    public function logout()
    {
        $this->load->helper('url');
        $this->load->library('session');
        $this->session->sess_destroy();

        return redirect('col/login');
    }

    /* 6. sign_up() */
    // Registrazione di un nuovo COL(inserimento dati COL)
    public function sign_up()
    {
        // Se è già esistente una sessione(ovvero se l'utente ha
        // già effettuato l'accesso), si viene reindirizzati
        // alla Home.
        $this->load->helper('url');

        $this->redirect_if_logged_in('col/index');

        $this->load->model('common_model');

        // Opzioni(prese dal database) da inserire nelle selectbox per selezionare
        // regione, provincia e comune del COL.
        $data['regioni'] = $this->common_model->get_regioni();
        $data['province'] = $this->common_model->get_province();
        $data['comuni'] = $this->common_model->get_comuni();

        $data['title'] = 'Registrazione COL';

        // Se i dati inseriti non soddisfano le regole sopra descritte..
        if($this->form_validation_sign_up() === FALSE)
        {
            // ..si viene reindirizzati alla stessa pagina
            // che questa volta presenta le cause dell'errore
            // nell'inserimento dei dati.
            $this->load->view('header', $data);
            $this->load->view('col/sign_up');
            $this->load->view('footer');
        }
        else
        {
            // ..altrimenti il COL viene inserito nel database.
            $this->col_model->create();

            // Invia una mail all'indirizzo del referente COL
            // in cui sono contenute le informazioni per attivare
            // l'account.
            $this->send_mail($this->input->post('email_referente'));

            // Infine, si viene reindirizzati ad una pagina
            // che avvisa l'utente di controllare la mail
            // per attivare l'account.
            $data['title'] = 'Registrazione completata';

            $this->load->view('header', $data);
            $this->load->view('sign_up_success');
            $this->load->view('footer');
        }
    }

    /* 7. activate_account() */
    // Utilizza il token presente nell'URL per attivare
    // l'account del COL e carica la view per stampare
    // l'esito della procedura.
    public function activate_account()
    {
        if(!$this->input->get('token')) return redirect('col/index');

        $token = $this->input->get('token');
        $this->col_model->activate($token) ?
            $data['message'] = 'Account attivato con successo' :
            $data['message'] = 'Errore nell\'attivazione dell\'account';

        $data['title'] = 'Esito attivazione account';

        $this->load->view('header', $data);
        $this->load->view('activate_account', $data);
        $this->load->view('footer');
    }

    /* 8. subscriptions() */
    // E' una parte del pannello di controllo.
    // Carica una tabella contenente tutti i progetti
    // ed il relativo numero di iscritti, nella provincia
    // in cui il COL è esercente.
    public function subscriptions()
    {
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('common_model');


        $this->redirect_if_not_logged_in('col/index');

        // Applica il filtro degli iscritti per provincia
        $provincia = $this->input->get('filtra_iscritti_provincia') ? $this->input->get('provincia') : NULL;

        $data['subscriptions'] = $this->common_model->get_subscriptions($this->session->col['regione'], $provincia);
        $data['title'] = 'Estrazione Iscritti ai Progetti';
        $data['user'] = $this->session->col;
        $data['province'] = $this->common_model->get_province_by_regione($this->session->col['regione']);

        $this->load->view('header', $data);
        $this->load->view('menu', $data);
        $this->load->view('col/subscriptions', $data);
        $this->load->view('footer');
    }

    /* 9. download_anagrafiche() */
    // Permette ad un COL registrato di scaricare il file .xls
    // contenente le anagrafiche degli studenti registrati ai progetti,
    // relativamente alla sua provincia.
    public function download_anagrafiche()
    {
        $this->load->library('session');

        $this->redirect_if_not_logged_in('col/index');

        $this->xls_subscription_table();
    }

    /* 10. send_mail() */
    // Invia una mail (all'indirizzo ricevuto come parametro)
    // contenente il link per attivare il suo account.
    private function send_mail($to)
    {
        $col_row = $this->col_model->get($to);
        $col_row = $col_row[0];

        $this->load->library('email');

        $this->email->from('info@go2mkt.com', 'Portale Valorinrete');
        $this->email->to($to);
        $this->email->subject('Valorinrete - Conferma Registrazione');
        $this->email->message('
        Gentile referente COL,
        clicca sul seguente link per attivare il tuo account: http://go2mkt.com/valorinrete/col/activate_account/?token='
        .$col_row->token_attiva_account);
        $this->email->send();
    }

    /* 11. xls_subscription_table() */
    // Crea un file .xls(Excel) scaricabile, contenente
    // i dati delle iscrizioni ai progetti nella provincia
    // del COL.
    private function xls_subscription_table()
    {
        $this->load->model('common_model');

        // Nome del file excel che verrà creato.
        $filename = 'valorinrete_iscrizioni_studenti.xls';

        // Estrae i dati degli studenti dal database.
        $subscriptions = $this->common_model->get_anagrafiche_studenti($this->session->col['provincia']);

        // Header per la creazione del file .xls .
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: inline; filename='.$filename);

        // Stampa il documento Excel.
        echo '
            <table border="1">
                <tr>
                    <th>Nome</th>
                    <th>Cognome</th>
                    <th>Nome Istituto</th>
                    <th>Classe</th>
                    <th>Sezione</th>
                    <th>Progetto</th>
                </tr>';

        foreach($subscriptions as $subscription)
        {
            echo '
                <tr>
                    <td>'.$subscription['nome_studente'].'</td>
                    <td>'.$subscription['cognome_studente'].'</td>
                    <td>'.$subscription['nome_istituto'].'</td>
                    <td>'.$subscription['classe'].'</td>
                    <td>'.$subscription['sezione'].'</td>
                    <td>'.$subscription['progetto'].'</td>
                </tr>';
        }

        echo '
            </table>
        ';
    }

    /* 12. redirect_if_not_logged_in() */
    // Reindirizza alla route indicata come parametro
    // se non è presente una sessione utente.
    private function redirect_if_not_logged_in($path_to_redirect)
    {
        $this->load->helper('url');
        $this->load->library('session');
        if(!$this->session->col) return redirect($path_to_redirect);
    }

    /* 13. redirect_if_logged_in() */
    // Reindirizza alla route indicata come parametro
    // se è presente una sessione utente(ovvero l'utente è loggato).
    private function redirect_if_logged_in($path_to_redirect)
    {
        $this->load->helper('url');
        $this->load->library('session');
        if($this->session->col) return redirect($path_to_redirect);
    }

    /* 14. form_validation_sign_up() */
    // Funzione richiamata da /sign_up per applicare
    // le regole di validazione della form di registrazione.
    // L'ho esternalizzata per diminuire il codice all'interno della funzione chiamante.
    private function form_validation_sign_up()
    {
      $this->load->helper('form');
      $this->load->library('form_validation');

      // regole per la validazione della form di iscrizione
      $this->form_validation->set_rules('nome_referente', 'Nome Referente', 'required');
      $this->form_validation->set_rules('cognome_referente', 'Cognome Referente', 'required');
      $this->form_validation->set_rules('email_referente', 'Email Referente', 'required|valid_email|matches[conferma_email_referente]|is_unique[tab_col.email_referente]');
      $this->form_validation->set_rules('conferma_email_referente', 'Conferma Email', 'required|valid_email');
      $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|matches[conferma_password]');
      $this->form_validation->set_rules('conferma_password', 'Conferma Password', 'required|min_length[6]');
      $this->form_validation->set_rules('comune', 'Comune', 'required');
      $this->form_validation->set_rules('provincia', 'Provincia', 'required');
      $this->form_validation->set_rules('regione', 'Regione', 'required');
      $this->form_validation->set_rules('indirizzo', 'Indirizzo', 'required');

      return $this->form_validation->run();
    }
}
