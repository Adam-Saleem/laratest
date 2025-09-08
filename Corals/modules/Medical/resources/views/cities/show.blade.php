@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('medical_city_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @component('components.box')
        @slot('title')
            {{ trans('Medical::labels.city.details') }}
        @endslot
        
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>{{ trans('Medical::attributes.city.name') }}</th>
                            <td>{{ $city->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('Corals::attributes.created_at') }}</th>
                            <td>{{ $city->created_at ? $city->created_at->format('d M, Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('Corals::attributes.updated_at') }}</th>
                            <td>{{ $city->updated_at ? $city->updated_at->format('d M, Y H:i') : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if($city->villages->count() > 0)
        <div class="row mt-4">
            <div class="col-md-12">
                <h4>{{ trans('Medical::labels.city.villages') }} ({{ $city->villages->count() }})</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ trans('Medical::attributes.village.name') }}</th>
                                <th>{{ trans('Corals::attributes.created_at') }}</th>
                                <th>{{ trans('Corals::labels.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($city->villages as $village)
                            <tr>
                                <td>{{ $village->name }}</td>
                                <td>{{ $village->created_at ? $village->created_at->format('d M, Y') : '-' }}</td>
                                <td>
                                    <a href="{{ route('medical.villages.show', $village->id) }}" class="btn btn-sm btn-info">
                                        {{ trans('Corals::labels.view') }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    @endcomponent
@endsection

