var btn_add_t = document.getElementById('add_time');
var modal_container_time = document.getElementById('modal_time');
var close_add_t = document.getElementById('btn_cancel_t');
var btn_save_t = document.getElementById('btn_time');

btn_add_t.addEventListener('click', () => {
    modal_container_time.classList.add('show');
});

close_add_t.addEventListener('click', () => {
    modal_container_time.classList.remove('show');
});

btn_save_t.addEventListener('click', () => {
    modal_container_time.classList.remove('show');
});
