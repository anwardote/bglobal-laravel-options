<div class="form-group">
    {!! Form::label('_value','Value : ') !!} <span class="text-danger text-bold">*</span>
    {!! Form::text('_value', $request->value, [ 'class' => 'form-control', 'placeholder' => 'Value There']) !!}
    <span class="text-danger">{!! $errors->first('_value') !!}</span>
</div>
