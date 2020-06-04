<?php

namespace App\Http\Controllers;

use App\Http\Requests\LecturerCreateRequest;
use App\Http\Requests\LecturerUpdateRequest;
use App\Repositories\LecturerRepository;
use App\Repositories\SubjectRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

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
     * @var SubjectRepository
     */
    protected $subjectRepository;

    /**
     * LecturersController constructor.
     *
     * @param LecturerRepository $repository
     * @param SubjectRepository $subjectRepository
     */
    public function __construct(LecturerRepository $repository, SubjectRepository $subjectRepository)
    {
        $this->repository = $repository;
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $lecturers = $this->repository->all();
        $subjects = $this->subjectRepository->all();
        return view('pages.manager.pages.lecturers', compact('lecturers', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LecturerCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function store(LecturerCreateRequest $request)
    {
        try {
            $this->repository->createLecturer($request->only('name', 'email', 'subject'));
            session()->flash('lecturer_create_success', trans('messages.create.success'));
            return response()->json([
                'error' => false
            ]);
        } catch (\Exception $e) {
            session()->flash('lecturer_create_fail', trans('messages.create.fail'));
            return response()->json([
                'error' => false,
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
     * @param int $id
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
     * @param LecturerUpdateRequest $request
     * @param string $id
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
                'data' => $lecturer->toArray(),
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
                'message' => 'Lecturer deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Lecturer deleted.');
    }
}
