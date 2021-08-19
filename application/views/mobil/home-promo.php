<section class="home-promo">
	<div class="container">
		<div class="float-left element-left">
			<div class="row box">
				<div class="col-12 text-center title">
					<img src="<?= base_url() ?>assets/images/home/<?= $folder ?>pret-bomba-mobile.png" class="img-fluid"/>
				</div>
				<div class="col-12">
					<div class="row">
					<? foreach($produse_bomba as $p): ?>
						<div class="col-6 product-list">
							<? $this->load->view('magazin/produs_lista_home', array('produs' => $p)) ?>
						</div>
					<? endforeach?>
					</div>
				</div>
			</div>
		</div>
		<div class="float-left element-right">
			<div class="row box">
				<div class="col-12 text-center title">
					<img src="<?= base_url() ?>assets/images/home/<?= $folder ?>noutati-mobile.png" class="img-fluid"/>
				</div>
				<div class="col-12">
					<div class="row">
					<? foreach($produse_noutati as $p): ?>
						<div class="col-6 product-list">
							<? $this->load->view('magazin/produs_lista_home', array('produs' => $p)) ?>
						</div>
					<? endforeach?>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</section>