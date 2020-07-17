$(function(){

	$(document).on("click","button.btn-search", function(){

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
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				location.reload();
			}
		});
	});	
});