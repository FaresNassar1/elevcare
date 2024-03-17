@extends('formBuilder::layouts.form-builder')

@section('form-builder-content')
    <div class="w-100 d-flex  align-items-center justify-content-center  mb-3 ">
        <h4 class="text-center w-50 sm-w-100">{{ $formSubmission->form?->name }}</h4>
    </div>

    <div class="w-100 d-flex justify-content-center ">

        <table class="w-75 sm-w-100">
            <tr>
                <th class="field">Field</th>
                <th>Value</th>
            </tr>
            <tbody>
                @forelse ($data as $key=>$value)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>
                            @if(is_array($value))
                                {{ json_encode($value) }}
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    </tr>
                @empty
                    <div class="text-danger text-center">No data</div>
                @endforelse
            </tbody>

        </table>
    </div>
@endsection
