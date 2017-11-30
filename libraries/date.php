<?php

Class Date {
    // Prende in input una stringa contenente
    // una data e restituisce una data(stringa) formattata
    // nel formato di MySQL(YYYY-MM-DD)
    public function date_to_mysql($date)
    {
        return date('Y-m-d', strtotime($date));
    }
}