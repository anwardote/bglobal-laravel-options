@if(isset($request->_layout))
    @if($request->_layout=='custom')
        <div class="form-group">
            <textarea class="form-control tinymce"
                      name="custom_layout"
                      id="_custom_layout">{{ (isset($request->value[$request->_layout]))?$request->value[$request->_layout]:null }}</textarea>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="tabbable" id="tabs-185468">
                    <ul class="nav nav-tabs">
                        @for($i=0; $i <$request->_layout; $i++)

                            @if($i==0)
                                <li class="layout_active_tab active">
                            @else
                                <li>
                                    @endif
                                    <a href="#settings_panel_{{$i+1}}" style="height: inherit"

                                       data-toggle="tab">
                                        {{Config::get('option.header_footer_option')['level'] }} {{$i+1}}
                                    </a>
                                </li>
                                @endfor
                    </ul>
                    <div class="tab-content">
                        @for($j=0; $j<$request->_layout; $j++)
                            @if($j==0)
                                <div class="tab-pane active" id="settings_panel_{{$j+1}}">
                                    @else
                                        <div class="tab-pane" id="settings_panel_{{$j+1}}">
                                            @endif
                                            @php
                                                $number = $j+1;
                                                $name = 'col_section_'.$number;
                                            @endphp
                                            <textarea name="{{$name}}" class="form-control tinymce"
                                                      id="{{'setting_layouts_'.$number}}">{{$request->$name}}</textarea>
                                        </div>
                                        @endfor
                                </div>

                    </div>
                </div>
            </div>
            <br>
        </div>
    @endif
@endif
