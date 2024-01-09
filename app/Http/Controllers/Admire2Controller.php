<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use View;
use Artisan;
use Str;

class Admire2Controller extends Controller
{

    public function showView($name = null)
    {
        if (is_null($name)) {
            return view('datatables');
        }
        if(View::exists($name)){
            return view($name);
        }
        else{
            return view('404');
        }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users');
    }

    /**
     * CRUD BUILDER
     * Check for folder permissions and return view
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function builder()
    {
        //check for permissions
        $permissions['models'] = is_writable(app_path(''));
        $permissions['controllers'] = is_writable(app_path('Http/Controllers'));
        $permissions['requests'] = is_writable(app_path('Http/Requests'));
        $permissions['views'] = is_writable(resource_path('views'));
        $permissions['migrations'] = is_writable(database_path('migrations'));
        $permissions['routes'] = is_writable(base_path('routes/web_builder.php'));
        $permissions['menu'] = is_writable(resource_path('views/layouts/menu.blade.php'));

        //check for pending migrations
        $pendingMigrations = $this->checkMigrations();

        return view(config('infyom.generator_builder.views.builder'), compact('permissions','pendingMigrations'));
    }

    public function checkMigrations(): bool
    {
        Artisan::call('migrate:status');
        $output = Artisan::output();
        if (Str::contains(trim($output), 'No migrations')) {
            return true;
        }
        $output = collect(explode("\n", $output));
        $output = $output->reject(function ($item) {
            return !Str::contains($item, '| N');
        });
        $count = $output->count() !== 0;
        if ($count) {
            return false;
        }
        return true;
    }

    public function modelCheck(Request $request)
    {
        $modelname = $request->modelName;
        $directory = app_path('Models/');
        $list = File::directories($directory);
        $filename = app_path('Models/'.$modelname.'.php');
        $filename1 = app_path($modelname.'.php');
        if (count($list) > 0) {
            $val = 0;
            foreach ($list as $folder) {
                $filename2 = $folder.'/'.$modelname.'.php';
                if (file_exists($filename) || file_exists($filename1) || file_exists($filename2)) {
                    $val++;
                }
            }
            if ($val>0) {
                return [
                    'status'=>false,
                    'message'=>'Model name already exists'
                ];
            } else {
                return [
                    'status'=>true,
                    'message'=>'success'
                ];
            }
        } else {
            if (file_exists($filename) || file_exists($filename1)) {
                return [
                    'status'=>false,
                    'message'=>'Model name already exists'
                ];
            } else {
                return [
                    'status'=>true,
                    'message'=>'success'
                ];
            }
        }
    }
}
