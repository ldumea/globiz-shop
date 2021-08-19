<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('feeduri') ?></span></div></h1>
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
							<div class="media-list">
								<div class="media">
									<div class="media-body">
										<strong>XML:</strong><br>
										<?= site_url('feed/xml/'.$this->session->userdata('tert_id').'/'.$tert['feed_hash']) ?>
									</div>
								</div>
								<div class="media">
									<div class="media-body">
										<strong>CSV:</strong><br>
										<?= site_url('feed/csv/'.$this->session->userdata('tert_id').'/'.$tert['feed_hash']) ?>
									</div>
								</div>		                    
							</div>
						</div>
                    </div>                    
                </div>
               
            </div>
            <!-- /CONTENT -->
        </div>
    </div>
</section>
<!-- /PAGE WITH SIDEBAR -->