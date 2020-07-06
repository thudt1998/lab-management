<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaboratoryCreateRequest;
use App\Http\Requests\LaboratoryUpdateRequest;
use App\Repositories\LaboratoryRepository;

/**
 * Class LaboratoriesController.
 *
 * @package namespace App\Http\Controllers;
 */
class LaboratoriesController extends Controller
{
    /**
     * @var LaboratoryRepository
     */
    protected $repository;

    /**
     * LaboratoriesController constructor.
     *
     * @param LaboratoryRepository $repository
     */
    public function __construct(LaboratoryRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $laboratories = $this->repository->paginate(10);
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $laboratories,
            ]);
        }
        return view('pages.manager.pages.laboratories', compact('laboratories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LaboratoryCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LaboratoryCreateRequest $request)
    {
        try {
            $this->repository->create($request->only('name', 'location'));
            session()->flash('laboratory_create_success', trans('messages.create.success'));
            return response()->json([
                'error' => false
            ]);
        } catch (\Exception $e) {
            session()->flash('laboratory_create_fail', trans('messages.create.fail'));
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $laboratory = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $laboratory,
            ]);
        }

        return view('laboratories.show', compact('laboratory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $laboratory = $this->repository->find($id);

        return view('laboratories.edit', compact('laboratory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LaboratoryUpdateRequest $request
     * @param string $id
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(LaboratoryUpdateRequest $request, $id)
    {
        try {
            $this->repository->update($request->only('name', 'location'), $id);
            session()->flash('laboratory_update_success', trans('messages.update.success'));
            return response()->json([
                'error' => false
            ]);
        } catch (\Exception $e) {
            session()->flash('laboratory_update_fail', trans('messages.update.fail'));
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
            session()->flash('laboratory_delete_success', trans('messages.update.success'));
            return response()->json([
                'error' => false
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
