
<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   

   <meta name="description" content="{{env('APP_NAME')}}">
   <meta name="author" content="{{env('APP_NAME')}}">
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>{{$hotel_info_arr['name']}}</title>
   
   @include('include.waiter_header_link')
   
</head>