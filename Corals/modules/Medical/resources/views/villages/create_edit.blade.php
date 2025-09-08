@extends('layouts.crud.create_edit')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('medical_village_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                {!! CoralsForm::openForm($village) !!}
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name', 'Medical::attributes.village.name', true, null) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::select('city_id', 'Medical::attributes.village.city', $cities->pluck('name', 'id'), true, null, ['placeholder' => trans('Medical::labels.select_city')]) !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($village) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($village) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection