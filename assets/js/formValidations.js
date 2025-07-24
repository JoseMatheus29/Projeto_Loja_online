function validarFormularioCliente(form) {
    let valido = true;
    let mensagens = [];

    // Limpa classes de erro anteriores
    const campos = form.querySelectorAll('.is-invalid');
    campos.forEach(c => c.classList.remove('is-invalid'));

    const nome = form.querySelector('[name="nome"]');
    if (nome) {
        if (nome.value.trim().length < 3) {
            valido = false;
            mensagens.push('Nome deve ter pelo menos 3 caracteres.');
            nome.classList.add('is-invalid');
        }
    }

    const email = form.querySelector('[name="email"]');
    if (email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email.value)) {
            valido = false;
            mensagens.push('E-mail inválido.');
            email.classList.add('is-invalid');
        }
    }

    const senha = form.querySelector('[name="senha"]');
    const senha2 = form.querySelector('[name="senha2"]');
    if (senha && senha2) {
        if (senha.value.length < 6) {
            valido = false;
            mensagens.push('A senha deve ter pelo menos 6 caracteres.');
            senha.classList.add('is-invalid');
        }
        if (senha.value !== senha2.value) {
            valido = false;
            mensagens.push('As senhas não coincidem.');
            senha.classList.add('is-invalid');
            senha2.classList.add('is-invalid');
        }
        // Força da senha
        const forte = /^(?=.*[a-zA-Z])(?=.*\d).{6,}$/;
        if (!forte.test(senha.value)) {
            valido = false;
            mensagens.push('A senha deve conter letras e números.');
            senha.classList.add('is-invalid');
        }
    }

    // Telefone
    const telefone = form.querySelector('[name="telefone"]');
    if (telefone) {
        const telLimpo = telefone.value.replace(/\D/g, '');
        if (telLimpo.length < 10) {
            valido = false;
            mensagens.push('Telefone deve ter pelo menos 10 dígitos.');
            telefone.classList.add('is-invalid');
        }
    }

    // Exibir mensagens de erro usando Toastr.js
    if (mensagens.length > 0 && typeof toastr !== 'undefined') {
        toastr.clear();
        mensagens.forEach(msg => toastr.error(msg, 'Erro de Validação'));
    }
    return valido;
}

// Exibir alerta de sucesso usando Toastr.js
function mostrarAlertaSucesso(form, mensagem) {
    if (typeof toastr !== 'undefined') {
        toastr.clear();
        toastr.success(mensagem, 'Sucesso!');
    }
}
