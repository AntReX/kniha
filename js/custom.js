$(function(){
	
	function vyhledejKnihy(){
		$.ajax({
			url: "/ajax",
			data: {
			  "action": "ajax_search",
			  "rok_vydani": $("#list-book tr.search input[name='rok-vydani']").val(),
			  "autor": $("#list-book tr.search input[name='autor']").val(),
			  "nazev_knihy": $("#list-book tr.search input[name='nazev-knihy']").val()
			},
			type: 'post',
			dataType: 'json',
			success: function(res){
				var nazev = "";
				var autor = "";
				
				if(res.status == "ok"){
					$("table.table_search tr.data").empty();
					
					$.each(res.data, function( index, value ){
						nazev = value['nazev'].replace(/(<([^>]+)>)/ig,"");
						autor = value['autor'].replace(/(<([^>]+)>)/ig,"");
						
						$("table.table_search").append("<tr class='data'><td>"+value['rok_vydani']+"</td><td>"+autor+"</td><td colspan='2'>"+nazev+"</td></tr>");
					});
					
					$('form')[0].reset();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				location.reload();
			}
		});
	}
	
	$(document).on("click","button.btn-search", function(){
		vyhledejKnihy();
	});
	
	$(document).on("click","span.remove", function(){
		var id = $(this).attr("data-id"),
			link = this,
			txt,
			r = confirm("Opravdu chcete knihu smazat ?");
			
		if (r == true) {
			$.ajax({
				url: "/ajax",
				data: {
				  "action": "ajax_remove_book",
				  "id": parseInt(id)
				},
				type: 'post',
				dataType: 'json',
				success: function(res){
					
					// z duvodu kombinovani 2 formularu php/ajax by dochazelo k odeslani formulare na vytvoreni po F5 nebo v pripade pouziti location.reload(); V praxi bych i vytvoreni jiz resil ajaxove.
					if(res.status == "ok"){
						location.href= "./";
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert("Došlo k chybě, prosím kontaktujte administrátora.");
				}
			});
		}
	});
	
	$(document).on("keypress","tr.search",function(e){
        if(e.which == 13) {
           vyhledejKnihy();
        }
    });
});