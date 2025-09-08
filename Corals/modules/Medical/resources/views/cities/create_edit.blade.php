@extends('layouts.crud.create_edit')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('medical_city_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('custom-actions')
    {!! CoralsForm::formButtons(attributes:['wrapper_class'=>'m-auto','form' => 'city-form']) !!}
@endsection

@section('content')
    @parent
    {!! CoralsForm::openForm($city, ['id' => 'city-form']) !!}
    <div class="row card">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    {!! CoralsForm::text('name', 'Medical::attributes.city.name', true, null) !!}
                </div>
            </div>

            {!! CoralsForm::customFields($city) !!}

        </div>
    </div>
    {!! CoralsForm::closeForm($city) !!}
@endsection

@section('js')
@endsection
