<?php 
namespace App\Controllers;

class RegrasUsuarios {

	public function validarString($string) {
		$string = trim($string);
		return strlen($string) > 2 && !strstr($string, ' ');
	}

	public function validarSobrenome($sobrenome) {
		$sobrenome = trim($sobrenome);
		return $sobrenome == '' ? true : strlen($sobrenome) > 3 && !strstr($sobrenome, ' ');
	}

	public function validarEmail($email) {
		$email = trim($email);
		return strstr($email, '@') && strstr($email, '.');
	}

	public function validarCpf($cpf) {
		$cpf = trim($cpf);
		return strstr($cpf, '-') && strstr($cpf, '.') && strlen($cpf) >= 14 && strlen($cpf) <= 15;
	}

	public function validarCep($cep) {
		$cep = trim($cep);
		return $cep == '' ? true : strlen($cep) == 9 && strstr($cep, '-');
	}

	public function validarNumero($numero) {
		$numero = trim($numero);

		return strlen($numero) == 15 && strstr($numero, '-') && strstr($numero, ' ') && strstr($numero, '(') && strstr($numero, ')');
	}

	public function validarSenha($senha) {
		$senha = trim($senha);
		return strlen($senha) >= 8;
	}

	public function compararSenhas($senha, $confirmSenha) {
		$senha = trim($senha);
		$confirmSenha = trim($confirmSenha);
		return $senha == $confirmSenha;
	}
	
	

} 
	
?>