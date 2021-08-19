<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?= $newsletter['titlu'] ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	</head>
	<body>
		<table width="800" cellspacing="0" cellpadding="0" border="0" align="center" style="font-family:Arial,Helvetica,sans-serif; width: 800px; border:#d6d6d6 solid 1px;">
			<? if($newsletter['imagine_top']!=''): ?>
			<tr>
				<td>
					<img src="<?= $this->config->item('media_url').'newsletter/'.$newsletter['imagine_top'] ?>" align="left" style="max-width: 100%">
				</td>
			</tr>
			<? endif ?>
			<? if($newsletter['text_top']!=''): ?>
			<tr>
				<td>
					<?= $newsletter['text_top'] ?>
				</td>
			</tr>
			<? endif ?>
			<tr>
				<? $rand_nou = 1 ?>
				<? $nr = 1; ?>
				<td style="max-width:780px;width:100%;padding:10px 5px 10px 10px;">
					
					<? foreach($articole as $a): ?>
						<? $pret_mare = 0 ?>
						<? $pret_mic = 0 ?>
						<? if($this->config->item('blackfriday')): ?>
							<? if($a['articol']['pret_intreg']>$a['articol']['pret_vanzare']): ?>
								<? $pret_mare = $a['articol']['pret_intreg'] ?>
							<? else: ?>
								<? $pret_mare = $a['articol']['pret_vanzare'] ?>
							<? endif ?>
							<? $pret_mic = $a['articol']['pret_vanzare']-($a['articol']['pret_vanzare']*$a['articol']['maxDiscount'])/100 ?>
						<? else: ?>
							<? if( ($a['articol']['pret_intreg']!=0) and ($a['articol']['pret_intreg']>$a['articol']['pret_vanzare']) ): ?>
								<? $pret_mare = $a['articol']['pret_intreg'] ?>
							<? endif ?>
							<? $pret_mic = $a['articol']['pret_vanzare'] ?>
						<? endif ?>


						<? if($rand_nou): ?>
						<table cellspacing="0" cellpadding="0" border="0" width="780">
							<tr>
							<? $rand_nou = 0 ?>
						<? endif ?>
						<?switch($a['tip']){
							case '3': ?>
								<td style="border-bottom:none;border-top:#d6d6d6 solid 1px;padding-right:15px;padding-top:20px;padding-bottom:20px" align="left" width="240" valign="top">
									<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
										<tbody>
											<tr>
												<td align="right">
													<span style="background: #EE5723; color: #fff; padding: 5px 20px 5px 40px; display: inline-block;text-align: right; font-weight: bold; margin-bottom: 10px; font-size: 16px;">
														<?= $a['articol']['cod'] ?>
													</span>
												</td>
											</tr>
											<tr>
												<td align="center">
													<? $src = $this->config->item('static_url').'230/230/'.$a['imagine'] ?>
													<a target="_blank" href="<?= produs_url($a['articol']) ?>">
														<img src="<?= $src ?>" />
													</a>
												</td>
											</tr>
											<tr>
												<td style="padding-bottom: 10px; height: 28px; overflow: hidden;display: block; text-align: center;">
													<a target="_blank" href="<?= produs_url($a['articol']) ?>" style="color: #000; font-weight: bold; text-decoration: none;">
														<?= $a['articol']['denumire'] ?>
													</a>
												</td>
											</tr>
											<tr>
												<td style="text-align: center">
													<? if(count($a['articol']['discount'])): ?>
														<? if($this->config->item('blackfriday')): ?>
															<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
																<tr>
																	<td style="color: #e47911; font-weight: bold; font-size: 20px;">
																		<?= number_format($pret_mic,2,",",".") ?> RON
																	</td>
																</tr>
																<? if( $pret_mic<$pret_mare ): ?>
																<tr>
																	<td style="font-size: 17px; text-decoration: line-through;"><?= number_format(($pret_mare),2,",",".") ?> RON</td>
																</tr>
																<? endif ?>
															</table>
														<? else: ?>
															<table cellspacing="0" cellpadding="0" border="0" style="width: 100%; padding: 0 10px;">
																<tr>
																	<td style="border-bottom: 1px solid #909090; text-align: center; padding: 3px;">
																		1-<?= $a['articol']['discount'][0]['no_produse']-1 ?>
																	</td>
																	<? foreach ($a['articol']['discount'] as $key => $d): ?>
																		<td style="border-bottom: 1px solid #909090; border-left: 1px solid #909090; text-align: center; padding: 3px;">
																			<? if(isset($a['articol']['discount'][$key+1]['no_produse'])): ?>
																				<? $next = $a['articol']['discount'][$key+1]['no_produse']-1 ?>
																			<? else: ?>
																				<? $next = '+' ?>
																			<? endif ?>
																			<?= $d['no_produse'] ?>-<?= $next ?>
																			
																		</td>
																	<? endforeach ?>
																</tr>
																<tr>
																	<td style="text-align: center; padding: 3px;">
																		<?= number_format(($a['articol']['pret_vanzare']), 2, ",", ".") ?>
																	</td>
																	<? foreach ($a['articol']['discount'] as $key => $d): ?>
																		<td style="border-left: 1px solid #909090; text-align: center; padding: 3px; <?= $key==count($a['articol']['discount'])-1?'color: #e47911; font-weight: bold;':'' ?>">
																			<?= number_format(($a['articol']['pret_vanzare']/$curs)*(100-$d['discount'])/100, 2, ",", ".") ?>
																			
																		</td>
																	<? endforeach ?>
																</tr>
															</table>
														<? endif ?>
													<? else: ?>
														<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
															<tr>
																<td style="color: #e47911; font-weight: bold; font-size: 20px;"><?= number_format(($a['articol']['pret_vanzare'])-(($a['articol']['pret_vanzare'])*$a['articol']['discountVal'])/100,2,",",".") ?> RON</td>
															</tr>
															<? if( (($a['articol']['pret_intreg'])!=0) and (($a['articol']['pret_intreg'])>($a['articol']['pret_vanzare'])) ): ?>
															<tr>
																<td style="font-size: 17px; text-decoration: line-through;"><?= number_format(($a['articol']['pret_intreg']),2,",",".") ?> RON</td>
															</tr>
															<? endif ?>
														</table>
													<? endif ?>
												</td>
											</tr>

											<tr>
												<td style="text-align: center; padding-top: 20px;">
													<a target="_blank" href="<?= produs_url($a['articol']) ?>" style="color: #000; font-weight: bold; text-decoration: none;">
														<img src="<?= base_url() ?>assets/images/vezi_detalii.png">
													</a>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<?		break;?>
							<?	case '2':?>
								
								<td style="border-bottom:none;border-top:#d6d6d6 solid 1px;padding-right:15px;padding-top:20px;padding-bottom:20px" width="390">
									<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
										<tbody>
											<tr>
												<td width="190">
													<? $src = $this->config->item('static_url').'185/185/'.$a['imagine'] ?>
													<a target="_blank" href="<?= produs_url($a['articol']) ?>">
														<img src="<?= $src ?>" />
													</a>
												</td>
												<td style=" vertical-align: top;">
													<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
														<tr>
															<td align="right">
																<span style="background: #EE5723; color: #fff; padding: 5px 20px 5px 40px; display: inline-block; text-align: right; font-weight: bold; margin-bottom: 10px; font-size: 16px;">
																	<?= $a['articol']['cod'] ?>
																</span>
															</td>
														</tr>
														<tr>
															<td style="text-align: center; padding-top: 20px;">
																<? if(count($a['articol']['discount'])): ?>
																	<? if($this->config->item('blackfriday')): ?>
																		<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
																			<tr>
																				<td style="color: #e47911; font-weight: bold; font-size: 20px;">
																					<?= number_format($pret_mic,2,",",".") ?> RON
																				</td>
																			</tr>
																			<? if( $pret_mic<$pret_mare ): ?>
																			<tr>
																				<td style="font-size: 17px; text-decoration: line-through;"><?= number_format(($pret_mare),2,",",".") ?> RON</td>
																			</tr>
																			<? endif ?>
																		</table>
																	<? else: ?>
																		<table cellspacing="0" cellpadding="0" border="0" style="width: 100%; padding: 0 10px;">
																			<tr>
																				<td style="border-bottom: 1px solid #909090; text-align: center; padding: 3px;">
																					1-<?= $a['articol']['discount'][0]['no_produse']-1 ?>
																				</td>
																				<? foreach ($a['articol']['discount'] as $key => $d): ?>
																					<td style="border-bottom: 1px solid #909090; border-left: 1px solid #909090; text-align: center; padding: 3px;">
																						<? if(isset($a['articol']['discount'][$key+1]['no_produse'])): ?>
																							<? $next = $a['articol']['discount'][$key+1]['no_produse']-1 ?>
																						<? else: ?>
																							<? $next = '+' ?>
																						<? endif ?>
																						<?= $d['no_produse'] ?>-<?= $next ?>
																						
																					</td>
																				<? endforeach ?>
																			</tr>
																			<tr>
																				<td style="text-align: center; padding: 3px;">
																					<?= number_format(($a['articol']['pret_vanzare']), 2, ",", ".") ?>
																				</td>
																				<? foreach ($a['articol']['discount'] as $key => $d): ?>
																					<td style="border-left: 1px solid #909090; text-align: center; padding: 3px; <?= $key==count($a['articol']['discount'])-1?'color: #e47911; font-weight: bold;':'' ?>">
																						<?= number_format(($a['articol']['pret_vanzare']/$curs)*(100-$d['discount'])/100, 2, ",", ".") ?>
																						
																					</td>
																				<? endforeach ?>
																			</tr>
																		</table>
																	<? endif ?>
																<? else: ?>
																	<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
																		<tr>
																			<td style="color: #e47911; font-weight: bold; font-size: 20px;"><?= number_format(($a['articol']['pret_vanzare'])-(($a['articol']['pret_vanzare'])*$a['articol']['discountVal'])/100,2,",",".") ?> RON</td>
																		</tr>
																		<? if( (($a['articol']['pret_intreg'])!=0) and (($a['articol']['pret_intreg'])>($a['articol']['pret_vanzare'])) ): ?>
																		<tr>
																			<td style="font-size: 17px; text-decoration: line-through;"><?= number_format(($a['articol']['pret_intreg']),2,",",".") ?> RON</td>
																		</tr>
																		<? endif ?>
																	</table>
																<? endif ?>
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td style="padding-bottom: 10px; text-align: center;" colspan="2">
													<a target="_blank" href="<?= produs_url($a['articol']) ?>" style="color: #000; font-weight: bold; text-decoration: none;">
														<?= $a['articol']['denumire'] ?>
													</a>
												</td>
											</tr>
											<tr>
												<td style="text-align: center; padding-top: 20px;" colspan="2">
													<a target="_blank" href="<?= produs_url($a['articol']) ?>" style="color: #000; font-weight: bold; text-decoration: none;">
														<img src="<?= base_url() ?>assets/images/vezi_detalii.png">
													</a>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
								<?		break;?>
							<?	default:?>
								<td style="border-top:#d6d6d6 solid 1px;border-left:none;border-right:none;border-bottom:none;padding:20px 0;" width="780">
									<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
										<tr>
											<td width="430">
												<? $src = $this->config->item('static_url').'420/420/'.$a['imagine'] ?>
												<a target="_blank" href="<?= produs_url($a['articol']) ?>">
													<img src="<?= $src ?>" />
												</a>
											</td>
											<td style=" vertical-align: top;">
												<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
													<tr>
														<td align="right">
															<span style="background: #EE5723; color: #fff; padding: 5px 20px 5px 40px; display: inline-block; text-align: right; font-weight: bold; margin-bottom: 10px; font-size: 16px;">
																<?= $a['articol']['cod'] ?>
															</span>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom: 10px; text-align: center;">
															<a target="_blank" href="<?= produs_url($a['articol']) ?>" style="color: #000; font-weight: bold; text-decoration: none;">
																<?= $a['articol']['denumire'] ?>
															</a>
														</td>
													</tr>
													<tr>
														<td style="padding-bottom: 10px;">
															<?= word_limiter(strip_tags($a['articol']['descriere'], '<br>'), 50) ?>
														</td>
													</tr>
													<tr>
														<td style="text-align: center">
															<? if(count($a['articol']['discount'])): ?>
																<? if($this->config->item('blackfriday')): ?>
																	<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
																		<tr>
																			<td style="color: #e47911; font-weight: bold; font-size: 20px;">
																				<?= number_format($pret_mic,2,",",".") ?> RON
																			</td>
																		</tr>
																		<? if( $pret_mic<$pret_mare ): ?>
																		<tr>
																			<td style="font-size: 17px; text-decoration: line-through;"><?= number_format(($pret_mare),2,",",".") ?> RON</td>
																		</tr>
																		<? endif ?>
																	</table>
																<? else: ?>
																	<table cellspacing="0" cellpadding="0" border="0" style="width: 100%; padding: 0 10px;">
																		<tr>
																			<td style="border-bottom: 1px solid #909090; text-align: center; padding: 3px;">
																				1-<?= $a['articol']['discount'][0]['no_produse']-1 ?>
																			</td>
																			<? foreach ($a['articol']['discount'] as $key => $d): ?>
																				<td style="border-bottom: 1px solid #909090; border-left: 1px solid #909090; text-align: center; padding: 3px;">
																					<? if(isset($a['articol']['discount'][$key+1]['no_produse'])): ?>
																						<? $next = $a['articol']['discount'][$key+1]['no_produse']-1 ?>
																					<? else: ?>
																						<? $next = '+' ?>
																					<? endif ?>
																					<?= $d['no_produse'] ?>-<?= $next ?>
																					
																				</td>
																			<? endforeach ?>
																		</tr>
																		<tr>
																			<td style="text-align: center; padding: 3px;">
																				<?= number_format(($a['articol']['pret_vanzare']), 2, ",", ".") ?>
																			</td>
																			<? foreach ($a['articol']['discount'] as $key => $d): ?>
																				<td style="border-left: 1px solid #909090; text-align: center; padding: 3px; <?= $key==count($a['articol']['discount'])-1?'color: #e47911; font-weight: bold;':'' ?>">
																					<?= number_format(($a['articol']['pret_vanzare']/$curs)*(100-$d['discount'])/100, 2, ",", ".") ?>
																					
																				</td>
																			<? endforeach ?>
																		</tr>
																	</table>
																<? endif ?>
															<? else: ?>
																<table cellspacing="0" cellpadding="0" border="0" style="width: 100%">
																	<tr>
																		<td style="color: #e47911; font-weight: bold; font-size: 20px;">
																			<?= number_format(($a['articol']['pret_vanzare'])-(($a['articol']['pret_vanzare'])*$a['articol']['discountVal'])/100,2,",",".") ?> RON
																		</td>
																	</tr>
																	<? if( (($a['articol']['pret_intreg'])!=0) and (($a['articol']['pret_intreg'])>($a['articol']['pret_vanzare'])) ): ?>
																	<tr>
																		<td style="font-size: 17px; text-decoration: line-through;"><?= number_format(($a['articol']['pret_intreg']),2,",",".") ?> RON</td>
																	</tr>
																	<? endif ?>
																</table>
															<? endif ?>
														</td>
													</tr>
													<tr>
														<td style="text-align: center; padding-top: 20px;">
															<a target="_blank" href="<?= produs_url($a['articol']) ?>" style="color: #000; font-weight: bold; text-decoration: none;">
																<img src="<?= base_url() ?>assets/images/vezi_detalii.png">
															</a>
														</td>
													</tr>

												</table>
											</td>
										</tr>
									</table>
									
								</td>
								<?		break;
						} ?>
							<? $nr++; ?>
						<? if($nr>$a['tip']): ?>
							<? $rand_nou = 1 ?>
							<? $nr = 1 ?>
							</tr>
						</table>
						<? endif ?>
					<? endforeach ?>
					
				</td>
			</tr>
			
			<? if($newsletter['imagine_bottom']!=''): ?>
			<tr>
				<td>
					<img src="<?= $this->config->item('media_url').'newsletter/'.$newsletter['imagine_bottom'] ?>" align="left" style="max-width: 100%">
				</td>
			</tr>
			<? endif ?>
			<? if($newsletter['text_bottom']!=''): ?>
			<tr>
				<td style="padding: 10px;">
					<?= $newsletter['text_bottom'] ?>
				</td>
			</tr>
			<? endif ?>
			<tr>
				<td style="text-align: center;; font-size: 12px; padding-top: 10px; padding-bottom: 10px;">
					Daca nu mai doresti sa primesti acest newsletter, te rugam sa te <a href="[[UNSUB_LINK]]">dezabonezi</a>. 
				</td>
			</tr>
		</table>
	</body>
</html>