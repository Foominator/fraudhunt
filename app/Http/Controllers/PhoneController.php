<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePhoneRequest;
use App\Http\Requests\UpdatePhoneRequest;
use App\Repositories\PhoneRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class PhoneController extends AppBaseController
{
    /** @var  PhoneRepository */
    private $phoneRepository;

    public function __construct(PhoneRepository $phoneRepo)
    {
        $this->phoneRepository = $phoneRepo;
    }

    /**
     * Display a listing of the Phone.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $phones = $this->phoneRepository->all();
        $phones->load('author');
        return view('phones.index')
            ->with('phones', $phones);
    }

    /**
     * Show the form for creating a new Phone.
     *
     * @return Response
     */
    public function create()
    {
        return view('phones.create');
    }

    /**
     * Store a newly created Phone in storage.
     *
     * @param CreatePhoneRequest $request
     *
     * @return Response
     */
    public function store(CreatePhoneRequest $request)
    {
        $input = $request->all();

        $phone = $this->phoneRepository->create($input);

        Flash::success('Phone saved successfully.');

        return redirect(route('phones.index'));
    }

    /**
     * Display the specified Phone.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $phone = $this->phoneRepository->find($id);

        if (empty($phone)) {
            Flash::error('Phone not found');

            return redirect(route('phones.index'));
        }

        return view('phones.show')->with('phone', $phone);
    }

    /**
     * Show the form for editing the specified Phone.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $phone = $this->phoneRepository->find($id);

        if (empty($phone)) {
            Flash::error('Phone not found');

            return redirect(route('phones.index'));
        }

        return view('phones.edit')->with('phone', $phone);
    }

    /**
     * Update the specified Phone in storage.
     *
     * @param int $id
     * @param UpdatePhoneRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePhoneRequest $request)
    {
        $phone = $this->phoneRepository->find($id);

        if (empty($phone)) {
            Flash::error('Phone not found');

            return redirect(route('phones.index'));
        }

        $phone = $this->phoneRepository->update($request->all(), $id);

        Flash::success('Phone updated successfully.');

        return redirect(route('phones.index'));
    }

    /**
     * Remove the specified Phone from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $phone = $this->phoneRepository->find($id);

        if (empty($phone)) {
            Flash::error('Phone not found');

            return redirect(route('phones.index'));
        }

        $this->phoneRepository->delete($id);

        Flash::success('Phone deleted successfully.');

        return redirect(route('phones.index'));
    }
}
