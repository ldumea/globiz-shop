<section>
	<div class="container">
		<div class="row categorie">
			<div class="col-lg-3 sidebar">
				<form action="<?= current_url() ?>" method="get" id="filtru_form">
				
					<!-- widget shop categories -->
					<? !isset($id_meniu)?$id_meniu = categorie_parinte():'' ?>
					<div class="shop-categories">
						<div class="title"><?= lang('categorii') ?></div>
						<div class="content">
							<?= meniu_stanga($id_meniu, 0, false,0, 0) ?>
						</div>
					</div>
				</form>
			</div>
			<!-- CONTENT -->
			<div class="col-lg-9 mt10  content" id="content">
				<div class="breadcrumbs">
					<h1><?= lang('cauta_re') ?></h1>
				</div>
				<!-- Products grid -->
				<div class="row produse scroll">
					<? $this->load->view('magazin/cautare_pagina.php', $this->content); ?>
				</div>
				<!-- /Products grid -->
			</div>
			<!-- /CONTENT -->
		</div>
	</div>
</section>