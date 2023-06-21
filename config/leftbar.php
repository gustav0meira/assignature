<style>
	body{
		margin: 0px !important;
		background-color: #454648 !important;
		padding: 60px 50px 0px calc(18vw + 50px) !important;
		color: white !important;
		font-family: Poppins !important;
		font-weight: 300 !important;
		font-size: 0.9rem !important;
	}

	.right{
		float: right;
	}

	.left{
		float: left;
	}

	div.leftApp{
		background-color: #222325 !important;
		border-radius: 0px 15px 15px 0px;
		font-size: 0.8rem !important;
		font-weight: 300 !important;
		position: fixed;
		width: 18vw;
		z-index: 5;
		top: 0;
		left: 0;
		height: 100%;
	}

	div.leftContent{
		padding: 30px;
		font-family: Poppins !important;
		color: white;
	}

	.align{
		position: relative;
		transform: translateY(-50%);
		top: 50%;
	}

	.leftApp svg{
		font-size: 0.9rem !important;
		color: white;
	}

	div.leftLink{
		cursor: pointer;
		padding: 18px 30px 18px 30px;
		background: #454648 !important;
		border-radius: 15px;
		transition: all 300ms;
		margin-bottom: 15px;
	}

	div.leftLink:hover{
		background: #4d5159 !important;
	}

	div.leftLink label{
		cursor: pointer;
		color: white;
	}

	div.hr{
		margin-top: 20px;
		margin-bottom: 20px;
		border-top: 1px solid #FFFFFF05;
	}

	.userProfile{
		padding: 10px;
		border-radius: 15px !important;
		background-color: #4d5159 !important;
	}

	.userProfile div.pp{
		width: 100%;
		background-position: center center !important;
		background-size: cover !important;
		padding-bottom: 100%;
		border-radius: 100%;
	}

	.userProfile label{
		cursor: pointer !important;
		color: white;
	}

	.dropdown-menu,
	.dropdown-item{
		font-size: 0.8rem !important;
		font-weight: 300 !important;
	}

	.logo{
		width: 40%;
		margin-top: 10px;
		margin-bottom: 10px;
	}

</style>

<div class="leftApp">
	<div class="leftContent">

		<center>
			<a href="<?php echo routeLink('dashboard'); ?>">
				<img class="logo" src="../../assets/logo.png">
			</a>
		</center>

		<div class="hr"></div>

		<div class="dropdown dropend">
			<a href="#" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
				<div class="userProfile">
					<div class="container">
						<div class="row">
							<div style="padding-right: 10px !important;" class="col-4">
								<div style="background: url('../../assets/pp/<?php echo $user['pp']; ?>');" class="pp"></div>
							</div>
							<div class="col-sm">
								<label class="align dropdown-toggle"><?php echo ucfirst($user['username']); ?>  </label>
							</div>
						</div>
					</div>
				</div>
			</a>
			<ul class="dropdown-menu dropdown-menu-dark">
				<li><a class="dropdown-item" href="<?php echo routeLink('minha-conta'); ?>"><i class="fa-regular fa-address-card"></i>⠀⠀Minha Conta</a></li>
				<li><a class="dropdown-item" href="<?php echo routeLink('central-de-ajuda'); ?>"><i class="fa-regular fa-circle-question"></i>⠀⠀Central de Ajuda</a></li>
				<hr style="border-color: #FFFFFF95 !important; margin-top: 10px; margin-bottom: 10px;">
				<li><a class="dropdown-item" href="<?php echo routeLink('logout'); ?>"><i class="fa-solid fa-arrow-right-from-bracket"></i>⠀⠀Sair</a></li>
			</ul>
		</div>

		<div class="hr"></div>

		<a href="<?php echo routeLink('painel'); ?>">
			<div class="leftLink">
				<div class="row">
					<div class="col-3">
						<i class="fa-regular fa-paper-plane align"></i>
					</div>
					<div class="col-sm">
						<label class="align">Painel</label>
					</div>
				</div>
			</div>
		</a>

		<a href="<?php echo routeLink('financeiro'); ?>">
			<div class="leftLink">
				<div class="row">
					<div class="col-3">
						<i class="fa-solid fa-dollar align"></i>
					</div>
					<div class="col-sm">
						<label class="align">Financeiro</label>
					</div>
				</div>
			</div>
		</a>

		<a href="<?php echo routeLink('contratos'); ?>">
			<div class="leftLink">
				<div class="row">
					<div class="col-3">
						<i class="fa-regular fa-file align"></i>
					</div>
					<div class="col-sm">
						<label class="align">Projetos</label>
					</div>
				</div>
			</div>
		</a>

		<a href="<?php echo routeLink('clientes'); ?>">
			<div class="leftLink">
				<div class="row">
					<div class="col-3">
						<i class="fa-regular fa-address-card align"></i>
					</div>
					<div class="col-sm">
						<label class="align">Clientes</label>
					</div>
				</div>
			</div>
		</a>

		<a id="buttonsideAtive">
			<div class="leftLink">
				<div class="row">
					<div class="col-3">
						<i class="fa-regular fa-pen-to-square align"></i>
					</div>
					<div class="col-sm">
						<label class="align">Ferramentas</label>
					</div>
				</div>
			</div>
		</a>

	</div>
</div>

<style>
.side{
	z-index: 4 !important;
	position: fixed;
	width: 270px;
	height: 100vh;
	background: #2e2f31 !important;
	top: 0;
	left: -18vw;
	transition: left 0.6s ease;
}

.sideOpen {
  left: 17vw !important;
}

.sideContent{
	padding: 40px;
	padding-left: 55px;
	font-size: 0.8rem !important;
}

.sideLink{
	color: white;
	cursor: pointer;
	font-size: 0.7rem;
	background: #FFFFFF10;
	padding: 15px 10px 15px 10px;
	border-radius: 15px;
	margin-bottom: 15px;
	transition: all 300ms;
}

.sidelink:hover{
	background: #FFFFFF30;
}

.sideLink label,
.sideLink svg{
	cursor: pointer !important;
}

.side hr{
	border-color: #FFFFFF10 !important;
	margin: 20px 0px 20px 0px;
}

.side h5{
	font-weight: 300 !important;
	font-size: 1rem;
	color: #FFFFFF50;
}
</style>

<div class="side" id="sideAtive">
	<div class="sideContent">

		<h5>#ferramentas</h5>

		<hr>

	    <a href="<?php echo routeLink('auditoria'); ?>">
	        <div class="row sideLink">
	            <div class="col-2">
	                <i class="fa-regular fa-chart-bar align"></i>
	            </div>
	            <div class="col-sm">
	                <label>Auditoria</label>
	            </div>
	        </div>
	    </a>

	    <a href="<?php echo routeLink('usuarios'); ?>">
	        <div class="row sideLink">
	            <div class="col-2">
	                <i class="fa-regular fa-user align"></i>
	            </div>
	            <div class="col-sm">
	                <label>Usuários</label>
	            </div>
	        </div>
	    </a>

	</div>
</div>

<script>
var sideAtive = document.getElementById('sideAtive');
var buttonsideAtive = document.getElementById('buttonsideAtive');

buttonsideAtive.addEventListener('click', function() {
  sideAtive.classList.toggle('sideOpen');
});

document.addEventListener('click', function(event) {
  if (!buttonsideAtive.contains(event.target) && !sideAtive.contains(event.target)) {
    sideAtive.classList.remove('sideOpen');
  }
});
</script>

<style>
	div.topBar{
		z-index: 3;
		background-color: transparent;
		padding: 20px 60px 10px calc(18vw + 60px);
		width: 100%;
		position: absolute;
		top: 0;
		left: 0;
	}
	a.button{
		padding: 5px;
		background: #8774E1;
		color: white;
		font-weight: 300;
		font-size: 0.7rem;
		text-decoration: none;
		border-radius: 5px;
	}
	.qntNotify{
		position: relative;
		margin-top: -20px;
	}
	.dropdown-menu{
		z-index: 1 !important;
	}
	.button svg,
	.button span,
	.button{
		cursor: pointer !important;
	}
	.not-notify{
		color: #FFFFFF40;
	}
	.ntfDate{
		color: #FFFFFF20;
	}
</style>

<div class="topBar">
	<div class="container">
		<div class="row">
			<div class="col-8"></div>
			<div style="text-align: right;" class="col-4">
				<div class="dropdown">
					<a style="margin-left: 10px;" class="button align" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
					   ﾠ<i class="fa-solid fa-bell"></i> <?php echo $notifyCount; ?>ﾠ
					</a>
					<ul class="dropdown-menu dropdown-menu-dark">
					<?php
					setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
					date_default_timezone_set('America/Sao_Paulo');
					$userId = $user['id'];
					$consulta = "SELECT * FROM notifications WHERE user_id = '$userId' LIMIT 5";
					$con = $conn->query($consulta) or die($conn->error);

					if (mysqli_num_rows($con) > 0) {
					while($dado = $con->fetch_array()) { ?>
						<li><a class="dropdown-item" href="<?php echo routeLink('invoices'); ?>">
						<?php echo $dado['icon'] . ' ' . $dado['title'] ?>ﾠ<label class="ntfDate"><?php echo date('M/d | h:i A', strtotime($dado['date'])); ?></label></a>
						</li>
					<?php } } else { echo '<center>Não há notificações!</center>'; } ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>