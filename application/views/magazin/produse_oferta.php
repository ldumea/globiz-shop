<section>
	<div class="container">
		<div class="row categorie">
			<div class="col-md-3 sidebar">
				<form action="<?= current_url() ?>" method="get" id="filtru_form">
				
					<!-- widget shop categories -->
					<? !isset($id_meniu)?$id_meniu = categorie_parinte():'' ?>
					<div class="shop-categories">
						<div class="title"><?= lang('categorii') ?></div>
						<div class="content">
							<?= meniu_stanga($id_meniu, 0, true,0, 0) ?>
						</div>
					</div>
				</form>
			</div>
			<!-- CONTENT -->
			<div class="col-md-9 mt10  content" id="content">
				<div class="breadcrumbs">
					<h1><?= $titlu ?></h1>
				</div>
				<? if(is_array($banner) and count($banner) and ($banner['imagine']!='')): ?>
					<div class="row products">
						<div class="media col-md-12">
							 <img width="870" height="350" class="p-b-10 img-responsive" alt="<?= $titlu ?>" src="<?= $this->config->item('media_url').'bannere/'.$banner['imagine'] ?>">
						</div>
					</div>
				<? endif ?>
				<hr class="gray"/>
				<!-- Products grid -->
				<div class="row produse scroll">
					<? $this->load->view('magazin/produse_oferta_pagina.php', $this->content); ?>
				</div>
				<!-- /Products grid -->
			</div>
			<!-- /CONTENT -->
		</div>
	</div>
</section>