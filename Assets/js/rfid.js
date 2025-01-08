function lettersOnly(input) {
  var regex = /s[^a-z]/gi;
  var inputValue = input.value;

  // Add your RFID detection logic here
  if (isRFIDCard(inputValue)) {
    // If it's an RFID card, you can choose to skip or handle it differently
    console.log("RFID card detected. Ignoring...");
    return;
  }

  // If not an RFID card, proceed with the letters-only logic
  input.value = inputValue.replace(regex, "");
}

// // Example RFID detection function (you need to implement your own logic)
// function isRFIDCard(value) {
//   // Replace this with your actual RFID detection logic
//   // For example, you might check the length, prefix, or some other characteristic of RFID cards
//   return value.length === 10 && value.startsWith("RFID");
// }

document.addEventListener("DOMContentLoaded", function () {
  var modal = document.getElementById("modal_add_student");
  var btn = document.getElementById("add-student-modal");
  var span = document.getElementById("btn_cancel");

  btn.onclick = function () {
      modal.style.display = "block";
  };  

  span.onclick = function () {
      modal.style.display = "none";
  };

  // JavaScript function to allow only letters in input fields

  // JavaScript function to prevent form submission on Enter key press for RFID input
  var rfidInput = document.getElementById("rfidcard");
  rfidInput.addEventListener("keydown", function (event) {
      if (event.key === "Enter") {
          event.preventDefault();
          
      }
  });   
  var rfidInput1 = document.getElementById("rfidcard1");
  rfidInput1.addEventListener("keydown", function (event) {
      if (event.key === "Enter") {
          event.preventDefault();
          
      }
  });
});

var rfidInput_teach = document.getElementById("rfidcard_teach");
rfidInput_teach.addEventListener("keydown", function (event) {
    if (event.key === "Enter") {
        event.preventDefault();
        
    }
});
var pass = document.getElementById("generate");
pass.addEventListener("onclick", function (event) {
    if (event.key === "onClick") {
        event.preventDefault();
        
    }
});
var pass1 = document.getElementById("btn_add1");
pass1.addEventListener("onclick", function (event) {
    if (event.key === "onClick") {
        event.preventDefault();
        
    }
});
var pass3 = document.getElementById("btn_add");
pass3.addEventListener("onclick", function (event) {
    if (event.key === "onClick") {
        event.preventDefault();
        
    }
});
var pass4 = document.getElementById("btn_admin");
pass4.addEventListener("onclick", function (event) {
    if (event.key === "onClick") {
        event.preventDefault();
        
    }
});