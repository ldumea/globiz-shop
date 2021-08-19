<? if(count($produse)): ?>

	<? foreach ($produse as $p): ?>
		<div class="col-md-2dot4 col-md-3 col-sm-4 col-6 product-list">
			<? $this->load->view('magazin/produs_lista', array('produs' => $p)) ?>
		</div>
	<? endforeach ?>
	<div class="clearfix"></div>
	<div class="pagination">
		<a class="pagination__next" href="<?= site_url('carguard/categorie_pagina/'.$categorie['id'].'/'.$pagina)."?".$_SERVER['QUERY_STRING'] ?>"><?= lang('urmatorul') ?></a>
	</div>
<? endif ?>