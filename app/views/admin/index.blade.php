<!DOCTYPE html>
<html>
  
  @include('admin.layouts.head')

  <body id="backend-bg" class="dash-body" <?php if (isset($bodyfunction)) echo $bodyfunction; ?>> 

    <div class="page-wrapper null compact-wrapper" id="pageWrapper">

      @include('admin.common.header')
  
      <div class="page-body-wrapper">
        
        @include('admin.common.menuleft')

          <div class="page-body pt-5">
            <div class="container-fluid">
              <div class="row second-chart-list third-news-update">
              
                @yield('content')
                
              </div>
            </div>
          </div>
          
      </div>
      
      @include('admin.layouts.footer')
 
    </div>
  </body>
</html>