// Price
function updatePrice() {
  var appointment = document.getElementById("appointment").value;
  var priceInput = document.getElementById("price");
  let price = 500;

  if (appointment === "SOLO") {
    price = 500;
  } else if (appointment === "DUO") {
    price = 800;
  } else if (appointment === "TRIO") {
    price = 900;
  } else if (appointment === "QUAD") {
    price = 1000;
  } else if (appointment === "DELUXE") {
    price = 2500;
  } else if (appointment === "GROUP") {
    price = 1500;
  } else if (appointment === "PACKAGE 1") {
    price = 899;
  } else if (appointment === "PACKAGE 2") {
    price = 1599;
  } else if (appointment === "PACKAGE 3") {
    price = 2599;
  } else if (appointment === "PACKAGE 4") {
    price = 3599;
  }

  priceInput.value = "₱ " + price;
}
