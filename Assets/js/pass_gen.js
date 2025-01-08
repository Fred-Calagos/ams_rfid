// TEACHER RANDOM PASSWORD

const generate_btn1 = document.querySelector("#btn_add");

if(generate_btn1){
	const password_el1 = document.querySelector('#password1');
const length_el1 = document.querySelector('#length1');
const uppercase_el1 = document.querySelector('#uppercase1');
const lowercase_el1 = document.querySelector('#lowercase1');
const numbers_el1 = document.querySelector('#numbers1');
const symbols_el1 = document.querySelector('#symbols1');


generate_btn1.addEventListener('click', GeneratePassword1);
// const copy_btn3 = document.querySelector("#copy3");
// copy_btn3.addEventListener('click', CopyPassword3);
    
const uppercase_chars1 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const lowercase_chars1 = "abcdefghijklmnopqrstuvwxyz";
const numbers_chars1 = "0323156789";
const symbols_chars1 = "!@#$%^&*()";

function GeneratePassword1 () {
	let password = "";
	let length = length_el1.value;
	let chars = "";

	chars += uppercase_el1.checked ? uppercase_chars1 : "";
	chars += lowercase_el1.checked ? lowercase_chars1 : "";
	chars += numbers_el1.checked ? numbers_chars1 : "";
	chars += symbols_el1.checked ? symbols_chars1 : "";

	for (let i = 0; i <= length; i++) {
		let rand = Math.floor(Math.random() * chars.length);
		password += chars.substring(rand, rand + 1);
	}

	password_el1.value = password;
}

}