<?php
// Modello utilizzato per prelevare dati
// che non sono strettamente in relazione con gli
// altri modelli(es: province, regioni, comuni).
class Common_model extends CI_Model {

    /*
        ## PUBLIC METHODS ##

        1. __construct()
        2. get_regioni()
        3. get_province()
        4. get_province_by_regione()
        5. get_comuni()
        6. get_regioni_province_comuni()
        7. get_subscriptions()
        8. get_anagrafiche_studenti()
    */

    /* 1. __construct() */
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /* 2. get_regioni() */
    // Restituisce un array contenente tutte le
    // regioni presenti nel db.
    public function get_regioni()
    {
        $query = $this->db->select('nome')
            ->from('tab_regioni')
            ->order_by('nome')
            ->get();

        return $query->result_array();
    }

    /* 3. get_province() */
    // Restituisce un array contenente tutte le
    // province presenti nel db.
    public function get_province()
    {
        $query = $this->db->select('nome')
            ->from('tab_province')
            ->order_by('nome')
            ->get();

        return $query->result_array();
    }

    /* 4. get_province_by_regione() */
    // Restituisce un array di province appartenenti alla
    // regione passata come parametro
    public function get_province_by_regione($regione)
    {
      $query = $this->db->select('tab_province.nome AS nome')
          ->from('tab_province')
          ->join('tab_regioni', 'tab_regioni.id = tab_province.id_regione')
          ->where(array('tab_regioni.nome' => $regione))
          ->order_by('nome')
          ->get();

      return $query->result_array();
    }

    /* 5. get_comuni() */
    // Restituisce un array contenente tutte le
    // province presenti nel db.
    public function get_comuni()
    {
        $query = $this->db->select('nome')
            ->from('tab_comuni')
            ->order_by('nome')
            ->get();

        return $query->result_array();
    }

    /* 6. get_regioni_province_comuni() */
    // Restituisce tutte le regioni associate alle province associate ai comuni
    // presenti nel db. Ogni record ha 3 campi: Regione - Provincia - Comune
    public function get_regioni_province_comuni()
    {
        $query = $this->db->select('tab_regioni.nome AS regione, tab_province.nome AS provincia, tab_comuni.nome AS comune')
            ->from('tab_regioni')
            ->join('tab_province', 'tab_regioni.id = tab_province.id_regione')
            ->join('tab_comuni', 'tab_province.id = tab_comuni.id_provincia')
            ->order_by('regione, provincia, comune')
            ->get();

        return $query->result_array();
    }

    /* 7. get_subscriptions() */
    // Restituisce un array contenente i nomi dei progetti
    // ed il relativo numero di studenti iscritti all'interno di una provincia.
    public function get_subscriptions($regione, $provincia = NULL)
    {
        // Nel caso in cui non venga specificata la provincia,
        // consente di ricercare solamente in base alla regione.
        $provinciaOrTrue = $provincia ? array('tab_istituti.provincia' => $provincia) : array('1' => 1);

        if($regione == 'Trentino-Alto Adige - Bolzano')
        {
            $regione = 'Trentino-Alto Adige';
            $provinciaOrTrue = 'Bolzano';
        }
        else if($regione == 'Trentino-Alto Adige - Trento')
        {
            $regione = 'Trentino-Alto Adige';
            $provinciaOrTrue = 'Trento';
        }
        else if($regione == "Piemonte - Valle d'Aosta")
        {
            $regione = 'Piemonte';
        }

        // La piattaforma prevede alcuni progetti ai quali
        // si possono iscrivere intere classi, ed altri ai quali
        // si possono iscrivere singoli studenti. Perciò è necessario
        // considerare entrambi i casi, utilizzando due query anzichè soltanto una.
        $query_studenti = $this->db->select('tab_progetti.nome AS nome_progetto, COUNT(*) AS n_studenti')
            ->from('tab_candidature')
            ->join('tab_progetti', 'tab_candidature.id_progetto = tab_progetti.id')
            ->join('tab_studenti_candidature', 'tab_studenti_candidature.id_candidatura = tab_candidature.id')
            ->join('tab_studenti', 'tab_studenti_candidature.id_studente = tab_studenti.id')
            ->join('tab_istituti', 'tab_studenti.id_istituto = tab_istituti.cod_meccanografico')
            ->where(array('tab_istituti.regione' => $regione))
            ->where($provinciaOrTrue)
            ->group_by('tab_progetti.nome')
            ->get();

        $query_classi = $this->db->select('tab_progetti.nome AS nome_progetto, SUM(tab_classi.n_studenti) AS n_studenti')
            ->from('tab_candidature')
            ->join('tab_progetti', 'tab_candidature.id_progetto = tab_progetti.id')
            ->join('tab_classi_candidature', 'tab_classi_candidature.id_candidatura = tab_candidature.id')
            ->join('tab_classi', 'tab_classi_candidature.id_classe = tab_classi.id')
            ->join('tab_istituti', 'tab_classi.id_istituto = tab_istituti.cod_meccanografico')
            ->where(array('tab_istituti.regione' => $regione))
            ->where($provinciaOrTrue)
            ->group_by('tab_progetti.nome')
            ->get();

        // Nel caso in cui un progetto non abbia iscritti, le query
        // non restituiranno il suo record. Nel caso in cui nessun progetto
        // abbia iscrizioni, verrà restituito un valore nullo.
        // Il seguente procedimento serve a prelevare i nomi di tutti i progetti
        // e a confrontarli con quelli presenti all'interno di query_classi e query_studenti.
        $query_projects = $this->db->select('nome')->from('tab_progetti')->get();
        $projects = $query_projects->result_array();

        for($i=0; $i<sizeof($projects); $i++)
        {
            // All'inizio di ogni ciclo, si presuppone
            // che il progetto $projects[$i] non abbia iscrizioni.
            $projects[$i]['has_subscriptions'] = FALSE;

            // Viene ricercata una corrispondenza tra il nome del progetto
            // e l'esistenza di informazioni riguardo gli iscritti ad esso.
            foreach($query_studenti->result_array() as $subscription)
            {
                if($projects[$i]['nome'] == $subscription['nome_progetto'])
                {
                    $projects[$i]['has_subscriptions'] = TRUE;
                    break;
                }
            }

            // Viene ricercata una corrispondenza tra il nome del progetto
            // e l'esistenza di informazioni riguardo gli iscritti ad esso.
            foreach($query_classi->result_array() as $subscription)
            {
                if($projects[$i]['nome'] == $subscription['nome_progetto'])
                {
                    $projects[$i]['has_subscriptions'] = TRUE;
                    break;
                }
            }
        }

        // Nel caso in cui alcuni progetti non abbiano iscrizioni,
        // questo procedimento fa sì che il nome del progetto
        // ed il numero(0) di iscritti venga comunque riportato
        // nel risultato da mostrare all'utente.
        $result = array();
        $index = 0;
        foreach($projects as $project)
        {
            if($project['has_subscriptions'] === FALSE)
            {
                $result[$index++] = array(
                    'nome_progetto' => $project['nome'],
                    'n_studenti' => 0
                );
            }
        }

        // Se esistono dei progetti a cui qualcuno si è iscritto,
        // il nome del progetto ed il numero di studenti iscritti
        // viene riportato nel risultato da mostrare all'utente.
        foreach($query_classi->result_array() as $subscription)
        {
            $result[$index++] = array(
                'nome_progetto' => $subscription['nome_progetto'],
                'n_studenti' => $subscription['n_studenti']
            );
        }

        // Se esistono dei progetti a cui qualcuno si è iscritto,
        // il nome del progetto ed il numero di studenti iscritti
        // viene riportato nel risultato da mostrare all'utente.
        foreach($query_studenti->result_array() as $subscription)
        {
            $result[$index++] = array(
                'nome_progetto' => $subscription['nome_progetto'],
                'n_studenti' => $subscription['n_studenti']
            );
        }

        // Risultato da mostrare all'utente
        return $result;
    }

    /* 8. get_anagrafiche_studenti() */
    // Data una provincia, restituisce un insieme di tuple
    // contenenti i dati degli studenti iscritti ai progetti.
    // Ogni tupla è così strutturata: nome_studente | cognome_studente | classe | sezione | progetto
    // Valore restituito: Array associativo
    public function get_anagrafiche_studenti($provincia)
    {
        $query = $this->db
            ->select('tab_studenti.nome AS nome_studente,
                tab_studenti.cognome AS cognome_studente,
                tab_istituti.nome_istituto AS nome_istituto,
                tab_studenti.classe AS classe,
                tab_studenti.sezione AS sezione,
                tab_progetti.nome AS progetto')
            ->from('tab_studenti')
            ->join('tab_istituti', 'tab_studenti.id_istituto = tab_istituti.cod_meccanografico')
            ->join('tab_studenti_candidature', 'tab_studenti_candidature.id_studente = tab_studenti.id')
            ->join('tab_candidature', 'tab_studenti_candidature.id_candidatura = tab_candidature.id')
            ->join('tab_progetti', 'tab_candidature.id_progetto = tab_progetti.id')
            ->where(array('tab_istituti.provincia' => $provincia))
            ->order_by('progetto, nome_istituto, classe, sezione, cognome_studente, nome_studente')
            ->get();

        return $query->result_array();
    }
}
