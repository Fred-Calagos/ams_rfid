var btn_add_e = document.getElementById('add_event');
var modal_container_event = document.getElementById('modal_event');
var close_add_e = document.getElementById('btn_cancel_e');
var btn_save_e = document.getElementById('btn_event');

btn_add_e.addEventListener('click', () => {
    modal_container_event.classList.add('show');
});

close_add_e.addEventListener('click', () => {
    modal_container_event.classList.remove('show');
});

btn_save_e.addEventListener('click', () => {
    modal_container_event.classList.remove('show');
});
