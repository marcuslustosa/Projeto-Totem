@extends('layouts.simple.master')
@section('title', 'Template - Editar')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Editar {{ $template->name }}</h3>
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
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <div class="card-body">
                <form class="form theme-form mega-form" method="post"
                    action="{{ route('post-templates.update', $template->id ) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="mb-3 col-lg-3 col-12 text-center">
                            <img src="https://cdn.metalife.com.br/familia-metalife/templates/{{$template->image}}"
                                alt="" id="thumb" class="post-template-thumb">
                        </div>
                        <div class="mb-3 col-lg-9 col-12">
                            <div class="row">
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="col-form-label">Nome</label>
                                    <input class="form-control input-air-primary" type="text" placeholder="nome"
                                        id="name" name="name" value="{{ $template->name }}">
                                </div>
                                <div class="mb-3 col-lg-6 col-12">
                                    <label class="col-form-label">Trocar Imagem</label>
                                    <input class="form-control input-air-primary mt-2" type="file"
                                        accept="image/jpg, image/jpeg, image/png" placeholder="imagem" id="image" name="image"
                                        onchange="loadFile(this)">
                                </div>

                            </div>

                            <div class="row">
                                <div class="mb-3 col-lg-4 col-12">
                                    <label class="col-form-label" for="logo_color">Cor do logo</label>
                                    <select class="form-select input-air-primary digits" id="logo_color"
                                        name="logo_color">
                                        <option value="0" {{ $template->logo_color == 0 ? 'selected' : ''}}>Colorido
                                        </option>
                                        <option value="1" {{ $template->logo_color == 1 ? 'selected' : ''}}>Claro
                                        </option>
                                        <option value="2" {{ $template->logo_color == 2 ? 'selected' : ''}}>Escuro
                                        </option>
                                    </select>
                                </div>
                                <div class="mb-3 col-lg-4 col-6">
                                    <label class="col-form-label">Posição X</label>
                                    <input class="form-control input-air-primary" type="number" placeholder="posição X"
                                        id="x_position" name="x_position" value="{{ $template->x_position }}">
                                </div>
                                <div class="mb-3 col-lg-4 col-6">
                                    <label class="col-form-label">Posição Y</label>
                                    <input class="form-control input-air-primary" type="number" placeholder="posição Y"
                                        id="y_position" name="y_position" value="{{ $template->y_position }}">
                                </div>


                            </div>
                            <div class="row">

                                <div class="mb-3 col-6">
                                    <label class="col-form-label">Largura do Logo</label>
                                    <input class="form-control input-air-primary" type="number"
                                        placeholder="largura do logo" id="logo_width" name="logo_width"
                                        value="{{ $template->logo_width }}">
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="col-form-label">Altura do Logo</label>
                                    <input class="form-control input-air-primary" type="number"
                                        placeholder="altura do logo" id="logo_height" name="logo_height"
                                        value="{{ $template->logo_height }}">
                                </div>


                            </div>
                            <div class="row">

                                <div class="mb-3 col-6">
                                    <label class="col-form-label" for="type">Tipo</label>
                                    <select class="form-select input-air-primary digits" id="type" name="type">
                                        @foreach(postType() as $type)
                                        <option value="{{$type['id']}}" {{ $template->type == $type['id'] ? 'selected' : ''}}>{{$type['description']}}</option>
                                        
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="col-form-label" for="type">Categoria</label>
                                    <select class="form-select input-air-primary digits" id="post_category_id"
                                        name="post_category_id">
                                        @foreach($categories->all() as $category)
                                        <option value="{{$category->id}}" {{$template->category->id == $category->id ?
                                            'selected' : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>


                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3 mt-3">
                                        <label class="col-form-label" for="description">Texto para publicação</label>
                                        <textarea class="form-control input-air-primary" id="description"
                                            name="description" rows="3">{{ $template->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>




                    <hr class="mt-4 mb-4">
                    <div class="float-end">

                        <a class="btn btn-secondary" href="{{ route('post-templates.index') }}">Voltar</a>
                        <button class="btn btn-primary" type="submit">Atualizar Template</button>
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

	image.addEventListener('change', (e) => {
		document.getElementById('thumb').src = e.target.value;
	});

	function loadFile(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#thumb')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

</script>

@endsection
