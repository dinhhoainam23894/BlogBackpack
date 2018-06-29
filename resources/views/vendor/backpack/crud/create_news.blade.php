@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            <span class="text-capitalize">{{ $crud->entity_name_plural }}</span>
            <small>{{ trans('backpack::crud.add').' '.$crud->entity_name }}.</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
            <li class="active">{{ trans('backpack::crud.add') }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <!-- Default box -->
            @if ($crud->hasAccess('list'))
                <a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a><br><br>
            @endif

            @include('crud::inc.grouped_errors')

            <form method="post"
                  action="{{ url($crud->route) }}"
                  @if ($crud->hasUploadFields('create'))
                  enctype="multipart/form-data"
                    @endif
            >
                {!! csrf_field() !!}
                <div class="row">
                    <div class="col-md-6">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</h3>
                            </div>
                            <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">
                                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                                @if(view()->exists('vendor.backpack.crud.form_content'))
                                    <?php
                                    $array = ['title', 'slug', 'date', 'content'];
                                    $fields = array_filter($crud->getFields('create'), function($feature) use($array){return in_array($feature['name'], $array);});
                                    ?>
                                    @include('vendor.backpack.crud.form_content', [ 'fields' => $fields, 'action' => 'create' ])
                                @else
                                    @include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
                                @endif
                            </div><!-- /.box-body -->
                            <div class="box-footer">

                                @include('crud::inc.form_save_buttons')

                            </div><!-- /.box-footer-->
                        </div>
                    </div><!-- /.box -->
                    <div class="col-md-3">
                        <div class="box">
                            <div class="box-header with-border">
                                <h3 class="box-title">Extra Info</h3>
                            </div>
                            <div class="box-body row display-flex-wrap" style="display: flex; flex-wrap: wrap;">
                                <!-- load the view from the application if it exists, otherwise load the one in the package -->
                                @if(view()->exists('vendor.backpack.crud.form_content'))
                                    <?php
                                    $array = ['title', 'slug', 'date', 'content'];
                                    $fields = array_filter($crud->getFields('create'), function($feature) use($array){return !in_array($feature['name'], $array);});
                                    ?>
                                    @include('vendor.backpack.crud.form_content', [ 'fields' => $fields, 'action' => 'create' ])
                                @else
                                    @include('crud::form_content', [ 'fields' => $crud->getFields('create'), 'action' => 'create' ])
                                @endif
                            </div><!-- /.box-body -->
                        </div>
                    </div><!-- /.box -->
                </div>
            </form>
        </div>
    </div>

@endsection