<section class="page-section breadcrumbs">
    <div class="container">
        <div class="page-header">
            <h1><?= lang('raspuns_tranzactie') ?></h1>
        </div>
    </div>
</section>

<!-- PAGE WITH SIDEBAR -->
<section class="page-section with-sidebar">
    <div class="container">
        <div class="row">
        	<?php $this->load->view('utilizator/sidebar') ?>            
            <!-- CONTENT -->
            <div class="col-md-9 content" id="content">
            	<div class="row">
            		<div class="col-md-12">
						<?= $raspuns ?>
						<br />
						<br />
						Click <a href="<?= site_url() ?>"><?= lang('aici') ?></a> <?= lang('pentru_continuarea_cumparaturilor') ?>.
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
