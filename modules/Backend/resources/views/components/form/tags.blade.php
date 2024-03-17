<div class="form-group form-taxonomy">
    <label class="col-form-label w-100">
        {{ $taxonomy->get('label') }}
        <span>
            <a href="javascript:void(0)" class="float-right add-new">
                <i class="fa fa-plus"></i> {{ trans_cms('cms::app.add_new') }}
            </a>
        </span>
    </label>

    <select class="form-control load-taxonomies select-tags"
            data-placeholder="--- {{ $taxonomy->get('label') }} ---"
            data-post-type="{{ $taxonomy->get('post_type') }}"
            data-type="{{ $taxonomy->get('type') }}"
            data-taxonomy="{{ $taxonomy->get('taxonomy') }}"
            data-explodes="{{ $taxonomy->get('taxonomy') }}-explode">
    </select>

    <div class="show-tags mt-2">
        @php
            $items = $model->taxonomies()
                ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
                ->get();
        @endphp

        @foreach($items as $item)
            @component('cms::components.tag-item', [
                'name' => $taxonomy->get('taxonomy'),
                'item' => $item
            ])
            @endcomponent
        @endforeach
    </div>

    <div class="form-add mt-2 form-add-taxonomy box-hidden">
        <input type="hidden" id="tag-lang" name="lang" value="en"/>

        <div class="form-group mb-1">
            <label class="col-form-label">{{ trans_cms('cms::app.name') }}</label>
            <input type="text" class="form-control taxonomy-name" autocomplete="off">
        </div>

        @if(in_array('hierarchical', $taxonomy->get('supports', [])))
            <div class="form-group mb-1">
                <label class="col-form-label">{{ trans_cms('cms::app.parent') }}</label>
                <select type="text" class="form-control taxonomy-parent load-taxonomies" autocomplete="off" data-post-type="{{ $taxonomy->get('post_type') }}" data-taxonomy="{{ $taxonomy->get('taxonomy') }}">
                </select>
            </div>
        @endif

        <button
            type="button"
            class="btn btn-primary mt-2"
            data-type="{{ $taxonomy->get('type') }}"
            data-post_type="{{ $taxonomy->get('post_type') }}"
            data-taxonomy="{{ $taxonomy->get('taxonomy') }}"
        ><i class="fa fa-plus-circle"></i> {{ trans_cms('cms::app.add') }}</button>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#tag-lang").val($(".lang-switch").val());
    });

</script>