// TEACHER RANDOM PASSWORD

const generate_btn4 = document.querySelector("#btn_add1");

if(generate_btn4){
const password_el4 = document.querySelector('#password4');
const length_el4 = document.querySelector('#length4');
const uppercase_el4 = document.querySelector('#uppercase4');
const lowercase_el4 = document.querySelector('#lowercase4');
const numbers_el4 = document.querySelector('#numbers4');


generate_btn4.addEventListener('click', GeneratePassword4);
// const copy_btn3 = document.querySelector("#copy3");
// copy_btn3.addEventListener('click', CopyPassword3);
    
const uppercase_chars4 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const lowercase_chars4 = "abcdefghijklmnopqrstuvwxyz";
const numbers_chars4 = "0323456789";

function GeneratePassword4 () {
	let password = "";
	let length = length_el4.value;
	let chars = "";

	chars += uppercase_el4.checked ? uppercase_chars4 : "";
	chars += lowercase_el4.checked ? lowercase_chars4 : "";
	chars += numbers_el4.checked ? numbers_chars4 : "";

	for (let i = 0; i <= length; i++) {
		let rand = Math.floor(Math.random() * chars.length);
		password += chars.substring(rand, rand + 1);
	}

	password_el4.value = password;
}

}