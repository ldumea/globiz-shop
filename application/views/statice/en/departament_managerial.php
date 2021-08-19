<!-- PAGE WITH SIDEBAR -->
<section class="page-section with-sidebar">
	<div class="container">
		<div class="row">
			<?php $this->load->view('statice/sidebar_contact') ?>
			<!-- CONTENT -->
			<div class="col-md-9 content statice" id="content">
				<article class="post-wrap post-single">
					<div class="post-header">
						<h1 class="post-title"><small>management</small> Department</h1>
					</div>
					<div class="post-body">
						<div class="row">
							<div class="col-md-2 col-xs-2 image">
								<img class="img-circle img-responsive" src="<?= base_url().THEMESFOLDER ?>images/contact/iosif.png" />
							</div>
							<div class="col-md-10 col-xs-10 info">
								<div>
									<h4>IOSIF BUDAI</h4>
									C.E.O.
								</div>
								<? /*
								<div>
									<i class="pull-left fa fa-phone"></i>
									<div>
										+40 728 777 777
									</div>
								</div>
								*/ ?>
								<div>
									<i class="pull-left fa fa-envelope"></i>
									<div>
										iosif.budai@carguard.ro
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-2 col-xs-2 image">
								<img class="img-circle img-responsive" src="<?= base_url().THEMESFOLDER ?>images/contact/janos.png" />
							</div>
							<div class="col-md-10 col-xs-10 info">
								<div>
									<h4>JANOS BUDAI</h4>
									ACQUISITIONS MANAGER
								</div>
								<div>
									<i class="pull-left fa fa-phone"></i>
									<div>
										+40 728 777 776
									</div>
								</div>
								<div>
									<i class="pull-left fa fa-envelope"></i>
									<div>
										janos.budai@carguard.ro
									</div>
								</div>
							</div>
						</div>

					</div>
				</article>
			</div>
			<!-- /CONTENT -->
		</div>
	</div>
</section>
<!-- /PAGE WITH SIDEBAR -->