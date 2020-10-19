const adm = new Administrador();
adm.admNome($('#nome'));
adm.admSenha($('#senha'));
adm.admNome($('#usuario'));
adm.admConfirmSenha($('#confirmSenha'), $('#senha'));