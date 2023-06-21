<?php 

	require "../config/sql.php";
	$id 			= $_REQUEST['id'];
	$client_id 		= $_REQUEST['client_id'];
	$query = "SELECT * FROM accounts_receivable WHERE id = '$id' AND client_id = '$client_id'";
	$queryRequest = mysqli_query($conn, $query);
	while ($invoices = mysqli_fetch_array($queryRequest)) {$invoice = $invoices;}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Fatura #<?php echo $invoice['id'] ?> | The Circle</title>
	<link rel="icon" type="image/x-icon" href="../assets/favicon/0.png">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
	<script src="https://kit.fontawesome.com/3fd2d35481.js" crossorigin="anonymous"></script>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,300;0,400;1,200;1,300;1,400&display=swap');
		body{
			font-family: Poppins !important;
			font-size: 0.8rem !important;
		}
		.module{
			padding: 50px;
			border-radius: 15px;

		}
		button.print{
			border-radius: 10px;
			border: none !important;
			padding: 10px 15px 10px 15px;
			font-family: Poppins;
			background: #454648;
			margin: 10px;
			color: white;
		}
		button.down{
			border-radius: 10px;
			border: none !important;
			padding: 10px 15px 10px 15px;
			font-family: Poppins;
			background: #454648;
			margin: 10px;
			color: white;
		}
		.align{
			position: relative;
			top: 50%;
			transform: translateY(-50%);
		}
		body {
		    margin-top: 20px;
		    color: #484b51;
		}
		.text-secondary-d1 {
		    color: #728299 !important;
		}
		.page-header {
		    margin: 0 0 1rem;
		    padding-bottom: 1rem;
		    padding-top: .5rem;
		    border-bottom: 1px dotted #e2e2e2;
		    display: -ms-flexbox;
		    display: flex;
		    -ms-flex-pack: justify;
		    justify-content: space-between;
		    -ms-flex-align: center;
		    align-items: center;
		}
		.page-title {
		    padding: 0;
		    margin: 0;
		    font-size: 1.75rem;
		    font-weight: 300;
		}
		.brc-default-l1 {
		    border-color: #dce9f0 !important;
		}
		.ml-n1, .mx-n1 {
		    margin-left: -.25rem !important;
		}
		.mr-n1, .mx-n1 {
		    margin-right: -.25rem !important;
		}
		.mb-4, .my-4 {
		    margin-bottom: 1.5rem !important;
		}
		hr {
		    margin-top: 1rem;
		    margin-bottom: 1rem;
		    border: 0;
		    border-top: 1px solid rgba(0, 0, 0, .1);
		}
		.text-grey-m2 {
		    color: #888a8d !important;
		}
		.text-success-m2 {
		    color: #86bd68 !important;
		}
		.font-bolder, .text-600 {
		    font-weight: 600 !important;
		}
		.text-110 {
		    font-size: 110% !important;
		}
		.text-blue {
		    color: #454648 !important;
		}
		.pb-25, .py-25 {
		    padding-bottom: .75rem !important;
		}
		.pt-25, .py-25 {
		    padding-top: .75rem !important;
		}
		.bgc-default-tp1 {
			background: #454648 !important;
			border-radius: 15px;
		}
		.bgc-default-l4, .bgc-h-default-l4:hover {
		    background-color: #454648 !important;
		}
		.page-header .page-tools {
		    -ms-flex-item-align: end;
		    align-self: flex-end;
		}
		.btn-light {
		    color: #757984;
		    background-color: #f5f6f9;
		    border-color: #dddfe4;
		}
		.w-2 {
		    width: 1rem;
		}
		.text-120 {
		    font-size: 120% !important;
		}
		.text-primary-m1 {
		    color: #4087d4 !important;
		}
		.text-danger-m1 {
		    color: #dd4949 !important;
		}
		.text-blue-m2 {
		    color: #454648 !important;
		}
		.text-150 {
		    font-size: 150% !important;
		}
		.text-60 {
		    font-size: 60% !important;
		}
		.text-grey-m1 {
		    color: #7b7d81 !important;
		}
		.align-bottom {
		    vertical-align: bottom !important;
		}
		.imgPP{
			background-size: cover !important;
			background-position: center center !important;
			padding-bottom: 100%;
			border-radius: 15px;
			width: 100%;
		}
		.desc{
			font-size: 0.8rem !important;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm">
				<div class="module">
					<div class="page-content container">
					 <div class="page-header text-blue-d2">
					    <h1 class="page-title text-secondary-d1">
					       ID: #<?php echo $invoice['id'] ?><br>
					       </small>
					    </h1>
					    <div class="page-tools">
					       <div class="action-buttons">
					          <a class="btn bg-white btn-light mx-1px text-95" onclick="window.print();" data-title="Print">
					          <i style="color: #454648 !important;" class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
					          Imprimir
					          </a>
					       </div>
					    </div>
					 </div>
					 <div class="container px-0">
					    <div class="row mt-4">
					       <div class="col-12 col-lg-12">
					          <div class="row">
					             <div class="col-12">
					                <div class="text-center text-100">
					                </div>
					             </div>
					          </div>
					          <div class="row">
					             <div class="col-sm-6">
					             	<?php 

					             	$clientId = $invoice['client_id'];
					             	$queryClient = "SELECT * FROM clients WHERE id = $clientId";
					             	$queryClientRequest = mysqli_query($conn, $queryClient);
					             	while ($clients = mysqli_fetch_array($queryClientRequest)) { $client = $clients; }

					             	?>
					                <div class="text-grey-m2">
					                	<div class="row">
					                		<div class="col-3">
					                			<div style="background: url('../assets/clients/<?php echo $client["pp"] ?>');" class="imgPP"></div>
					                		</div>
					                		<div class="col-9">
					                			<div class="align">
						                			<span class="text-600 text-110 text-blue align-middle"><?php echo $client['name'] . ' ' . $client['surname']; ?></span><br>
						                      		<?php echo $client['email']; ?><br>
						                      		<label class="desc">Vencimento: <?php echo date('Y/m/d', strtotime($invoice['due_date'])); ?></label>
					                			</div>
					                		</div>
					                	</div>
					                </div>
					             </div>
					          </div>
					          <div class="mt-5">
					             <div class="row text-600 text-white bgc-default-tp1 py-25">
					                <div class="col-3">Título</div>
					                <div class="col-9">Descrição</div>
					             </div>
					             <div class="text-95 text-secondary-d3">
					                <div class="row mb-2 mb-sm-0 py-25">
					                   <div class="col-3"><?php echo $invoice['title'] ?></div>
					                   <div class="col-9"><p><?php echo $invoice['description'] ?></p></div>
					                </div>
					             </div>
					             <div class="row border-b-2 brc-default-l2"></div>
					             <div class="row mt-5">
					                <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
					                   <!-- <img width="100px" src="https://ps.w.org/doqrcode/assets/icon-256x256.png?rev=2143781"> -->
					                </div>
					                <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
					                   <div class="row my-2 align-items-center bgc-primary-l3">
					                      <div class="col-5 text-right">
					                         Total:
					                      </div>
					                      <div style="text-align: right !important;" class="col-7">
					                         <span class="text-150 text-success-d3 opacity-2"><?php echo 'R$ ' . number_format($invoice['amount'], 2, ',', '.'); ?></span>
					                      </div>
					                   </div>
					                </div>
					             </div>
					             <hr/>
					          </div>
					       </div>
					    </div>
					 </div>
					</div>
					<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
					<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
				</div>
			</div>
		</div>
	</div>
</body>
</html>