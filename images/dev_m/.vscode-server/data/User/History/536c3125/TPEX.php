@extends('layouts.simple.master')
@section('title', 'Templates - Lista')

@section('css')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/sweetalert2.css')}}">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
<h3>Templates</h3>
@endsection

@section('breadcrumb-items')

<a class="btn btn-success btn-register-campain" href="{{ route('post-templates.create')}}">
    Criar Template
</a>

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
                    <div class="user-status product-table table-responsive">
                        <table class="table table-bordernone" id="basic-1">
                            <thead>
                                <tr>
                                    <th class="text-center">Imagem</th>
                                    <th class="text-center">Nome</th>
                                    <th class="text-center">Tipo</th>
                                    <th class="text-center">Categoria</th>

                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($templates->all() as $template)
                                <tr>
                                    <td style="width: 100px;">
                                        <a class="" title="Mais Detalhes" href="{{route('post-templates.edit', $template->id)}}">
                                            <!-- <img style="width:64px" class="img-fluid" src="{{s3Image($template->image)}}" alt=""> -->
                                            
                                        </a>
                                    </td>
                                    <td class="table-main">
                                        <strong>
                                            <a class="" title="Mais Detalhes" href="{{route('post-templates.edit', $template->id)}}">{{$template->name}}</a>
                                        </strong>

                                    </td>
                                    <td style="font-weight: 600;">
                                        <i data-feather="{{postType($template->type)['icon']}}" class="txt-primary" height="18"></i>
                                        {{postType($template->type)['name']}}
                                    </td>
                                    <td>
                                        {{$template->category->name}}
                                    </td>
                                    <td style="width: 50px;" class="text-center">
                                        <form action="{{ route('post-templates.destroy',$template->id) }}" method="POST" id="deleteForm{{$template->id}}">

                                            @csrf
                                            @method('DELETE')
                                            <a class="p-1 m-2 txt-danger" title="Excluir" onclick="deleteItem({{$template}})" href="#"><i class="fa fa-trash-o fa-lg"></i></a>
                                            <a class="p-1 txt-primary" title="Editar" href="{{route('post-templates.edit', $template->id)}}"><i class="fa fa-edit fa-lg"></i></a>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
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
<script src="{{asset('assets/js/isotope.pkgd.js')}}"></script>

<script src="{{asset('assets/js/masonry-gallery.js')}}"></script>
<script>
    function deleteItem(item) {
        swal({
                title: "Tem Certeza?",
                text: "Você deseja excluir " + item['name'] + "?",
                icon: "warning",
                buttons: ["Cancelar", "Excluir"],
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    document.getElementById('deleteForm' + item['id']).submit();
                } else {

                }
            })
        // var el = $('contact-tab-'+index);
        // el.addClass('delete-contact');

    }
</script>
@endsection
