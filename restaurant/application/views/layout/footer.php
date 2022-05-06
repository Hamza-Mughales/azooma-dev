   <!-- footer start-->
   <footer class="footer">
       <div class="container-fluid">
           <div class="row">
               <div class="col-md-12 footer-copyright text-center">
                   <p class="mb-0">Copyright 2021 © Azooma </p>
               </div>
           </div>
       </div>
   </footer>
   </div>
   </div>
   <!-- inject:js-->

   <script src="<?= base_url(js_path()) ?>/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url(js_path()) ?>/sidebar-menu.js"></script>
   <script src="<?= base_url(js_path()) ?>/simplebar.js"></script>
   <script src="<?= base_url(js_path()) ?>/custom.js"></script>
   <script src="<?= base_url(js_path()) ?>/script.js"></script>
   <script src="<?= base_url(js_path()) ?>index.js"></script>
   <script src="<?= base_url(js_path()) ?>/sweetalert2.js"></script>
   <script src="<?= base_url(js_path()) ?>/icons/feather-icon/feather.min.js"></script>
   <script src="<?= base_url(js_path()) ?>/icons/feather-icon/feather-icon.js"></script>
 
   <script src="<?= base_url(js_path()) ?>/select2.min.js"></script>
   <script>
       $(document).ready(function() {
           $(".mode").on("click", function(e) {
               var darkMode = true;
               $(".mode").toggleClass("selected");


               if ($(this).hasClass("selected")) {
                   darkMode = false;

                   console.log("selected");
                   $(".dash-body").addClass("dark-only");
                   setCookie('darkMode', 1);

               } else {
                   console.log("unselected");

                   darkMode = false;
                   $(".dash-body").removeClass("dark-only");


                   setCookie('darkMode', 0);
               }
           });

       });
  
       function setCookie(cname, cvalue, exdays = 1000000) {
           var d = new Date();
           d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
           var expires = "expires=" + d.toUTCString();
           document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
       }
   </script>

   <!-- endinject-->
   </body>


   </html>