<?php 

	// =============== VARS
	// app
	$appName = 'The Circle';
	$notifyCount = 9;
	$domain = $_SERVER['HTTP_HOST'];
	$url = isset($_GET['url']) ? $_GET['url'] : '';
	$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
	$fullUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; $urlParts = parse_url($fullUrl);
	$baseUrl = $protocol . '://' . $urlParts['host'] . dirname($urlParts['path']) . '/';
	$appLocal 			= $baseUrl;

?>

<style> body{ background: #242322 !important; } </style>

<style>
/* ===== Scrollbar CSS ===== */
* {
scrollbar-width: auto;
scrollbar-color: #878787 #414548;
}
*::-webkit-scrollbar {
width: 10px;
}
*::-webkit-scrollbar-track {
background: #414548;
}
*::-webkit-scrollbar-thumb {
background-color: #878787;
border-radius: 10px;
border: 3px solid #414548;
}
.module{
	padding: 20px !important;
	background: #56585a !important;
	border-radius: 15px !important;
	margin-bottom: 20px;
	box-shadow: 0px 0px 50px -13px rgba(0,0,0,0.1);
}
.dropdown-item{
	font-weight: 300 !important;
}
.dropdown-item:active{
	background: #454d54 !important;
}
.noButton{
	background: transparent !important;
	margin: 0px !important;
	padding: 0px !important;
	border: none !important;
}
p.v{
	position: absolute;
	left: 50%;
	transform: translateX(-50%);
	bottom: 0px;
	font-family: Poppins;
	font-size: 0.7rem;
	color: #FFFFFF20;
	cursor: default;
}
</style>

<title><?php if($notifyCount > 0){echo '('.$notifyCount.') ';} ?> <?php echo ucfirst($url) . ' | ' . $appName ?></title>

<!-- =================  favicon  ================= -->
<link rel="icon" type="image/x-icon" href="assets/favicon/0.png">
<link rel="icon" type="image/x-icon" href="../../assets/favicon/0.png">
<?php if ($notifyCount >= 1) { echo '<link rel="icon" type="image/x-icon" href="assets/favicon/1.png">'; } ?>

<!-- ================  copyright  ================ -->
<style>p.copy{ position:fixed; color: #FFFFFF10; bottom: 5; cursor: default; font-size:0.5rem; font-family:Poppins; left:50%; transform:translateX(-50%); }</style>
<p class="copy">Todos os direitos reservados à The Circle ©</p>


<?php // ======== FUNCTIONS ================== 

// ===============  ROTAS  =================== 

function route($routeName){
	$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
	$fullUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$urlParts = parse_url($fullUrl);
	$baseUrl = $protocol . '://' . $urlParts['host'] . dirname($urlParts['path']) . '';
	$appLocal = $baseUrl;
	header('Location: ' . $appLocal . '/' . $routeName);
}

function routeLink($routeName){
	$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
	$fullUrl = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$urlParts = parse_url($fullUrl);
	$baseUrl = $protocol . '://' . $urlParts['host'] . dirname($urlParts['path']) . '';
	$appLocal = $baseUrl;
	return $appLocal . '/' . $routeName;
}


// ===============  AUTH  =================== 

function planById($id, $conn) {
    $query = "SELECT plan FROM users WHERE id = '$id'"; 
    $result_query = mysqli_query($conn, $query) or die(' Erro na query:' . $query . ' ' . mysqli_error($conn) ); 
    while ($row = mysqli_fetch_array($result_query)) {
        $plan = $row[0]; 
    }

    if ($plan == 3) {
    	$plan = array("assets/icons/exclusive.png", "Plano Exclusive");
    } elseif ($plan == 2) {
    	$plan = array("assets/icons/premium.png", "Plano Premium");
    } elseif ($plan == 1) {
    	$plan = array("assets/icons/essentials.png", "Plano Essential");
    } else{
    	$plan = array("assets/icons/free.png", "Plano Gratuito");
    }

    return $plan;
}

function login($email, $password, $conn) {
	$password = hash('sha256', $password);

    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
	$result = mysqli_query($conn, $query); $user = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) === 1) {
    	session_start(); $_SESSION['id'] = $user['id']; route('painel');
    } else {
        $error = "E-mail ou senha inválidos.";
    }

}

function catchUser($id, $conn) {
	$query = "SELECT * FROM users WHERE id = '$id'";
	$result = mysqli_query($conn, $query); if ($userArray = mysqli_fetch_array($result)){$user = $userArray;};
	return $user;
}

function verifyAuth() { if (!isset($_SESSION['id'])) { route('login'); }}

?>