var selected;
var next;
$(document).ready(function(){
    
        var cache = {},
            lastXhr;
        $( "#rest_name" ).autocomplete({
			
            minLength: 2,
            source: function( request, response ) {
                    var term = request.term;
                    if ( term in cache ) {
                            response( cache[ term ] );
                            return;
                    }
                    lastXhr = $.getJSON( base+"home/suggest/", request, function( data, status, xhr ) {
                            cache[ term ] = data;
                            if ( xhr === lastXhr ) {
                                    response( data );
                            }
                    });
            },
            focus: function( event, ui ) {
                    $( "#rest_name" ).val( ui.item.rest_Name );
                    $( "#rest_id_hdn" ).val( ui.item.rest_ID );
                    return false;
            },
            select: function( event, ui ) {
                   $( "#rest_name" ).val( ui.item.rest_Name );
                   $( "#rest_id_hdn" ).val( ui.item.rest_ID );
                    return false;
            }
	}).data( "autocomplete" )._renderItem = function( ul, item ) {
			return $( "<li></li>" )
				.data( "item.autocomplete", item )
				.append( "<a>" + item.rest_Name + " - " + item.rest_Name_Ar + "</a>" )
				.appendTo( ul );
	};
        
        var typed="";

       

});


