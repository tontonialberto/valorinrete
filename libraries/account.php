<?php
class Account {

	public function __construct()
	{

	}

	// Crea un username. Se l'array $parameters contiene
	// stringhe, queste vengono concatenate per la generazione
	// dello username.
	
	public function generate_username(array $parameters = NULL)
	{
		$username = '';

		foreach($parameters as $param)
		{
			$username .= $param;
			$username .= '_';
		}

		return $username;
	}

	// Genera una password random, la cui lunghezza
	// viene ricevuta come parametro. La lunghezza
	// di default è 8.

	public function generate_password($length = 8)
	{
		return substr(uniqid(mt_rand(), true), 0, $length);
	}	
}