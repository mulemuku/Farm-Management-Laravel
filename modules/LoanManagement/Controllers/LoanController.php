<?php

namespace Modules\LoanManagement\Controllers;

use Illuminate\Http\Request;
use Modules\LoanManagement\Models\Loan;
use Modules\LoanManagement\Models\LoanChange;
use Modules\FarmerManagement\Models\Farmer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB; 

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('farmer')->paginate(12);
        return view('LoanManagement::index', compact('loans'));
    }

    public function create()
    {
        $farmers = Farmer::all();
        return view('LoanManagement::create', compact('farmers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'loan_amount' => 'required|numeric|min:1',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'repayment_duration_months' => 'required|integer|min:1',
        ]);

        $loan = Loan::create(array_merge($validated, [
            'status' => 'pending',
            'created_by' => Auth::id(),
        ]));

        LoanChange::create([
            'loan_id' => $loan->id,
            'changed_by' => Auth::id(),
            'change_description' => 'Loan created.',
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan added successfully!');
    }

    public function approve(Loan $loan)
    {
        try {
            $loan->update(['status' => 'approved']);
            LoanChange::create([
                'loan_id' => $loan->id,
                'changed_by' => Auth::id(),
                'change_description' => 'Loan approved.',
            ]);
            return back()->with('success', 'Loan approved successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve loan.');
        }
    }

    public function reject(Request $request, Loan $loan)
{
    try {
        $loan->update(['status' => 'rejected']);
        LoanChange::create([
            'loan_id' => $loan->id,
            'change_description' => 'Loan rejected.',
            'changed_by' => Auth::id(), // Default to 999 if no user is logged in
        ]);

        return response()->json(['message' => 'Loan rejected successfully.'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to reject loan.', 'error' => $e->getMessage()], 500);
    }
}

public function repay(Loan $loan)
{
    try {
        $loan->update(['status' => 'repaid']);

        // Log the action
        LoanChange::create([
            'loan_id' => $loan->id,
            'change_description' => 'Loan marked as repaid.',
            'changed_by' => Auth::id() ?? 999, // Use user ID or fallback to 999 if not authenticated
        ]);

        return redirect()->route('loans.index')->with('success', 'Loan marked as repaid successfully.');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to mark loan as repaid.');
    }
}

public function show($loan)
{
    // Fetch loan details using the loan ID
    $loan = Loan::with('farmer')->findOrFail($loan);

    return view('LoanManagement::loans.show', compact('loan'));
}


public function report(Request $request)
{
    // Filters
    $statusFilter = $request->input('status');
    $search = $request->input('search');

    // Loan Data Query
    $loans = Loan::with('farmer')
        ->when($statusFilter, function ($query, $statusFilter) {
            $query->where('status', $statusFilter);
        })
        ->when($search, function ($query, $search) {
            $query->whereHas('farmer', function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                    ->orWhere('last_name', 'like', "%$search%")
                    ->orWhere('nrcs_number', 'like', "%$search%");
            });
        })
        ->paginate(10);

    // Summaries
    $loansByStatus = Loan::select('status', DB::raw('COUNT(*) as count'))
        ->groupBy('status')
        ->get();

    $totalDisbursed = Loan::where('status', 'approved')->sum('loan_amount');

    return view('LoanManagement::reports', compact('loans', 'loansByStatus', 'totalDisbursed'));
}

}
