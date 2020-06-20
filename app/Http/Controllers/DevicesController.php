<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DeviceCreateRequest;
use App\Http\Requests\DeviceUpdateRequest;
use App\Repositories\DeviceRepository;
use App\Validators\DeviceValidator;

/**
 * Class DevicesController.
 *
 * @package namespace App\Http\Controllers;
 */
class DevicesController extends Controller
{
    /**
     * @var DeviceRepository
     */
    protected $repository;

    /**
     * @var DeviceValidator
     */
    protected $validator;

    /**
     * DevicesController constructor.
     *
     * @param DeviceRepository $repository
     * @param DeviceValidator $validator
     */
    public function __construct(DeviceRepository $repository, DeviceValidator $validator)
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
        $devices = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $devices,
            ]);
        }

        return view('devices.index', compact('devices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DeviceCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(DeviceCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $device = $this->repository->create($request->all());

            $response = [
                'message' => 'Device created.',
                'data'    => $device->toArray(),
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
        $device = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $device,
            ]);
        }

        return view('devices.show', compact('device'));
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
        $device = $this->repository->find($id);

        return view('devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DeviceUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(DeviceUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $device = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Device updated.',
                'data'    => $device->toArray(),
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
                'message' => 'Device deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Device deleted.');
    }
}
