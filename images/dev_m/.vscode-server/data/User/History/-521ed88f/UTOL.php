@extends('layouts.simple.master')
@section('title', 'Templates - Cadastrar')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Cadastrar Template</h3>
@endsection

@section('content')
@if ($errors->any())

@foreach ($errors->all() as $error)
<div class="alert alert-danger outline alert-dismissible fade show" role="alert">
    <i data-feather="alert-triangle"></i>
    <span class="m-l-5"> {{ $error }}</span>
    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endforeach

@endif
<div id="loader">
    <div class="loader-3"></div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form class="form theme-form mega-form" method="post" action="{{ route('post-templates.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-lg-9 col-12">
                            <div class="row">
                                <div class="mb-3 col-6">
                                    <label class="col-form-label" for="type">Tipo</label>
                                    <select class="form-select input-air-primary digits" id="type" name="type">
                                        @foreach(postType() as $type)
                                        <option value="{{$type['id']}}">{{$type['description']}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-6">
                                    <label class="col-form-label" for="type">Categoria</label>
                                    <select class="form-select input-air-primary digits" id="post_category_id"
                                        name="post_category_id">
                                        @foreach($categories->all() as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="col-form-label">Nome</label>
                                    <input class="form-control input-air-primary" type="text" placeholder="nome"
                                        id="name" name="name">
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="col-form-label">Imagem</label>
                                    <input class="form-control input-air-primary" type="file"
                                        accept="image/jpg, image/jpeg, image/png" placeholder="imagem" id="image"
                                        name="image" onchange="loadFile(this)">
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label class="col-form-label" for="description">Texto para publicação</label>
                                    <textarea class="form-control input-air-primary" id="description" name="description"
                                        rows="3"></textarea>
                                </div>
                            </div>
                            <hr class="mt-4 mb-4">

                            <div id='imageType' class="row">
                                <div class="mb-3 col-lg-4 col-12">
                                    <label class="col-form-label" for="logo_color">Cor do logo</label>
                                    <select class="form-select input-air-primary digits" id="logo_color"
                                        name="logo_color">
                                        <option value="0">Colorido</option>
                                        <option value="1">Claro</option>
                                        <option value="2">Escuro</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-4 col-6">
                                    <label class="col-form-label">Posição X</label>
                                    <input class="form-control input-air-primary" type="number" placeholder="posição X"
                                        id="x_position" name="x_position" value="740">
                                </div>
                                <div class="mb-3 col-lg-4 col-6">
                                    <label class="col-form-label">Posição Y</label>
                                    <input class="form-control input-air-primary" type="number" placeholder="posição Y"
                                        id="y_position" name="y_position" value="70">
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="col-form-label">Largura do Logo</label>
                                    <input class="form-control input-air-primary" type="number"
                                        placeholder="largura do logo" id="logo_width" name="logo_width" value="297">
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="col-form-label">Altura do Logo</label>
                                    <input class="form-control input-air-primary" type="number"
                                        placeholder="altura do logo" id="logo_height" name="logo_height" value="102">
                                </div>
                            </div>

                            <div id='videoType' class="row" style="display:none">
                                <div class="mb-12">
                                    <label class="col-form-label">Vídeo</label>
                                    <input class="form-control input-air-primary" type="file" accept="video/*"
                                        placeholder="video" id="video" name="video">
                                </div>
                            </div>



                            <hr class="mt-4 mb-4">
                            <div class="float-end">
                                <a class="btn btn-secondary" href="{{ route('post-templates.index') }}">Cancelar</a>
                                <button class="btn btn-primary" type="submit">Cadastrar Template</button>
                            </div>
                        </div>
                        <div class="mb-3 col-lg-3 col-12 text-center">
                            <img alt="" id="thumb" class="post-template-thumb">
                        </div>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.pt.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
<script>
    var image = document.getElementById('image');


    function loadFile(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#thumb')
                    .attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).ready(function() {

        $('#type').on('change', function() {
            var id = $(this).val();

            if (id != 3) {
                $('#imageType').show();
                $('#videoType').hide();
            } else {
                $('#imageType').hide();
                $('#videoType').show();
            }
        });
    })
</script>

<!-- script de loading  -->
<script>
    $(function() {
        $("form").submit(function() {
            $("#loader").addClass("loader_modal");
            $("#loader").addClass("loader-box");
        });
    });
</script>

@endsection