@extends('layouts.crud.show')

@section('content_header')
    @component('components.content_header')
        @slot('page_title')
            {{ $title_singular }}
        @endslot

        @slot('breadcrumb')
            {{ Breadcrumbs::render('medical_village_show') }}
        @endslot
    @endcomponent
@endsection

@section('content')
    @component('components.box')
        @slot('title')
            {{ trans('Medical::labels.village.details') }}
        @endslot
        
        <div class="row">
            <div class="col-md-6">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>{{ trans('Medical::attributes.village.name') }}</th>
                            <td>{{ $village->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('Medical::attributes.village.city') }}</th>
                            <td>
                                @if($village->city)
                                    <a href="{{ route('medical.cities.show', $village->city->id) }}">
                                        {{ $village->city->name }}
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>{{ trans('Corals::attributes.created_at') }}</th>
                            <td>{{ $village->created_at ? $village->created_at->format('d M, Y H:i') : '-' }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('Corals::attributes.updated_at') }}</th>
                            <td>{{ $village->updated_at ? $village->updated_at->format('d M, Y H:i') : '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {!! CoralsForm::customFieldsShow($village) !!}
    @endcomponent
@endsection