$(document).ready(function () {
  async function mountForm(type) {
    // Wait for the js/service.js JavaScript file to be loaded.
    // await service.onload;

    let formData = {
      customers: {},
      products: {},
    };

    await getCustomers().then((response) => (formData.customers = response));
    await getProducts().then((response) => (formData.products = response));

    let fieldName = {
      customer: "customerSelect",
      products: "productSelect",
    };

    if (type === "update")
      fieldName = {
        customer: "editCustomerSelect",
        products: "editProductSelect",
      };

    const customerSelectElement = document.getElementById(fieldName.customer);
    // Loop through the array and create an option element for each user
    formData.customers.forEach((user) => {
      const option = document.createElement("option");
      option.value = user.id; // Set the value of the option to the user's id
      option.text = user.name; // Set the text of the option to the user's name
      customerSelectElement.appendChild(option); // Append the option to the select element
    });

    const productSelectElement = document.getElementById(fieldName.products);

    // Loop through the array and create an option element for each user
    console.log(formData.products);
    formData.products.forEach((user) => {
      const option = document.createElement("option");
      option.value = user.id; // Set the value of the option to the user's id
      option.text = user.name; // Set the text of the option to the user's name
      productSelectElement.appendChild(option); // Append the option to the select element
    });
  }

  $("#btnRegisterModal").on("click", () => mountForm());

  const moneyInput = $("#price");
  moneyInput.on("input", function () {
    formatMoneyInput($(this));
  });

  //   Create order
  $(".crud-submit").click(function (e) {
    e.preventDefault();

    let form_action = $("#create-item").find("form").attr("action");

    let price = $("#price").val();

    const customerSelect = $("#customerSelect").val();
    const productSelect = $("#productSelect").val();

    if (price != "" && customerSelect != "" && productSelect != "") {
      $.ajax({
        dataType: "json",
        type: "POST",
        url: url + form_action,
        contentType: "application/json", // Set the content type to JSON
        data: JSON.stringify({
          price: price,
          customerSelect: customerSelect,
          productSelect: productSelect,
        }),
      }).done(function (data) {
        $("#create-item").find("#price").val("");
        $("#create-item").find("#customerSelect").val("");
        $("#create-item").find("#productSelect").val("");
        getPageData();
        $(".modal").modal("hide");
        toastr.success("Pedido cadastrado com sucesso.", "Pedido cadastrado", {
          timeOut: 5000,
        });
        manageData();
      });
    } else {
      alert("You are missing title or description.");
    }
  });

  /* Remove order*/

  $("body").on("click", ".remove-item", function () {
    let id = $(this).closest("tr").find("td:first").text();

    $.ajax({
      dataType: "json",

      type: "POST",

      url: url + "api/delete.php",

      data: { id: id },
    }).done(function (data) {
      toastr.success("Pedido removido com sucesso!", "Pedido removido", {
        timeOut: 2000,
      });

      window.location.reload();
    });
  });

  /* Updated product */
  $(".crud-submit-edit").click(function (e) {
    e.preventDefault();
    window.location.reload();
  });
});
