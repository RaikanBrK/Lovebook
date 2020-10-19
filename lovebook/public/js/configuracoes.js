$(document).ready(function() {
	$('body').on('change', '#change-senha', function(e) {
		const checkbox = e.target;

		if (checkbox.checked) {
			$('#content-senha').show('slow');
			$('#content-new-senha').show('slow');
		} else {
			$('#content-senha').hide('slow');
			$('#content-new-senha').hide('slow');
		}
	});
});

const user = new Usuario();
user.userNome($('#nome'));
user.userNome($('#usuario'));
user.userCpf($('#cpf'));
user.userNumero($('#numero'));
user.userSenha($('#senha'));
user.userSenha($('#newSenha'));