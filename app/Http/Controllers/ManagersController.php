<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ManagerCreateRequest;
use App\Http\Requests\ManagerUpdateRequest;
use App\Repositories\ManagerRepository;
use App\Validators\ManagerValidator;

/**
 * Class ManagersController.
 *
 * @package namespace App\Http\Controllers;
 */
class ManagersController extends Controller
{
    /**
     * @var ManagerRepository
     */
    protected $repository;

    /**
     * @var ManagerValidator
     */
    protected $validator;

    /**
     * ManagersController constructor.
     *
     * @param ManagerRepository $repository
     * @param ManagerValidator $validator
     */
    public function __construct(ManagerRepository $repository, ManagerValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $managers = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $managers,
            ]);
        }

        return view('managers.index', compact('managers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ManagerCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ManagerCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $manager = $this->repository->create($request->all());

            $response = [
                'message' => 'Manager created.',
                'data'    => $manager->toArray(),
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
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $manager = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $manager,
            ]);
        }

        return view('managers.show', compact('manager'));
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
        $manager = $this->repository->find($id);

        return view('managers.edit', compact('manager'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ManagerUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ManagerUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $manager = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Manager updated.',
                'data'    => $manager->toArray(),
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
                'message' => 'Manager deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Manager deleted.');
    }
}
