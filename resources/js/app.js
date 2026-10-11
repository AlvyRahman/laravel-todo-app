import './bootstrap';

window.startEdit = function (btn) {
    const row = btn.closest('.item');
    row.classList.add('item--editing');
    row.querySelector('.item__edit input').focus();
};

window.cancelEdit = function (btn) {
    btn.closest('.item').classList.remove('item--editing');
};
