@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model,
    ])
        <div class="row appointment_form">
            <div class="col-md-8">
                @component('cms::components.card', [
                    'label' => trans('contacts::content.contact-info'),
                ])
                    <div class="row mb-2">
                        <div class="col-md-12">
                            {{ Field::text($model, 'name', ['disabled' => true]) }}
                            {{ Field::text($model, 'email', ['disabled' => true]) }}
                            {{ Field::text($model, 'phone', ['disabled' => true]) }}
                            {{ Field::text($model, 'subject', ['disabled' => true]) }}
                            {{ Field::text($model, 'message', ['disabled' => true]) }}
                            {{ Field::text($model, 'created_at', ['disabled' => true, 'value' => jw_date_format($model->created_at), 'label' => 'Date']) }}
                        </div>
                    </div>
                @endcomponent
            </div>
        </div>
    @endcomponent
@endsection
