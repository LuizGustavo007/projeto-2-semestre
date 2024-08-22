document.getElementById("register-form").addEventListener("submit", function(event){
    event.preventDefault();
    
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirm-password").value;
    
    if(password !== confirmPassword) {
        alert("As senhas não coincidem. Por favor, tente novamente.");
    } else {
        alert("Cadastro realizado com sucesso!");
        // Aqui você pode adicionar o código para enviar os dados para o servidor
    }
});
