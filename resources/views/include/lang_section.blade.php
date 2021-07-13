
@php
$lang=CommonMethods::getLang();
$direction=($lang=='ar' || $lang=='kr')? 'rtl/' : '';
$lang_txt=($lang=='ar' || $lang=='kr')?($lang=='kr' && $recipe_name!='')?'كردي  ': ' عربي   ' : 'E' ;
$div_mar=($lang=='ar' || $lang=='kr')? "left:10px": 'right:10px' ;
@endphp
 <nav class="navbar navbar-light d-flex justify-content-between">
      <div class="container cust_head1 mt-4">
         <div class="location-wrap">
            <img src="{!! env('APP_ASSETS') !!}img/exported_images/location.png" class="img-fluid location-img" style="height:16px;">
            <span class="location-text pl-2" style="font-size: 12px;">{{$hotel_info_arr['address']}}</span>
         </div>
         <!-- <a class="language-wrap lang_btn" id="lang_btn" data-lang="{{$direction}}">
            <img src="{!! env('APP_ASSETS') !!}img/exported_images/globe.png" class="img-fluid globe-img" style="height:16px; {{$direction}}">
            <span class="lang-text mb-2" style="font-size:12px;">{{$lang_txt}}</span>
         </a> -->

         @if($recipe_name!='')
          <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{$lang_txt}}
             <img src="{!! env('APP_ASSETS') !!}img/exported_images/globe.png" class="img-fluid globe-img" style="height:16px; {{$direction}}">
          </a>
          @endif

          <div class="dropdown-menu text-center" aria-labelledby="dropdown09" style="{{$div_mar}}">
              <a class="dropdown-item lang_btn" data-lang="ar"><span class="flag-icon flag-icon-fr"> </span> عربي    </a>
              <!-- <a class="dropdown-item lang_btn" data-lang="en"><span class="flag-icon flag-icon-it"> </span>  Eng</a> -->
              @if($recipe_name!='')
              <a class="dropdown-item lang_btn" data-lang="kr"><span class="flag-icon flag-icon-ru"> </span> كردي   </a>
              @endif
          </div>
      </div>
   </nav>
   