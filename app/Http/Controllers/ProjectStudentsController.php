<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\ProjectStudentCreateRequest;
use App\Http\Requests\ProjectStudentUpdateRequest;
use App\Repositories\ProjectStudentRepository;
use App\Validators\ProjectStudentValidator;

/**
 * Class ProjectStudentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProjectStudentsController extends Controller
{
    /**
     * @var ProjectStudentRepository
     */
    protected $repository;

    /**
     * @var ProjectStudentValidator
     */
    protected $validator;

    /**
     * ProjectStudentsController constructor.
     *
     * @param ProjectStudentRepository $repository
     * @param ProjectStudentValidator $validator
     */
    public function __construct(ProjectStudentRepository $repository, ProjectStudentValidator $validator)
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
        $projectStudents = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $projectStudents,
            ]);
        }

        return view('projectStudents.index', compact('projectStudents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProjectStudentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ProjectStudentCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $projectStudent = $this->repository->create($request->all());

            $response = [
                'message' => 'ProjectStudent created.',
                'data'    => $projectStudent->toArray(),
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
        $projectStudent = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $projectStudent,
            ]);
        }

        return view('projectStudents.show', compact('projectStudent'));
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
        $projectStudent = $this->repository->find($id);

        return view('projectStudents.edit', compact('projectStudent'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProjectStudentUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProjectStudentUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $projectStudent = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'ProjectStudent updated.',
                'data'    => $projectStudent->toArray(),
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
                'message' => 'ProjectStudent deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'ProjectStudent deleted.');
    }
}
