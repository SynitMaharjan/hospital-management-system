<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\StoreBillItemRequest;
use App\Http\Requests\RecordPaymentRequest;
use App\Models\Appointment;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Patient;
use App\Services\BillService;
use Illuminate\Http\Request;

class ReceptionistBillController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(protected BillService $billService)
    {
    }

    /**
     * Display a listing of the bills.
     */
    public function index(Request $request)
    {
        $query = Bill::with([
            'patient',
            'appointment.doctor.user',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($query) use ($search) {
                $query->where(
                    'bill_number',
                    'ilike',
                    "%{$search}%"
                )
                    ->orWhereHas('patient', function ($query) use ($search) {
                        $query->where(
                            'patient_number',
                            'ilike',
                            "%{$search}%"
                        )
                            ->orWhere(
                                'first_name',
                                'ilike',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'middle_name',
                                'ilike',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'last_name',
                                'ilike',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'phone',
                                'ilike',
                                "%{$search}%"
                            )
                            ->orWhere(
                                'email',
                                'ilike',
                                "%{$search}%"
                            )
                            ->orWhereRaw( "CONCAT_WS(' ', first_name, middle_name, last_name) ILIKE ?", ["%{$search}%"] );
                    });
            });
        }

        $bills = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $patients = Patient::with('user')
            ->orderBy('first_name')
            ->get();

        return view(
            'receptionist.bill.index',
            compact('bills', 'patients')
        );
    }

    /**
     * Store a newly created bill in storage.
     */
    public function store(StoreBillRequest $request)
    {
        $bill = $this->billService->create(
            $request->validated()
        );

        return redirect()
            ->route('receptionist.bill.show', $bill)
            ->with(
                'success',
                'Bill created successfully.'
            );
    }

    /**
     * Display the specified bill.
     */
    public function show(Bill $bill)
    {
        $bill->load([
            'patient.user',
            'appointment.doctor.user',
            'billItems',
        ]);

        return view(
            'receptionist.bill.show',
            compact('bill')
        );
    }

    /**
     * Store a new bill item.
     */
    public function storeItem(
        StoreBillItemRequest $request,
        Bill $bill
    ) {
        $this->billService->addItem(
            $bill,
            $request->validated()
        );

        return back()
            ->with(
                'success',
                'Item added to bill successfully.'
            );
    }

    /**
     * Remove a bill item.
     */
    public function destroyItem(
        Bill $bill,
        BillItem $item
    ) {
        if ($item->bill_id !== $bill->id) {
            abort(404);
        }

        $this->billService->removeItem($item);

        return back()
            ->with(
                'success',
                'Item removed from bill successfully.'
            );
    }

    /**
     * Display a printable version of the bill.
     */
    public function print(Bill $bill)
    {
        $bill->load([
            'patient',
            'appointment.doctor.user',
            'billItems',
        ]);

        return view(
            'receptionist.bill.print',
            compact('bill')
        );
    }

    /**
     * Record a payment for the bill.
     */
    public function payment(
        RecordPaymentRequest $request,
        Bill $bill
    ) {
        $this->billService->recordPayment(
            $bill,
            $request->validated()
        );

        return back()
            ->with(
                'success',
                'Payment recorded successfully.'
            );
    }

    /**
     * Get appointments belonging to a specific patient.
     */
    public function appointmentsByPatient(Patient $patient)
    {
        $appointments = Appointment::with([
            'patient',
            'doctor.user',
        ])
            ->where('patient_id', $patient->id)
            ->latest('appointment_date')
            ->latest('appointment_time')
            ->get();

        return response()->json($appointments);
    }
}