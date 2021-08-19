
<!-- PAGE -->
<section class="page-section color">
	<div class="container">

		<div class="row">
			<!-- CONTENT -->
			<div class="col content statice" id="content">
				<div class="row">
					<div class="col-md-6">
						<div class="contact-info">

							<div class="section-title gray text-uppercase"><span>Contact</span></div>
							<ul>
								<li><i class="fa fa-map-marker-alt"></i> Şos. Borsului nr 72, loc Sântion, jud. Bihor</li>
								<li><i class="fa fa-mobile-alt"></i> +40 359 306 158 ; +40 728 777 776</li>
								<li><i class="fa fa-envelope"></i> comenzi@globiz.ro</li>
							</ul>
							<div class="text-center program">
								<?= lang('program_de_lucru') ?>: <b><?= lang('L-V') ?>: 9:00 - 17:00</b>
							</div>

						</div>
					</div>

					<div class="col-md-6 text-left">

						<div class="section-title text-uppercase"><span>Formular de contact</span></div>

						<!-- Contact form -->
						<div id="contact-success" class="dn alert alert-success"></div>
						<div id="contact-errors"  class="dn alert alert-danger"></div>
						<form id="contact-form" name="contact-form" action="javascript:;" onsubmit="return false;" method="post">
							<div class="outer required">
								<div class="form-group">
									<label>Nume</label>
									<input type="text" name="nume" id="name"value="" size="30" class="form-control"/>
								</div>
							</div>

							<div class="outer required">
								<div class="form-group">
									<label>Email</label>
									<input type="text" name="email" id="email" value="" size="30" class="form-control placeholder"/>
								</div>
							</div>

							<div class="outer required">
								<div class="form-group">
									<label>Subiect</label>
									<input type="text" name="subiect" id="subject" value="" size="30" class="form-control placeholder"/>
								</div>
							</div>

							<div class="form-group">
								<label>Mesaj</label>
								<textarea name="mesaj" id="input-message" rows="4" cols="50" class="form-control placeholder"></textarea>
							</div>

							<div class="outer required">
								<div class="form-group">
									<input type="button" class="btn btn-dark px-5 text-uppercase fs20 d-inline-block" id="submit_btn" value="Trimite mesajul" onclick="sendContact()" />
								</div>
							</div>

						</form>
						<!-- /Contact form -->

					</div>
				</div>

			</div>
		</div>

	</div>
</section>
<!-- /PAGE -->