{{-- THUMB --}}
{{--dd($thumb)--}}
<div class="thumb thumb_{{$row}}">
    <div class="image_holder">
        <a href="javascript:void(0);" class="btnCrop" title="{{$thumb['filename']}}"
             data-id="{{$thumb['id']}}"
             data-filename="{{$thumb['filename']}}"
             data-image_template="{{$thumb['image_template']}}"
             data-field="{{$field}}"
             data-dialog="crop">
            <img src="/storage/uploads/{{$thumb['image_template']}}/thumb/{{$thumb['filename']}}" alt="{{$thumb['filename']}}">
        </a>
        <div class="button_holder">
            <button title="{{Lang::get('images.Delete this image')}}" type="button"
             data-field="{{$field}}"
             data-id="{{$thumb['id']}}"
             data-url="/admin/images/{{$thumb['id']}}"
             data-filename="{{$thumb['filename']}}"
             data-module="images"
             data-dialog="image_delete"
             class="btnImageDelete row_btn">
                <div class="far fa-trash-alt"></div>
            </button>
        </div>
    </div>
    {!! Form::hidden($field."[id][".$row."]", $thumb['id']) !!}
    {!! Form::hidden($field."[field][".$row."]", $field) !!}
    {!! Form::hidden($field."[filename][".$row."]", $thumb['filename']) !!}
    {!! Form::hidden($field."[image_template][".$row."]", $thumb['image_template']) !!}
    {{-- Form::hidden($field."[filesize][".$row."]", $thumb['filesize']) !!--}}
</div>






