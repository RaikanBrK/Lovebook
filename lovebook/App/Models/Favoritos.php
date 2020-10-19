<?php 

namespace App\Models;
use MF\Model\Model;

class Favoritos extends Model {
	protected $id;
	protected $id_usuario;
	protected $id_book;
	protected $id_autor;

	public function setFavorito() {
		$query = '
			INSERT INTO lovebook_tb_favoritos(
				id_usuario, id_book, id_autor
			) VALUES (
				:id_usuario, :id_book, :id_autor
			);
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id_book', $this->__get('id_book'));
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->execute();
	}

	public function removeFavorito() {
		$query = '
			DELETE FROM lovebook_tb_favoritos 
			WHERE id_usuario = :id_usuario && id_book = :id_book && id_autor = :id_autor
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id_book', $this->__get('id_book'));
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->execute();	
	}

	public function verificarFavorito() {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_favoritos
			WHERE id_usuario = :id_usuario && id_book = :id_book && id_autor = :id_autor
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id_book', $this->__get('id_book'));
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function removeFavoritoFromBook() {
		$query = '
			DELETE FROM lovebook_tb_favoritos WHERE id_book = :id_book
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_book', $this->__get('id_book'));
		$stmt->execute();
	}

	public function removeFavoritossAssocFromAutor() {
		$query = '
			DELETE FROM lovebook_tb_favoritos WHERE id_autor = :id_autor
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->execute();
	}
}


?>