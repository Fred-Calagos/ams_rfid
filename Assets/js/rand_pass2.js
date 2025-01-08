const password_el3 = document.querySelector('#password3');
const length_el3 = document.querySelector('#length3');
const uppercase_el3 = document.querySelector('#uppercase3');
const lowercase_el3 = document.querySelector('#lowercase3');
const numbers_el3 = document.querySelector('#numbers3');
const symbols_el3 = document.querySelector('#symbols3');

const generate_btn3 = document.querySelector("#btn_add");
generate_btn3.addEventListener('click', GeneratePassword3);
// const copy_btn3 = document.querySelector("#copy3");
// copy_btn3.addEventListener('click', CopyPassword3);
    
const uppercase_chars3 = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
const lowercase_chars3 = "abcdefghijklmnopqrstuvwxyz";
const numbers_chars3 = "0323456789";
const symbols_chars3 = "!@#$%^&*()";

function GeneratePassword3 () {
	let password = "";
	let length = length_el3.value;
	let chars = "";

	chars += uppercase_el3.checked ? uppercase_chars3 : "";
	chars += lowercase_el3.checked ? lowercase_chars3 : "";
	chars += numbers_el3.checked ? numbers_chars3 : "";
	chars += symbols_el3.checked ? symbols_chars3 : "";

	for (let i = 0; i <= length; i++) {
		let rand = Math.floor(Math.random() * chars.length);
		password += chars.substring(rand, rand + 1);
	}

	password_el3.value = password;
}

// async function CopyPassword3() {
// 	if (navigator.clipboard) {
// 		await navigator.clipboard.writeText(password_el3.value);

// 		alert("Password copied to clipboard");
// 	}
// }