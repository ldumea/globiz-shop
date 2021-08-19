<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><img src="<?= site_url() ?>assets/images/info.png" class="align-middle"/> <?= lang('informatii') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 offset-md-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-md-7 col-sm-12">
				<div class="row informatii">
					<div class="col-lg-6 col-md-12 tert">
						<div class="section-title gray text-uppercase">
							<span><?= lang('informatii') ?></span>
						</div>
						<div class="info">
							<span><?= lang('nume_firma') ?>:</span>
							<div><?= $utilizator['denumire'] ?></div>
						</div>
						<div class="info">
							<span><?= lang('cod_fiscal') ?>:</span>
							<div><?= $utilizator['cod_fiscal'] ?></div>
						</div>
						<div class="info">
							<span><?= lang('nr_reg_com') ?>:</span>
							<div><?= $utilizator['reg_com'] ?></div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="info">
									<span><?= lang('tara') ?>:</span>
									<div><?= $utilizator['tara'] ?></div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="info">
									<span><?= lang('judet') ?>:</span>
									<div><?= $utilizator['judet'] ?></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="info">
									<span><?= lang('oras') ?>:</span>
									<div><?= $utilizator['oras'] ?></div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="info">
									<span><?= lang('cod_postal') ?>:</span>
									<div><?= $utilizator['cod_postal'] ?></div>
								</div>
							</div>
						</div>
						<div class="info">
							<span><?= lang('adresa') ?>:</span>
							<div><?= $utilizator['adresa'] ?></div>
						</div>
					</div>
					<div class="col-lg-6 col-md-12 agent">
						<div class="section-title text-uppercase">
							<span><?= lang('agentul_tau') ?></span>
						</div>
						<div class="text-right">
							
							<div class="image">
								<? if($agent['poza']!=''): ?>
									<? $src = $this->config->item('media_url') ?>
									<? $src.= 'agenti/' ?>
									<? $src.= $agent['poza'] ?>
									<img src="<?= $this->config->item('timthumb_url').'?src='.$src.'&w=198&h=198&zc=2' ?>"  />
								<? else: ?>
									<span style="height: 198px; padding-top: 25px;width: 198px; display: inline-block; vertical-align: top; text-align: center">
										<i class="fa fa-user" style="font-size: 120px;"></i>
									</span>
								<? endif ?>
							</div>
							<div class="clearfix"></div>
							<div class="agent-info">
								<span><?= lang('nume') ?>:</span>
								<div><?= $agent['last_name'] ?> <?= $agent['first_name'] ?></div>
							</div>
							<? if($agent['telefon']!=''): ?>
							<div class="agent-info">
								<span><?= lang('telefon') ?>:</span>
								<div><?= $agent['telefon'] ?></div>
							</div>
							<? endif ?>
							<? if($agent['email']!=''): ?>
							<div class="agent-info">
								<span><?= lang('email') ?>:</span>
								<div><?= $agent['email'] ?></div>
							</div>
							<? endif ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>