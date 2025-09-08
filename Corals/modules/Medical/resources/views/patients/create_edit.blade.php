@extends('layouts.crud.create_edit')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot
        @slot('breadcrumb')
            {{ Breadcrumbs::render('medical_patient_create_edit') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @parent
    <div class="row">
        <div class="col-md-12">
            @component('components.box')
                @slot('title')
                    {{ trans('Medical::labels.patient.basic_info') }}
                @endslot

                {!! CoralsForm::openForm($patient) !!}
                
                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::text('name', 'Medical::attributes.patient.name', true, null) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::text('id_number', 'Medical::attributes.patient.id_number', false, null) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        {!! CoralsForm::date('date_of_birth', 'Medical::attributes.patient.date_of_birth', false, null) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::number('age', 'Medical::attributes.patient.age', true, null, ['min' => 0, 'max' => 150]) !!}
                    </div>
                    <div class="col-md-4">
                        {!! CoralsForm::text('phone', 'Medical::attributes.patient.phone', false, null) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::select('gender', 'Medical::attributes.patient.gender', \Corals\Modules\Medical\Enums\GenderStatus::options(), true, null, ['placeholder' => trans('Medical::labels.select_gender')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::select('marital', 'Medical::attributes.patient.marital', \Corals\Modules\Medical\Enums\MaritalStatus::options(), true, null, ['placeholder' => trans('Medical::labels.select_marital_status')]) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        {!! CoralsForm::select('city_id', 'Medical::attributes.patient.city', $cities->pluck('name', 'id'), false, null, ['placeholder' => trans('Medical::labels.select_city')]) !!}
                    </div>
                    <div class="col-md-6">
                        {!! CoralsForm::select('village_id', 'Medical::attributes.patient.village', $villages->pluck('name', 'id'), false, null, ['placeholder' => trans('Medical::labels.select_village')]) !!}
                    </div>
                </div>

                {!! CoralsForm::customFields($patient) !!}

                <div class="row">
                    <div class="col-md-12">
                        {!! CoralsForm::formButtons() !!}
                    </div>
                </div>
                {!! CoralsForm::closeForm($patient) !!}
            @endcomponent
        </div>
    </div>
@endsection

@section('js')
@endsection
