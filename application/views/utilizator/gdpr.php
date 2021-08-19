<section>
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="page-title"><div><span><?= lang('Acord de prelucrare a datelor personale') ?></span></div></h1>
			</div>
		</div>
		<div class="row">
			<div class="col">
				<form action="<?= site_url('acord_gdpr') ?>" method="post">
					<div class="alert acord_gdpr">
						<p>
							In conformitate cu prevederile Regulamentului (UE) 2016/679 al Parlamentului European si al Consiliului, privind protectia persoanelor fizice cu privire la
							prelucrarea datelor cu caracter personal si libera circulatie a acestor date, Globiz Group SRL., cu sediul in Santion, judet Bihor, calea Borsului 72
							inregistrata la Registrul Comertului Bihor sub nr. J05/783/2014 intentioneaza sa administreze, sa colecteze, sa inregistreze, sa stocheze, sa utilizeze
							(impreuna "Prelucreze") datele dumneavoastra cu caracter personal, necesare executarii contractului dintre parti, in conformitate cu termenii si conditiile
							descrise mai jos, si cu respectarea dispozitiilor legale.
						</p>
						<p>
							Prelucrarea datelor va avea ca și scop activitatea de cercetare piata, reclama, marketing si publicitate.<br />
							Datele Personale pot fi accesate/prelucrate de angajatii Globiz Group SRL, in conformitate cu atributiile specifice functiei lor si cu procedurile de lucru
							interne ale Globiz Group SRL.
						</p>
						<p>
							Datele dumneavoastra vor fi pastrate de Globiz Group pentru o perioada care nu depaseste perioada necesara pentru a atinge scopurile descrise sau pentru orice
							alta durata necesara in virtutea obligatiilor legale de pastrare aplicabile societatii.
						</p>
						<p>
							Declar ca imi exprim consimtamantul in mod expres si neechivoc, pentru ca orice date cu caracter personal, sa fie prelucrate de catre Globiz Group SRL,
							In scopuri legate de furnizare de bunuri si servicii (oferte curente de produse), marketing, publicitate, in conformitate cu legislatia in vigoare si cu
							prevederile contractuale.
						</p>
						</p>
						<p>
							Am luat la cunostinta faptul ca, pe baza unei cereri scrise, datate si semnate, adresate catre Globiz Group, cu sediul in Santion, judet Bihor, calea Borsului nr 72,
							tel. 0359306158, email: janos.budai@globiz.ro, imi pot exercita, in mod gratuit, urmatoarele drepturi:<br />
							- Dreptul de acces la date - dreptul de a obtine de la Globiz Group o confirmare ca se prelucreaza sau nu date cu caracter personal ale mele<br />
							- Dreptul la rectificare - dreptul de a obtine de la Globiz Group, fara intarzieri nejustificate, rectificarea datelor cu caracter inexact care ma privesc<br />
							- Dreptul la stergerea datelor “dreptul de a fi uitat” – dreptul de a obtine din partea Globiz Group stergerea datelor cu caracter personal care ma privesc,<br />
							- Dreptul la portabilitatea datelor – dreptul de a primi datele cu caracter personal care ma privesc si pe care le-am furnizat Globiz Group, avand dreptul de a transmite aceste date unui alt operator, fara obstacole din partea Globiz Group<br />
							- Dreptul la opozitie– dreptul de a ma opune in orice moment, din motive intemeiate si legitime legate de situatia mea particulara, ca datele care ma vizeaza sa faca obiectul unei prelucrari, cu exceptia cazurilor in care exista dispozitii legale contrare.<br />
						</p>
						<p>
							Datele vor fi folosite pentru a imi furniza in scris, personal sau prin canalul de contact selectat de mine, ofertele adaptate intereselor mele
							(ex: oferte speciale, evenimente, newsletter-uri). In acest scop, procedurile analitice, inclusiv construirea de profiluri, pot fi folosite pentru a evalua interesele mele.
						</p>
						<p>
							De asemenea, accept sa fiu invitat sa particip la sondaje de opinie privind produsele si serviciile oferite de Globiz Group.
						</p>
					</div>
					<div class="text-center btn_acord_acceptat">
						<label class="fs-20">
							<input type="checkbox" onclick="schimba_afisare()" <?= set_value('acord_date')==1?'checked':'' ?> id="acord_date" name="acord_date" value="1"> Sunt de acord
						</label>
					</div>
					<div class="row <?= set_value('acord_date')==1?'':'dn' ?>" id="form_div">
						<div class="col-md-12">
							<?= isset($error)?$error:''; ?>
							<div class="outer required">
								<div class="form-group af-inner">
								<label class=""><?= lang('utilizator') ?></label>
								<input type="text" readonly="readonly" class="form-control" name="utilizator" value="<?= $utilizator['utilizator'] ?>">
								</div>
							</div>
							<div class="outer required">
								<div class="form-group af-inner">
								<label class=""><?= lang('telefon') ?></label>
								<input type="text" class="form-control" name="telefon" value="<?= set_value('telefon', $utilizator['telefon']) ?>">
								</div>
							</div>
							<div class="outer required">
								<div class="form-group af-inner">
								<label class=""><?= lang('email') ?></label>
								<input type="text" class="form-control" name="email" value="<?= set_value('email', $utilizator['email']) ?>">
								</div>
							</div>
							<div class="outer required">
								<div class="form-group af-inner">
								<label class=""><?= lang('nume') ?></label>
									<input type="text" class="form-control" name="delegat" value="<?= set_value('delegat', $utilizator['delegat']) ?>">
								</div>
							</div>
							<div class="outer required">
								<div class="form-group af-inner">
									<button type="submit" class="btn btn-globiz btn-shadow"><?= lang_new('Actualizeaza') ?></button>
								</div>
							</div>	          			
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>