<?php

Class Date {
    // Prende in input una stringa contenente
    // una data e restituisce una data(stringa) formattata
    // nel formato di MySQL(YYYY-MM-DD)
    public function to_mysql_date($date)
    {
    	$new_date = DateTime::createFromFormat('d-m-Y', str_replace('/', '-', $date));
    	return date_format($new_date, 'Y-m-d'); 
    }
}