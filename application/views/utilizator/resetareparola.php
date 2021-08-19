 <!-- PAGE -->
<section class="page-section color">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="page-title"><div><span><?= lang('resetare_parola') ?></span></div></h1>
                <form id="form-inregistrare" action="<?= site_url('utilizator/resetareparola') ?>" method="post"class="form-login">
                    <input type="hidden" name="action" value="login">
                    <div class="row">
                        <div class="col-12 ">
							<div class="message-box mb-3">
								<?= lang('Pentru resetarea parolei va rugam sa introduceti numele de utilizator.');?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-6">
							<?= isset($error)?$error:''; ?>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group"><input class="form-control" type="text" name="utilizator" placeholder="<?= lang('utilizator') ?>"></div>
								</div>                 
								<div class="col-md-6">                            
									<input type="submit" class="btn btn-globiz" value="Resetare parola">
								</div>
							</div>
						</div>
					</div>
                </form>
            </div>
		</div>
	</div>
</section>