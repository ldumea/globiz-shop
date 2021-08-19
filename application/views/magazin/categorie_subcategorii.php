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
				<? foreach($subcategorii as $s): ?>
					<? if(count($s['produse'])): ?>
						<div class="row produse">
							<div class="col-12">
								<h1><?= $s['nume'.$this->session->userdata('fieldLang')]!=''?$s['nume'.$this->session->userdata('fieldLang')]:$s['nume'] ?></h1>
								<hr class="gray"/>
							</div>
							
								<? foreach ($s['produse'] as $p): ?>
									<div class="col-md-2dot4 col-md-3 col-sm-4 col-6 product-list">
										<? $this->load->view('magazin/produs_lista', array('produs' => $p)) ?>
									</div>
								<? endforeach ?>
						</div>
						<div class="clearfix"></div>
					<? endif ?>
					<div class="clearfix"></div>
				<? endforeach ?>
			</div>
		</div>
	</div>
</section>