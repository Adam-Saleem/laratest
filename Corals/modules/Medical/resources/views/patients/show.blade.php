@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('medical_patient_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    <div class="row">
        <!-- Basic Information -->
        <div class="col-md-8">
            @component('components.box')
                @slot('title')
                    {{ trans('Medical::labels.patient.basic_info') }}
                @endslot
                
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.name') }}</th>
                                    <td>{{ $patient->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.id_number') }}</th>
                                    <td>{{ $patient->id_number ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.age') }}</th>
                                    <td>{{ $patient->age ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.date_of_birth') }}</th>
                                    <td>{{ $patient->date_of_birth ? $patient->date_of_birth->format('d M, Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.phone') }}</th>
                                    <td>{{ $patient->phone ?: '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.gender') }}</th>
                                    <td>{!! $patient->gender ? $patient->gender->badge() : '-' !!}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.marital') }}</th>
                                    <td>{!! $patient->marital ? $patient->marital->badge() : '-' !!}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.city') }}</th>
                                    <td>
                                        @if($patient->city)
                                            <a href="{{ route('medical.cities.show', $patient->city->id) }}">
                                                {{ $patient->city->name }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.village') }}</th>
                                    <td>
                                        @if($patient->village)
                                            <a href="{{ route('medical.villages.show', $patient->village->id) }}">
                                                {{ $patient->village->name }}
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('Medical::attributes.patient.address') }}</th>
                                    <td>{{ $patient->full_address ?: '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endcomponent
        </div>

        <!-- Summary Card -->
        <div class="col-md-4">
            @component('components.box')
                @slot('title')
                    {{ trans('Medical::labels.patient.summary') }}
                @endslot
                
                <div class="text-center">
                    <h3>{{ $patient->name }}</h3>
                    <p class="text-muted">
                        @if($patient->age)
                            {{ $patient->age }} {{ trans('Medical::labels.years_old') }}
                        @endif
                        @if($patient->gender)
                            • {!! $patient->gender->badge() !!}
                        @endif
                    </p>
                    
                    @if($patient->phone)
                    <p><i class="fa fa-phone"></i> {{ $patient->phone }}</p>
                    @endif
                    
                    @if($patient->full_address)
                    <p><i class="fa fa-map-marker"></i> {{ $patient->full_address }}</p>
                    @endif
                </div>

                <hr>

                <table class="table table-sm">
                    <tr>
                        <th>{{ trans('Corals::attributes.created_at') }}</th>
                        <td>{{ $patient->created_at ? $patient->created_at->format('d M, Y H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('Corals::attributes.updated_at') }}</th>
                        <td>{{ $patient->updated_at ? $patient->updated_at->format('d M, Y H:i') : '-' }}</td>
                    </tr>
                </table>
            @endcomponent
        </div>
    </div>
@endsection

