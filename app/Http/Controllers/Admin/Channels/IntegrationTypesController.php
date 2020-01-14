<?php

namespace App\Http\Controllers\Admin\Channels;

use App\Http\Requests\Channels\IntegrationTypeRequest;
use App\Models\Integrations\IntegrationType;
use App\Repositories\Integrations\IntegrationTypeRepository;
use App\Services\Integrations\IntegrationTypesService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IntegrationTypesController extends Controller
{
    /**
     * @var IntegrationTypesService
     */
    protected $integrationTypeService;

    /**
     * @var IntegrationTypeRepository
     */
    protected $integrationTypeRepository;

    /**
     * IntegrationTypesController constructor.
     * @param IntegrationTypesService $service
     * @param IntegrationTypeRepository $repository
     */
    public function __construct(IntegrationTypesService $service,IntegrationTypeRepository $repository)
    {
        $this->integrationTypeService = $service;
        $this->integrationTypeRepository = $repository;
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
           return $exception->getMessage();
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  IntegrationType  $integrationType
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $integrationType = $this->integrationTypeRepository->findById($id);

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
        $integrationType = $this->integrationTypeRepository->findById($id);

        return view('admin.integration-types.edit', ['type'=>$integrationType]);
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
            $integrationType = $this->integrationTypeRepository->findById($id);
            $type = $this->integrationTypeService->update($request, $integrationType);

            return redirect(route('integration-types.show', $type->id))
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
            $integrationType = $this->integrationTypeRepository->findById($id);
            $this->integrationTypeService->destroy($integrationType);

            return redirect(route('integration-types.index'))->with(['info' => 'Тип удален успешно!']);
        }catch (\Throwable $ex){
            return back()->with(['error' => $ex->getMessage()]);
        }
    }
}
