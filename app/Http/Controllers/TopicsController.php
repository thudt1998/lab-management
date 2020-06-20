<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TopicCreateRequest;
use App\Http\Requests\TopicUpdateRequest;
use App\Repositories\TopicRepository;
use App\Validators\TopicValidator;

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
     * @var TopicValidator
     */
    protected $validator;

    /**
     * TopicsController constructor.
     *
     * @param TopicRepository $repository
     * @param TopicValidator $validator
     */
    public function __construct(TopicRepository $repository, TopicValidator $validator)
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
        $topics = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $topics,
            ]);
        }

        return view('topics.index', compact('topics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TopicCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TopicCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $topic = $this->repository->create($request->all());

            $response = [
                'message' => 'Topic created.',
                'data'    => $topic->toArray(),
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
     * @param  int $id
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
     * @param  TopicUpdateRequest $request
     * @param  string            $id
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
                'data'    => $topic->toArray(),
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
                'message' => 'Topic deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Topic deleted.');
    }
}
