jQuery(document).ready(function() {
	if($("#cod_produs").length)
	{
		$("#cod_produs").autocomplete({
			source: function( request, response ) {
					$.post('/carguard/autosugestion_cod', {'text': request.term}, function(data){
						response(data);
					}, 'json')
				},
				select: function(event, ui) {
					$("#produs_id").val(ui.item.id);
				},
				search: function(event, ui) {
					$("#produs_id").val('');
				},
				minLength: 2,
				delay: 100,
				messages: {
					noResults: '',
					results: function() {}
				}
		}); 
	}


	if($('#data_interval').length){
		$('#data_interval').daterangepicker({
                //opens: (App.isRTL() ? 'left' : 'right'),
				opens: 'left',
                endDate: moment().add('days', 7),
                startDate: moment(),
                //minDate: '01/01/2012',
                //maxDate: '12/31/2014',
                //dateLimit: {
                //    days: 60
                //},
                
                //timePicker: false,
                //timePickerIncrement: 1,
                ranges: {
                    'Azi': [moment(), moment()],
                    'Ieri': [moment().add('days', -1), moment().add('days', -1)],
                    'Ultimele 7 zile': [moment().add('days', -7), moment()],
                    'Luna aceasta': [moment().startOf('month'), moment().endOf('month')],
                },
                buttonClasses: ['btn'],
                applyClass: 'green',
                cancelClass: 'default',
                format: 'DD/MM/YYYY',
                separator: ' la ',
                locale: {
                    applyLabel: 'Selecteaza',
                    cancelLabel: 'Anuleaza',
                    fromLabel: 'De la',
                    toLabel: 'La',
                    customRangeLabel: 'Personalizat',
                    firstDay: 1,
					format: 'DD/MM/YYYY',
                }
            },
            function (start, end) {
                $('#data_interval input.range').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            }
        );
	}
	
	//if($(".acord_gdpr").length)
	//{
	//	$('.acord_gdpr').on('scroll', function() {
	//		if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
	//			$(".btn_acord_acceptat").show();
	//		}
	//	})
	//}
});
function sterge_adresa_livrare(id){
	var ok = confirm('Sigur doresti sa stergi adresa de livrare?');
	if (ok) {
		$.post('/utilizator/sterge_adresa_livrare', {'id': id}, function(data){
			if (data.type == 'error') {
				alert(data.msg)
			} else {
				$("#al_"+id).remove();
			}
		}, 'json')
	}
}
function schimba_adresa_implicita(id){
	 $.post('/utilizator/schimba_adresa_implicita', {'id': id});
}

function sterge_utilizator(id){
	var ok = confirm('Sigur doresti sa stergi utilizatorul?');
	if (ok) {
		$.post('/utilizator/sterge_utilizator', {'id': id}, function(data){
			$("#u_"+id).remove();
		})
	}
}

function stergePrecomanda(id){
	var ok = confirm('Sigur doresti sa stergi precomanda?');
	if (ok) {
		$.post('/utilizator/sterge_precomanda', {'id': id}, function(data){
			$("#p_"+id).remove();
		})
	}
}
function schimbat_tara(){
	$.post('/utilizator/schimbat_tara/', {'tara': $("#tara").val()}, function(data){
		$("#div_judet").html(data.judet);
		$("#div_oras").html(data.oras);

		$("#judet").selectpicker();
		$("#oras").selectpicker();
	}, 'json');
}
function schimbat_judet(){
	$.post('/utilizator/schimbat_judet/', {'judet': $("#judet").val()}, function(data){
		$("#oras").selectpicker('destroy');
		$("#div_oras").html(data);
		$("#oras").selectpicker();
	});
}

function schimba_afisare(){
	if($("#acord_date").prop('checked')){
		$("#form_div").show();
	} else {
		$("#form_div").hide();
	}
}
function pdf_factura(id){
	$.post('/utilizator/factura_pdf', {'id': id}, function(data){
		//document.location = data;
		document.location = '/utilizator/download_pdf/facturi/'+data;
	});
}