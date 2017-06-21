<?php

namespace Bglobal\Options\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Bglobal\Options\Models\Option as Option;
use Validator, Illuminate\Support\Facades\Redirect;
use Config;

class OptionsController extends Controller
{
    protected $CreateRoute;
    protected $UpdateRoute;
    protected $ListView;
    protected $FormView;
    protected $UniqueKeyArr;
    protected $model;

    public function __construct()
    {

        $Model = Config('option.option_model_class', 'Bglobal\Options\Models\Option');
        $this->model=new $Model;
        $this->CreateRoute = 'admin.options.create';
        $this->UpdateRoute = 'admin.options.update';
        $this->ListRoute = 'admin.options.list';
        $this->ListView = 'admin.options.list';
        $this->FormView = 'admin.options.form';
        $this->UniqueKeyArr = $this->getunusedKeys();
    }

    public function getList(Request $request)
    {
        $Settings = $this->model->paginate(15);
        return view($this->ListView)->with(['settings' => $Settings, 'request' => $request]);
    }

    public function getcreate(Request $request)
    {
        return view($this->FormView)->with(['request' => $request, 'route' => $this->CreateRoute, 'KeyArr' => $this->UniqueKeyArr]);
    }


    /*Add New Settings*/
    public function postcreate(Request $request)
    {

        $Validation = Array();
        $Validation['key'] = 'required|unique:options|max:190';
        if (isset($request->key) && ($request->key == 'header' || $request->key == 'footer')) {
            $Validation['_layout'] = 'required';

        } else {
            $Validation['_value'] = 'required';
        }

        $this->validate($request, $Validation);

        $bglobalSettings = $this->model;

        try {
            if (isset($request->_layout)) {
                $value = $this->getSettingLayoutArray($request);
                $bglobalSettings->key = $request->key;
                $bglobalSettings->value = $value;
                $bglobalSettings->description = $request->description;
                $bglobalSettings->save();
            } else {

                $bglobalSettings->key = $request->key;
                $bglobalSettings->value = $request->_value;
                $bglobalSettings->description = $request->description;
                $bglobalSettings->save();
            }

        } catch (\Exception $e) {
            return Redirect::route($this->ListRoute)->withInput()->withErrors('Sorry something went worng. Please try again.');

        }

        return Redirect::route($this->ListRoute)->withMessage('The option added successfully.');
    }


    /*Add New Settings*/
    public function postupdate(Request $request)
    {

        $Validation = Array();
        if (isset($request->_layout)) {
            $Validation['_layout'] = 'required';

        } else {
            $Validation['_value'] = 'required';
        }
        $this->validate($request, $Validation);

        $bglobalSettings = $this->model->find($request->id);
        try {
            if (isset($request->_layout)) {
                $value = $this->getSettingLayoutArray($request);
//                $bglobalSettings->key = $request->key;
                $bglobalSettings->value = $value;
                $bglobalSettings->description = $request->description;
                $bglobalSettings->update();
            } else {
//                $bglobalSettings->key = $request->key;
                $bglobalSettings->value = $request->_value;
                $bglobalSettings->description = $request->description;
                $bglobalSettings->update();
            }

        } catch (\Exception $e) {
            return redirect()->route($this->UpdateRoute, ['id' => $request->id])->withInput()->withErrors('Sorry something went worng. Please try again.');
        }

        return Redirect::route($this->ListRoute)->withMessage('The option updated successfully.');
    }

    public function getupdate(Request $request)
    {

        try {
            $settings = $this->model->findorfail($request->id);
        } catch (\Exception $e) {
            return Redirect::route($this->ListRoute)->withInput()->withErrors('Sorry something went worng. Please try again.');
        }


        $_layoutObj = json_decode($settings->value, true);
        $_layout = '';
        if (isset($_layoutObj['custom'])) {
            $_layout = 'custom';
        } else {
            $_layout = count($_layoutObj);
        }

        $request->merge(array('_layout' => $_layout));
        $request->merge(array('key' => $settings->key));;
        $request->merge(array('value' => $settings->value));
        $request->merge(array('description' => $settings->description));;
        $request->merge(array('id' => $settings->id));;

        return view($this->FormView)->with(['settings' => $settings, 'request' => $request, 'route' => $this->UpdateRoute]);
    }

    /*Delete Settings*/
    public function getdelete(Request $request)
    {
        try {
            $settings = $this->model->findorfail($request->id);
            $settings->delete();
        } catch (\Exception $e) {
            return Redirect::route($this->ListRoute)->withInput()->withErrors('Sorry something went worng. Please try again.');
        }
        return Redirect::route($this->ListRoute)->withMessage('The option delete successfully.');
    }

    /*ajax requested method*/

    public function getlayout(Request $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            $settings = $this->model->findorfail($request->id);
            $request->merge(array('value' => json_decode($settings->value, true)));
            $_layoutObj = json_decode($settings->value, true);
            foreach ($_layoutObj as $key => $val) {
                $request->merge(array($key => $val));
            }

        }
        $info = view('admin.options._header_footer')
            ->with('request', $request)
            ->with('_time', time())->render();
        return $info;
    }

    public function getfield(Request $request)
    {
        if (isset($request->m)) {
            return view($this->FormView)->with(['request' => $request, 'route' => $this->UpdateRoute, 'KeyArr' => $this->UniqueKeyArr]);
        } else {

            return view($this->FormView)->with(['request' => $request, 'route' => $this->CreateRoute, 'KeyArr' => $this->UniqueKeyArr]);
        }
    }


    /*Private method*/
    private function getSettingLayoutArray($request)
    {
        $ValArr = array();
        if (isset($request->custom_layout)) {
            $ValArr['custom'] = $request->custom_layout;
        } else {
            for ($i = 1; $i <= $request->_layout; $i++) {
                $j = 'col_section_' . $i;
                $ValArr[$j] = $request->$j;
            }
        }
        return json_encode($ValArr);
    }

    private function getunusedKeys()
    {
        try{
        $dbKeysObj = $this->model->all(['key'])->toArray();
        $dbKeysArr = array_flip(array_column($dbKeysObj, 'key'));
        return array_diff_key(Config::get('option.keys'), $dbKeysArr);
        }catch (\Exception $exception){
            return null;
        }
    }


}
