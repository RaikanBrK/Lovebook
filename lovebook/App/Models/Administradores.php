<?php 

namespace App\Models;
use MF\Model\Model;

class Administradores extends Model {
	protected $id;
	protected $nome;
	protected $sobrenome;
	protected $usuario;
	protected $email;
	protected $senha;

	public function loginAdministrativo() {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_administradores
			WHERE
				(usuario = :usuario || email = :usuario) && senha = :senha
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':usuario', $this->__get('usuario'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function createAdministrador() {
		if ($this->__get('sobrenome')) {
			$sobrenome = 'sobrenome';
		} else {
			$sobrenome = '';
		}
		$query = "
			INSERT INTO lovebook_tb_administradores(nome, usuario, email, senha, $sobrenome) VALUES(
				:nome, :usuario, :email, :senha, :sobrenome
			)
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':usuario', $this->__get('usuario'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		if ($sobrenome != '') {
			$stmt->bindValue(':sobrenome', $this->__get('sobrenome'));
		}
		$stmt->execute();
	}

	public function validarAdmExist() {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_administradores
			WHERE
				usuario = :usuario || email = :email
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':usuario', $this->__get('usuario'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function validarAdmExistWithId() {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_administradores
			WHERE
				(usuario = :usuario || email = :email) && id != :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->bindValue(':usuario', $this->__get('usuario'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getAllAdministradores() {
		$query = '
			SELECT
				id, nome, sobrenome, usuario, email
			FROM
				lovebook_tb_administradores
		';
		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function verificarQtdAdm() {
		$query = '
			SELECT
				COUNT(nome) as num_adm
			FROM
				lovebook_tb_administradores
		';

		$stmt = $this->db->prepare($query);
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function excluirAdm() {
		$query = '
			DELETE FROM lovebook_tb_administradores
			WHERE id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function getAdmFromId() {
		$query = '
			SELECT 
				id, nome, sobrenome, usuario, email, senha
			FROM
				lovebook_tb_administradores
			WHERE
				id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function updateAdm() {
		if ($this->__get('sobrenome')) {
			$sobrenome = 'sobrenome = :sobrenome,';
		} else {
			$sobrenome = '';
		} 
		$query = "
			UPDATE
				lovebook_tb_administradores
			SET
				nome = :nome,
				usuario = :usuario,
				email = :email,
				$sobrenome
				senha = :senha
			WHERE
				id = :id
		";

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':usuario', $this->__get('usuario'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		if ($sobrenome != '') {
			$stmt->bindValue(':sobrenome', $this->__get('sobrenome'));
		}
		$stmt->execute();
	}

	
}


?>