<?php 
namespace App\Controllers;

class RegrasAdministradores {

	public function validarString($string) {
		$string = trim($string);
		return strlen($string) > 2 && !strstr($string, ' ');
	}

	public function validarSobrenome($sobrenome) {
		$sobrenome = trim($sobrenome);
		return $sobrenome == '' ? true : strlen($sobrenome) > 1 && !strstr($sobrenome, ' ');
	}

	public function validarEmail($email) {
		$email = trim($email);
		return strstr($email, '@') && strstr($email, '.');
	}

	public function compararSenhas($senha, $confirmSenha) {
		$senha = trim($senha);
		$confirmSenha = trim($confirmSenha);
		return $senha == $confirmSenha;
	}

	public function validarSenha($senha) {
		$senha = trim($senha);
		return strlen($senha) >= 8;
	}


} 
	
?>