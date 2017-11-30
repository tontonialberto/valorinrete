<?php 

class Debug {
    // Stampa a video tutti i dati contenuti in $_POST
    public function print_post()
    {
        echo 'POST data: <pre>';
        print_r($_SESSION);
        echo '</pre>';
    }

    // Stampa a video tutti i dati contenuti in $_SESSION
    public function print_session()
    {
        echo 'SESSION data: <pre>';
        print_r($_SESSION);
        echo '</pre>';
    }
}