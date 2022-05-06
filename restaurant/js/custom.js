$(document).ready(function(){
    $("#mobile-menu").on('click',function(){     
        $(".side-menu").toggleClass('show');
        if  ($(".side-menu").hasClass("show") ) {
            $("#close").css('display',"none");
            $("#bars").css('display',"block");
            $(".side-menu").animate({ left: "-30%" }, 500);
        }
        else{
            $("#mobile-menu").innerHtml = ' <i class="las la-bars"></i>';
            $(".side-menu").animate({ left: '0' }, 500);
            $("#close").css('display',"block");
            $("#bars").css('display',"none");
        }
            
    })
    
})