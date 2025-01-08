// TEACHER RANDOM PASSWORD

const generate_btn = document.querySelector("#btn_add1");

if(generate_btn){
	const password_el = document.querySelector('#password');
const length_el = document.querySelector('#length');
const uppercase_el = document.querySelector('#uppercase');
const lowercase_el = document.querySelector('#lowercase');
const numbers_el = document.querySelector('#numbers');
const symbols_el = document.querySelector('#symbols');


generate_btn.addEventListener('click', GeneratePassword);
// const copy_btn3 = document.querySelector("#copy3");
// copy_btn3.addEventListener('click', CopyPassword3);
    
const uppercase_chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const lowercase_chars = "abcdefghijklmnopqrstuvwxyz";
const numbers_chars = "032356789";
const symbols_chars = "!@#$%^&*()";

function GeneratePassword () {
	let password = "";
	let length = length_el.value;
	let chars = "";

	chars += uppercase_el.checked ? uppercase_chars : "";
	chars += lowercase_el.checked ? lowercase_chars : "";
	chars += numbers_el.checked ? numbers_chars : "";
	chars += symbols_el.checked ? symbols_chars : "";

	for (let i = 0; i <= length; i++) {
		let rand = Math.floor(Math.random() * chars.length);
		password += chars.substring(rand, rand + 1);
	}

	password_el.value = password;
}

}