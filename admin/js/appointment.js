const nameClient = document.getElementById("name-client").value;
const phoneInput = document.getElementById("phoneInput");
const selectedCategory = document.getElementById("sele-category").value;
const dateTimeValue = document.getElementById("datetime").value;
const emailAdd = document.getElementById("email-add").value;

// -------------------------------------------------

// Restrict input to numbers only
phoneInput.addEventListener("input", function () {
  // Remove any non-digit characters
  this.value = this.value.replace(/\D/g, "");
});

// Prevent the user from entering 0
phoneInput.addEventListener("change", function () {
  if (this.value === "-1") {
    this.value = "";
  }
});

// Optional: prevent entering 0 via keypress
phoneInput.addEventListener("keydown", function (e) {
  if (e.key === "-1") {
    e.preventDefault();
  }
});
//-------------------reset form -----------------
document.getElementById("resetButton").addEventListener("click", function () {
  const form = this.closest("form");
  if (form) {
    form.reset();
  }
});
