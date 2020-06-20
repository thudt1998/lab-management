<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\TopicProjectCreateRequest;
use App\Http\Requests\TopicProjectUpdateRequest;
use App\Repositories\TopicProjectRepository;
use App\Validators\TopicProjectValidator;

/**
 * Class TopicProjectsController.
 *
 * @package namespace App\Http\Controllers;
 */
class TopicProjectsController extends Controller
{
    /**
     * @var TopicProjectRepository
     */
    protected $repository;

    /**
     * @var TopicProjectValidator
     */
    protected $validator;

    /**
     * TopicProjectsController constructor.
     *
     * @param TopicProjectRepository $repository
     * @param TopicProjectValidator $validator
     */
    public function __construct(TopicProjectRepository $repository, TopicProjectValidator $validator)
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
        $topicProjects = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $topicProjects,
            ]);
        }

        return view('topicProjects.index', compact('topicProjects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  TopicProjectCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(TopicProjectCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $topicProject = $this->repository->create($request->all());

            $response = [
                'message' => 'TopicProject created.',
                'data'    => $topicProject->toArray(),
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
        $topicProject = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $topicProject,
            ]);
        }

        return view('topicProjects.show', compact('topicProject'));
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
        $topicProject = $this->repository->find($id);

        return view('topicProjects.edit', compact('topicProject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  TopicProjectUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(TopicProjectUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $topicProject = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'TopicProject updated.',
                'data'    => $topicProject->toArray(),
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
                'message' => 'TopicProject deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'TopicProject deleted.');
    }
}
