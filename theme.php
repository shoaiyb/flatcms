<?php global $Wcms ?>

<!DOCTYPE HTML>
<html>
	<head>
		<meta charset="UTF-8">
	        <meta http-equiv="X-UA-Compatible" content="IE=edge">
	        <meta name="viewport" content="width=device-width, initial-scale=1">

                <title><?= $Wcms->get('config', 'siteTitle') ?> - <?= $Wcms->page('title') ?></title>
	        <meta name="description" content="<?= $Wcms->page('description') ?>">
	        <meta name="keywords" content="<?= $Wcms->page('keywords') ?>">

	        <meta property="og:url" content="<?= $this->url() ?>" />
	        <meta property="og:type" content="website" />
	        <meta property="og:site_name" content="<?= $Wcms->get('config', 'siteTitle') ?>" />
	        <meta property="og:title" content="<?= $Wcms->page('title') ?>" />
                <meta name="twitter:site" content="<?= $this->url() ?>" />
		<meta name="twitter:title" content="<?= $Wcms->get('config', 'siteTitle') ?> - <?= $Wcms->page('title') ?>" />
		<meta name="twitter:description" content="<?= $Wcms->page('description') ?>" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="<?= $Wcms->asset('css/main.css') ?>" />
		<?= $Wcms->css() ?>
		<noscript><link rel="stylesheet" href="<?= $Wcms->asset('css/noscript.css') ?>" /></noscript>
	</head>
	<body>
		<!-- Setting's Function -->
                  <?= $Wcms->settings() ?>
                  <?= $Wcms->alerts() ?>
		
                <!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<div class="inner">

							<!-- Logo -->
								<a href="<?= $Wcms->url() ?>" class="logo">
									<!-- <span class="symbol"><img src="images/logo.svg" alt="logo" /></span> --><span class="title"><?= $Wcms->get('config','siteTitle') ?></span>
								</a>

							<!-- Nav -->
								<nav>
									<ul>
										<li><a href="#menu">Menu</a></li>
									</ul>
								</nav>

						</div>
					</header>

				<!-- Menu -->
					<nav id="menu">
						<h2>Menu</h2>
						<ul>
							<?= $Wcms->menu() ?>
						</ul>
					</nav>

				<!-- Main -->
					<div id="main">
						<div class="inner">
							<?=wCMS::page('content')?>
				                </div>
						<div>
				                <?=wCMS::block('subside')?>
			                        </div>
					</div>

				<!-- Footer -->
					<footer id="footer">
						<div class="inner">
							<!-- <section>
								<h2>Get in touch</h2>
								<form method="post" action="https://cdn.shoaiybsysa.ga/php/contact_form/action.php">
									<div class="fields">
										<div class="field half">
											<input type="text" name="name" id="name" placeholder="Name" />
										</div>
										<div class="field half">
											<input type="email" name="email" id="email" placeholder="Email" />
										</div>
										<div class="field">
											<textarea name="message" id="message" placeholder="Message"></textarea>
										</div>
									</div>
									<ul class="actions">
										<li><input type="submit" value="Send" class="primary" /></li>
									</ul>
								</form>
							</section>
							<section>
								<h2>Follow</h2>
								<ul class="icons">
									<li><a href="#" class="icon brands style2 fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon brands style2 fa-facebook-f"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon brands style2 fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="icon brands style2 fa-dribbble"><span class="label">Dribbble</span></a></li>
									<li><a href="#" class="icon brands style2 fa-github"><span class="label">GitHub</span></a></li>
									<li><a href="#" class="icon brands style2 fa-500px"><span class="label">500px</span></a></li>
									<li><a href="#" class="icon solid style2 fa-phone"><span class="label">Phone</span></a></li>
									<li><a href="#" class="icon solid style2 fa-envelope"><span class="label">Email</span></a></li>
								</ul>
							</section> -->
							<div class="copyright">
								<?= $Wcms->footer() ?>
							</div>
						</div>
					</footer>

			</div>

		<!-- Scripts -->
			<script src="<?= $Wcms->asset('js/jquery.min.js')?>"></script>
			<script src="<?= $Wcms->asset('js/browser.min.js')?>"></script>
			<script src="<?= $Wcms->asset('js/breakpoints.min.js')?>"></script>
			<script src="<?= $Wcms->asset('js/util.js')?>"></script>
			<script src="<?= $Wcms->asset('js/main.js')?>"></script>
		        <?= $Wcms->js() ?>
		        <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
	                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</body>
</html>
