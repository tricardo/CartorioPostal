$(document).ready(
		function() {
			var remCampos = new Array();

			$("#addCampo").click(
					function() {
						$.get(urlBase + "/servico/novoCampo/"
								+ $('#campos').children().length, {
							ajax : 1
						}, function(data) {
							$(data).appendTo('#campos');
						});
						return false;
					});

			$(".remCampo").live('click', function() {
				if($(this).attr('href')!=''){
					remCampos.push($(this).attr('href'));
					$('#remCampos').attr('value', remCampos);
				}
				$(this).parent().remove();
				return false;
			});

		});