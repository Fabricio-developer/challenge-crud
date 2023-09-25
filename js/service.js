function manageData(page = 1) {
  $.ajax({
    dataType: "json",

    url: url + "api/getData.php",

    data: { page: page },
  }).done(function (data) {
    total_page = Math.ceil(data.total / 10);

    current_page = page;

    return manageRow(data.orders);

    is_ajax_fire = 1;
  });
}

/* Get Page Data*/

function getPageData(page = 1) {
  $.ajax({
    dataType: "json",

    url: url + "api/getData.php",

    data: { page: page },
  }).done(function (data) {
    manageRow(data);
  });
}

/* Add new Item table row */

function manageRow(data) {
  var rows = "";

  $.each(data, function (key, value) {
    rows = rows + "<tr>";

    rows = rows + "<td>" + value.order_id + "</td>";
    rows = rows + "<td>" + value.product_name + "</td>";
    rows = rows + "<td>" + value.cpf + "</td>";

    rows = rows + "<td>" + value.customer_name + "</td>";

    rows = rows + '<td data-id="' + value.id + '">';

    rows =
      rows +
      '<button data-toggle="modal" data-target="#edit-item" class="btn btn-primary edit-item" onclick="editItem(' +
      value.order_id +
      ')" >Editar</button> ';
    rows = rows + '<button class="btn btn-danger remove-item">Apagar</button>';

    rows = rows + "</td>";

    rows = rows + "</tr>";
  });

  $("tbody").html(rows);
}

// Get customers
async function getCustomers () {
  let response = {};
  await $.ajax({
    dataType: "json",

    url: url + "api/customers/getData.php",
  }).done(function (data) {
    response =  data;
  });

  return response;
}

async function getProducts(type) {
  let response = {};
  await $.ajax({
    dataType: "json",

    url: url + "api/products/getData.php",
  }).done(function (data) {
    response = data;
  });

  return response;
}

//   Format form
function formatMoneyInput(input) {
  const value = input.val().replace(/\D/g, "");
  const formattedValue = (value / 100).toLocaleString("pt-BR", {
    style: "currency",
    currency: "BRL",
  });
  input.val(formattedValue);
}
