<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LaboratoryCreateRequest;
use App\Http\Requests\LaboratoryUpdateRequest;
use App\Repositories\LaboratoryRepository;
use App\Validators\LaboratoryValidator;

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
        $laboratories = $this->repository->all();
        return view('pages.manager.pages.laboratories', compact('laboratories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LaboratoryCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(LaboratoryCreateRequest $request)
    {
        try {
            $this->repository->create($request->only('name','location'));
            session()->flash('laboratory_create_success', trans('messages.create.success'));
            return response()->json([
                'error' => false
            ]);
        } catch (\Exception $e) {
            session()->flash('laboratory_create_fail', trans('messages.create.fail'));
            return response()->json([
                'error' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
     * @param  int $id
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
     * @param  LaboratoryUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(LaboratoryUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $laboratory = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Laboratory updated.',
                'data'    => $laboratory->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Laboratory deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Laboratory deleted.');
    }
}
