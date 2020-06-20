<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompartmentCreateRequest;
use App\Http\Requests\CompartmentUpdateRequest;
use App\Repositories\CompartmentRepository;
use App\Repositories\LaboratoryRepository;
use App\Validators\CompartmentValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class CompartmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class CompartmentsController extends Controller
{
    /**
     * @var CompartmentRepository
     */
    protected $repository;

    /**
     * @var LaboratoryRepository
     */
    protected $laboratoryRepository;

    /**
     * CompartmentsController constructor.
     *
     * @param CompartmentRepository $repository
     * @param LaboratoryRepository $laboratoryRepository
     */
    public function __construct(CompartmentRepository $repository, LaboratoryRepository $laboratoryRepository)
    {
        $this->repository = $repository;
        $this->laboratoryRepository = $laboratoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $compartments = $this->repository->with('laboratory')->all();
        $laboratories = $this->laboratoryRepository->all();
        return view('pages.manager.pages.compartments',
            ['compartments' => $compartments, 'laboratories' => $laboratories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompartmentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CompartmentCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $compartment = $this->repository->create($request->all());

            $response = [
                'message' => 'Compartment created.',
                'data' => $compartment->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
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
        $compartment = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $compartment,
            ]);
        }

        return view('compartments.show', compact('compartment'));
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
        $compartment = $this->repository->find($id);

        return view('compartments.edit', compact('compartment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompartmentUpdateRequest $request
     * @param string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CompartmentUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $compartment = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Compartment updated.',
                'data' => $compartment->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error' => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Compartment deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Compartment deleted.');
    }
}
