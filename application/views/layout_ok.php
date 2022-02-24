<!doctype html>
<html lang="ro">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VXT8RXF8RK"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VXT8RXF8RK');
</script>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<meta name="description" content="">
	<title><? if(isset($title) and ($title!='')): ?><?= $title ?><? else: ?>Globiz<? endif ?></title>

	<link href="<?= base_url() ?>assets/plugins/bootstrap/dist/css/bootstrap.css" rel="stylesheet"/>
	
	<link href="<?= base_url() ?>assets/plugins/fontawesome/css/all.css" rel="stylesheet" crossorigin="anonymous" />
	<link href="<?= base_url() ?>assets/plugins/line-awesome/css/line-awesome.css" rel="stylesheet" crossorigin="anonymous" />
	
	<link href="<?= base_url() ?>assets/fonts/stylesheet.css" rel="stylesheet" crossorigin="anonymous" />
	
	<!--<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">-->
	
	<link href="<?= base_url() ?>assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" crossorigin="anonymous" />
	<link href="<?= base_url() ?>assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.css" rel="stylesheet" crossorigin="anonymous" />
	<link href="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" crossorigin="anonymous" />
	<link href="<?= base_url() ?>assets/css/globiz.css?v=<?= $this->config->item('css_js') ?>" rel="stylesheet" crossorigin="anonymous" />
	<? if (isset($css) and count($css)): ?>
		<? foreach ($css as $c): ?>
			<link rel="stylesheet" href="<?= $c ?>" type="text/css"/>
		<? endforeach; ?>
	<? endif; ?>
</head>
<body class="<? if(!$this->session->userdata('loggedFrontend')): ?>not-connect<? endif ?> <?  if($this->input->cookie('globiz_ms_cookie')!=1): ?>afisare-ms-cookie<? endif ?>">
	<?
	if($this->session->userdata('loggedFrontend')){
		if($this->session->userdata('gdpr') != '1'){
			$className = $this->router->fetch_class();
			$methodName = $this->router->fetch_method();
			if(!(($className == 'utilizator') and ($methodName =='gdpr'))){
				redirect('acord_gdpr');
			}
		}
	}
	?>
    <header class="site-header sticky-top">
		<div class="display-mobile"><? $this->load->view('mobil/header') ?></div>
		<div class="display-desktop"><? $this->load->view('header') ?></div>
	<?/* if($this->agent->is_mobile()): ?>
		<? $this->load->view('mobil/header') ?>
	<? else: ?>
		<? $this->load->view('header') ?>
	<? endif */?>
		<? /*
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<div class="container">
				<a class="navbar-brand" href="#">Carousel</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarCollapse">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item active">
							<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#">Link</a>
						</li>
						<li class="nav-item">
							<a class="nav-link disabled" href="#">Disabled</a>
						</li>
					</ul>
					<form class="form-inline mt-2 mt-md-0">
						<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
					</form>
				</div>
			</div>
		</nav>
		*/ ?>
	</header>

	<main role="main">
	<!-- FOOTER -->
		<? if(isset($content)):?>
		<?= $content ?>
		<? endif ?>
	</main>
	
	<? $this->load->view('footer') ?>
	<div id="to-top" class="to-top"><i class="fa fa-angle-up"></i></div>
	
	<div id="dialog" title="Download complete"></div>
	<div class="modal dialog" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
				
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Inchide</button>
				</div>
			</div>
		</div>
	</div>
	<div class="spinner dn">
		<div class="rect1"></div>
		<div class="rect2"></div>
		<div class="rect3"></div>
		<div class="rect4"></div>
		<div class="rect5"></div>
	</div>

	
  <div class="cookie">
        <div class="container">
            <div class="text-center">
            <p><?= lang('globiz.ro utilizeaza cookie-uri') ?><br/>
               <?= lang('Prin continuarea navigarii sunteti de acord cu utilizarea lor. Pentru mai multe informatii va rugam sa cititi') ?> <a href="<?= site_url('cookie.html') ?>"><?= lang('Politica privind cookie-urile') ?></a></p>
            </div>
            <div class="text-center big-buttons-group">
                <a href="javascript:;" onclick="inchide_ms_cookie('acord')" class="btn" style="color: #fff;"><?= lang('Sunt de acord') ?></a>
                <a href="javascript:;" onclick="inchide_ms_cookie('fara_acord')" class="btn btn-transparent"><?= lang('Nu sunt de acord') ?></a>
            </div>
        </div>
    </div>
    <? endif ?>


	<? /*
	<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
	*/ ?>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"  crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap/dist/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap-select/dist/js/bootstrap-select.min.js" crossorigin="anonymous"></script>
	<script src="<?= base_url() ?>assets/plugins/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.js" crossorigin="anonymous"></script>
	<script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js" crossorigin="anonymous"></script>
	<script src="<?= base_url() ?>assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" crossorigin="anonymous"></script>
	<script src="<?= base_url() ?>assets/plugins/jquery.blockUI.js" crossorigin="anonymous"></script>
	<script src="<?= base_url() ?>assets/plugins/lazyload/lazyload.min.js" crossorigin="anonymous"></script>
    <script src="<?= base_url() ?>assets/scripts/general.js?v=<?= $this->config->item('css_js') ?>"></script>
	
	<script>
		var site_url = '<?= site_url() ?>';
		var produse_adauga_cos = '<?= lang('produse_adauga_cos') ?>';
		var js_inchide = '<?= lang('js_inchide') ?>';
	</script>
	
	<? if (isset($javascript) and count($javascript)): ?>
		<? foreach ($javascript as $js): ?>
			<script type="text/javascript" src="<?= $js ?>"></script>
		<? endforeach; ?>
	<? endif; ?>
	<? if(($this->config->item('chat')==1)): ?>
		<!--Start of Tawk.to Script-->
		<script type="text/javascript">
		var $_Tawk_API={},$_Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/55ffd8b0152481263b2faa5d/default';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
		})();
		</script>
		<!--End of Tawk.to Script-->
	<? endif ?>
	<!-- Cookies
	<?
		if(in_array($_SERVER['REMOTE_ADDR'], array('86.125.35.128'))){
			if (isset($_SERVER['HTTP_COOKIE'])) {
				$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
				foreach($cookies as $cookie) {
					$parts = explode('=', $cookie);
					$name = trim($parts[0]);
					print_R($name);
					echo "\n";
				}
			}
		}
	?>
	-->
</body>
</html>
