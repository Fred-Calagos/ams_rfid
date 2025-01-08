var btn_add_s= document.getElementById('add-student-modal');
var modal_container_book= document.getElementById('modal_add_student');
var close_add = document.getElementById('btn_cancel');
var btn_add = document.getElementById('btn_add');

btn_add_s.addEventListener('click', () => {
	modal_container_book.classList.add('show');
});
close_add.addEventListener('click', () => {
	modal_container_book.classList.remove('show');
});
btn_add.addEventListener('click', () => {
	modal_container_book.classList.remove('show');
});
