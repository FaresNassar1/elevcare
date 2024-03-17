@extends('formBuilder::layouts.form-builder')

@section('form-builder-content')
    <div class="row">
        <div class="col-md-6"></div>
        <div class="col-md-6 text-right">
            <div class="btn-group">
                <button id="submitFormBtn" class="btn btn-success px-5">
                    <i class="fa fa-save"></i> {{ trans_cms('cms::app.save') }}
                </button>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-9">
            <div class="row mb-2">
                <div class="col-md-6">
                    <label>{{ trans_cms('cms::app.name') }}</label>
                    <input id="formNameInput" name="form_name" value='{{ $form->name }}' class="form-control" required />
                </div>
            </div>
        </div>
    </div>

    <div id="formio"></div>

    <script>
        window.addEventListener('load', function() {
            var formDefinition = {!! $form->form_definition !!};

            window.builder1 = new Formio.builder(document.getElementById('formio'), {
                components: formDefinition
            }).then(function(builder) {
                builder.on('addComponent', function(component) {
                    var inputElement = document.querySelector(`input[name="data[key]"]`);
                    if (inputElement) {
                        inputElement.setAttribute('readonly', 'readonly');
                    }
                });
                builder.on('updateComponent', function(component) {
                    var inputElement = document.querySelector(`input[name="data[key]"]`);
                    if (inputElement) {
                        inputElement.setAttribute('readonly', 'readonly');
                    }
                });

                var submitBtn = document.getElementById('submitFormBtn');

                submitBtn.addEventListener('click', function() {
                    var formData = builder.schema.components;; //this is not true its undefined
                    var formName = document.getElementById('formNameInput').value;
                    var url = "{{ route('form.show.saved', ':formId') }}".replace(':formId',
                        '{{ $form->id }}');

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                json_definition: formData,
                                form_name: formName

                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            var url =
                                "/admin-cp/form-builder";
                            window.location.href = url;
                        })
                        .catch(error => {
                            console.error('Error saving form:', error.message);
                        });
                });
            });
        });
    </script>
@endsection
