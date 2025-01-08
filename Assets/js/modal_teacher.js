var btn_add_t= document.getElementById('add-teacher-modal');
var modal_container_t= document.getElementById('modal_add_teacher');
var close_add = document.getElementById('btn_cancel');
var btn_add = document.getElementById('btn_add');

if(btn_add_t){
	btn_add_t.addEventListener('click', () => {
		modal_container_t.classList.add('show');
	});
	close_add.addEventListener('click', () => {
		modal_container_t.classList.remove('show');
	});
	btn_add.addEventListener('click', () => {
		modal_container_t.classList.remove('show');
	}); 
}