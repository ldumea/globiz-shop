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
							<?= meniu_stanga($id_meniu, 0, true,$id_sub_meniu, $id_parinte, $categorie['id']) ?>
						</div>
					</div>

					<? if(isset($filtre) and count($filtre)): ?>
						<? foreach ($filtre as $atribut_id => $atribut): ?>
							<div class="shop-categories filtre">
								<h4><?= $atribut['atribut'] ?></h4>
								<div>
									<? foreach ($atribut['valori'] as $valoare_id => $valoare): ?>
									<div>
										<label>
											<input type="checkbox" name="atribut[<?= $atribut_id ?>][]" value="<?= $valoare_id ?>" <? if(isset($atribute_selectare[$atribut_id]) and in_array($valoare_id, $atribute_selectare[$atribut_id])): ?>checked<? endif ?> onchange="$('#filtru_form').submit()">
											<?= $valoare ?>
										</label>
									</div>
									<? endforeach?>
								</div>
							</div>
						<? endforeach ?>
					<? endif ?>
				</form>
			</div>
			<!-- CONTENT -->
			<div class="col-lg-9 mt10  content" id="content">
				<div class="breadcrumbs">
					<h1><?= $categorie['nume'.$this->session->userdata('fieldLang')]!=''?$categorie['nume'.$this->session->userdata('fieldLang')]:$categorie['nume'] ?></h1>
				</div>
				<hr class="gray"/>
				<!-- Products grid -->
				<div class="row produse scroll">
					<? $this->load->view('magazin/categorie_pagina.php', $this->content); ?>
				</div>
				<!-- /Products grid -->
			</div>
			<!-- /CONTENT -->
		</div>
	</div>
</section>