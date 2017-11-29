<?php
class Col_model extends CI_Model {

    /* 
        ## PUBLIC METHODS ##

        1. __construct()
        2. create()
        3. login()
        4. activate()
        5. get()
    */

    /* 1. __construct() */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* 2. create() */
    // Inserisce un nuovo COL nel database
    // a partire dai valori presenti in una form.
    public function create()
    {
        $data = array(
            'id' => NULL,
            'nome_referente' => $this->input->post('nome_referente'),
            'cognome_referente' => $this->input->post('cognome_referente'),
            'email_referente' => $this->input->post('email_referente'),
            'password' => md5($this->input->post('password')),
            'comune' => $this->input->post('comune'),
            'provincia' => $this->input->post('provincia'),
            'regione' => $this->input->post('regione'),
            'indirizzo' => $this->input->post('indirizzo'),
            'token_attiva_account' => md5(uniqid($this->input->post('email_referente'))) // viene inviato via mail all'utente per confermare la registrazione
        );

        return $this->db->insert('tab_col', $data);
    }

    /* 3. login() */
    // Dati un email ed una password, ricerca una corrispondenza
    // tra i COL presenti nel database che hanno attivato il loro account. 
    // Se la ricerca ha successo,
    // restituisce il record trovato, altrimenti ritorna FALSE.
    public function login()
    {
        $query = $this->db
            ->select('id, nome_referente, cognome_referente, email_referente, password, comune, provincia, regione, indirizzo, account_attivo, token_attiva_account')
            ->from('tab_col')
            ->where(array('email_referente' => $this->input->post('email')))
            ->where(array('account_attivo' => 1))
            ->get();

        if(!$query->num_rows()) return FALSE;
        else
        {
            if(md5($this->input->post('password')) == $query->row()->password) return $query->row();
            else return FALSE;
        }
    }

    /* 4. activate() */
    // Dato un token per l'attivazione di un account,
    // ricerca una corrispondenza all'interno del database
    // e se la trova, attiva l'account corrispondente e ritorna TRUE.
    // Altrimenti ritorna FALSE.
    public function activate($token)
    {
        $query = $this->db
            ->where(array('token_attiva_account' => $token))
            ->update('tab_col', array('account_attivo' => 1));

        if($this->db->affected_rows()) return TRUE;
        else return FALSE;
    }

    /* 5. get() */
    // Se il parametro mail non è nullo,
    // restituisce i dati del COL che ha
    // la mail specificata. Se il parametro mail è nullo,
    // restituisce i dati di tutti i COL presenti nel db.
    public function get($email = NULL)
    {
        if($email === NULL)
        {
            $query = $this->db
                ->select('id, nome_referente, cognome_referente, email_referente, comune, provincia, regione, indirizzo, account_attivo, token_attiva_account')
                ->from('tab_col')
                ->get();

            return $query->result();
        }
        $query = $this->db
            ->select('id, nome_referente, cognome_referente, email_referente, comune, provincia, regione, indirizzo, account_attivo, token_attiva_account')
            ->from('tab_col')
            ->where(array('email_referente' => $email))
            ->get();

        return $query->result();
    }
}