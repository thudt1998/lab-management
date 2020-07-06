<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageCreateRequest;
use App\Http\Requests\MessageUpdateRequest;
use App\Repositories\CompartmentRepository;
use App\Repositories\MessageRepository;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class MessagesController.
 *
 * @package namespace App\Http\Controllers;
 */
class MessagesController extends Controller
{
    /**
     * @var MessageRepository
     */
    protected $repository;

    /**
     * @var CompartmentRepository
     */
    protected $compartmentRepository;

    /**
     * MessagesController constructor.
     *
     * @param MessageRepository $repository
     * @param CompartmentRepository $compartmentRepository
     */
    public function __construct(MessageRepository $repository, CompartmentRepository $compartmentRepository)
    {
        $this->repository = $repository;
        $this->compartmentRepository = $compartmentRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $messages = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $messages,
            ]);
        }

        return view('messages.index', compact('messages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MessageCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MessageCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $message = $this->repository->create($request->all());

            $response = [
                'message' => 'Message created.',
                'data' => $message->toArray(),
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
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $message,
            ]);
        }

        return view('messages.show', compact('message'));
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
        $message = $this->repository->find($id);

        return view('messages.edit', compact('message'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MessageUpdateRequest $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MessageUpdateRequest $request, $id)
    {
        try {
            $compartment = $this->compartmentRepository->find($request->get('compartment_id'));
            $this->compartmentRepository->update([
                'tables' => $compartment->tables + (int)$request->get('tables'),
                'chairs' => $compartment->chairs + (int)$request->get('chairs'),
                'computers' => $compartment->computers + (int)$request->get('computers'),
            ], $request->get('compartment_id'));
            $this->repository->update(['status' => 0], $request->get('id'));
            return response()->json([
                'error' => false,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
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
                'message' => 'Message deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Message deleted.');
    }
}
