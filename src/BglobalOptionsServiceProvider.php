<?php

namespace Bglobal\Options;

use Route;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Bglobal\Options\Http\Helpers\options_helper;
use Bglobal\Options\Models\Option;
use Illuminate\Support\Facades\Config;

class BglobalOptionsServiceProvider extends ServiceProvider
{

    protected $OptionControllerClass = 'Bglobal\Options\Controllers\OptionsController';
    protected $ModelClass = 'Bglobal\Options\Models\Option';
    protected $routePrfix = 'admin/options';
    protected $middleware = 'web';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views/admin', 'options');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/admin/options'),
        ]);
        // publish migrations
        $this->publishes([__DIR__.'/database/migrations' => database_path('migrations')], 'migrations');

        // public config
        $this->publishes([__DIR__.'/config/option.php' => config_path('option.php')]);

        /*Bglobal*/
        try{
            $ModelNamespace = Config('option.option_model_class', $this->ModelClass);
            $model = new $ModelNamespace;
            $settings = $model->all();
            foreach ($settings as $key => $setting) {
                Config::set('option.' . $setting->key, $setting->value);
            }
            $headerhtml =options_helper::getHFHtml(json_decode(Config::get('option.header'), true));
            $footerhtml =options_helper::getHFHtml(json_decode(Config::get('option.footer'), true));
            Config::set('option.headerhtml', $headerhtml);
            Config::set('option.footerhtml', $footerhtml);
        }catch (\Exception $e){

        }

    }


    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {

        $routePrefix = Config('option.route_prefix', $this->routePrfix);
        Route::group(['prefix' => $routePrefix, 'middleware'=>$this->middleware], function()
        {
            $controller = config('option.option_controller_class', $this->OptionControllerClass);

            Route::get('/list', [
                'as' => 'admin.options.list',
                'uses' => $controller.'@getList']);
            /*create*/
            Route::get('/create', [
                'as' => 'admin.options.create',
                'uses' => $controller.'@getcreate']);

            Route::post('/create', [
                'as' => 'admin.options.create',
                'uses' =>  $controller.'@postcreate']);
            /*update*/
            Route::get('/update', [
                'as' => 'admin.options.update',
                'uses' =>  $controller.'@getupdate']);

            Route::post('/update', [
                'as' => 'admin.options.update',
                'uses' =>  $controller.'@postupdate']);

            Route::post('/layout', [
                'as' => 'admin.options.layout',
                'uses' =>  $controller.'@getlayout']);

            Route::get('/field', [
                'as' => 'admin.options.field',
                'uses' =>  $controller.'@getfield']);

            Route::get('/delete/{id}', [
                'as' => 'admin.options.delete',
                'uses' =>  $controller.'@getdelete']);
        });

    }




    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
         $this->setupRoutes($this->app->router);
    }
}
