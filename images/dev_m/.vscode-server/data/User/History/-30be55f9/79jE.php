@extends('layouts.simple.master')
@section('title', 'Galeria de Templates')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/sweetalert2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Galeria de Templates</h3>
@endsection

@section('breadcrumb-items')


@endsection

@section('content')
<div class="container-fluid">
    @if(session()->get('success'))

    <div class="alert alert-success outline alert-dismissible fade show" role="alert">
        <i data-feather="alert-thumb"></i>
        <span class="m-l-5"> {{ session()->get('success') }} </span>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    @endif
    <div class="row">
        <!-- Individual column searching (text inputs) Starts-->
        <div class="col-sm-12">
            <div class="card">

                <div class="card-body">

                    <div class="row">
                        @foreach ($templates->all() as $template)
                        <div class="col-auto">
                            <img id="{{$template->id}}" src="{{asset('templates/'.$template->image)}}"
                                class="post-template-thumb" alt="">


                            <div class="text-center mt-2">
                                <h6>{{$template->name}}</h6>
                                <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                    data-bs-target=".bd-example-modal-lg"
                                    onclick="setImage('{{$template->image}}', '{{$template->x_position}}', '{{$template->y_position}}', '{{$template->logo_width}}', '{{$template->logo_height}}', '{{$template->logo_color}}')">Utilizar</button>
                            </div>
                        </div>
                        @endforeach

                    </div>
                    <div>


                    </div>

                </div>
            </div>
        </div>
        <!-- Individual column searching (text inputs) Ends-->
    </div>

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="btn btn-secondary p-2 m-2" onclick="downloadImage()">
                        Download <i data-feather="download"></i>
                    </a>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-body">
                <div id="controls">
                    hue:
                    <input id="hue" type="range" min="0" max="259" step="1" value="150" />
                    saturação:
                    <input
                        id="saturation"
                        type="range"
                        min="-2"
                        max="10"
                        step="0.5"
                        value="0"
                    />
                    luminância:
                    <input
                        id="luminance"
                        type="range"
                        min="-2"
                        max="2"
                        step="0.1"
                        value="0"
                    />
                </div>
                    <div class="row">

                        <canvas id="demo"></canvas>

                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/js/rating/jquery.barrating.js')}}"></script>
<!--<script src="{{asset('assets/js/owlcarousel/owl.carousel.js')}}"></script>-->
<!--<script src="{{asset('assets/js/ecommerce.js')}}"></script>-->
<script src="{{asset('assets/js/product-list-custom.js')}}"></script>
<script src="{{asset('assets/js/sweet-alert/sweetalert.min.js')}}"></script>
<script>
    // (B) IMAGES + CANVAS
   var logo1 = new Image(),
   logo2 = new Image(),
      canvas = document.getElementById("demo"),
      img = new Image(),
      ctx = canvas.getContext("2d"),
      yOffset = 0;

      // (C1) ADD BACKGROUND IMAGE


      logo1.src = 'assets/images/templates/logo1.png';
      logo2.src = 'assets/images/templates/logo2.png';


      function setImage(url, x, y,w,h, color){
         img.src = 'templates/' + url;
         getImage();
         if(color == 0){
            ctx.drawImage(logo2, x, y, w, h);
         } else if(color == 1){
            ctx.drawImage(logo1, x, y, w, h);
         } else{
            ctx.drawImage(logo1, x, y, w, h);
         }
      }

      function getImage(){
         canvas.width = img.naturalWidth;
         canvas.height = img.naturalHeight;
         ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight);
         yOffset = 20;
      }



   function insertLogo1() {

         ctx.drawImage(logo1, (canvas.width/2) - logo1.width, canvas.height - logo1.height -yOffset, logo1.naturalWidth, logo1.naturalHeight);
   }

   function insertLogo2() {

         ctx.drawImage(logo2, (canvas.width/2) - logo2.width, canvas.height - logo2.height -yOffset, logo2.naturalWidth, logo2.naturalHeight);
   }

   function downloadImage(){

         let anchor = document.createElement("a");
         anchor.href = canvas.toDataURL("image/png");
         anchor.download = "imagem_post.png";
         anchor.click();
         anchor.remove();
   }


</script>
@endsection
