 <!-- PAGE -->
<section class="page-section color">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
				<h1 class="page-title"><div><span><?= lang('schimba_parola') ?></span></div></h1>
				<form id="form-inregistrare" action="<?= site_url('utilizator/schimbaparola/'.$str) ?>" method="post"class="form-login">
                    <input type="hidden" name="action" value="login">
                    <div class="row">
						<div class="col-md-6">
							<?= isset($error)?$error:''; ?>
							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input class="form-control" type="password" name="parola" placeholder="<?= lang('parola') ?>">
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input class="form-control" type="password" name="confirma_parola" placeholder="<?= lang('confirma_parola') ?>">
									</div>
								</div>                        
								<div class="col-md-6">                            
									<input type="submit" class="btn btn-globiz" value="<?= lang('actualizeaza') ?>">
								</div>
							</div>
						</div>
                    </div>
                </form>
            </div>
		</div>
	</div>
</section>