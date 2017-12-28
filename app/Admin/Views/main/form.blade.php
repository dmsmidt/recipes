
@if(isset($form->error))
<div class="error_msg">{{ $form['error'] }}</div>
@else
{!! Form::open(["method" => $form->method, "url" => $form->url ]) !!}
    @foreach($form->formfields as $name => $row)
        {!! $row['field'] !!}
    @endforeach
{!! Form::close() !!}
@endif
