<?php 
	namespace App\Controllers;


	class CreateImagem {
		private $id = null;
		private $path = null;
		private $files = null;
		private $input = null;
		public $urlImagem = null;
		public $nameArquivo = '';
		public $extensao = null;
		public $createSucess = false;

		public $formatosPermitidos = null;

		public function __set($attr, $valor) {
			$this->$attr = $valor;
		}

		public function __get($attr) {
			return $this->$attr;
		}

		public function excluindoImagem($list) {
			$diretorio = dir($this->path);
			while($arquivo = $diretorio->read()){
				$arrayFromArquivo = explode('-', $arquivo);
				$code = $arrayFromArquivo['0'];

				if (in_array($code, $list)) {
					unlink($this->path.$arquivo);
				}
			}
			$diretorio->close();
		}

	   	public function excluindoPossiveisArquivosClone() {
			$diretorio = dir($this->path);
			while($arquivo = $diretorio->read()){
				$arrayFromArquivo = explode('-', $arquivo);
				$code = $arrayFromArquivo['0'];

				if ($code == $this->id) {
					unlink($this->path.$arquivo);
				}
			}
			$diretorio->close();
	   	}

	   	public function arquivoTemporario() {
	   		$this->extensao = pathinfo($this->files[$this->input]['name'], PATHINFO_EXTENSION);
			$code = $this->id . '-';

			if (in_array($this->extensao, $this->formatosPermitidos)) {
				$pasta = $this->path;
				$temporario = $this->files[$this->input]['tmp_name'];
				$novoNome = "$code" . uniqid().".$this->extensao";

				if (move_uploaded_file($temporario, $this->path.$novoNome)) {
					$this->createSucess = true;
					$this->nameArquivo = $novoNome;
				}
				
			} else {
				$this->createSucess = false;
			}
	   	}

	   	public function criarImagem() {
			$filename = $this->path . $this->nameArquivo;

			list($width, $height) = getimagesize($filename);

			if ($width >= 500) {
				$new_width = 500;
			} else {
				$new_width = $width;
			}

			if ($height >= 500) {
				$new_height = 500;
			} else {
				$new_height = $height;
			}

			$image_p = imagecreatetruecolor($new_width, $new_height);

			if ($this->extensao == 'png') {
				$image = imagecreatefrompng($filename);
			} else {
				$image = imagecreatefromjpeg($filename);
			}

			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

			$this->urlImagem = $this->path . $this->nameArquivo;
			if ($this->extensao == 'png') {
				imagepng($image_p, $this->urlImagem);
			} else {
				imagejpeg($image_p, $this->urlImagem);
			}

			return $this->nameArquivo;
	   	}

	}
	



?>