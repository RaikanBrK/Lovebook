<?php 
	namespace App\Controllers;

	class RenderAdministradores {
		protected $adminitradores = null;

		public function __set($attr, $valor) {
			$this->$attr = $valor;
		}

		public function __get($attr) {
			return $this->$attr;
		}

		public function renderAdm() { ?>	
			<div class="container table-responsive">
				
				<table class="table table-hover table-dark">
					<thead>
						<tr>
							<th scope="col">Primeiro nome</th>
							<th scope="col">Sobrenome</th>
							<th scope="col">Usuário</th>
							<th scope="col">email</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($this->__get('adminitradores') as $adm) { ?>
							<tr data-id="<?= $adm['id'] ?>">
								<th scope="row"><?= $adm['nome'] ?></th>
								<td><?= $adm['sobrenome'] ?></td>
								<td><?= $adm['usuario'] ?></td>
								<td><?= $adm['email'] ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php
		}
	}

?>