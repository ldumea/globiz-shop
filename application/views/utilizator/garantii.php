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
						<a class="btn btn-globiz btn-shadow fs-11" href="<?= site_url('utilizator/adauga_garantie') ?>">
							<span class="fa fa-plus"></span> <?= lang('adauga_garantie') ?>
						</a>
						<br />&nbsp;
					</div>
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-users">
								<thead>
									<tr>
										<th class="input-xsmall">
											<span>#</span>
										</th>
										<th>
											<span><?= lang('data') ?></span>
										</th>
										<th width="190">
											<span><?= lang('stare') ?></span>
										</th>
										<th width="190">
											
										</th>
									</tr>
								</thead>
								<? foreach ($garantii as $g): ?>
								<tr>
									<td>
										<a href="<?= site_url('utilizator/garantie/'.$g['id']) ?>">
											<?= $g['id'] ?>
										</a>
									</td>
									<td><?= date('d/m/Y', strtotime($g['data'])) ?></td>
									<td>
										<?
										switch ($g['stare']) {
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
										}
										?>
										<? $stare = $stare_garantie[$g['stare']]; ?>
										<span class="label <?= $class_stare ?>"><?= $stare ?></span>
									</td>
									<td>
										<a href="<?= site_url('utilizator/garantie/'.$g['id']) ?>" class="btn btn-globiz btn-sm btn-shadow">
											<i class="fa fa-edit"></i>&nbsp;<?= lang('vizualizare') ?> 
										</a>
									</td>
								</tr>
								<? endforeach ?>
							</table>
						</div>
						<div class="dataTables_paginate paging_bootstrap_full_number">
							<?= $pages ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>