<?php 

namespace App\Models;
use MF\Model\Model;

class Books extends Model {
	protected $id;
	protected $titulo;
	protected $img;
	protected $id_autor;
	protected $data_lancamento;
	protected $preco;
	protected $desc_book;
	protected $paginas;

	public function ultimoId() {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_books
			ORDER BY
				id DESC
			LIMIT
				0, 1
		';

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getBooksDestaques($offset = 0, $limit = 4) {
		$query = "
			SELECT
				b.id, b.titulo, b.img, b.id_autor, b.data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor, (
			    	SELECT
			        	COUNT(id_book)
			        FROM
			        	lovebook_tb_favoritos
			        WHERE
			        	id_book = b.id
			    ) as qtd_favorito
			FROM
				lovebook_tb_books as b 
				LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
			ORDER BY
				qtd_favorito DESC
			LIMIT
				$offset, $limit
		";

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function createBook() {
		$query = '
			INSERT INTO lovebook_tb_books(
				titulo,
				id_autor,
				data_lancamento,
				preco,
				desc_book,
				paginas
			) VALUES (
				:titulo,
				:id_autor,
				:data_lancamento,
				:preco,
				:desc_book,
				:paginas
			)
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':titulo', $this->__get('titulo'));
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->bindValue(':data_lancamento', $this->__get('data_lancamento'));
		$stmt->bindValue(':preco', $this->__get('preco'));
		$stmt->bindValue(':desc_book', $this->__get('desc_book'));
		$stmt->bindValue(':paginas', $this->__get('paginas'));
		$stmt->execute();
		return $this->db->lastInsertId();		
	}

	public function getBookLimit($limit = 8, $offset = 0) {
		$query = "
			SELECT
				b.id, b.titulo, b.img, b.id_autor, b.data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor
			FROM
				lovebook_tb_books as b 
				LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
            ORDER BY
				id DESC            
			LIMIT
				$offset, $limit
		";

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getBookFromId() {
		$query = "
			SELECT
				b.id, b.titulo, b.img, b.id_autor, b.data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor
			FROM
				lovebook_tb_books as b 
				LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
           	WHERE
           		b.id = :id
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function updateBook() {
		$query = '
			UPDATE
				lovebook_tb_books
			SET
				titulo = :titulo,
				id_autor = :id_autor,
				data_lancamento = :data_lancamento,
				preco = :preco,
				desc_book = :desc_book,
				paginas = :paginas
			WHERE
				id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->bindValue(':titulo', $this->__get('titulo'));
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->bindValue(':data_lancamento', $this->__get('data_lancamento'));
		$stmt->bindValue(':preco', $this->__get('preco'));
		$stmt->bindValue(':desc_book', $this->__get('desc_book'));
		$stmt->bindValue(':paginas', $this->__get('paginas'));
		$stmt->execute();

		$this->updateImg();
	}

	public function updateImg() {
		if ($this->__get('img') != '') {
			$query = '
				UPDATE
					lovebook_tb_books
				SET
					img = :img
				WHERE
					id = :id
			';

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->bindValue(':img', $this->__get('img'));
			$stmt->execute();
		}
	}

	public function removeBookFromId() {
		$query = '
			DELETE FROM lovebook_tb_books WHERE id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
	}

	public function livrosAssocFromAutor($id) {
		$query = '
			SELECT 
				bk.id
			FROM 
				lovebook_tb_autores as au
			    RIGHT JOIN lovebook_tb_books as bk ON(au.id = bk.id_autor)
			WHERE
				au.id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function validBookAutorTitle() {
		$validId = $this->__get('id') != null ? '&& id != :id' : false;
		$query = "
			SELECT
				id
			FROM
				lovebook_tb_books
			WHERE
				titulo = :titulo && id_autor = :id_autor $validId
		";

		$stmt = $this->db->prepare($query);
		if ($validId != false) {
			$stmt->bindValue(':id', $this->__get('id'));
		}
		
		$stmt->bindValue(':titulo', $this->__get('titulo'));
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->execute();
		return count($stmt->fetchAll(\PDO::FETCH_ASSOC)) <= 0;
	}

	public function getBookFromIdAutor($id, $offset = 0, $limit = 20) {
		$query = "
			SELECT
				b.id, b.titulo, b.img, b.id_autor, b.data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor
			FROM
				lovebook_tb_books as b 
				LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
           	WHERE
           		au.id = :id
           	LIMIT
           		$offset, $limit
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $id);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getBookFromIdAutorException($id, $id_exp, $offset = 0, $limit = 20) {
		$query = "
			SELECT
				b.id, b.titulo, b.img, b.id_autor, b.data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor
			FROM
				lovebook_tb_books as b 
				LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
           	WHERE
           		au.id = :id AND b.id != :id_exp
           	LIMIT
           		$offset, $limit
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $id);
		$stmt->bindValue(':id_exp', $id_exp);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getBookFromBookAndAutor($nome_autor) {
		$query = "
			SELECT
				b.id, b.titulo, b.img, b.id_autor, DATE_FORMAT(b.data_lancamento, '%d/%m/%Y') as data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor, au.img as autor_img,  au.desc_autor, au.estado_civil, au.data_nascimento
			FROM
				lovebook_tb_books as b 
				LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
           	WHERE
           		b.titulo = :titulo_book && au.nome = :nome_autor
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':titulo_book', $this->__get('titulo'));
		$stmt->bindValue(':nome_autor', $nome_autor);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function getBookRecomends($ids, $offset = 0, $limit = 6) {
		$ids = $ids == null ? 0 : $ids;
		$query = "
			SELECT
				b.id, b.titulo, b.img, b.id_autor, b.data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor
			FROM
				lovebook_tb_books as b 
				LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
			WHERE
				b.id NOT IN(:ids)
			ORDER BY 
				rand()
			LIMIT
				$offset, $limit
		";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':ids', $ids);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}	

	public function getBookFavoritos($offset = 0, $limit = 30) {
		$query = "
			SELECT
				b.id, b.titulo, b.img, b.id_autor, b.data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor
			FROM
				lovebook_tb_books as b 
			    LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
			WHERE
				b.id IN(
			    	SELECT
			        	fav.id_book
			        FROM
			        	lovebook_tb_favoritos as fav
			        WHERE
			        	fav.id_usuario = :id
			    )
			LIMIT
				$offset, $limit
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getBooksPay($offset = 0, $limit = 30) {
		$query = "
			SELECT
				b.id, b.titulo, b.img, b.id_autor, b.data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor
			FROM
				lovebook_tb_books as b 
			    LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
			WHERE
				b.id IN(
			    	SELECT
			        	pay.id_book
			        FROM
			        	lovebook_tb_pay as pay
			        WHERE
			        	pay.id_usuario = :id
			    )
			LIMIT
				$offset, $limit
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function removeLivrosAssocFromAutor() {
		$query = '
			DELETE FROM lovebook_tb_books WHERE id_autor = :id_autor
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->execute();
	}

	public function searchBook($text) {
		$text = '%'.$text.'%';
		$query = '
			SELECT
				b.id, b.titulo, b.img, b.id_autor, b.data_lancamento, b.preco, b.desc_book, b.paginas, au.nome as autor
			FROM
				lovebook_tb_books as b 
			    LEFT JOIN lovebook_tb_autores as au ON (au.id = b.id_autor)
			WHERE
				b.titulo LIKE :text	
			LIMIT
				0, 5
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':text', $text);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}

}


?>