<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\LecturerCreateRequest;
use App\Http\Requests\LecturerUpdateRequest;
use App\Repositories\LecturerRepository;
use App\Validators\LecturerValidator;

/**
 * Class LecturersController.
 *
 * @package namespace App\Http\Controllers;
 */
class LecturersController extends Controller
{
    /**
     * @var LecturerRepository
     */
    protected $repository;

    /**
     * @var LecturerValidator
     */
    protected $validator;

    /**
     * LecturersController constructor.
     *
     * @param LecturerRepository $repository
     * @param LecturerValidator $validator
     */
    public function __construct(LecturerRepository $repository, LecturerValidator $validator)
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
        $lecturers = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $lecturers,
            ]);
        }

        return view('lecturers.index', compact('lecturers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LecturerCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(LecturerCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $lecturer = $this->repository->create($request->all());

            $response = [
                'message' => 'Lecturer created.',
                'data'    => $lecturer->toArray(),
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
        $lecturer = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $lecturer,
            ]);
        }

        return view('lecturers.show', compact('lecturer'));
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
        $lecturer = $this->repository->find($id);

        return view('lecturers.edit', compact('lecturer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LecturerUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(LecturerUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $lecturer = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Lecturer updated.',
                'data'    => $lecturer->toArray(),
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
                'message' => 'Lecturer deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Lecturer deleted.');
    }
}
