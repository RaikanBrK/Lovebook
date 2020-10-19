<?php 
namespace App\Controllers;

class RegrasLivro {

	public function validarTitulo($titulo) {
		$titulo = trim($titulo);
		return strlen($titulo) > 5;
	}

	public function validarAutor($autor) {
		$autor = trim($autor);
		return $autor != '';
	}

	public function validarDateLancamento($dados) {
		date_default_timezone_set('America/Sao_Paulo');
		$timeAtual = strtotime(Date('Y-m-d'));
		$time = strtotime($dados);
		return $timeAtual >= $time;
	}

	public function validarPreco($preco) {
		return $preco >= 5 && $preco <= 3000;
	}

	public function validarPaginas($paginas) {
		return $paginas >= 20 && $paginas != '';
	}

	public function validarDesc($desc) {
		$desc = trim($desc);
		return strlen($desc) >= 30 && $desc != '';	
	}
} 
	
?>