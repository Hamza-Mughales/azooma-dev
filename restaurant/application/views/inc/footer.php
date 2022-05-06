<div class="footer">
	<div class="pagesize clear">
		<p class="bt-space15"><span class="copy"><strong>&copy; <?php echo date("Y"); ?> Copyright by  <a href="http://www.sufrati.com" target="_blank">sufrati.com</a></strong></span> </p>
		
	</div>
</div>
<script>
$('#navbar').affix();
$(function() {
    var $window = $(window);
    var mainheight=$('#main-container').height();
    mainheight=parseInt(mainheight);
    
    if(mainheight > 520){
        console.log(mainheight);
        $("#spy-bar").attr("data-spy",'affix');
        $('.bs-docs-sidenav').affix({
           offset: {
             top: function() {
               return $window.width() <= 980 ? 290 : 180
             },
             bottom: 108
           }
        });
    }else{
    console.log(mainheight);
    } 
});
</script>