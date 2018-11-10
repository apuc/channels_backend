<?php

namespace App\Http\Controllers\Admin;

use App\Extensions\Models\ServiceAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class ServiceAuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = ServiceAuth::paginate(20);


        return view('admin.service-auth.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.service-auth.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Validator::make($request->all(), [
            'id' => 'required|string|max:255|unique:service_auth,service_id'
        ])->validate();

        $service = new ServiceAuth();
        $service->service_id = $request->id;
        $service->access_token = bcrypt(Str::random());
        $service->status = 1;

        $service->save();

        return redirect(route('service.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = ServiceAuth::findOrFail($id);

        return view('admin.service-auth.show', compact('service'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = ServiceAuth::findOrFail($id);

        $service->delete();

        return redirect(route('service.index'));
    }
}
