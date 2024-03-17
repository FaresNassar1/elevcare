<div class="row">
    <div class="col-md-12">
        <ul id="repeater_items" class="mt-5">
            @if ($repeater_items = $model->getMeta('repeater'))

                @foreach ($repeater_items as $index => $row_item)
                    @php
                        $row_item = (object) $row_item;
                    @endphp
                    <li>
                        <div class="row repeater-item">
                            <div class="col-md-3">
                                @component('cms::components.form_image', [
                                    'label' => trans_cms('cms::app.thumbnail'),
                                    'name' => 'repeater_images[]',
                                    'value' => $row_item->image ?? '',
                                ])
                                @endcomponent
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label">{{ trans_cms('cms::app.title') }}</label>
                                    <input type="text" class="form-control" name="repeater_titles[]"
                                        autocomplete="off" value="{{ @$row_item->title }}">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">{{ trans_cms('cms::app.description') }}</label>
                                    <textarea class="form-control" name="repeater_descriptions[]">{{ @$row_item->description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">{{ trans_cms('cms::app.link') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="repeater_links[]"
                                            autocomplete="off" value="{{ @$row_item->link }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><input type="checkbox"
                                                    name="repeater_new_tabs[]" value="1"
                                                    @if (@$row_item->new_tab == 1) checked @endif>
                                                {{ trans_cms('cms::app.open_new_tab') }}</span>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon3"><input type="checkbox"
                                                    name="repeater_button_links[]" value="1"
                                                    @if (@$row_item->button_link == 1) checked @endif>
                                                {{ trans_cms('cms::app.button_link') }}</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>{{ trans_cms('cms::app.start_date') }}</label>
                                        <input type="datetime-local" name="repeater_date[]"
                                            value="{{ @$row_item->date ? @$row_item->date : now()->format('Y-m-d\TH:i') }}">
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-1">
                                <a href="javascript:void(0)" class="text-danger remove-banner"><i
                                        class="fa fa-times-circle"></i></a>
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>

        <div class="text-right mt-5">
            <a href="javascript:void(0)" class="add-item">{{ trans_cms('cms::app.add_new_item') }}</a>
        </div>
    </div>
</div>

<template id="repeater-template">
    <li>
        <div class="row repeater-item">
            <div class="col-md-3">
                @component('cms::components.form_image', [
                    'label' => trans_cms('cms::app.thumbnail'),
                    'name' => 'repeater_images[]',
                ])
                @endcomponent
            </div>

            <div class="col-md-8">
                <div class="form-group">
                    <label class="form-label">{{ trans_cms('cms::app.title') }}</label>
                    <input type="text" class="form-control" name="repeater_titles[]" autocomplete="off"
                        value="">
                </div>

                <div class="form-group">
                    <label class="form-label">{{ trans_cms('cms::app.description') }}</label>
                    <textarea class="form-control" name="repeater_descriptions[]"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">{{ trans_cms('cms::app.link') }}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="repeater_links[]" autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"><input type="checkbox" class="link-new-tab"
                                    value="1"> {{ trans_cms('cms::app.open_new_tab') }}</span>
                            <input type="hidden" name="repeater_new_tabs[]" class="new-tab" value="0">
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon3"><input type="checkbox"
                                    class="link-button-link" value="1">
                                {{ trans_cms('cms::app.button_link') }}</span>
                            <input type="hidden" name="repeater_button_links[]" class="button-link" value="0">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>{{ trans_cms('cms::app.date') }}</label>
                        <input type="datetime-local" name="repeater_date[]" value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>

                </div>
            </div>

            <div class="col-md-1">
                <a href="javascript:void(0)" class="text-danger remove-banner">
                    <i class="fa fa-times-circle fa-2x"></i>
                </a>
            </div>
        </div>
    </li>
</template>

<script type="text/javascript">
    $("#repeater_items").sortable();

    $("#repeater_items").disableSelection();

    $("body").on('click', '.add-item', function() {
        let temp = document.getElementById('repeater-template').innerHTML;
        let length = $("#repeater_items li").length + 1;
        let newbanner = replace_template(temp, {
            'length': length
        });

        $("#repeater_items").append(newbanner);
        $('.load-media').filemanager('image', {
            prefix: '/admin-cp/file-manager'
        });
    });

    $("#repeater_items").on('click', '.remove-banner', function() {
        let item = $(this);
        Swal.fire({
            title: '',
            text: '{{ trans_cms('cms::app.are_you_sure_you_want_to_delete_this_item') }}',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '{{ trans_cms('cms::app.yes') }}',
            cancelButtonText: '{{ trans_cms('cms::app.cancel') }}',
        }).then((result) => {
            if (result.value) {
                item.closest('li').remove();
            }
        });
    });

    $("#repeater_items").on('change', '.link-new-tab', function() {
        if ($(this).is(':checked')) {
            $(this).closest('.input-group-append').find('.new-tab').val(1);
        } else {
            $(this).closest('.input-group-append').find('.new-tab').val(0);
        }
    });
</script>
