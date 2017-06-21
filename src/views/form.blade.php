@extends(Config('option.base_layout', 'admin.options.base'))

@section('title')
    {!! Config::get('option.option_level.title') !!}: {!! isset($request->id)? 'Update' : 'Create' !!} {!! Config::get('option.option_level.level') !!}
@stop

@section('content')

    <div class="row global_settings">
        <div class="col-md-12">

            @if( isset($message) )
                <div class="alert alert-success">{!! $message !!}</div>
            @endif
            @if($errors->has('model') )
                <div class="alert alert-danger">{!! $errors->first('model') !!}</div>
            @endif
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="panel-title bariol-bold"><i class="fa fa-cog fa-fw"></i> {!! isset($request->id)? 'Update' : 'Create' !!} {!! Config::get('option.option_level.level') !!} </h3>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-12 col-xs-12">
                        {!! Form::open(
                                                array(
                                                'route' => $route,
                                                'class' => '',
                                                'files' => true)) !!}

                        <div class="form-group">
                            {!! Form::label('key','Settings Key: ') !!} <span class="text-danger text-bold">*</span>
                            @if(isset($request->id) && !empty($request->id))
                            {!! Form::select('key', Config::get('option.keys'), $request->key, [ 'class' => 'form-control', 'placeholder' => 'Select One', 'disabled'=>'disabled']) !!}
                                @else
                            {!! Form::select('key', $KeyArr, $request->key, [ 'class' => 'form-control', 'placeholder' => 'Select One']) !!}
                                @endif
                            <span class="text-danger" id="key_error">{!! $errors->first('key') !!}</span>
                        </div>
                        @if(isset($request->key) && ($request->key=='header' || $request->key=='footer' ))
                            <div class="form-group">
                                {!! Form::label('_layout','Layout : ') !!} <span class="text-danger text-bold">*</span>
                                {!! Form::select('_layout', Config::get('option.layout'), $request->_layout, [ 'class' => 'form-control', 'placeholder' => 'Select Layout', 'id'=>'select_settings_layout']) !!}
                                <span class="text-danger" id="_layout_error">{!! $errors->first('_layout') !!}</span>
                            </div>
                            <div id="_header_footer"></div>
                        @else
                            @include('admin.options._value')
                        @endif
                        <div class="form-group">
                            {!! Form::label('description','Description : ') !!}
                            {!! Form::textarea('description', $request->description, [ 'class' => 'form-control', 'placeholder' => 'Hin\'s description here.']) !!}
                            <span class="text-danger">{!! $errors->first('description') !!}</span>
                        </div>

                        <div class="alert alert-success pull-left success-added hidden">
                            <strong>Success! </strong>The settting added successfully.
                        </div>
                        <div class="alert alert-success pull-left success-updated hidden">
                            <strong>Success! </strong>The settting updated successfully.
                        </div>
                        <input type="hidden" name="id" id="_id" value="{{isset($request->id)?$request->id:''}}"/>
                        {!! Form::submit('Save', array("class"=>"btn btn-info pull-right", 'id'=>'submitbtn')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('footer_scripts')
    <script>
        $(".delete").click(function () {
            return confirm("Are you sure to delete this item?");
        });


        tinymce.init({
            selector: "textarea.tinymce",
            skin: "dick-light",
            plugins: "image,link,media,anchor,code",
            file_browser_callback: elFinderBrowser,
        });

        function elFinderBrowser(field_name, url, type, win) {
            tinymce.activeEditor.windowManager.                        open({
                file: '{{ url(config('backpack.base.route_prefix').'/elfinder/tinymce4') }}',// use an absolute path!
                title: 'elFinder 2.0',
                width: 900,
                height: 450,
                resizable: 'yes'
            }, {
                setUrl: function (url) {
                    win.document.getElementById(field_name).value = url;
                }
            });
            return false;
        }


        $(document).ready(function (e) {
            function load_layout() {
                var form = $('.global_settings form');
                $.ajax({
                    url: "{{URL('/').'/admin/options/layout'}}",
                    type: 'POST',
                    data: form.serialize(),
                    success: function (json) {
                        $("#_header_footer").html(json);
                        inisializeTinymce();

                    },
                    error: function (xhr, status, response) {
                        var error = jQuery.parseJSON(xhr.responseText);  // this section is key player in getting the value of the errors from controller.
                    }
                })
            }


            load_layout();
            $(document).on('change, click', '.global_settings #select_settings_layout', function (e) {
                load_layout();
            })

            $(document).on('click, change', '.global_settings #key', function (e) {
                e.preventDefault();
                var form = $('.global_settings form');
                var key = form.find("#key").val();
                var _id = form.find("#_id").val();
                var route;
                if(_id){
                    var route ="{{URL('/').'/admin/options/field'}}?m=u&key=" + key;
                }   else{
                    var route ="{{URL('/').'/admin/options/field'}}?key=" + key;
                }
                window.location.href = route;
            })
            /*inisitalize tinymce*/
            function inisializeTinymce() {
                tinyMCE.execCommand('mceRemoveEditor', false, 'setting_layouts_1');
                tinyMCE.execCommand('mceRemoveEditor', false, 'setting_layouts_2');
                tinyMCE.execCommand('mceRemoveEditor', false, 'setting_layouts_3');
                tinyMCE.execCommand('mceRemoveEditor', false, 'setting_layouts_4');
                tinyMCE.execCommand('mceRemoveEditor', false, 'setting_layouts_5');
                tinyMCE.execCommand('mceRemoveEditor', false, 'setting_layouts_6');
                tinyMCE.execCommand('mceRemoveEditor', false, '_custom_layout');
                tinymce.init({
                    selector: ".tinymce",
                    skin: "dick-light",
                    plugins: "image,link,media,anchor,code",
                    file_browser_callback: elFinderBrowser,
                });
            }
        })
    </script>
@stop