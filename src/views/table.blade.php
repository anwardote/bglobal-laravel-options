<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title bariol-bold"><i class="fa fa-cog fa-fw"></i> {!! Config::get('option.option_level.level') !!} List</h3>
    </div>
    <div class="panel-body">
        <div class="col-md-12">
            <a href="{!! URL::route('admin.options.create') !!}" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Add New</a>
        </div>
        <div class="row">
            <div class="col-md-12">
                @if(! $settings->isEmpty() )
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Keys</th>
                            <th>Values</th>
                            <th>Description</th>
                            <th>Operations</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($settings as $setting)
                            <tr>
                                <td>{!! $setting->key !!}</td>
                                <td>
                                    @if($setting->key ==='header' || $setting->key ==='footer')
                                        Can't be displayed
                                    @else
                                        {!! $setting->value !!}
                                    @endif
                                </td>
                                <td>
                                    {!! $setting->description !!}
                                </td>
                                <td>
                                    <a href="{!! URL::route('admin.options.update', ['id' => $setting->id]) !!}"><i
                                                class="fa fa-pencil-square-o fa-2x"></i></a>
                                    <a href="{!! URL::route('admin.options.delete',['id' => $setting->id]) !!}"
                                       class="margin-left-5 delete"><i class="fa fa-trash-o fa-2x"></i></a>
                                </td>
                            </tr>

                        </tbody>
                        @endforeach
                    </table>
                    <div class="paginator">
                        {!! $settings->appends($request->except(['page']) )->render() !!}
                    </div>
                @else
                    <span class="text-warning"><h5>No results found.</h5></span>
                @endif
            </div>
        </div>
    </div>
</div>
