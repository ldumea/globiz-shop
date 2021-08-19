<? $folder = $this->session->userdata('folderView')==''?'':$this->session->userdata('folderView').'/' ?>
<section class="background-half">
	<div class="container slider-home">
		<div class="row">
			<div class="col">
				<? $slider = $this->magazin_db->slideshow(array('magazin' => 'globiz'), array('rank' => 'asc')) ?>
				<? 
					$src = $this->config->item('media_url');
					$src.= 'slider';
				?>
				<ul class="lightSlider home_slider">
				<? foreach($slider as $k => $p): ?>
					<? $img_slider = $p['imagine'.$this->session->userdata('fieldLang')]==''?$p['imagine']:$p['imagine'.$this->session->userdata('fieldLang')]; ?>
					<li>
						<? if($p['link']!=''): ?>
							<a href="<?= $p['link'] ?>">
						<? endif ?>
								<img class="img-fluid" src="<?= $src.'/'.$img_slider ?>" alt=""/>

						<? if($p['link']!=''): ?>
							</a>
						<? endif ?>
					</li>
				<? endforeach ?>
				</ul>
			</div>
		</div>
	</div>
</section>
<? $this->load->view('home-promotii') ?>
<? if($this->agent->is_mobile()): ?>
	<? $this->load->view('mobil/home-promo') ?>
<? else: ?>
	<? $this->load->view('home-promo') ?>
<? endif ?>
<? //$this->load->view('home-promo-new') ?>
<section class="home promotia-saptamanii">
	<div class="container">
		<div class="section-title text-uppercase">
			<span><?= lang('Promotia saptamanii') ?></span>
			<div class="float-right product_scroller">
				<? /*
				<a href="javascript:;" class="product_scroller_btn_left" data-scroller="1"><i class="fas fa-chevron-left"></i></a>
				<a href="javascript:;" class="product_scroller_btn_right" data-scroller="1"><i class="fas fa-chevron-right"></i></a>
				*/ ?>
			</div>
		</div>
		<div class="row ">
		<? foreach ($produse_promo as $key => $p): ?>
			<div class="col-lg-2 col-md-4 col-6 product-list">
				<? $this->load->view('magazin/produs_lista_home', array('produs' => $p)) ?>
			</div>
		<? endforeach ?>
		</div>
	</div>
</section>
<section class="home promotia-saptamanii">
	<div class="container">
		<div class="section-title text-uppercase">
			<span><?= lang('prod_recomand') ?></span>
			<div class="float-right product_scroller">
				<? /*
				<a href="javascript:;" class="product_scroller_btn_left" data-scroller="1"><i class="fas fa-chevron-left"></i></a>
				<a href="javascript:;" class="product_scroller_btn_right" data-scroller="1"><i class="fas fa-chevron-right"></i></a>
				*/ ?>
			</div>
		</div>
		<div class="row ">
		<? foreach ($produse_recomandate as $key => $p): ?>
			<div class="col-lg-2 col-md-4 col-6 product-list">
				<? $this->load->view('magazin/produs_lista_home', array('produs' => $p)) ?>
			</div>
		<? endforeach ?>
		</div>
	</div>
</section>
<section class="home promotia-saptamanii">
	<div class="container">
		<div class="section-title text-uppercase">
			<span><?= lang('lichidari') ?></span>
			<div class="float-right product_scroller">
				<? /*
				<a href="javascript:;" class="product_scroller_btn_left" data-scroller="1"><i class="fas fa-chevron-left"></i></a>
				<a href="javascript:;" class="product_scroller_btn_right" data-scroller="1"><i class="fas fa-chevron-right"></i></a>
				*/ ?>
			</div>
		</div>
		<div class="row ">
		<? foreach ($produse_lichidari as $key => $p): ?>
			<div class="col-lg-2 col-md-4 col-6 product-list">
				<? $this->load->view('magazin/produs_lista_home', array('produs' => $p)) ?>
			</div>
		<? endforeach ?>
		</div>
	</div>
</section>