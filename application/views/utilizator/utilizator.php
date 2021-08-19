<h1 id="page-title"><?= lang('informatii') ?></h1>
<hr class="orange" />
<br />
<div class="register">
	<div class="form">
		<?= form_open('utilizator') ?>
		<?= isset($error)?$error:''; ?>
		<? /*
		<!-- <div class="form-item">
			<label for="utilizator">
				Nume utilizator
			</label>
			<input type="text" readonly="readonly" value="<?= set_value('utilizator', $utilizator['utilizator']) ?>" name="utilizator" id="utilizator" size="60" class="form-text" />
		</div>
		<div class="form-item">
			<label for="email">
				Adresa e-mail<span title="<?= lang('acest_camp_este_obligatoriu') ?>" class="form-required">*</span>
			</label>
			<input type="text" value="<?= set_value('email', $utilizator['email']) ?>" name="email" id="email" size="60" class="form-text" />
		</div>
		<div class="form-item">
			<label for="parola">
				Parolă
			</label>
			<input type="password" value="" name="parola" id="parola" size="60" class="form-text" />
		</div> -->
		*/ ?>
		<div class="form-item">
			<label for="denumire">
				<?= lang('nume_firma') ?><span title="<?= lang('acest_camp_este_obligatoriu') ?>" class="form-required">*</span>
			</label>
			<input type="text" value="<?= set_value('denumire', $utilizator['denumire']) ?>" name="denumire" id="denumire" size="60" class="form-text" />
		</div>
		<div class="form-item">
			<label for="cod_fiscal">
				<?= lang('cod_fiscal') ?><span title="<?= lang('acest_camp_este_obligatoriu') ?>" class="form-required">*</span>
			</label>
			<input type="text" value="<?= set_value('cod_fiscal', $utilizator['cod_fiscal']) ?>" name="cod_fiscal" id="cod_fiscal" size="60" class="form-text" />
		</div>
		<div class="form-item">
			<label for="reg_com">
				<?= lang('nr_reg_com') ?><span title="<?= lang('acest_camp_este_obligatoriu') ?>" class="form-required">*</span>
			</label>
			<input type="text" value="<?= set_value('reg_com', $utilizator['reg_com']) ?>" name="reg_com" id="reg_com" size="60" class="form-text" />
		</div>
		<div class="form-item">
			<label for="adresa">
				<?= lang('adresa') ?><span title="<?= lang('acest_camp_este_obligatoriu') ?>" class="form-required">*</span>
			</label>
			<input type="text" value="<?= set_value('adresa', $utilizator['adresa']) ?>" name="adresa" id="adresa" size="60" class="form-text" />
		</div>
		<div class="form-item">
			<label for="adresa">
				<?= lang('oras') ?><span title="<?= lang('acest_camp_este_obligatoriu') ?>" class="form-required">*</span>
			</label>
			<input type="text" value="<?= set_value('oras', $utilizator['oras']) ?>" name="oras" id="oras" size="60" class="form-text" />
		</div>
		<div class="form-item">
			<label for="adresa">
				<?= lang('cod_postal') ?>
			</label>
			<input type="text" value="<?= set_value('cod_postal', $utilizator['cod_postal']) ?>" name="cod_postal" id="cod_postal" size="60" class="form-text" />
		</div>
		<div class="form-item">
			<label for="judet">
				<?= lang('judet') ?><span title="<?= lang('acest_camp_este_obligatoriu') ?>" class="form-required">*</span>
			</label>
			<?= form_dropdown('judet', $judet, set_value('judet', $utilizator['judet']), 'class="form-control"') ?>
		</div>
		<!-- <div class="form-item">
			<label for="telefon">
				Telefon<span title="<?= lang('acest_camp_este_obligatoriu') ?>" class="form-required">*</span>
			</label>
			<input type="text" value="<?= set_value('telefon', $utilizator['telefon']) ?>" name="telefon" id="telefon" size="60" class="form-text" />
		</div> -->
		<div class="form-item">
			<button class="button">
				<?= lang('actualizeaza') ?>
			</button>
		</div>
		<?= form_close() ?>
	</div>
</div>
<? if(count($agent)): ?>
<h2 id="page-title"><?= lang('agentul_tau') ?></h2>
<hr class="orange" />
<br />
<div class="agent">
	<? if($agent['poza']!=''): ?>
		<div class="float-lt img">
			<? $src = $this->config->item('media_url') ?>
			<? $src.= 'agenti/' ?>
			<? $src.= $agent['poza'] ?>
			<img class="etalage_thumb_image" src="<?= $this->config->item('timthumb_url').'?src='.$src.'&w=220&zc=2' ?>"  />
		</div>
	<? endif ?>
	<div class="float-lt">
		<?= lang('nume') ?>: <strong><?= $agent['last_name'] ?> <?= $agent['first_name'] ?></strong><br />
		<br />
		<? if($agent['telefon']!=''): ?>
			<?= lang('telefon') ?>: <strong><?= $agent['telefon'] ?></strong><br />
			<br />
		<? endif ?>
		<? if($agent['email']!=''): ?>
			<?= lang('email') ?>: <strong><?= $agent['email'] ?></strong><br />
			<br />
		<? endif ?>
	</div>
</div>
<? endif ?>