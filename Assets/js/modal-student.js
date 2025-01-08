// ADDING SUBJECT
var btn_add_sub= document.getElementById('add-subject');

// ADDING STUDENT and STUDENT ACCOUNT
var btn_add_s= document.getElementById('add-student-modal');
var modal_container= document.getElementById('modal_add_student');
var close_add = document.getElementById('btn_cancel');
var btn_add = document.getElementById('btn_add_st');

if(btn_add_s){
	btn_add_s.addEventListener('click', () => {
		modal_container.classList.add('show');
	});
	close_add.addEventListener('click', () => {
		modal_container.classList.remove('show');
	});
	btn_add.addEventListener('click', () => {
		modal_container.classList.remove('show');
	});
	
}
// ADDING TEACHER
var btn_teach = document.getElementById('add_teach');
var modal_container_teach= document.getElementById('modal_add_teacher1');
var close_add_teach = document.getElementById('btn_cancel1');
var btn_add_teach = document.getElementById('btn_add1');

if(btn_teach){
	btn_teach.addEventListener('click', () => {
		modal_container_teach.classList.add('show');
	});
	close_add_teach.addEventListener('click', () => {
		modal_container_teach.classList.remove('show');
	});
	btn_add_teach.addEventListener('click', () => {
		modal_container_teach.classList.remove('show');
	});
	
}
if(btn_add_sub){
	btn_add_sub.addEventListener('click', () => {
		modal_container.classList.add('show');
	});
	close_add.addEventListener('click', () => {
		modal_container.classList.remove('show');
	});
	btn_add.addEventListener('click', () => {
		modal_container.classList.remove('show');
	});
	
}