<? if(count($produse)): ?>
	<div class="col-md-12">
		<hr />
	</div>
	<? foreach ($produse as $p): ?>
		<div class="col-md-2dot4 col-md-3 col-6 product-list">
			<? $this->load->view('magazin/produs_lista', array('produs' => $p)) ?>
		</div>
	<? endforeach ?>
<? endif ?>