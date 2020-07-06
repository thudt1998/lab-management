<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicCreateRequest;
use App\Http\Requests\TopicUpdateRequest;
use App\Repositories\TopicRepository;
use App\Validators\TopicValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class TopicsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TopicsController extends Controller
{
    /**
     * @var TopicRepository
     */
    protected $repository;

    /**
     * TopicsController constructor.
     *
     * @param TopicRepository $repository
     */
    public function __construct(TopicRepository $repository)
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
        $topics = $this->repository->all();
        return view('pages.lecturer.pages.topic', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TopicCreateRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TopicCreateRequest $request)
    {
        try {
            $request['lecturer_id'] = auth()->user()->id;
            $this->repository->create($request->only('lecturer_id', 'name'));
            session()->flash('topic_create_success', trans('messages.create.success'));
            return response()->json([
                'error' => false
            ]);
        } catch (\Exception $e) {
            session()->flash('topic_create_fail', trans('messages.create.fail'));
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
        $topic = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $topic,
            ]);
        }

        return view('topics.show', compact('topic'));
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
        $topic = $this->repository->find($id);

        return view('topics.edit', compact('topic'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TopicUpdateRequest $request
     * @param string $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TopicUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $topic = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Topic updated.',
                'data' => $topic->toArray(),
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
                'message' => 'Topic deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Topic deleted.');
    }
}
