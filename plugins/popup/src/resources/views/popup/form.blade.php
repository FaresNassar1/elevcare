<div class="row">
    <div class="col-md-12">
        <ul id="banners" class="mt-5 p-0">
            @if($banners = $model->getMeta('content'))
                @php
                    $banners = json_decode($banners, true);
                @endphp
                @foreach($banners as $index => $banner)
                    @php
                        $banner = (object) $banner;
                    @endphp
                    <li>
                        <div class="row banner-item">
                            <div class="col-md-3">
                                @component('cms::components.form_image', [
                                    'label' => trans_cms('juim::content.banner'),
                                    'name' => 'images[]',
                                    'value' => $banner->image ?? ''
                                ])@endcomponent
                            </div>

                            <div class="col-md-8">
                              
                                <div class="form-group">
                                    <label class="form-label">{{ trans_cms('cms::app.link') }}</label>
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="links[]" autocomplete="off" value="{{ @$banner->link }}">
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="basic-addon2"><input type="checkbox" name="new_tabs[]" value="1" @if(@$banner->new_tab == 1) checked @endif> {{ trans_cms('cms::app.open_new_tab') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>

   
    </div>
</div>

<template id="banner-template">
    <li>
        <div class="row banner-item">
            <div class="col-md-3">
                @component('cms::components.form_image', [
                    'label' => trans_cms('juim::content.banner'),
                    'name' => 'images[]'
                ])@endcomponent
            </div>

            <div class="col-md-8">
               
                <div class="form-group">
                    <label class="form-label">{{ trans_cms('cms::app.link') }}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="links[]" autocomplete="off">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2"><input type="checkbox" class="link-new-tab" value="1"> {{ trans_cms('cms::app.open_new_tab') }}</span>
                            <input type="hidden" name="new_tabs[]" class="new-tab" value="0">
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </li>
</template>

<script type="text/javascript">

if($(".banner-item").length == 0){
        let temp = document.getElementById('banner-template').innerHTML;
        let length = $("#banners li").length + 1;
        let newbanner = replace_template(temp, {
            'length': length
        });

        $("#banners").append(newbanner);
        $('.load-media').filemanager('image', {prefix: '/admin-cp/file-manager'});
}
    $("#banners").on('change', '.link-new-tab', function () {
        if ($(this).is(':checked')) {
            $(this).closest('.input-group-append').find('.new-tab').val(1);
        }
        else {
            $(this).closest('.input-group-append').find('.new-tab').val(0);
        }
    });
</script>

