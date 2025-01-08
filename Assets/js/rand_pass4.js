// TEACHER RANDOM PASSWORD

const generate_btn5 = document.querySelector("#btn_admin");

if(generate_btn5){
	const password_el5 = document.querySelector('#password5');
const length_el5 = document.querySelector('#length5');
const uppercase_el5 = document.querySelector('#uppercase5');
const lowercase_el5 = document.querySelector('#lowercase5');
const numbers_el5 = document.querySelector('#numbers5');


generate_btn5.addEventListener('click', GeneratePassword5);
// const copy_btn3 = document.querySelector("#copy3");
// copy_btn3.addEventListener('click', CopyPassword3);
    
const uppercase_chars5 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const lowercase_chars5 = "abcdefghijklmnopqrstuvwxyz";
const numbers_chars5 = "0323556789";

function GeneratePassword5 () {
	let password = "";
	let length = length_el5.value;
	let chars = "";

	chars += uppercase_el5.checked ? uppercase_chars5 : "";
	chars += lowercase_el5.checked ? lowercase_chars5 : "";
	chars += numbers_el5.checked ? numbers_chars5 : "";

	for (let i = 0; i <= length; i++) {
		let rand = Math.floor(Math.random() * chars.length);
		password += chars.substring(rand, rand + 1);
	}

	password_el5.value = password;
}

}