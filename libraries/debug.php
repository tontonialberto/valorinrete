<?php 

class Debug {

    public function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->library('session');

        // Se l'applicazione è in fase di sviluppo,
        // stamperà i messaggi di debug.
        // Se l'applicazione è in produzione,
        // tutte le funzioni di debug non verranno stampati.
        
        $this->app_env = $this->ci->config->item('app_env');
    }

    // Stampa a video tutti i dati contenuti in $_REQUEST.
    public function print_request()
    {
        if($this->in_development() === TRUE)
        {
            echo '<pre>HTTP data: ';
            print_r($_REQUEST);
            echo '</pre>';
        }
    }

    // Stampa a video tutti i dati contenuti in $_SESSION
    public function print_session()
    {
        if($this->in_development() === TRUE)
        {
            echo '<pre>SESSION data: ';
            print_r($_SESSION);
            echo '</pre>';
        }
    }

    // Ritorna TRUE se l'applicazione è in fase di sviluppo.
    // Altrimenti ritorna FALSE.
    
    private function in_development()
    {
        return $this->app_env === 'development';
    }
}