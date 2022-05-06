
//document.ready:start
$(document).ready(function(){
	
	$('#slideshow').cycle({
		fx:     'scrollHorz',
		pager:  '#carouselnav',
		prev:   '#prev',
		next:   '#next',
		speed:   500,
		autostop:	0,
		autostopCount:	100000,
		activePagerClass: 'current',
		timeout: 7000,/*currently set at 7 sec interval between slide transitions*/
        pagerAnchorBuilder: function(idx, slide) {
            return '#carouselnav li:eq(' + (idx) + ') a';
        },
		before: function(currSlideElement, nextSlideElement, options, forwardFlag){
			//$('ul.threeslides li a').css('background-image','images/btn_Temporary_Recruitment1.png');
			var nextIndex = $('.stagepromo .bannercarousel .slide').index($(nextSlideElement));			
			//$('ul.threeslides li').eq(nextIndex).prev('li').find('div.carouseltab').css('background-image','none');
		}
	});//}).cycle("pause");
	
});