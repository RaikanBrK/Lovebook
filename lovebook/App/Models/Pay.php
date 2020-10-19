<?php 

namespace App\Models;
use MF\Model\Model;

class Pay extends Model {
	protected $id;
	protected $id_usuario;
	protected $id_book;
	protected $id_autor;

	public function pay() {
		$query = '
			INSERT INTO lovebook_tb_pay(
				id_usuario, id_book, id_autor
			) VALUES(
				:id_usuario, 
				:id_book,
				:id_autor
			)
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id_book', $this->__get('id_book'));
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->execute();
	}	

	public function verificarPay() {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_pay
			WHERE id_usuario = :id_usuario && id_book = :id_book && id_autor = :id_autor
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
		$stmt->bindValue(':id_book', $this->__get('id_book'));
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function removePayFromBook() {
		$query = '
			DELETE FROM lovebook_tb_pay WHERE id_book = :id_book
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_book', $this->__get('id_book'));
		$stmt->execute();
	}


	public function removePayAssocFromAutor() {
		$query = '
			DELETE FROM lovebook_tb_pay WHERE id_autor = :id_autor
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id_autor', $this->__get('id_autor'));
		$stmt->execute();
	}
}


?>