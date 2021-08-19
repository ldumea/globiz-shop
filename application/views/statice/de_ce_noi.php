<!-- PAGE WITH SIDEBAR -->
<section class="page-section with-sidebar">
	<div class="container">
		<div class="row">
			<!-- SIDEBAR -->
			<aside class="col-md-3 sidebar" id="sidebar">
				<!-- widget shop categories -->                
				<div class="widget shop-categories">
					<div class="widget-content">
						<ul>
							<li><a href="<?= site_url('istoric.html') ?>">Istoric</a></li>
							<li><a href="<?= site_url('beneficii.html') ?>">Beneficii</a></li>
						</ul>
					</div>
				</div>
			</aside>
			<!-- /SIDEBAR -->
			<!-- CONTENT -->
			<div class="col-md-9 content" id="content">
				<article class="post-wrap post-single">
					<div class="post-header">
						<h1 class="post-title"><?= $pagina['titlu'] ?></h1>
					</div>
					<div class="post-body">
						<?= $pagina['continut'] ?>
					</div>
				</article>
			</div>
			<!-- /CONTENT -->
		</div>
	</div>
</section>
<!-- /PAGE WITH SIDEBAR -->