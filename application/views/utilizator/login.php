<section>
	<div class="container login">
		<div class="row">
			<div class="offset-md-3 col-md-6">
				<div class="section-title gray text-uppercase"><span><?= lang('intra_in_cont') ?></span></div>
                <?= isset($error_login)?$error_login:''; ?>
				<form id="form-inregistrare" action="<?= site_url('utilizator/login') ?>" method="post"class="form-login">
				<div class="row">
                    <input type="hidden" name="action" value="login">
					<div class="col-md-12">
						<div class="form-group">
							<label><?= lang('utilizator') ?></label>
							<input class="form-control" type="text" name="utilizator">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label><?= lang('parola') ?></label>
							<input class="form-control" type="password" name="parola">
						</div>
					</div>
					<div class="col-md-12">
						<a href="<?= site_url('utilizator/resetareparola') ?>" class="orange"><?= lang('Ți-ai uitat parola?') ?></a>
					</div>
					<div class="col-md-5 mb20">
						<input type="submit" class="btn btn-dark btn-login" value="Login">
					</div>
				</div>
				</form>
			</div>
			<div class="offset-md-3 col-md-6">
				<div class="section-title text-uppercase"><span><?= lang('inregistrare') ?></span></div>
					<div class="message-box mb-3 text-center"><?= lang('text_login_page');?></div>
				<?= isset($error)?$error:''; ?>
                <form id="form-inregistrare" action="<?= site_url('utilizator/login') ?>" method="post" class="form-login">
                    <input type="hidden" name="action" value="inregistrare">
                    <div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><?= lang('nume_firma') ?></label>
								<input class="form-control" type="text" name="denumire" value="<?= set_value('denumire') ?>">
							</div>
						</div>
						<div class="col-md-6">
                            <div class="form-group">
								<label><?= lang('cod_fiscal') ?></label>
								<input class="form-control" type="text" name="cod_fiscal" value="<?= set_value('cod_fiscal') ?>">
							</div>
						</div>
						<div class="col-md-6">
                            <div class="form-group">
								<label><?= lang('nr_reg_com') ?></label>
								<input class="form-control" type="text" name="reg_com" value="<?= set_value('reg_com') ?>">
							</div>
						</div>
                        <div class="col-md-6">
                            <div class="form-group">
								<label><?= lang('Adresa sediului') ?></label>
								<input class="form-control" type="text" name="adresa" value="<?= set_value('adresa') ?>">
							</div>
						</div>
						<div class="col-md-6">
                            <div class="form-group">      
								<label><?= lang('tara') ?></label>                                                          
                                <?= form_dropdown(
                                        'tara', 
                                         $tara, 
                                         set_value('tara', 'RO'), 
                                        'class="form-control selectpicker" id="tara" data-style="btn-select" data-live-search="true" data-width="100%" data-toggle="tooltip" onchange="schimbat_tara()"'
                                    ) 
                                ?>
                            </div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><?= lang('judet') ?></label>
								<div id="div_judet">
									<? if(set_value('tara', 'RO') == 'RO'): ?>					  
										<?= form_dropdown(
														  'judet', 
														   $judet, 
														   set_value('judet'), 
														  'class="form-control selectpicker" id="judet" data-live-search="true" data-width="100%" data-style="btn-select" data-toggle="tooltip" onchange="schimbat_judet()"'
														) 
										?>
									<? else: ?>
										<input class="form-control" type="text" name="judet" value="<?= set_value('judet') ?>" placeholder="<?= lang('judet') ?>">
									<? endif ?>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label><?= lang('oras') ?></label>
								<? if(set_value('tara', 'RO') == 'RO'): ?>
									<div id="div_oras"><?= form_dropdown('oras', $localitati, set_value('oras'), 'class="form-control selectpicker" data-style="btn-select" id="oras" data-live-search="true" data-width="100%" data-toggle="tooltip"' ) ?></div>
								<? else: ?>
									<div id="div_oras"><input class="form-control" type="text" name="oras" value="<?= set_value('oras') ?>"</div>
								<? endif ?>
							</div>
						</div>
						<div class="col-md-6">
                            <div class="form-group">
								<label><?= lang('Persoana de contact') ?></label>
								<input class="form-control" type="text" name="delegat" value="<?= set_value('delegat') ?>">
							</div>
						</div>
						<div class="col-md-6">
                            <div class="form-group">
								<label><?= lang('telefon') ?></label>
								<input class="form-control" type="text" name="telefon" value="<?= set_value('telefon') ?>" placeholder="<?= lang('telefon') ?>">
							</div>
						</div>
						<div class="col-md-6">
                            <div class="form-group">
								<label><?= lang('email') ?></label>
								<input class="form-control" type="text" name="email" value="<?= set_value('email') ?>">
							</div>
						</div>
						<div class="col-md-6">
                            <div class="form-group">
								<label><?= lang('utilizator') ?></label>
								<input class="form-control" type="text" name="utilizator" value="<?= set_value('utilizator') ?>">
							</div>
						</div>
						<div class="col-md-6">
                            <div class="form-group">
								<label><?= lang('confirma_parola') ?></label>
								<input class="form-control" type="password" name="confirma_parola">
							</div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group">
								<label><?= lang('parola') ?></label>
								<input class="form-control" type="password" name="parola">
							</div>
                        </div>
					</div>
					<div class="row">
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-dark btn-login" value="<?= lang('inregistrare') ?>">
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
</section>