@extends('cms::layouts.backend')

@section('content')
@component('cms::components.form_resource', [
'model' => $model,
])
<div class="row appointment_form">
    <div class="col-md-8">
        @component('cms::components.card', [
        'label' => trans('appoi::content.appointment_info'),
        ])
        <div class="row mb-2">
            <div class="col-md-12">
                {{ Field::text($model, 'name', ['disabled' => true]) }}
                {{ Field::text($model, 'email', ['disabled' => true]) }}
                {{ Field::text($model, 'phone', ['disabled' => true]) }}
                {{ Field::text($model, 'date', ['disabled' => true]) }}
                {{ Field::text($model, 'subject', ['disabled' => true]) }}
            </div>
        </div>
        @endcomponent
    </div>
</div>
@endcomponent
@endsection