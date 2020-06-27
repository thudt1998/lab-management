<?php

namespace App\Http\Controllers;

use App\Entities\Project;
use App\Entities\Student;
use App\Entities\Topic;
use App\Events\SendPassword;
use App\Http\Requests\LecturerCreateRequest;
use App\Http\Requests\LecturerUpdateRequest;
use App\Repositories\LecturerRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $lecturers = $this->repository->getListLecturers($request->all());
        $subjects = $this->subjectRepository->all();
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $lecturers,
            ]);
        }
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
     */
    public function update(LecturerUpdateRequest $request, $id)
    {
        try {

        } catch (ValidatorException $e) {

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

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInfoLaboratories()
    {
        try {
            $students = Student::all()->count();
            $topics = Topic::all()->count();
            $projects = Project::all()->count();
            return response()->json([
                'students' => $students,
                'topics' => $topics,
                'projects' => $projects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgotPassword(Request $request)
    {
        try {
            $password = Str::random(8);
            $lecturer = $this->repository->findWhere(['email' => $request->get('email')])->first();
            $this->repository->update(['password' => Hash::make($password)], $lecturer->id);
            event(new SendPassword($request->get('email'), $password));
            return response()->json([
                'error' => false,
                'message' => trans('messages.update.password.success')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => trans('messages.update.password.fail')
            ]);
        }
    }
}
