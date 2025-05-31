// Get references to elements
const selectAllCheckbox = document.getElementById("selectAll");
const deleteButton = document.getElementById("deleteBtn");
const table = document.getElementById("dataTable");

// Function to toggle all checkboxes
selectAllCheckbox.addEventListener("change", function () {
  const checkboxes = document.querySelectorAll(".rowCheckbox");
  checkboxes.forEach((cb) => {
    cb.checked = this.checked;
  });
});

// Optional: Uncheck "Select All" if any individual checkbox is unchecked
const rowCheckboxes = document.querySelectorAll(".rowCheckbox");
rowCheckboxes.forEach((cb) => {
  cb.addEventListener("change", function () {
    if (!this.checked) {
      selectAllCheckbox.checked = false;
    } else {
      // If all checkboxes are checked, check "Select All"
      const allChecked = Array.from(rowCheckboxes).every((c) => c.checked);
      selectAllCheckbox.checked = allChecked;
    }
  });
});

// Delete selected rows
deleteButton.addEventListener("click", function () {
  const checkboxes = document.querySelectorAll(".rowCheckbox");
  checkboxes.forEach((cb) => {
    if (cb.checked) {
      // Remove the row containing this checkbox
      const row = cb.closest("tr");
      row.remove();
    }
  });
  // After deletion, uncheck "Select All"
  selectAllCheckbox.checked = false;
});
