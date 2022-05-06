$(document).ready(function(){
	var hash=location.hash ;
  	hash=hash.replace("#",'');
  	$("#search-result-tabs a[href='#"+hash+"']").tab('show');
});

