@extends('layouts.simple.master')
@section('title', 'Leads - Cadastrar')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/date-picker.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Cadastrar Lead</h3>
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
                <form class="form theme-form mega-form" method="post" action="{{ route('leads.store') }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-12">
                            <label class="col-form-label">Nome</label>
                            <input class="form-control input-air-primary" type="text" placeholder="nome" id="name" name="name">
                        </div>
                        <div class="mb-3 col-lg-6 col-12">
                            <label class="col-form-label">Email</label>
                            <input class="form-control input-air-primary" type="email" placeholder="email" id="email" name="email">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col-lg-6 col-12">
                            <label class="col-form-label" for="phone">Telefone</label>
                            <input class="form-control input-air-primary" type="text" placeholder="telefone" id="phone" name="phone">
                        </div>
                        <div class="mb-3 col-lg-6 col-12">
                            <label class="col-form-label" for="mobile">Celular</label>
                            <input class="form-control input-air-primary" type="text" placeholder="celular" id="mobile" name="mobile">
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3 mb-0">
                                <label class="col-form-label" for="notes">Observações</label>
                                <textarea class="form-control input-air-primary" id="notes" name="notes" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                   
                    <hr class="mt-4 mb-4">
                    <div class="float-end">

                        <a class="btn btn-secondary" href="{{ route('leads.index') }}">Cancelar</a>
                        <input type="hidden" name="studio_id" id="studio_id" value="{{selectedStudioId()}}">
                        <button class="btn btn-primary" type="submit">Cadastrar Lead</button>
                    </div>
                </form>

            </div>

        </div>

    </div>
</div>
@endsection

@section('script')
<!-- script de loading  -->
<script>
    $(function() {
        $("form").submit(function() {
            $("#loader").addClass("loader_modal");
            $("#loader").addClass("loader-box");
        });
    });
</script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.pt.js')}}"></script>
<script src="{{asset('assets/js/datepicker/date-picker/datepicker.custom.js')}}"></script>
@endsection
