var sliderarray={tooltip:'hide'};
$("#sort-filter-btn").click(function(e){
	e.preventDefault();
	var s='?';
	$.each($('*[data-name].btn-clicked'),function(index,item){
		s+=$(item).attr('data-name')+'='+$(item).attr('data-val')+'&';
	});
	if($("#filter-result-cuisine").length>0){
		var cuisine=$("#filter-result-cuisine").val().trim();
		s+='cuisine='+cuisine;
	}
	s=s.trim();
	var turl=window.location.href.split('?')[0];
	turl=turl.split('#')[0];
	var url=turl+s+'#n';
	document.location=url;
});

$('*[data-name]').click(function(e){
	e.preventDefault();
	var $this=$(this),name=$(this).attr('data-name');
	if($this.hasClass('btn-clicked')){
		$("*[data-name='"+name+"']").removeClass('btn-clicked');
	}else{
		$("*[data-name='"+name+"']").removeClass('btn-clicked');
		$this.addClass('btn-clicked');
	}
});
$(document).ready(function(){
	if($("input.pop-slider").length>0){
		$("input.pop-slider").slider(sliderarray).on('slideStop slide',function(value){
	  	 	var cls=getClass(value);
	  	 	var curel=$(this).attr('id')+'Slider';
	  	 	$("#"+curel).next().find('i').attr('class','').addClass(cls);
	  	});
	}
  	if(typeof near!="undefined"&&near==1){

  		var url=window.location.href;
  		url=url.split('#')[0];
  		url=url.split('/');
  		if(url[url.length-1]=="near-me"){
  			if (navigator.geolocation) {

  				sufratiloading();
		        navigator.geolocation.getCurrentPosition(function(position){
		        	$.ajax({
		        		url:base+'/'+city.url+'/near-me',
		        		type:'GET',
		        		data:{latitude:position.coords.latitude,longitude:position.coords.longitude},
		        		success:function(data){
		        			hideloading(true);
		        			$("#nearby-col").html(data['html']);
		        			if(typeof data['paginator']!="undefined"&&data['paginator']!=""){
		        				$("#nearby-col").append(data['paginator']);
		        			}
		        		},		        		
		        	})
		        });
		    } else {
		    	alert('Geolocation is not supported by your browser');
		    }
  		}
  	}
});