@extends('layouts.simple.master')
@section('title', 'Crie seus Posts')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/select2.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/range-slider.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>{{$title}}</h3>
@endsection

@section('breadcrumb-items')
<div class="feature-products col-12 d-flex justify-content-end">
    <!--<form>
         <div class="form-group m-0">
            <input class="form-control" type="search" placeholder="Buscar..." data-original-title="" title="">
            <i class="fa fa-search"></i>
         </div>
      </form>-->

</div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="col-12 row justify-content-end p-r-5">
        <div class="col-12">
            <label>Categorias</label>
        </div>
        <div class="d-flex justify-content-between">
            <div class="mb-2 col-9">
                <select class="js-example-basic-multiple col-12" multiple="multiple" id="selectCategories">
                    @foreach($categories->all() as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-2 d-flex justify-content-end items-bottom mb-2 text-right">
                <button class="btn btn-sm btn-success" onclick="getTemplatesByCategory()">Filtrar</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 box-col-4">
            <div class="card">

                <div class="card-body photoswipe-pb-responsive">
                    <div class="my-gallery row grid gallery" style="min-height: 10rem;" id="myGallery">
                        @foreach ($templates->all() as $template)


                        <figure class="col-xl-2 col-md-3 col-sm-6 col-6 grid-item" onclick="setImage('/s3?path={{$template->image}}', '{{$template->x_position}}', '{{$template->y_position}}', '{{$template->logo_width}}', '{{$template->logo_height}}', '{{$template->logo_color}}', '{{$template->name}}' , '{{$template->description}}')">

                            <a href="#">
                                <div class="product-box">
                                    <div class="product-img">
                                        <img class="img-fluid w-100" src="/s3?path={{$template->image}}" alt="">
                                        <div class="product-hover">
                                            <button class="btn btn-success">Utilizar</button>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </figure>
                        @endforeach

                    </div>

                </div>
                <div class="p-10">{{$templates->links() }}</div>
            </div>
            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="post-modal" aria-labelledby="post-modal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="row">
                                <h4 class="modal-title" id="post-title"></h4>
                                <div class="product-view">

                                    <!-- <button class="btn btn-facebook btn-sm p-1 m-r-5" onclick="shareOnFacebook()" type="button"><i class="fa fa-facebook p-r-10"> </i>Postar   </button> -->
                                    <button class="btn btn-secondary btn-sm p-1 m-r-5" onclick="downloadImage()" type="button"><i class="fa fa-download p-r-10"> </i>Download </button>
                                    <button class="btn btn-primary btn-sm p-1 m-r-5" onclick="share()" type="button"><i class="fa fa-share p-r-10"> </i>Compartilhar </button>
                                    <button class="btn btn-info btn-sm p-1 m-r-5" data-bs-toggle="collapse" data-bs-target="#collapseicon" aria-expanded="true" aria-controls="collapseicon" type="button"><i class="fa fa-filter p-r-10"> </i>Editar Logo</button>

                                </div>                                
                                
                            </div>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>

                        </div>
                        <div class="modal-body">
                            <div class="row col-12">
                                <div class="loader-box text-center" id="modal-loader">
                                    <div class="loader-3"></div>
                                </div>
                                <div class="col-12 d-flex d-flex justify-content-center align-items-center">                                        
                                    
                                    <div class="collapse" id="collapseicon" aria-labelledby="collapseicon" data-bs-parent="#accordion">
                                        
                                        <div id="controls" class="row col-12">                                    
                                            <div class="form-group col">
                                                <label class="col-md-2 control-label sm-left-text" for="hue">Matriz</label>
                                                                                        
                                                <input id="hue" type="text">
                                                
                                            </div>
                                            <div class="form-group col">
                                                <label class="col-md-2 control-label sm-left-text" for="luminance">Luminância</label>
                                                <div>
                                                    <input id="luminance" type="text">
                                                </div>
                                            </div>
                                            <div class="form-group col">
                                                <label class="col-md-2 control-label sm-left-text" for="saturation">Saturação:</label>
                                                <div>
                                                    <input id="saturation" type="text">
                                                </div>
                                            </div>                                    
                                        </div>
                                        <div class="mb-1 col-12 row d-flex d-flex justify-content-center align-items-end">

                                            <div class="col-8">
                                                <label class="col-form-label" for="type">Versão do Logo</label>
                                                <select class="form-select input-air-primary digits" id="logo-color" name="type">
                                                
                                                    <option value="0">Colorido</option>
                                                    <option value="1">Claro</option>
                                                    <option value="2">Escuro</option>
                                                
                                                </select>
                                            </div>
                                            <div class="col-4">                                            
                                                <button class="btn btn-primary btn-md" onclick="resetSliders()" type="button">
                                                    Limpar Filtros 
                                                </button>
                                            </div>    
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                                                

                                <div class="konva-parent" id="canvas-div">
                                    <div id="container"></div>
                                </div>
                                <div class="mt-2 d-flex justify-content-center" id="descriptionContainer">
                                    <div id="post-description-div" class="custom-scrollbar d-flex flex-column">
                                        <small class="mt-1 mb-1"><strong>sugestão de texto
                                                <a href="#" onclick="copyText()"><span class="badge badge-primary" id="btCopy">copiar</span></a>
                                            </strong></small>
                                        <p id="post-description"></p>
                                    </div>
                                </div>

                                <!--<div class="text-center">

                           <div class="product-qnty mt-2">
                              <h6 class="f-w-600">Publicar</h6>
                              <div class="addcart-btn">
                                 <button class="btn btn-primary" onclick="shareOnFacebook()" type="button"><i class="fa fa-facebook"> </i></button>
                                 <button class="btn btn-secondary" onclick="downloadImage()" type="button"><i class="fa fa-download"> </i></button>
                              </div>
                           </div>

                        </div>-->

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="loading-div text-center hide-div align-items-center justify-content-center" id="loading-div">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Criando Imagem...</span>
    </div>
</div>


@endsection

<script>
    var user = @json(Auth::user());
    var type = @json($type);
    var selectedStudioID = @json(selectedStudioId());
    var logoColor
</script>

@section('script')

<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
<script src="{{asset('assets/js/range-slider/ion.rangeSlider.min.js')}}"></script>
<script src="{{asset('assets/js/range-slider/rangeslider-script.js')}}"></script>

<script src="{{asset('assets/js/konva/konva.min.js')}}"></script>
<script src="{{asset('assets/js/template/functions.js')}}"></script>
<script src="{{asset('assets/js/postgallery/custom.js')}}"></script>


@endsection
