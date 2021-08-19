
<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('editare_utilizator') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 offset-md-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-md-7 col-sm-12">
            	<div class="row">
            		<div class="col-md-12">
            		<form action="<?= site_url('utilizator/editare_utilizator/'.$utilizator['id']) ?>" class="form-horizontal" method="post">					
						<?= isset($error)?$error:''; ?>
						<div class="outer required">
                        	<div class="form-group af-inner">
							<label class=""><?= lang('utilizator') ?></label>
							<input type="text" readonly="readonly" class="form-control" name="utilizator" value="<?= $utilizator['utilizator'] ?>">
							</div>
						</div>
						<div class="outer required">
                        	<div class="form-group af-inner">
							<label class=""><?= lang('parola') ?></label>
							<input type="password" class="form-control" name="parola" value="">
							</div>
						</div>
						<div class="outer required">
                        	<div class="form-group af-inner">
							<label class=""><?= lang('telefon') ?></label>
							<input type="text" class="form-control" name="telefon" value="<?= set_value('telefon', $utilizator['telefon']) ?>">
							</div>
						</div>
						<div class="outer required">
                        	<div class="form-group af-inner">
							<label class=""><?= lang('email') ?></label>
							<input type="text" class="form-control" name="email" value="<?= set_value('email', $utilizator['email']) ?>">
							</div>
						</div>
						<div class="outer required">
                        	<div class="form-group af-inner">
							<label class=""><?= lang('nume') ?></label>
								<input type="text" class="form-control" name="delegat" value="<?= set_value('delegat', $utilizator['delegat']) ?>">
							</div>
						</div>
						<div class="outer required">
                        	<div class="form-group af-inner">
								<button type="submit" class="btn btn-globiz btn-shadow"><?= lang('salveaza') ?></button>
							</div>
						</div>					
				</form>            			
            		</div>
                </div>
               
            </div>
            <!-- /CONTENT -->
        </div>
    </div>
</section>
<!-- /PAGE WITH SIDEBAR -->