<?php

namespace App\Http\Controllers;

use App\Events\Notification;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Repositories\LaboratoryRepository;
use App\Repositories\MessageRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TopicRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ProjectsController.
 *
 * @package namespace App\Http\Controllers;
 */
class ProjectsController extends Controller
{
    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var StudentRepository
     */
    protected $studentRepository;

    /**
     * @var LaboratoryRepository
     */
    protected $laboratoryRepository;

    /**
     * @var TopicRepository
     */
    protected $topicRepository;

    /**
     * @var MessageRepository
     */
    protected $messageRepository;

    /**
     * ProjectsController constructor.
     *
     * @param ProjectRepository $repository
     * @param StudentRepository $studentRepository
     * @param LaboratoryRepository $laboratoryRepository
     * @param TopicRepository $topicRepository
     * @param MessageRepository $messageRepository
     */
    public function __construct(
        ProjectRepository $repository,
        StudentRepository $studentRepository,
        LaboratoryRepository $laboratoryRepository,
        TopicRepository $topicRepository,
        MessageRepository $messageRepository
    )
    {
        $this->repository = $repository;
        $this->studentRepository = $studentRepository;
        $this->laboratoryRepository = $laboratoryRepository;
        $this->topicRepository = $topicRepository;
        $this->messageRepository = $messageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $projects = $this->repository->with(['lecturer', 'students', 'topics', 'compartment'])->paginate(10);
        $user = auth()->user();
        if (request()->wantsJson()) {

            return response()->json([
                'data' => $projects,
            ]);
        }
        return view('pages.lecturer.pages.project', compact('projects', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(ProjectCreateRequest $request)
    {
        try {
            $request['lecturer_id'] = auth()->user()->id;
            $project = $this->repository->create($request->only('lecturer_id', 'compartment_id', 'name', 'date_start', 'date_finish'));
            $students = $request->get('students');
            $students = array_map(function ($member) use ($project) {
                $student['project_id'] = $project->id;
                $student['student_id'] = $member['id'];
                return $student;
            }, $students);
            $project->students()->attach($students);
            $topics = $request->get('topics');
            $topics = array_map(function ($item) use ($project) {
                $topic['project_id'] = $project->id;
                $topic['topic_id'] = $item['id'];
                return $topic;
            }, $topics);
            $project->topics()->attach($topics);
            if ($request->get('chairs') > 0 || $request->get('tables') > 0 || $request->get('computers') > 0) {
                $request['project_id'] = $project->id;
                $message = $this->messageRepository->create($request->only('project_id', 'compartment_id', 'tables', 'chairs', 'computers'));
                $newMessage = $this->messageRepository->with(['project', 'compartment'])->find($message->id);
                broadcast(new Notification($newMessage));
            }
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $project,
            ]);
        }

        return view('projects.show', compact('project'));
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
        $project = $this->repository->find($id);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectUpdateRequest $request
     * @param string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(ProjectUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $project = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Project updated.',
                'data' => $project->toArray(),
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $project=$this->repository->find($id);
        $project->students()->detach();
        $project->topics()->detach();
        $this->repository->delete($id);
        return response()->json([
            'error' => false
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $laboratories = $this->laboratoryRepository->with('compartments')->all();
        $topics = $this->topicRepository->all();
        return view('pages.lecturer.pages.createProject', compact('laboratories', 'topics'));
    }
}
