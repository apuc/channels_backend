<?php

namespace App\Http\Controllers\Admin\Channels;

use App\Http\Requests\Channels\IntegrationTypeRequest;
use App\Models\Channels\IntegrationType;
use App\Services\Channels\IntegrationTypesService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntegrationTypesController extends Controller
{
    /**
     * @var IntegrationTypesService
     */
    protected $integrationTypeService;

    public function __construct(IntegrationTypesService $service)
    {
        $this->integrationTypeService = $service;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $types = IntegrationType::paginate(15);


        return view('admin.integration-types.index', compact('types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.integration-types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  IntegrationTypeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IntegrationTypeRequest $request)
    {
       try{
            $integrationType = $this->integrationTypeService->create($request);

            return redirect(route('integration-types.show',$integrationType))
                ->with(['success' => 'Успешно создано']);
       }catch (\Throwable $exception){
//           return back()->with(['error' => $exception->getMessage()]);
           return $exception->getMessage();
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Channels\IntegrationType  $integrationType
     * @return \Illuminate\Http\Response
     */
    public function show(IntegrationType $integrationType)
    {
        return view('admin.integration-types.show')->with(['type' => $integrationType]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int Integration Type ID
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = IntegrationType::find($id);

        return view('admin.integration-types.edit', compact('type'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  IntegrationTypeRequest $request
     * @param  int Integration Type ID
     * @return \Illuminate\Http\Response
     */
    public function update(IntegrationTypeRequest $request, $id)
    {
        try {
            $integrationType = IntegrationType::find($id);
            $type = $this->integrationTypeService->update($request, $integrationType);

            return redirect(route('integration-types.show', compact('type')))
                ->with(['warning' => 'Изменено!']);
        }catch (\Throwable $ex){
            return back()->with(['error' => $ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id IntegrationType ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $integrationType = IntegrationType::find($id);
            $this->integrationTypeService->destroy($integrationType);

            return redirect(route('integration-types.index'))->with(['info' => 'Тип удален успешно!']);
        }catch (\Throwable $ex){
            return back()->with(['error' => $ex->getMessage()]);
        }
    }
}
