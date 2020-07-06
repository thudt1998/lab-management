<?php

namespace App\Http\Controllers;

use App\Entities\Lecturer;
use App\Entities\Project;
use App\Entities\Subject;
use App\Entities\Topic;
use App\Http\Requests\StudentCreateRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Repositories\LecturerRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\StudentRepository;
use Illuminate\Http\Request;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class StudentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class StudentsController extends Controller
{
    /**
     * @var StudentRepository
     */
    protected $repository;

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;

    /**
     * @var LecturerRepository
     */
    protected $lecturerRepository;

    /**
     * StudentsController constructor.
     *
     * @param StudentRepository $repository
     * @param ProjectRepository $projectRepository
     * @param LecturerRepository $lecturerRepository
     */
    public function __construct(
        StudentRepository $repository,
        ProjectRepository $projectRepository,
        LecturerRepository $lecturerRepository
    )
    {
        $this->repository = $repository;
        $this->projectRepository = $projectRepository;
        $this->lecturerRepository = $lecturerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $students = $this->repository->paginate(10);
        return view('pages.lecturer.pages.student', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StudentCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StudentCreateRequest $request)
    {
        try {
            $request['lecturer_id'] = auth()->user()->id;
            $this->repository->createStudent($request->only('name', 'email', 'class', 'lecturer_id'));
            session()->flash('student_create_success', trans('messages.create.success'));
            return response()->json([
                'error' => false
            ]);
        } catch (\Exception $e) {
            session()->flash('student_create_fail', trans('messages.create.fail'));
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
        $student = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $student,
            ]);
        }

        return view('students.show', compact('student'));
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
        $student = $this->repository->find($id);

        return view('students.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StudentUpdateRequest $request
     * @param string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(StudentUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $student = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Student updated.',
                'data' => $student->toArray(),
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
                'message' => 'Student deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Student deleted.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchStudent(Request $request)
    {
        $students = $this->repository->findWhere([['name', 'like', '%' . $request->get('name') . '%']]);
        return response()->json([
            'data' => $students
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getLecturers(Request $request)
    {
        $name = $request->get('name');
        $subject = $request->get('subject');
        $lecturers = Lecturer::with(['subject', 'projects'])
            ->where('name', 'like', '%' . $name . '%');
        if ($subject !== null) {
            $lecturers->whereHas('subject', function ($query) use ($subject) {
                $query->where('subject_id', '=', $subject);
            });
        }
        $lecturers = $lecturers->paginate(10);
        $subjects = Subject::all();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $lecturers,
            ]);
        }
        return view('pages.student.pages.lecturer', compact('lecturers', 'subjects'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getProjects(Request $request)
    {
        $name = $request->get('name');
        $topic = $request->get('topic');
        $projects = $this->projectRepository
            ->with(['lecturer', 'students', 'topics', 'compartment'])
            ->whereHas('lecturer', function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });
        if ($topic !== null) {
            $projects->whereHas('topics', function ($query) use ($topic) {
                $query->where('topic_id', '=', $topic);
            });
        }
        $projects = $projects->paginate(10);
        $topics = Topic::all();
        if (request()->wantsJson()) {
            return response()->json([
                'data' => $projects,
            ]);
        }
        return view('pages.student.pages.project', compact('projects', 'topics'));
    }

    public function getInfoLaboratories()
    {
        try {
            $projects = Project::all()->count();
            $lecturers = Lecturer::all()->count();
            return response()->json([
                'projects' => $projects,
                'lecturers' => $lecturers
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
    }
}
