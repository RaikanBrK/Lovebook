<?php 

namespace App\Models;
use MF\Model\Model;

class Autores extends Model {
	protected $id;
	protected $nome;
	protected $img;
	protected $desc_autor;
	protected $estado_civil;
	protected $data_nascimento;

	public function getAllAutores() {
		$query = '
			SELECT
				id, nome
			FROM
				lovebook_tb_autores
		';

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getAutoresDestaques($offset = 0, $limit = 8) {
		$query = "
			SELECT
				*, (
			    	SELECT
			        	COUNT(id_autor)
			        FROM
			        	lovebook_tb_favoritos
			        WHERE
			        	id_autor = au.id
			    ) as qtd_favorito
			FROM
				lovebook_tb_autores as au
			ORDER BY
				qtd_favorito DESC
			LIMIT
				$offset, $limit
		";

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getAutores($limit = 8, $offset = 0) {
		$query = "
			SELECT
				id, nome, img, desc_autor, estado_civil, data_nascimento 
			FROM
				lovebook_tb_autores
			ORDER BY
				id ASC
			LIMIT
				$offset, $limit
		";
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getAutorFromId() {
		$query = "
			SELECT
				id, nome, img, desc_autor, estado_civil, data_nascimento
			FROM
				lovebook_tb_autores
			WHERE
				id = :id
		";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function getAutorFromName() {
		$query = "
			SELECT
				id, nome, img, desc_autor, estado_civil, data_nascimento
			FROM
				lovebook_tb_autores
			WHERE
				nome = :nome
		";
		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function createAutor() {
		$query = '
			INSERT INTO lovebook_tb_autores(nome, desc_autor, estado_civil, data_nascimento) VALUES(
				:nome, :desc_autor, :estado_civil, :data_nascimento
			);
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':desc_autor', $this->__get('desc_autor'));
		$stmt->bindValue(':estado_civil', $this->__get('estado_civil'));
		$stmt->bindValue(':data_nascimento', $this->__get('data_nascimento'));
		$stmt->execute();
		return $this->db->lastInsertId();
	}

	public function validarAutor() {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_autores
			WHERE
				nome = :nome
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function validarAutorEdit() {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_autores
			WHERE
				nome = :nome && id != :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function ultimoId() {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_autores
			ORDER BY
				id DESC
			LIMIT
				0, 1
		';

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function updateAutor() {
		$query = '
			UPDATE
				lovebook_tb_autores
			SET
				nome = :nome,
				desc_autor = :desc_autor,
				estado_civil = :estado_civil,
				data_nascimento = :data_nascimento
			WHERE
				id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':desc_autor', $this->__get('desc_autor'));
		$stmt->bindValue(':estado_civil', $this->__get('estado_civil'));
		$stmt->bindValue(':data_nascimento', $this->__get('data_nascimento'));
		$stmt->execute();

		$this->updateImg();
	}

	public function updateImg() {
		if ($this->__get('img') != '') {
			$query = '
				UPDATE
					lovebook_tb_autores
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

	public function removeBooksFromAutor() {
		$query = '
			DELETE FROM lovebook_tb_books WHERE id_autor = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
	}

	public function removeAutor() {
		$query = '
			DELETE FROM lovebook_tb_autores WHERE id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
	}

	public function searchAutores($text) {
		$text = '%'.$text.'%';
		$query = '
			SELECT
				id, nome, img, desc_autor, estado_civil, data_nascimento
			FROM
				lovebook_tb_autores
			WHERE
				nome LIKE :text	
			LIMIT
				0, 4
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':text', $text);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_OBJ);
	}
}


?>