<section class="home home-promo">
	<div class="container">
		<div style="display: flex">
			<div class="float-left element-left">
				<div class="row box">
					<div class="col-2 text-center">
						<div class="title">
							<img src="<?= base_url() ?>assets/images/home/<?= $folder ?>pret-bomba.png" class="img-fluid"/>
						</div>
					</div>
					<div class="col-10">
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
			<div class="float-left element-center"></div>
			<div class="float-left element-right">
				<div class="row box">
					<div class="col-10">
						<div class="row">
						<? foreach($produse_noutati as $p): ?>
							<div class="col-6 product-list">
								<? $this->load->view('magazin/produs_lista_home', array('produs' => $p)) ?>
							</div>
						<? endforeach?>
						</div>
					</div>
					<div class="col-2 text-center">
						<div class="title">
							<img src="<?= base_url() ?>assets/images/home/<?= $folder ?>noutati.png" class="img-fluid"/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</section>