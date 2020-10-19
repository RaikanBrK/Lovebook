<?php 
	namespace App\Controllers;

	class RenderBook {
		protected $books = null;

		public function __set($attr, $valor) {
			$this->$attr = $valor;
		}

		public function __get($attr) {
			return $this->$attr;
		}

		static public function convert_url($url) {
			return str_replace('_', ' ', $url);
		}

		static public function convert_to_url($url) {
			return str_replace(' ', '_', strtolower($url));
		}

		public function createBooks($controller = true) {
			$responseAdmin = "col-md-6 col-lg-4";
			$response = "col-sm-6 col-md-4 col-lg-3";
			foreach ($this->__get('books') as $book) { 
				$diretorio = $this->convert_to_url($book['titulo']);
				$autor = 'autor='.$this->convert_to_url($book['autor']);
				?>
				<div class="<?= $controller ? $response : $responseAdmin ?>">
					<div class="cartao" data-id="<?= $book['id'] ?>">
						<a href="/livros/livro?book=<?= $diretorio.'&'.$autor ?>">
							<img src="/imagens/books/<?= $book['img'] ?>" alt="<?= $book['titulo'] ?>" class="img-cartao">
						</a>

						<div class="desc-cartao">
							<a href="/livros/livro?book=<?=  $diretorio.'&'.$autor ?>" class="title-cartao"><?= $book['titulo'] ?></a>

							<div class="info-cartao">
								<a href="/autores/autor?<?= $autor ?>" class="autor-cartao"><?= $book['autor'] ?></a>
								<span class="preco-cartao">R$ <?= $book['preco'] ?></span>
							</div>

						</div>
					</div>			

				</div>
			<?php }

		}
	}

?>