<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('garantii') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 offset-md-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-md-8 col-sm-12 mt-sm-10">
                <div class="row">
                    <div class="col-md-12">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-md-3 control-label"><?= lang('stare') ?></label>
								<p class="col-md-8 form-control-static">
									<? switch ($garantie['stare']) {
										case '2':
											$class_stare = 'label-warning';
											break;
										case '3':
											$class_stare = 'label-warning';
											break;
										case '4':
											$class_stare = 'label-warning';
											break;
										case '5':
											$class_stare = 'label-danger';
											break;
										case '6':
											$class_stare = 'label-success';
											break;
										default:
											$class_stare = 'label-primary';
											break;
									} ?>
									<? $stare = $stare_garantie[$garantie['stare']]; ?>
									<span class="label <?= $class_stare ?> "><?= $stare ?></span>
								</p>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><?= lang('data') ?></label>
								<p class="col-md-8 form-control-static"><?= date('d/m/Y', strtotime($garantie['data'])) ?></p>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><?= lang('codprodus') ?></label>
								<p class="col-md-8 form-control-static"><?= $garantie['cod_produs'] ?></p>
							</div>
							<? if($garantie['produs_id']): ?>
							<div class="form-group">
								<label class="col-md-3 control-label"><?= lang('produs') ?></label>
								<p class="col-md-8 form-control-static"><?= $garantie['produs']['denumire'] ?></p>
							</div>
							<? endif ?>
							<div class="form-group">
								<label class="col-md-3 control-label"><?= lang('bon_fiscal') ?></label>
								<p class="col-md-8 form-control-static">
									<? $src = $this->config->item('media_url').'garantii/'. $garantie['bon_fiscal'] ?>
									<a href="<?= $src ?>" target="_blank">
										<img src="<?= $this->config->item('timthumb_url').'?src='.$src.'&h=150' ?>" />
									</a>
								</p>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><?= lang('certificat_de_garantie') ?></label>
								<p class="col-md-8 form-control-static">
									<? $src = $this->config->item('media_url').'garantii/'. $garantie['certificat'] ?>
									<a href="<?= $src ?>" target="_blank">
										<img src="<?=$this->config->item('timthumb_url').'?src='.$src.'&h=150' ?>" />
									</a>
								</p>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label"><?= lang('observatie') ?></label>
								<p class="col-md-8 form-control-static"><?= nl2br($garantie['observatie']) ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
