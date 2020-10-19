<?php 

namespace App\Models;
use MF\Model\Model;

class Usuarios extends Model {
	protected $id;
	protected $nome;
	protected $sobrenome;
	protected $usuario;
	protected $email;
	protected $cpf;
	protected $cep;
	protected $numero;
	protected $senha;

	public function createUser() {
		if ($this->validarUserExist()) {
			$query = '
				INSERT INTO lovebook_tb_usuario(nome, sobrenome, usuario, email, cpf, cep, numero, senha) VALUES(
					:nome, :sobrenome, :usuario, :email, :cpf, :cep, :numero, :senha
				)
			';

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nome', $this->__get('nome'));
			$stmt->bindValue(':sobrenome', $this->__get('sobrenome'));
			$stmt->bindValue(':usuario', $this->__get('usuario'));
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->bindValue(':cpf', $this->__get('cpf'));
			$stmt->bindValue(':cep', $this->__get('cep'));
			$stmt->bindValue(':numero', $this->__get('numero'));
			$stmt->bindValue(':senha', $this->__get('senha'));
			$stmt->execute();
			return true;
		} else {
			return false;
		}

	}

	public function validarUserExist() {
		$query = '
			SELECT
				id
			FROM 
				lovebook_tb_usuario
			WHERE
				email = :email || usuario = :usuario || cpf = :cpf
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':usuario', $this->__get('usuario'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':cpf', $this->__get('cpf'));
		$stmt->execute();
		$users = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return count($users) == 0;
	}

	public function logarUserAccount() {
		$query = '
			SELECT 
				id
			FROM
				lovebook_tb_usuario
			WHERE
				(usuario = :usuario || email = :usuario || cpf = :usuario)  && senha = :senha
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':usuario', $this->__get('usuario'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function getUserFromId() {
		$query = '
			SELECT
				id, nome, sobrenome, usuario, email, cpf, cep, numero, senha
			FROM
				lovebook_tb_usuario
			WHERE
				id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function updateDateAccount() {
		$query = '
			UPDATE 
				lovebook_tb_usuario
			SET
				id = :id, 
				nome = :nome, 
				sobrenome = :sobrenome, 
				usuario = :usuario, 
				email = :email, 
				cpf = :cpf, 
				cep = :cep, 
				numero = :numero
			WHERE
				id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->bindValue(':nome', $this->__get('nome'));
		$stmt->bindValue(':sobrenome', $this->__get('sobrenome'));
		$stmt->bindValue(':usuario', $this->__get('usuario'));
		$stmt->bindValue(':email', $this->__get('email'));
		$stmt->bindValue(':cpf', $this->__get('cpf'));
		$stmt->bindValue(':cep', $this->__get('cep'));
		$stmt->bindValue(':numero', $this->__get('numero'));
		$stmt->execute();
		return $stmt->fetch(\PDO::FETCH_ASSOC);
	}

	public function verificarAlteracaoSenha($senha) {
		$query = '
			SELECT
				id
			FROM
				lovebook_tb_usuario
			WHERE
				id = :id && senha = :senha
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->bindValue(':senha', $senha);
		$stmt->execute();
		$user = $stmt->fetchAll(\PDO::FETCH_ASSOC);
		return count($user) > 0;
	}

	public function updateSenhaAccount() {
		$query = '
			UPDATE
				lovebook_tb_usuario
			SET
				senha = :senha
			WHERE
				id = :id
		';

		$stmt = $this->db->prepare($query);
		$stmt->bindValue(':id', $this->__get('id'));
		$stmt->bindValue(':senha', $this->__get('senha'));
		$stmt->execute();
	}

	
}


?>