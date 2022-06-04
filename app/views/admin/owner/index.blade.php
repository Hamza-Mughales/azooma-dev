<!DOCTYPE html>
<html>
  
  @include('admin.owner_layout.head')

  <body id="backend-bg" class="dash-body <?=(isset($_COOKIE['darkMode']) && $_COOKIE['darkMode']==1 ? "dark-only" :"")?>" <?php if (isset($bodyfunction)) echo $bodyfunction; ?>> 

    <div class="page-wrapper null compact-wrapper" id="pageWrapper">

      @include('admin.owner_layout.header')
  
      <div class="page-body-wrapper">
        
        @include('admin.owner_layout.menuleft')

          <div class="page-body pt-5">
            <div class="container-fluid">
              <div class="row second-chart-list third-news-update">
              
                @yield('content')
                
              </div>
            </div>
          </div>
          
      </div>
      
      @include('admin.owner_layout.footer')
 
    </div>
  </body>
</html>