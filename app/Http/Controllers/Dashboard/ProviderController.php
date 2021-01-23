<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Nationality;
use App\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{

    public function index(Request $request)
    {
        if($request->ajax()) {
            $providers = Provider::get();
            return response()->json($providers);
        }
        return  view('dashboard.providers.index');
    }


    public function create()
    {
        return  view('dashboard.providers.create');
    }


    public function store(Request $request)
    {

        Provider::create($this->validator($request));
        return redirect(route('dashboard.providers.index'));
    }


    public function show(Provider $provider)
    {
        //
    }


    public function edit(Provider $provider)
    {
        return  view('dashboard.providers.edit',compact('provider'));

    }


    public function update(Request $request, Provider $provider)
    {
        $provider->update($this->validator($request, $provider->id));
        return redirect(route('dashboard.providers.index'));
    }


    public function destroy(Provider $provider)
    {
        //
    }
    public function validator(Request $request, $id = null)
    {
        $rules = Provider::$rules;
        if($id){
            $rules['email'] = ($rules['email'] . ',email,' . $id);
        }
        return $request->validate($rules);
    }
}
