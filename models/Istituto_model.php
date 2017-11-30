<?php
class Istituto_model extends CI_Model {

    /*
        ## PUBLIC METHODS ##
        
        1. __construct()
        2. create()
        3. create_candidatura()
        4. get_candidature_by_istituto()
        5. create_studente()
        6. create_classe()
        7. login()
        8. activate()
        9. get()
        10. get_by_id()
        11. set_random_password()
        12. set_password()
    */

    /* 1. __construct() */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* 2. create() */
    // Inserisce un nuovo Istituto nel database
    // a partire da un valore passato come parametro.
    // Inserisce anche il grado dell'istituto
    // all'interno della tabella tab_gradi_istituti.
    public function create($istituto = NULL)
    {
        if(!$istituto) return FALSE;

        $istituto['password'] = md5($istituto['password']);
        $istituto['token_attiva_account'] = md5(uniqid($istituto['email_referente'])); // viene inviato via mail all'utente per confermare la registrazione
        
        if(!$this->db->insert('tab_istituti', $istituto)) return FALSE;

        return TRUE;
    }

    /* 3. create_candidatura() */
    // Inserisce una nuova candidatura nella tabella tab_candidature.
    // Se la candidatura viene inserita con successo, ritorna l'id di quest'ultima,
    // altrimenti ritorna FALSE.
    public function create_candidatura($candidatura = NULL)
    {   
        if(!$candidatura) return FALSE;
        
        $candidatura['candidatura_approvata'] = 0;

        if(!$this->db->insert('tab_candidature', $candidatura)) return FALSE;
        return $this->db->insert_id();
    }
    
    /* 4. get_candidature_by_istituto() */
    // Prende in input contenente i dati di un Istituto(Codice meccanografico, email referente, ecc..)
    // e restituisce un array associativo di tutte le candidature appartenenti a quell'Istituto
    public function get_candidature_by_istituto(array $istituto)
    {
        $query = $this->db->select('*')
            ->from('tab_candidature')
            ->join('tab_progetti', 'tab_progetti.id = tab_candidature.id_progetto')
            ->join('tab_istituti', 'tab_istituti.cod_meccanografico = tab_candidature.id_istituto')
            ->where(array('tab_istituti.cod_meccanografico' => $istituto[0]->cod_meccanografico))
            ->get();
        
        var_dump($query->num_rows());
        if(!$query->num_rows()) return FALSE;
        return $query->result_array();
    }

    /* 5. create_studente() */
    // Inserisce un nuovo record nella tabella tab_studenti.
    // Se lo studente viene inserito con successo, restituisce
    // l'id dello studente appena inserito, altrimenti ritorna FALSE.
    public function create_studente($studente = NULL)
    {
        if(!$studente) return FALSE;
        
        if(!$this->db->insert('tab_studenti', $studente)) return FALSE;
        return $this->db->insert_id();

        die($studente);
    }

    /* 6. create_classe() */
    // Inserisce un nuovo record nella tabella tab_classi.
    // Se la classe viene inserita con successo, restituisce
    // l'id della classe appena inserita, altrimenti ritorna FALSE.
    public function create_classe($classe = NULL)
    {
        if(!$classe) return FALSE;

        if(!$this->db->insert('tab_classi', $classe)) return FALSE;
        return $this->db->insert_id();
    }

    /* 7. login() */
    // Dati un email ed una password, ricerca una corrispondenza
    // tra gli Istituti presenti nel database che hanno attivato il loro account. 
    // Se la ricerca ha successo,
    // restituisce il record trovato, altrimenti ritorna FALSE.
    public function login($email, $password)
    {
        $query = $this->db
            ->select('cod_meccanografico, nome_istituto, password, cap, email_istituto, telefono_referente, nome_referente, cognome_referente, email_referente, comune, provincia, regione, indirizzo, account_attivo, token_attiva_account')
            ->from('tab_istituti')
            ->where(array('email_referente' => $email))
            ->where(array('account_attivo' => 1))
            ->get();

        if(!$query->num_rows()) return FALSE;
        else
        {
            if(md5($password) == $query->row()->password) return $query->row();
            else return FALSE;
        }
    }

    /* 8. activate() */
    // Dato un token per l'attivazione di un account,
    // ricerca una corrispondenza all'interno del database
    // e se la trova, attiva l'account corrispondente e ritorna TRUE.
    // Altrimenti ritorna FALSE.
    public function activate($token)
    {
        $query = $this->db
            ->where(array('token_attiva_account' => $token))
            ->update('tab_istituti', array('account_attivo' => 1));

        if($this->db->affected_rows()) return TRUE;
        else return FALSE;
    }

    /* 9. get() */
    // Se il parametro mail non è nullo,
    // restituisce i dati dell'istituto che ha
    // la mail referente uguale a quella specificata. 
    // Se il parametro mail è nullo,
    // restituisce i dati di tutti gli istituti presenti nel db.
    public function get($email = NULL)
    {
        if($email === NULL)
        {
            $query = $this->db
                ->select('cod_meccanografico, nome_istituto, cap, email_istituto, telefono_referente, nome_referente, cognome_referente, email_referente, comune, provincia, regione, indirizzo, account_attivo, token_attiva_account')
                ->from('tab_istituti')
                ->get();

            return $query->result();
        }
        $query = $this->db
            ->select('cod_meccanografico, nome_istituto, cap, email_istituto, telefono_referente, nome_referente, cognome_referente, email_referente, comune, provincia, regione, indirizzo, account_attivo, token_attiva_account')
            ->from('tab_istituti')
            ->where(array('email_referente' => $email))
            ->get();

        return $query->result();
    }

    /* 10. get_by_id() */
    // Prende in input il codice meccanografico(identificatore univoco)
    // di un istituto e restituisce un array associativo con i dati
    // dell'istituto
    public function get_by_id($cod_meccanografico)
    {
        $query = $this->db
            ->select('cod_meccanografico, 
                nome_istituto, 
                cap, 
                email_istituto, 
                telefono_referente, 
                nome_referente, 
                cognome_referente, 
                email_referente, 
                comune, 
                provincia, 
                regione, 
                indirizzo, 
                account_attivo, 
                token_attiva_account')
            ->from('tab_istituti')
            ->where(array('cod_meccanografico' => $cod_meccanografico))
            ->get();

        return $query->result_array()[0];
    }

    /* 11. set_random_password() */
    // Prende in input l'identificativo di un istituto
    // e cambia la sua password(generandola randomicamente). 
    // Se l'operazione ha successo, restituisce la nuova password,
    // altrimenti ritorna false.
    public function set_random_password($cod_meccanografico)
    {
        $this->load->helper('string');

        $new_password = random_string('alnum');

        $query = $this->db->where(array('cod_meccanografico' => $cod_meccanografico))
            ->update('tab_istituti', array('password' => md5($new_password)));

        if(!$this->db->affected_rows()) return FALSE;

        return $new_password;
    }

    /* 12. set_password() */
    // Cambia la password di un istituto con una nuova passata come parametro.
    // Se l'operazione ha successo restituisce TRUE, altrimenti FALSE.
    public function set_password($cod_meccanografico, $password)
    {
        $query = $this->db->where(array('cod_meccanografico' => $cod_meccanografico))
            ->update('tab_istituti', array('password' => md5($password)));

        if(!$this->db->affected_rows()) return FALSE;

        return TRUE;
    }
}