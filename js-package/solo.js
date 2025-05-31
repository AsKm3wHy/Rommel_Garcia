document
  .getElementById("appointmentForm")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const package = this.elements["package"].value;
    const fullName = this.elements["fullName"].value;
    const email = this.elements["email"].value;
    const phone = this.elements["phone"].value;
    const date = this.elements["date"].value;
    const time = this.elements["time"].value;

    const modalContent = document.getElementById("modalContent");
    modalContent.innerHTML = `
        <p><strong>Package:</strong> ${package}</p>
        <p><strong>Full Name:</strong> ${fullName}</p>
        <p><strong>Email:</strong> ${email}</p>
        <p><strong>Phone #:</strong> ${phone}</p>
        <p><strong>Date:</strong> ${date}</p>
        <p><strong>Time:</strong> ${time}</p>
    `;

    document.getElementById("confirmationModal").style.display = "flex";
  });

document.getElementById("closeModal").addEventListener("click", function () {
  document.getElementById("confirmationModal").style.display = "none";

  document.getElementById("appointmentForm").reset();
});

const today = new Date();
const year = today.getFullYear();
const month = String(today.getMonth() + 1).padStart(2, "0");
const day = String(today.getDate()).padStart(2, "0");

const minDate = `${year}-${month}-${day}`;

document.querySelector('input[name="date"]').setAttribute("min", minDate);
