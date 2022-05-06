var Ads=(function(){
	var _adbase=base+'/ads/',_found=[];
	var getAd=function(bannerType,container){
		_found.push(bannerType);
		var cityid=0;
		if(typeof city!="undefined"){
			cityid=city['id'];
		}
		var tdata={cityid:cityid,bannerType:bannerType};
		$.ajax({
			url:base+'/ads',
			data:tdata,
			type:'GET',
			success:function(data){
				$("#"+container).html('<a href="'+_adbase+'"><img src="http://placehold.it/'+bannerType+'" /></a>');
			},
			dataType:'json'
		});
	}
	return {
		getAd:getAd
	};
})();

$(document).ready(function(){
	$.each($("div[data-type='ad-banner']"), function(index, val) {
		Ads.getAd($(val).attr('data-size'),$(val).attr('id'));
	});
});