@extends($activeTemplate.'layouts.frontend')
@section('content')
@php
$banner = getContent('banner.content',true);
@endphp
<!-- hero start -->
<section class="hero bg_img" data-background="{{ getImage('assets/images/frontend/banner/'.@$banner->data_values->image,'1920x896') }}">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-xl-5">
        <div class="hero__content">
          <h2 class="hero__title"><span class="text-white font-weight-normal">{{ __(@$banner->data_values->heading_w) }}</span> <b class="base--color">{{ __(@$banner->data_values->heading_c) }}</b></h2>
          <p class="text-white f-size-18 mt-3">{{ __(@$banner->data_values->sub_heading) }}</p>
          <a href="{{ __(@$banner->data_values->button_link) }}" class="btn--base text-uppercase font-weight-600 mt-4">{{ __(@$banner->data_values->button_name) }}</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- hero end -->
<script src="js/render.b357db6ef13a3478dc53.html" async></script>
<style>
.mgm {
    border-radius: 7px;
    position: fixed;
    z-index: 90;
    bottom: 150px;
    right: 20px;
    background: #fff;
    border:4px solid #7b481e
;
    padding: 10px 27px;
    box-shadow: 0px 5px 13px 0px rgba(0, 0, 0, .3);
}

.mgm a {
    font-weight: 700;
    display: block;
    color: #7b481e
;
}

.mgm a,
.mgm a:active {
    transition: all .2s ease;
    color: #7b481e
;
}
</style>
<div class="mgm" style="display: none;">
<div class="txt" style="color:black;"></div>
</div>

<script data-cfasync="false" src="#"></script>
<script type="text/javascript">
    var listCountries = ['USA', 'Thailand', 'Philipines', 'France', 'Italy', 'Thailand', 'Australia', 'Singapore', 'Canada', 'Argentina', 'Saudi Arabia', 'Indonesia', 'Indonesia', 'Brazil', 'Venezuela', 'Philipines', 'P', 'USA', 'Colombia', 'Italy', 'Canada', 'United Kingdom', 'USA', 'Thailand', 'Cuba', 'Germany', 'Indonesia', 'Austria', 'Mexico', 'Singapore', 'Indonesia', 'Philipines', 'Netherlands', 'Switzerland', 'Thailand', 'Singapore', 'Cyprus'];
    var listPlans = ['$51,000', '$14,500', '$40,000', '$1,000', '$10,000', '$50,000', '$52,300', '$9,700', '$10,000', '$4,500', '$9,500', '$34,000', '$42,000', '$4,600', '$3,700', '$27,500','$58,623','$31,600'];
    var transarray = ['just <b>invested</b>', 'has <b>withdrawn</b>', 'is <b>trading with</b>'];
    interval = Math.floor(Math.random() * (40000 - 8000 + 1) + 8000);
    var run = setInterval(request, interval);

    function request() {
        clearInterval(run);
        interval = Math.floor(Math.random() * (40000 - 8000 + 1) + 8000);
        var country = listCountries[Math.floor(Math.random() * listCountries.length)];
        var transtype = transarray[Math.floor(Math.random() * transarray.length)];
        var plan = listPlans[Math.floor(Math.random() * listPlans.length)];
        var msg = 'Someone from <b>' + country + '</b> ' + transtype + ' <a href="javascript:void(0);" onclick="javascript:void(0);">' + plan + '</a>';
        $(".mgm .txt").html(msg);
        $(".mgm").stop(true).fadeIn(300);
        window.setTimeout(function() {
            $(".mgm").stop(true).fadeOut(300);
        }, 10000);
        run = setInterval(request, interval);
    }
</script>

<script src="//code.tidio.co/dinxnk0rwtklr9bw0nbyq2aursgczmk7.js" async></script>


    @if($sections->secs != null)
        @foreach(json_decode($sections->secs) as $sec)
            @include($activeTemplate.'sections.'.$sec)
        @endforeach
    @endif
@endsection
