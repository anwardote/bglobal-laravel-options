@extends(Config('option.base_layout', 'admin.options.base'))

@section('title')
    {!! Config::get('option.option_level.title') !!}: {!! Config::get('option.option_level.level') !!} list
@stop

@section('content')
<div class="row">
        <div class="col-md-12">
            {{-- print messages --}}
            <?php
            $message = Session::get('message');
            //$authentication = App::make('authenticator');
            //$u = $authentication->getLoggedUser();
            ?>
            @if( isset($message) )
            <div class="alert alert-success">{!! $message !!}</div>
            @endif
            {{-- print errors --}}
            @if($errors && ! $errors->isEmpty() )
            @foreach($errors->all() as $error)
            <div class="alert alert-danger">{!! $error !!}</div>
            @endforeach
            @endif
            {{-- user lists --}}
            @include('admin.options.table')
        </div>
        {{-- <div class="col-md-3">
            @include('laravel-authentication-acl::admin.user.search')
        </div>--}}

</div>
@stop

@section('footer_scripts')
<script>
    $(".delete").click(function () {
        return confirm("Are you sure to delete this item?");
    });
</script>
@stop