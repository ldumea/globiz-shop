<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('adauga_adresa_livrare') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 offset-md-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-md-8 col-sm-12 mt-sm-10">
            	<div class="row">
            		<div class="col-md-12">
                    <?= isset($error)?$error:''; ?>
            		<form action="<?= site_url('utilizator/adauga_adresa_livrare/') ?>" class="form-horizontal" method="post">
                        <div class="outer required">
                            <div class="form-group af-inner">
                            <?= form_dropdown('tara', $tara, set_value('tara', 'RO'), 'class="form-control selectpicker" id="tara" data-live-search="true" data-width="100%"  data-style="btn-select" data-toggle="tooltip" onchange="schimbat_tara()"') ?>
                            </div>
                        </div>
                        <div class="outer required">
                            <? if(set_value('tara', 'RO') == 'RO'): ?>
                                <div class="form-group af-inner" id="div_judet">
                                    <?= form_dropdown(
                                                      'judet', 
                                                       $judet, 
                                                       set_value('judet'), 
                                                      'class="form-control selectpicker" id="judet" data-live-search="true" data-width="100%" data-toggle="tooltip" data-style="btn-select" onchange="schimbat_judet()"'
                                                    ) 
                                    ?>
                                </div>
                            <? else: ?>
                                <div class="form-group af-inner">
                                    <input class="form-control" type="text" name="judet" value="<?= set_value('judet') ?>" placeholder="<?= lang('judet') ?>">
                                </div>
                            <? endif ?>
                        </div>
                        <div class="outer required">
                            <? if(set_value('tara', 'RO') == 'RO'): ?>
                                <div class="form-group af-inner" id="div_oras">
                                    <?= form_dropdown('oras', $localitati, set_value('oras'), 'class="form-control selectpicker" id="oras" data-live-search="true" data-width="100%" data-style="btn-select" data-toggle="tooltip"' ) ?></div>
                            <? else: ?>
                                <div class="form-group  af-inner">
                                    <input class="form-control" type="text" name="oras" value="<?= set_value('oras') ?>" placeholder="<?= lang('oras') ?>">
                                </div>
                            <? endif ?>
                        </div>
                        <div class="outer required">
                            <div class="form-group af-inner">
                            <input type="text" class="form-control" name="adresa" value="<?= set_value('adresa') ?>" placeholder="<?= lang('adresa') ?>">
                            </div>
                        </div>                      
                        <div class="outer required">
                            <div class="form-group af-inner">
                            <input type="text" class="form-control" name="cod_postal" value="<?= set_value('cod_postal') ?>" placeholder="<?= lang('cod_postal') ?>">
                            </div>
                        </div>
						<div class="outer required">
                        	<div class="form-group af-inner">
								<button type="submit" class="btn  btn-globiz btn-shadow"><?= lang('salveaza') ?></button>
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