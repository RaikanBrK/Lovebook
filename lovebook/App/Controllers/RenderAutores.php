<?php 
	namespace App\Controllers;

	class RenderAutores {
		protected $autores = null;

		public function __set($attr, $valor) {
			$this->$attr = $valor;
		}

		public function __get($attr) {
			return $this->$attr;
		}

		static public function convert_url_autor($autor) {
			return str_replace('_', ' ', $autor);
		}

		static public function convert_to_url($url) {
			return str_replace(' ', '_', strtolower($url));
		}

		public function createAutor($limit = 4, $offset = 0) {
			for ($i = $offset; $i < $limit; $i++) {				
				if (isset($this->__get('autores')[$i])) {
					$autor = $this->__get('autores')[$i];
					$diretorio = $this->convert_to_url($autor['nome']);
				?>
				
				<div class="col-6 col-md-4 col-lg-3">
					<div class="autor" data-id="<?= $autor['id'] ?>">
						<img src="/imagens/autores/<?= $autor['img'] ?>" alt="" class="img-autor">
						<a href="/autores/autor?autor=<?= $diretorio ?>" class="title-autor"><?= $autor['nome'] ?></a>
					</div>
				</div>
			<?php }
			}

		}
	}

?>