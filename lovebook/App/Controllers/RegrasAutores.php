<?php 
namespace App\Controllers;

class RegrasAutores {

	public function validarString($string) {
		$string = trim($string);
		return strlen($string) > 5;
	}

	public function validarEstadoCivil($civil) {
		$civil = trim($civil);
		return $civil == '' ? true : strlen($civil) > 3;
	}

	public function validarDateNascimento($date) {
		date_default_timezone_set('America/Sao_Paulo');
		$timeAtual = strtotime(Date('Y-m-d'));
		$time = strtotime($date);
		return $timeAtual > $time;
	}

	public function validarDesc($desc) {
		$desc = trim($desc);
		return strlen($desc) >= 20;
	}
} 
	
?>