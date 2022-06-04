@extends('admin.index')
@section('content')

{{-- Charts CSS --}}
<style>
  .highcharts-figure,
  .highcharts-data-table table {
      min-width: 360px;
      max-width: 800px;
      margin: 1em auto;
  }

  .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #ebebeb;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
  }

  .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
  }

  .highcharts-data-table th {
      font-weight: 600;
      padding: 0.5em;
  }

  .highcharts-data-table td,
  .highcharts-data-table th,
  .highcharts-data-table caption {
      padding: 0.5em;
  }

  .highcharts-data-table thead tr,
  .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
  }

  .highcharts-data-table tr:hover {
      background: #f1f7ff;
  }
</style>


<div class=" mb-2">
  <span class="">You are in <span class="h5 text-start"><?= (MDashboard::getAdminCountry($country)) ? MDashboard::getAdminCountry($country)[0]->name : '' ;?> Dashboard</span></span>
</div>

{{-- Start Section --}}
<div class="col xl-100 chart_data_left box-col-12">
  <div class="card">
    <div class="card-body p-0">
      <div class="row m-0 chart-main">
        <div class="col-xl-3 col-md-6 col-sm-4 p-0 box-col-6">
          <div class="media align-items-center">
            <div class="hospital-small-chart">
              <div class="small-bar">
                <div class="small-chart flot-chart-container"><div class="chartist-tooltip" style="top: -9.60005px; left: 31px;"><span class="chartist-tooltip-value">1200</span></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
              </div>
            </div>
            <div class="media-body">
              <div class="right-chart-content">
                <h5>
                    <?php
                      $abc = MDashboard::getTotalAnalytics($country);
                      $xyz = MDashboard::getTotalMobileAnalytics($country);
                      echo ($abc + $xyz);
                      ?>
                  </h5>
                  <span><?= __('OVERALL VISITS') ?> </span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
          <div class="media align-items-center">
            <div class="hospital-small-chart">
              <div class="small-bar">
                <div class="small-chart1 flot-chart-container"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="55.5" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="52.8" y2="31.199999999999996" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="55.5" y2="31.200000000000003" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
              </div>
            </div>
            <div class="media-body">
              <div class="right-chart-content">
                <h5>
                  <?= MDashboard::getTotalAnalytics($country, 1);?>
               </h5>
                  <span><?= __('WEBSITES VISITS') ?></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
          <div class="media align-items-center">
            <div class="hospital-small-chart">
              <div class="small-bar">
                <div class="small-chart2 flot-chart-container"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="39.3" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="44.7" class="ct-bar" ct:value="900" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="36.6" class="ct-bar" ct:value="1200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="39.3" y2="31.199999999999996" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="44.7" y2="31.200000000000003" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="52.8" y2="31.199999999999996" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="42" y2="31.200000000000003" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="36.6" y2="31.200000000000003" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
              </div>
            </div>
            <div class="media-body">
              <div class="right-chart-content">
                <h5>
                  <?= MDashboard::getTotalMobileAnalytics($country, 1); ?>
              </h5><span><?= __('MOBILE HITS') ?></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-6 p-0 box-col-6">
          <div class="media border-none align-items-center">
            <div class="hospital-small-chart">
              <div class="small-bar">
                <div class="small-chart3 flot-chart-container"><div class="chartist-tooltip"></div><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"></g><g><g class="ct-series ct-series-a"><line x1="13.571428571428571" x2="13.571428571428571" y1="69" y2="58.2" class="ct-bar" ct:value="400" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="69" y2="52.8" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="69" y2="47.4" class="ct-bar" ct:value="800" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="69" y2="42" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="69" y2="50.1" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="69" y2="39.3" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="69" y2="60.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line></g><g class="ct-series ct-series-b"><line x1="13.571428571428571" x2="13.571428571428571" y1="58.2" y2="31.200000000000003" class="ct-bar" ct:value="1000" style="stroke-width: 3px"></line><line x1="20.714285714285715" x2="20.714285714285715" y1="52.8" y2="39.3" class="ct-bar" ct:value="500" style="stroke-width: 3px"></line><line x1="27.857142857142858" x2="27.857142857142858" y1="47.4" y2="31.199999999999996" class="ct-bar" ct:value="600" style="stroke-width: 3px"></line><line x1="35" x2="35" y1="42" y2="33.9" class="ct-bar" ct:value="300" style="stroke-width: 3px"></line><line x1="42.14285714285714" x2="42.14285714285714" y1="50.1" y2="31.200000000000003" class="ct-bar" ct:value="700" style="stroke-width: 3px"></line><line x1="49.285714285714285" x2="49.285714285714285" y1="39.3" y2="33.9" class="ct-bar" ct:value="200" style="stroke-width: 3px"></line><line x1="56.42857142857143" x2="56.42857142857143" y1="60.9" y2="31.199999999999996" class="ct-bar" ct:value="1100" style="stroke-width: 3px"></line></g></g><g class="ct-labels"></g></svg></div>
              </div>
            </div>
            <div class="media-body">
              <div class="right-chart-content">
                <h5>
                </h5>
                  <?php
                    $dataSearch = MDashboard::getAnnualTrafficPercentage($country);
                    echo '<b>' . $dataSearch['direct'] . '%</b> <span> Direct Traffic</span><br>';
                    echo '<b>' . $dataSearch['search'] . '%</b> <span> Search Traffic</span><br>';
                    ?>
                <span class="mt-2"><?= __('SEARCH') ?></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{{-- End Section --}}

{{-- Start Chart Section --}}
<div class="row">
  
  <div style="position: absolute;width: 100px;right: 51px;z-index: 1;">
    <select name="chart_years" id="chart_years">
      @foreach ($YearsChart as $year)
          <option value="{{ $year }}">{{ $year }}</option>
      @endforeach
    </select>
  </div>

  <figure id="chart1">
  </figure>
</div>
{{-- End Section --}}

{{-- Start Section --}}
<div class="m-5 h4">
  <span><?= __('Statistics') ?></span>
</div>
  <div class="col-sm-6 col-lg-3">
    <a  href="<?=url("hungryn137/adminrestaurants")?>">
      <div class="card o-hidden">
        <div class="bg-primary b-r-4 card-body">
          <div class="media static-top-widget">
            <div class="align-self-center text-center">
              <i data-feather="archive"></i>
            </div>
            <div class="media-body"><span class="m-0"><?= __('RESTAURANTS') ?></span>
              <h4 class="mb-0 counter"><?= MDashboard::getTotalRestaurants($country);?></h4>
              <i class="feather feather-shopping-bag icon-bg" data-feather="archive"></i>
              <?php $newrest = MDashboard::getTotalRestaurants($country, 1);?>
              <div class="stat"><b>New</b> {{ $newrest }}</div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?= url('hungryn137/adminusers'); ?>">
      <div class="card o-hidden">
        <div class="bg-secondary b-r-4 card-body">
          <div class="media static-top-widget">
            <div class="align-self-center text-center">
              <i data-feather="users"></i>
            </div>
            <div class="media-body"><span class="m-0"><?= __('USERS') ?></span>
              <h4 class="mb-0 counter"><?= MDashboard::getTotalUsers($country); ?></h4>
              <i data-feather="users" class="feather feather-shopping-bag icon-bg"></i>
              <?php $newuser = MDashboard::getTotalUsers($country, 1); ?>
              <div class="stat"><b>New</b> {{ $newuser }}</div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?= URL::route('adminmembers'); ?>">
      <div class="card o-hidden text-white">
        <div class="b-r-4 card-body" style="background-color: #f8d62b;">
          <div class="media static-top-widget">
            <div class="align-self-center text-center">
              <i data-feather="thumbs-up"></i>
            </div>
            <div class="media-body"><span class="m-0"><?= __('SUBSCRIBERS') ?></span>
              <h4 class="mb-0 counter"><?= MDashboard::getTotalSubscribers($country); ?></h4>
              <i data-feather="thumbs-up" class="feather feather-shopping-bag icon-bg"></i>
              <?php $subscribers = MDashboard::getTotalSubscribers($country, 1); ?>
              <div class="stat"><b>Active</b> {{ $subscribers }}</div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?= URL::route('admingallery').'?type=All'; ?>">
      <div class="card o-hidden">
        <div class="b-r-4 card-body text-white" style="background-color: #51bb25;">
          <div class="media static-top-widget">
            <div class="align-self-center text-center">
            <i data-feather="image"></i>
          </div>
          <div class="media-body"><span class="m-0"><?= __('PHOTOS') ?></span>
            <h4 class="mb-0 counter"><?= MDashboard::getTotalPhotos($country); ?></h4>
            <i data-feather="image" class="feather feather-shopping-bag icon-bg"></i>
            <?php
              $subscribers = MDashboard::getTotalPhotos($country, 1);
              ?>
            <div class="stat"><b>New</b> {{ $subscribers }}</div>
          </div>
        </div>
      </div>
    </a>
    </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?= url('hungryn137/adminarticles'); ?>">
      <div class="card o-hidden">
        <div class="b-r-4 card-body text-white" style="background-color: #6f42c1;">
          <div class="media static-top-widget">
            <div class="align-self-center text-center">
              <i data-feather="edit-3"></i>
            </div>
            <div class="media-body"><span class="m-0"><?= __('ARTICLES') ?></span>
              <h4 class="mb-0 counter"><?= MDashboard::getTotalArticles($country); ?></h4>
              <i data-feather="edit-3" class="feather feather-shopping-bag icon-bg"></i>
              <div class="stat"><b>Videos</b> <?= MDashboard::getTotalVideos($country);?></div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?= url('hungryn137/adminmenurequest'); ?>">
      <div class="card o-hidden">
        <div class="b-r-4 card-body text-white" style="background-color: #989898">
          <div class="media static-top-widget">
            <div class="align-self-center text-center">
              <i data-feather="database"></i>
            </div>
            <div class="media-body"><span class="m-0"><?= __('MENU REQUESTS') ?></span>
              <h4 class="mb-0 counter"><?= MDashboard::getTotalMenuRequest($country);?></h4>
              <i data-feather="database" class="feather feather-shopping-bag icon-bg"></i>
              <?php $menurequest = MDashboard::getTotalMenuRequest($country, 1); ?>
                  <div class="stat"><b>New</b> {{ $menurequest }}</div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?=url("hungryn137/adminhotels")?>">
      <div class="card o-hidden">
        <div class=" b-r-4 card-body text-white" style="background-color: #426d93">
        <div class="media static-top-widget">
          <div class="align-self-center text-center">
            <i data-feather="home"></i>
          </div>
          <div class="media-body"><span class="m-0"><?= __('Hotels') ?></span>
            <h4 class="mb-0 counter"><?= MDashboard::getTotalHotels($country);?></h4>
            <i data-feather="home" class="feather feather-shopping-bag icon-bg"></i>
            <?php $menurequest = MDashboard::getTotalHotels($country, 1); ?>
            <div class="stat"><b>New</b> {{ $menurequest }}</div>
          </div>
        </div>
      </div>
    </a>
  </div>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?=url("hungryn137/admincuisine")?>">
      <div class="card o-hidden">
        <div class=" b-r-4 card-body text-white" style="background-color: #00a0c0">
          <div class="media static-top-widget">
            <div class="align-self-center text-center">
              <i data-feather="layout"></i>
            </div>
            <div class="media-body"><span class="m-0"><?= __('Cuisines') ?></span>
              <h4 class="mb-0 counter"><?= MDashboard::getTotalCuisines($country);?></h4>
              <i data-feather="layout" class="feather feather-shopping-bag icon-bg"></i>
              <?php $menurequest = MDashboard::getTotalCuisines($country, 1); ?>
              <div class="stat"><b>New</b> {{ $menurequest }}</div>
            </div>
          </div>
        </div>
      </div>
    </a>
  </div>
{{-- End Section --}}

{{-- Start Section --}}
<div class="card pt-4 text-center">
  <div class="row">
    <span class="h4 text-start">Other Information</span>

    <div class="card-body row py-4">
      <div class="col">
        <a class="text-dark" href="hungryn137/adminrestaurantsgroup">
          <h6><?= __('Group of Restaurants')?></h6>
          <h4 class="counter"><?= MDashboard::getTotalGroupofRestaurants($country); ?></h4>
        </a>
      </div>
      <div class="col">
        <a class="text-dark" href="hungryn137/adminrecipe">
          <h6><?= __('Recipes')?></h6>
          <h4><span class="counter"><?= MDashboard::getTotalRecipes($country); ?></span></h4>
        </a>
      </div>
      <div class="col">
        <a class="text-dark" href="hungryn137/adminknownfor">
          <h6><?= __('Known For')?></h6>
          <h4><span class="counter"><?= MDashboard::getTotalKnownFor($country); ?></span></h4>
        </a>
      </div>
      <div class="col">
        <a class="text-dark" href="hungryn137/adminsuggested">
          <h6><?= __('Suggested')?></h6>
          <h4><span class="counter"><?= MDashboard::getTotalSuggested($country); ?></span></h4>
        </a>
      </div>
      <div class="col">
        <a class="text-dark" href="hungryn137/admingallery">
          <h6><?= __('Photos Likes')?></h6>
          <h4><span class="counter"><?= MDashboard::getTotalPhotoLike($country); ?></span></h4>
        </a>
      </div>
    </div>

  </div>
</div>
{{-- End Section --}}

{{-- Start Section --}}
<div class="m-5 h4">
  <span><?= __('Azooma Members')?></span>
</div>
<div class="col-md-4">
  <div class="card browser-widget">
    <div class="media card-body align-items-center">
      <div class="media-img col-md-3"><img src="<?= asset('img/01.png') ?>" alt=""></div>
      <div class="mx-4 w-100 col-md-9 text-sm-center">
        <a href="hungryn137/adminmembers" class="text-dark">
          <div class="d-flex w-100">
            <h6 class="mx-3"><?= __('GOLD MEMBERS')?></h6>
            <h6><span ><?= MDashboard::getTotalMembers($country, 1); ?></span></h6>
          </div>
          <div class="d-flex w-100 align-items-center">
            <h5 class="mx-3"> New </h5>
            <h6><span class="mr-2"><?= MDashboard::getTotalMembers($country, 1, 1); ?></span></h6>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="card browser-widget">
    <div class="media card-body align-items-center">
      <div class="media-img col-md-3"><img src="<?= asset('img/02.png') ?>" alt=""></div>
      <div class="mx-4 w-100 col-md-9 text-sm-center">
        <a href="hungryn137/adminmembers" class="text-dark">
          <div class="d-flex w-100">
            <h6 class="mx-3"><?= __('SILVER MEMBERS')?></h6>
            <h6><span ><?= MDashboard::getTotalMembers($country, 2); ?></span></h6>
          </div>
          <div class="d-flex w-100 align-items-center">
            <h5 class="mx-3"> New </h5>
            <h6><span class="mr-2"><?= MDashboard::getTotalMembers($country, 2, 1); ?></span></h6>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="card browser-widget">
    <div class="media card-body align-items-center">
      <div class="media-img col-md-3"><img src="<?= asset('img/03.png') ?>" alt=""></div>
      <div class="mx-4 w-100 col-md-9 text-sm-center">
        <a href="hungryn137/adminmembers" class="text-dark">
          <div class="d-flex w-100">
            <h6 class="mx-3"><?= __('FREE MEMBERS')?></h6>
            <h6><span ><?= MDashboard::getTotalMembers($country, 0);?></span></h6>
          </div>
          <div class="d-flex w-100 align-items-center">
            <h5 class="mx-3"> New </h5>
            <h6><span class="mr-2"><?= MDashboard::getTotalMembers($country, 0, 1); ?></span></h6>
          </div>
        </a>
      </div>
    </div>
  </div>
</div>
{{-- End Section --}}

{{-- Start Section --}}
<div class="col-xl-6 xl-100 box-col-12 userActivities">
  <div class="widget-joins card widget-arrow">
    <span class="h4 mt-3 px-3"><?= __('TRENDING USERS')?></span>
    <div class="row">
      
      <div class="col-sm-4 pe-0">
        <div class="media border-after-xs row ">
          <div class="d-flex">
            <span class="mx-3 font-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle icon-bg"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
            </span>
            <div class="media-body align-self-center"><span class="mb-1"><?= __('COMMENTS')?></span></div>
            <div class="media-body text-center">
              <a href="hungryn137/admincomments">
                <h5 class="mb-0"><span class="counter"><?= MDashboard::getTotalReviews($country); ?></span></h5>
              </a>
            </div>
          </div>

          {{-- <div class="d-flex">
            <?php $newReviews = MDashboard::getTotalReviews($country, 1); ?>
            
              <span class="text-right">New</span> 
            
              <span class="text-center">{{ $newReviews }} </span>
          </div> --}}

        </div>
      </div>
      
      <div class="col-sm-4 pe-0">
        <div class="media border-after-xs row ">
          <div class="d-flex">
            <span class="mx-3 font-primary">
              <i data-feather="heart"></i>
            </span>
            <div class="media-body align-self-center"><span class="mb-1"><?= __('Rating')?></span></div>
            <div class="media-body text-center">
              <h5 class="mb-0"><span class="counter"><?= MDashboard::getTotalRating($country); ?></span></h5>
            </div>
          </div>

          {{-- <div class="d-flex">
            <?php $newrating = MDashboard::getTotalRating($country, 1); ?>
            
              <span class="text-right">New</span> 
            
              <span class="text-center">{{ $newrating }} </span>
          </div> --}}

        </div>
      </div>
      
      <div class="col-sm-4 pe-0">
        <div class="media border-after-xs row ">
          <div class="d-flex">
            <span class="mx-3 font-primary">
              <i data-feather="image"></i>
            </span>
            <div class="media-body align-self-center"><span class="mb-1"><?= __('PHOTOS UPLOADED')?></span></div>
            <div class="media-body text-center">
              <a href="hungryn137/admingallery?type=Users">
                <h5 class="mb-0"><span class="counter"><?= MDashboard::getTotalPhotos($country, 0, 1); ?></span></h5>
              </a>
            </div>
          </div>

          {{-- <div class="d-flex">
            <?php $subscribers = MDashboard::getTotalPhotos($country, 1, 1); ?>
            
              <span class="text-right">New</span> 
            
              <span class="text-center">{{ $subscribers }} </span>
          </div> --}}

        </div>
      </div>
      
      <div class="col-sm-4 pe-0">
        <div class="media border-after-xs row ">
          <div class="d-flex">
            <span class="mx-3 font-primary">
              <i data-feather="chevrons-down"></i>
            </span>
            <div class="media-body align-self-center"><span class="mb-1"><?= __('MENU DOWNLOADS')?></span></div>
            <div class="media-body text-center">
              <h5 class="mb-0"><span class="counter"><?= MDashboard::getTotalMenuDownloads($country); ?></span></h5>
            </div>
          </div>

          {{-- <div class="d-flex">
            <?php $menuD = MDashboard::getTotalMenuDownloads($country, 1); ?>
            
              <span class="text-right">New</span> 
            
              <span class="text-center">{{ $menuD }} </span>
          </div> --}}

        </div>
      </div>
      
      <div class="col-sm-4 pe-0">
        <div class="media border-after-xs row ">
          <div class="d-flex">
            <span class="mx-3 font-primary">
              <i data-feather="arrow-down-circle"></i> 
            </span>
            <div class="media-body align-self-center"><span class="mb-1"><?= __('IOS APP DOWNLOADS')?></span></div>
            <div class="media-body text-center">
              <h5 class="mb-0"><span class="counter"><?= MDashboard::getAppDownloads($country, 'iOS'); ?></span></h5>
            </div>
          </div>

          {{-- <div class="d-flex">
            <?php $newApp = MDashboard::getAppDownloads($country, 'iOS', 1); ?>
            
              <span class="text-right">New</span> 
            
              <span class="text-center">{{ $newApp }} </span>
          </div> --}}

        </div>
      </div>
      
      <div class="col-sm-4 pe-0">
        <div class="media border-after-xs row ">
          <div class="d-flex">
            <span class="mx-3 font-primary">
              <i data-feather="chevron-down"></i>
            </span>
            <div class="media-body align-self-center"><span class="mb-1"><?= __('Android APP DOWNLOADS')?></span></div>
            <div class="media-body text-center">
              <h5 class="mb-0"><span class="counter"><?= MDashboard::getAppDownloads($country, 'Android'); ?></span></h5>
            </div>
          </div>

          {{-- <div class="d-flex">
            <?php $newAndroidApp = MDashboard::getAppDownloads($country, 'Android', 1); ?>
            
              <span class="text-right">New</span> 
            
              <span class="text-center">{{ $newAndroidApp }} </span>
          </div> --}}

        </div>
      </div>
      
    </div>
  </div>
</div>
{{-- End Section --}}

{{-- Start Section --}}
  {{-- <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h5><?= __('Popular Sections')?></h5>
      </div>
      <div class="card-body">
        <div class="spacer spacing"></div>
          <div class="row">
              <?php
              $searchs = MDashboard::getDailyKeywords($country);
              if (is_array($searchs) && count($searchs) > 0) {
                  echo '<ul class="dashboard-other-info">';
                  foreach ($searchs as $search) {
                      echo '<li>';
                      echo stripslashes($search->search_term);
                      echo '</li>';
                  }
                  echo '</ul>';
              }
              ?>
          </div>
        <div class="user-status table-responsive">
          <table class="table table-bordernone">
            <thead>
              <tr>
                <th scope="col">Restaurants</th>
                <th scope="col">Cuisines</th>
                <th scope="col">Sections</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $popRests = MDashboard::getPopularRestaurants($country);
                $popCui = MDashboard::getPopularCuisines($country);
                $popSec = MDashboard::getPopularSections($country);
                if (is_array($popRests)) {
                  foreach ($popRests as $rest) {
                    echo '<tr>';
                      ?>
                      
                          <?php echo stripslashes($rest->rest_Name) ?>
                          <td style="margin-left: 5px;" class="f-w-600"><?php echo $rest->total_view; ?></td>
                      
                      <?php
                  }
                  if (is_array($popCui)) {
                      foreach ($popCui as $value) {
                          ?>
                              <?php echo stripslashes($value->cuisine_Name) ?> 
                              <td><?php echo $value->cuisine_viewed; ?></td>
                          <?php
                      }
                  }
                  if (is_array($popSec)) {
                      foreach ($popSec as $value) {
                          ?>
                              <?php echo stripslashes($value->name) ?> 
                              <td style="margin-left: 5px;" class="badge"><?php echo $value->viewed_eng; ?></td>
                      
                          <?php
                      }
                  }

                }
                ?>
              <tr>
                <td class="f-w-600">Simply dummy text of the printing</td>
                <td>1</td>
                <td class="font-primary">Pending</td>
                <td>
                  <div class="span badge rounded-pill pill-badge-secondary">6523</div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div> --}}
  <div class="bg-body text-dark  col-md-8">
    <div class="row">
        <?php
          $searchs = MDashboard::getDailyKeywords($country);
          if (is_array($searchs) && count($searchs) > 0) {
              echo '<ul class="dashboard-other-info">';
              foreach ($searchs as $search) {
                  echo '<li>';
                  echo stripslashes($search->search_term);
                  echo '</li>';
              }
              echo '</ul>';
          }
        ?>
    </div>

    <legend>TRENDING ON AZOOMA</legend>
    <div class="row">
        <div class="left col-lg-4">
            <h4>Restaurants</h4>
            <ul style=" padding-left: 15px; ">
                <?php
                $popRests = MDashboard::getPopularRestaurants($country);
                if (is_array($popRests)) {
                    foreach ($popRests as $rest) {
                        ?>
                        <li>
                            <?php echo stripslashes($rest->rest_Name) ?>
                            <span style="margin-left: 5px;" class="badge"><?php echo $rest->total_view; ?></span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="left col-lg-4">
            <h4>Cuisines</h4>
            <ul style=" padding-left: 15px; ">
                <?php
                $popCui = MDashboard::getPopularCuisines($country);
                if (is_array($popCui)) {
                    foreach ($popCui as $value) {
                        ?>
                        <li>
                            <?php echo stripslashes($value->cuisine_Name) ?> 
                            <span style="margin-left: 5px;" class="badge"><?php echo $value->cuisine_viewed; ?></span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="left col-lg-4">
            <h4>Sections</h4>
            <ul style=" padding-left: 15px; ">
                <?php
                $popSec = MDashboard::getPopularSections($country);
                if (is_array($popSec)) {
                    foreach ($popSec as $value) {
                        ?>
                        <li>
                            <?php echo stripslashes($value->name) ?> 
                            <span style="margin-left: 5px;" class="badge"><?php echo $value->viewed_eng; ?></span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    <div class="spacer"></div>
    <div class="row overflow">
        <legend>Reports </legend>
        <div class="overflow margin-bottom">
            <button type="button" class="btn btn-primary btn-large" data-bs-toggle="collapse" data-bs-target="#rest-report">  <i data-feather="file-plus"></i> Restaurants Report </button>
            <button type="button" class="btn btn-light btn-large" data-bs-toggle="collapse" data-bs-target="#user-report">  <i data-feather="file-plus"></i> User Report </button>
        </div>
        <div class="collapse well-white" id="rest-report">
            <legend>Restaurants</legend>
            <div>
                <form name="admin-form-report" id="admin-form-report" class="form-horizontal" role="form" action="{{ route('adminsearch'); }}" method="post" >
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control">
                                <option value="">please select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="city">City</label>
                        <div class="col-md-6">
                            <?php
                            $cities = MGeneral::getAllCities($country);
                            echo MGeneral::generate_list($cities, "city_ID", "city_Name", 'city', 'city');
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="cuisine">Cuisine</label>
                        <div class="col-md-6">
                            <?php
                            $cuisines = MGeneral::getAllCuisine(1);
                            echo MGeneral::generate_list($cuisines, "cuisine_ID", "cuisine_Name", 'cuisine', 'cuisine');
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="best">Best For</label>
                        <div class="col-md-6">
                            <?php
                            $bestfor = MGeneral::getAllBestFor(1);
                            echo MGeneral::generate_list($bestfor, "bestfor_ID", "bestfor_Name", 'best', 'best');
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="membership">Membership</label>
                        <div class="col-md-6">
                            <?php
                            $bestfor = MGeneral::getAllSubscriptionTypes($country);
                            echo MGeneral::generate_list($bestfor, "id", "accountName", 'membership', 'membership');
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="rest_style">Restaurant Style</label>
                        <div class="col-md-6">
                            <select class="form-control" name="rest_style" id="rest_style">
                                <option value=""> please Select Restaurant Style</option>
                                <?php
                                $reststyle = MRestActions::getAllRestStyles();
                                if (count($reststyle) > 0) {
                                    foreach ($reststyle as $style) {
                                        ?>
                                        <option value="<?php echo $style->id; ?>">
                                            <?php echo stripslashes($style->name) . ' - ' . stripslashes($style->nameAr); ?>
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="class_category">Class Category</label>
                        <div class="col-md-6">
                            <select class="form-control" name="class_category" id="class_category">
                                <option value=""> please Select Class Category</option>
                                <?php
                                $DiningServices = Config::get('commondata.DiningServices');
                                if (is_array($DiningServices)) {
                                    foreach ($DiningServices as $key => $value) {
                                        ?>
                                        <option value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="price_range">Price Range</label>
                        <div class="col-md-6">
                            <select class="form-control" name="price_range" id="price_range">
                                <option value=""> please Select Price Range</option>
                                <?php
                                $PriceRange = Config::get('commondata.PriceRange');
                                if (is_array($PriceRange)) {
                                    foreach ($PriceRange as $key => $value) {
                                        ?>
                                        <option value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                        <?php
                                    }
                                }
                                ?> 
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label" for=""></label>
                        <div class="col-md-6">
                            <input type="hidden" name="type" value="restaurants" id="type">
                            <button type="submit" class="btn btn-primary-gradien">Download Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="collapse well-white" id="user-report">
            <legend>Users</legend>
            <div>
                <form name="admin-form-report" id="admin-form-report" class="form-horizontal" role="form" action="{{ route('adminsearch'); }}" method="post" >
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="status">Status</label>
                        <div class="col-md-6">
                            <select name="status" id="status" class="form-control">
                                <option value="">please select Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 control-label" for="city">City</label>
                        <div class="col-md-6">
                            <?php
                            $cities = MGeneral::getAllCities($country);
                            echo MGeneral::generate_list($cities, "city_ID", "city_Name", 'city', 'city');
                            ?>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 control-label" for=""></label>
                        <div class="col-md-6">
                            <input type="hidden" name="type" value="users" id="type">
                            <button type="submit" class="btn btn-primary-gradien">Download Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

  </div>

  <div class="col-md-4 text-center">
    <div class="card">
      <div class="cal-date-widget card-body">
        <div class="row">
          <div class="col">
            <div class="cal-info text-center">
              <h2><?= date('d')?></h2>
              <div class="d-inline-block mt-2"><span class="b-r-dark pe-3"><?= date('M')?></span><span class="ps-3"><?= date('Y')?></span></div>
              <p class="mt-4 f-16 text-muted">"This time will pass"</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

{{-- End Section --}}



{{-- Start js --}}
<script src="<?= asset(js_path() . 'chart/highcharts/highcharts.js' )?>" type="text/javascript"></script>
<script src="<?= asset(js_path() . 'chart/highcharts/exporting.js' )?>" type="text/javascript"></script>

<script type="text/javascript">
  function load_months_applications_chart(result = '') {
    if (result === '') {
      var totalVisits = <?php echo json_encode($TotalVisits) ?>;
      var englishVisits = <?php echo json_encode($EnglishVisits) ?>;
      var arabicVisits = <?php echo json_encode($ArabicVisits) ?>;
    } else {
      var totalVisits = result.TotalVisits;
      var englishVisits = result.EnglishVisits;
      var arabicVisits = result.ArabicVisits;
    }

    Highcharts.chart('chart1', {
    chart: {
    type: 'line'
    },
    title: {
    text: 'Average Visits'
    },
    xAxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
    title: {
    text: ''
    }
    },
    legend: {
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'middle'
  },
    tooltip: {
    shared: true,
    crosshairs: true,
    },
    plotOptions: {
      line: {
        dataLabels: {
        enabled: true
        },
        enableMouseTracking: false
      }
    },
      series: [
        {
          "name":"Total Visits",   
          "data": totalVisits
        },
        {
          "name":"English Visits", 
          "data":englishVisits
        },
        {
          "name":"Arabic Visits",  
          "data":arabicVisits
        }
      ] 
  });
  }

  $( document ).ready(function() {
    load_months_applications_chart();
  });

</script>

<script>
  
  $('#chart_years').on('change', function(e) {
    console.log( e.target.value );
    var year =e.target.value;
    $.ajax({
        url: " {{ route('chart/year') }}",
        type: "POST",
        data: {
            year: year
        },
        success: function(t) {
          console.log($.parseJSON(t));
          load_months_applications_chart($.parseJSON(t));
        },
      error: function(t) {
      alert("Sorry, Somethinge Went wrong!")
        }
    });
  });  
</script>

@endsection
