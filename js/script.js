
const horarios = document.querySelectorAll('main tbody td:not(.dia)');

horarios.forEach(slot => {
    slot.addEventListener('click', () => {
        alert('Você selecionou o horário: ' + obterInformacaoSlot(slot));
        
    });
});

function obterInformacaoSlot(slot) {
    const linha = slot.parentElement;
    const dia = linha.querySelector('.dia').textContent;
    const index = Array.from(slot.parentElement.children).indexOf(slot) + 1;
    const horario = document.querySelector(`main thead th:nth-child(${index + 1})`).textContent;
    return `${dia} às ${horario}`;
}
