<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('adrese_livrare') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 offset-md-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-md-8 col-sm-12 mt-sm-10">
            	<div class="row">
            		<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-users">
								<thead>
								  <tr>
									<th><span><?= lang('adresa') ?></span></th>
									<th><span><?= lang('implicit') ?></span></th>
									<th width="210"></th>
								  </tr>
								</thead>
								<tbody>
		
								<? foreach ($adrese as $k => $al): ?>
								<tr id="al_<?= $al['id'] ?>">
									<td>
										<?if ($al['tara'] == 'RO'):?>
											<?= $tara[$al['tara']] ?>, <?= $judet[$al['judet']] ?>, <?= $al['oras'] ?>, <?= $al['adresa'] ?>
										<? else : ?>
											<?= $tara[$al['tara']] ?>, <?= $al['judet'] ?>, <?= $al['oras'] ?>, <?= $al['adresa'] ?>
										<? endif?>
		
									</td>
									<td class="text-center ">
										<input type="radio" class="ml20" name="implicit" onchange="schimba_adresa_implicita(<?= $al['id'] ?>)" value="<?= $al['id'] ?>" <? if($al['implicit']): ?>checked="checked"<? endif ?>>
									</td>
									<td>
										<a href="<?= site_url('utilizator/editare_adresa_livrare/'.$al['id']) ?>" class="btn btn-globiz btn-sm btn-shadow">
											<i class="fa fa-edit"></i> <?= lang('editare') ?> 
										</a>&nbsp;
										<a ref="javascript:void(0)" onclick="sterge_adresa_livrare(<?= $al['id'] ?>)" class="btn btn-gray btn-sm btn-shadow">
											<i class="fas fa-trash"></i> <?= lang('sterge') ?> 
										</a>
									</td>
								</tr>
								<? endforeach ?>
								</tbody>
							</table>
						</div>
					  	<a href="<?= site_url('utilizator/adauga_adresa_livrare/') ?>" class="btn btn-globiz btn-shadow fs12">
							<span class="fa fa-plus"></span> <?= lang('adauga_adresa_livrare') ?>
						</a>					  	
            		</div>
                </div>
               
            </div>
            <!-- /CONTENT -->
        </div>
    </div>
</section>
<!-- /PAGE WITH SIDEBAR -->