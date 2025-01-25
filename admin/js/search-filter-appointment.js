document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.querySelector('input[name="search"]');
  const searchButton = document.querySelector('input[type="submit"]');
  const clientTableBody = document.getElementById("client-table-body");

  function filterClients() {
    const filterValue = searchInput.value.toLowerCase();
    const rows = clientTableBody.getElementsByTagName("tr");
    let anyMatch = false;

    for (let i = 0; i < rows.length; i++) {
      const clientNameCell = rows[i].children[1];
      if (clientNameCell) {
        const clientName =
          clientNameCell.textContent || clientNameCell.innerText;
        if (clientName.toLowerCase().includes(filterValue)) {
          rows[i].style.display = "";
          anyMatch = true;
        } else {
          rows[i].style.display = "none";
        }
      }
    }

    // Clear previous messages
    const messageRow = document.querySelector(".no-results-message");
    if (messageRow) {
      messageRow.remove();
    }

    // Show message if no matches found
    if (!anyMatch) {
      const noResultsRow = document.createElement("tr");
      noResultsRow.classList.add("no-results-message");
      noResultsRow.innerHTML = `<td colspan="8" style="text-align:center;">
            <p class="heading-main12" style="font-size:20px;color:rgb(49, 49, 49)">We couldn't find anything related to your keywords!</p>
            </td>`;
      clientTableBody.appendChild(noResultsRow);
    }
  }

  searchButton.addEventListener("click", function (event) {
    event.preventDefault();
    filterClients();
  });

  searchInput.addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      filterClients();
    }
  });
});
