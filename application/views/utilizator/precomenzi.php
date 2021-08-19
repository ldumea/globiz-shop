<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('precomenzi') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3 col-sm-12 offset-md-1">
				<? $this->load->view('utilizator/sidebar') ?>
			</div>
			<div class="col-md-8 col-sm-12 mt-sm-10">
				<div class="table-responsive">
					<table class="table table-users">
						<thead>
							<tr>
								<th><span><?= lang('poza') ?></span></th>
								<th><span><?= lang('produs') ?></span></th>
								<th><span><?= lang('cantitate') ?></span></th>
								<th><span><?= lang('data') ?></span></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<? foreach ($precomenzi as $p): ?>
							<tr id="p_<?= $p['id'] ?>">
								<td class="text-center">
									<a href="<?= produs_url($p['produs']) ?>">
										<? if(isset($p['produs']['imagine']['imagine']) and ($p['produs']['imagine']['imagine']!='')): ?>
											<? $src = $this->config->item('media_url') ?>
											<? $src.='articole/'.$p['produs']['imagine']['imagine'] ?>
											<img width="40" height="40" alt="" src="<?= $this->config->item('static_url').'50/50/'.$p['produs']['imagine']['imagine'] ?>" typeof="foaf:Image">
										<? endif ?>
									</a>
								</td>
								<td class="text-center">
									<a href="<?= produs_url($p['produs']) ?>">
										<?= $p['produs']['denumire'] ?>
									</a>
								</td>
								<td class="text-center"><?= $p['cantitate'] ?></td>
								<td class="text-center"><span class="ml20"><?= date('d/m/Y', strtotime($p['data'])) ?></span></td>
								<td>
									<a onclick="stergePrecomanda(<?= $p['id'] ?>)" href="javascript:void(0)" class="btn btn-color btn-icon btn-sm btn-shadow"><i class="fas fa-times"></i></a>
								</td>
							</tr>
							<? endforeach ?>	
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>