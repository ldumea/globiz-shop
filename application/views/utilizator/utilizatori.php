<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('utilizatori') ?></span></div></h1>
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
									<th><span><?= lang('utilizator') ?></span></th>
									<th><span><?= lang('email') ?></span></th>
									<th><span><?= lang('nume') ?></span></th>
									<th></th>
								  </tr>
								</thead>
								<tbody>
								<? foreach ($utilizatori as $k => $u): ?>
								<tr id="u_<?= $u['id'] ?>">
									<td class="text-center">
										<?= $u['utilizator'] ?>
									</td>
									<td>
										<?= $u['email'] ?>
									</td>
									<td>
										<span class="ml20"><?= $u['delegat'] ?></span>
									</td>
									<td>
										<a href="<?= site_url('utilizator/editare_utilizator/'.$u['id']) ?>" class="btn btn-globiz btn-sm btn-shadow">
											<i class="fa fa-edit"></i> <?= lang('editare') ?>
										</a>
										<? if($u['id'] != $this->session->userdata['id']): ?>
										&nbsp;
										<a href="javascript:void(0)" onclick="sterge_utilizator(<?= $u['id'] ?>)" class="btn btn-gray btn-sm btn-shadow">
											<i class="fas fa-trash"></i> <?= lang('sterge') ?>
										</a>								
										<? endif ?>
									</td>
								</tr>
								<? endforeach ?>
								</tbody>
							</table>
						</div>
					  	<a href="<?= site_url('utilizator/adauga_utilizator/') ?>" class="btn btn-globiz btn-shadow fs12">
							<span class="fa fa-plus "></span> <?= lang('adauga_utilizator') ?>
						</a>
            		</div>
                </div>
               
            </div>
            <!-- /CONTENT -->
        </div>
    </div>
</section>
<!-- /PAGE WITH SIDEBAR -->