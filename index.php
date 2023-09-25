<!DOCTYPE html>

<html>

<head>
	<title> CRUD </title>


	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>

	<script type="text/javascript"
		src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>

	<script type="text/javascript"
		src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.3.1/jquery.twbsPagination.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.5/validator.min.js"></script>

	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

	<script type="text/javascript">

		var url = "http://localhost:80/challenge-crud/";

	</script>

	<script src="/challenge-crud/js/index.js"></script>
	<script src="/challenge-crud/js/service.js"></script>
	<script src="/challenge-crud/js/form.js"></script>

</head>

<body>


	<div class="container">

		<div class="row">

			<div class="col-lg-12 margin-tb">

				<div class="pull-left">

					<h2>Listagem de pedidos</h2>

				</div>

				<div class="pull-right">

					<button type="button" id="btnRegisterModal"  class="btn btn-success" data-toggle="modal" data-target="#create-item">

						Criar pedido

					</button>

				</div>

			</div>

		</div>

		<table class="table table-bordered">

			<thead>

				<tr>

					<th>ID</th>

					<th>Produto</th>
					<th>CPF</th>

					<th>Cliente</th>

					<th width="200px"></th>

				</tr>

			</thead>

			<tbody>

			</tbody>

		</table>



		<ul id="pagination" class="pagination-sm"></ul>



		<!-- Create Item Modal -->

		<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="createOrder">

			<div class="modal-dialog" role="document">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">×</span></button>

						<h4 class="modal-title" id="createOrder">Criar pedido</h4>

					</div>



					<div class="modal-body">

						<form data-toggle="validator" action="api/create.php" method="POST">

							<div class="form-group">

								<label class="control-label" for="title">Preço:</label>

								<input name="price" id="price" class="form-control"
									data-error="Por favor insira o preço." required />

								<div class="help-block with-errors"></div>

							</div>

							<div class="form-group">

								<label class="control-label" for="title">Selecione o cliente</label>

								<select name="customerSelect" id="customerSelect" class="form-control"
									data-error="Por favor selecione o cliente " required>
									<option value="">Selecione o cliente</option>
								</select>
								<div class="help-block with-errors"></div>

							</div>

							<div class="form-group">

								<label class="control-label" for="title">Selecione o Produto</label>

								<select name="productSelect" id="productSelect" class="form-control"
									data-error="Por favor selecione o cliente " required>
									<option value="">Selecione o produto</option>
								</select>
								<div class="help-block with-errors"></div>

							</div>


							<div class="form-group">

								<button type="submit" class="btn crud-submit btn-success">Submit</button>

							</div>

						</form>



					</div>

				</div>



			</div>

		</div>



		<!-- Edit order Modal -->

		<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">

			<div class="modal-dialog" role="document">

				<div class="modal-content">

					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
								aria-hidden="true">×</span></button>

						<h4 class="modal-title" id="myModalLabel">Editar pedido</h4>

					</div>

					<div class="modal-body">

						<form data-toggle="validator" action="api/update.php" method="put">

							<input type="hidden" name="id" class="edit-id">

							<div class="form-group">

								<label class="control-label" for="title">Preço:</label>

								<input name="price" id="editprice" class="form-control"
									data-error="Por favor insira o preço." required />

								<div class="help-block with-errors"></div>

							</div>

							<div class="form-group">

								<label class="control-label" for="title">Selecione o cliente</label>

								<select name="customerSelect" id="editcustomerSelect" class="form-control"
									data-error="Por favor selecione o cliente " required>
									<option value="">Selecione o cliente</option>
								</select>
								<div class="help-block with-errors"></div>

							</div>

							<div class="form-group">

								<label class="control-label" for="title">Selecione o Produto</label>

								<select name="productSelect" id="editproductSelect" class="form-control"
									data-error="Por favor selecione o cliente " required>
									<option value="">Selecione o produto</option>
								</select>
								<div class="help-block with-errors"></div>

							</div>


							<div class="form-group">

								<button type="submit" class="btn btn-success crud-submit-edit">Submit</button>

							</div>



						</form>



					</div>

				</div>

			</div>

		</div>



	</div>

</body>

<script>
	function editItem(id) {
		$.ajax({
			dataType: "json",
			url: url + 'api/getData.php?id=' + id,
		}).done(function (data) {

			getCustomers('edit');

			getProducts('edit');

			let order = data.orders[0];
			$("#edit-item").find("#editprice").val('R$ '+  order.price.replace('.', ','));
	
			$("#edit-item").find("#editcustomerSelect").val(description);
	
			$("#edit-item").find("#editproductSelect").val(description);
	
			$("#edit-item").find(".edit-id").val(id);
		});

	};

	  // Get customers
	  function getCustomers(type) {
    let base = type == 'edit' ?? edit;
    $.ajax({
      dataType: "json",

      url: url + "api/customers/getData.php",
    }).done(function (data) {

      // Get the select element by its id
      const selectElement = document.getElementById('editcustomerSelect');

      // Loop through the array and create an option element for each user
      data.forEach((user) => {
        const option = document.createElement("option");
        option.value = user.id; // Set the value of the option to the user's id
        option.text = user.name; // Set the text of the option to the user's name
        selectElement.appendChild(option); // Append the option to the select element
      });
    });
  }

  function getProducts(type) {
    $.ajax({
      dataType: "json",

      url: url + "api/products/getData.php",
    }).done(function (data) {
      // Get the select element by its id
      const selectElement = document.getElementById('editproductSelect');

      // Loop through the array and create an option element for each user
      data.forEach((user) => {
        const option = document.createElement("option");
        option.value = user.id; // Set the value of the option to the user's id
        option.text = user.name; // Set the text of the option to the user's name
        selectElement.appendChild(option); // Append the option to the select element
      });
    });
  }

</script>

</html>