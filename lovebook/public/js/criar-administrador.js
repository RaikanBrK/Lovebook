$('body').on('keypress', '#nome', function(e) {
	if (e.keyCode == 32) {
		e.preventDefault();
	}
});

$('body').on('keypress', '#sobrenome', function(e) {
	if (e.keyCode == 32) {
		e.preventDefault();
	}
});

$('body').on('keypress', '#usuario', function(e) {
	if (e.keyCode == 32) {
		e.preventDefault();
	}
});


const adm = new Administrador();
adm.admNome($('#nome'));
adm.admSenha($('#senha'));
adm.admNome($('#usuario'));
adm.admConfirmSenha($('#confirmSenha'), $('#senha'));