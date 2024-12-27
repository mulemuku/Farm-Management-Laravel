<?php

namespace Modules\FarmerManagement\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Modules\FarmerManagement\Models\Farmer;
use Illuminate\Routing\Controller;

class FarmerController extends Controller
{
    public function index()
    {
        $farmers = Farmer::paginate(10);
        return view('FarmerManagement::index', compact('farmers'));
    }

    public function create()
    {
        return view('FarmerManagement::create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15',
            'nrcs_number' => 'required|string|unique:farmers',
            'date_of_birth' => 'required|date',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'next_of_kin' => 'required|string|max:255',
            'email' => 'nullable|email',
            'type_of_farm' => 'required|string',
            'category' => 'required|in:commercial,subsistent',
            'land_area' => 'nullable|numeric',
            'nrc_passport_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'bank_statement' => 'nullable|file|mimes:pdf|max:2048',
            'other_documents' => 'nullable|file|max:5120',
        ]);
    
        // Check for duplicate NRC number
        if (Farmer::where('nrcs_number', $validated['nrcs_number'])->exists()) {
            return response()->json(['message' => 'A farmer with this NRC number already exists.'], 422);
        }
    
        // Check for duplicate mobile number
        if (Farmer::where('mobile_number', $validated['mobile_number'])->exists()) {
            return response()->json(['message' => 'A farmer with this mobile number already exists.'], 422);
        }
    
        // Check for duplicate email if provided
        if (!empty($validated['email']) && Farmer::where('email', $validated['email'])->exists()) {
            return response()->json(['message' => 'A farmer with this email already exists.'], 422);
        }
    
        // Handle file uploads
        $validated['nrc_passport_file'] = $this->storeFile($request->file('nrc_passport_file'), 'nrcs', $validated['nrcs_number']);
        $validated['bank_statement'] = $this->storeFile($request->file('bank_statement'), 'bank_statements', $validated['nrcs_number']);
        $validated['other_documents'] = $this->storeFile($request->file('other_documents'), 'other_documents', $validated['nrcs_number']);
    
        // Create farmer record
        Farmer::create($validated);
    
        return response()->json(['message' => 'Farmer added successfully!'], 200);
    }
    
    
    /**
     * Store file securely and return the stored file path.
     */
  

    public function edit(Farmer $farmer)
    {
        return view('FarmerManagement::edit', compact('farmer'));
    }
    public function update(Request $request, Farmer $farmer)
    {
        try {
            $validated = $request->validate([
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'mobile_number' => 'nullable|string|max:15',
                'nrcs_number' => "nullable|string|unique:farmers,nrcs_number,{$farmer->id}",
                'date_of_birth' => 'nullable|date',
                'country' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:255',
                'next_of_kin' => 'nullable|string|max:255',
                'email' => 'nullable|email',
                'type_of_farm' => 'nullable|string',
                'category' => 'nullable|in:commercial,subsistent',
                'land_area' => 'nullable|numeric',
                'status' => 'nullable|in:pending,active,suspended,inactive',
                'nrc_passport_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
                'bank_statement' => 'nullable|file|mimes:pdf|max:2048',
                'other_documents' => 'nullable|file|max:5120',
            ]);
    
            if ($request->hasFile('nrc_passport_file')) {
                $validated['nrc_passport_file'] = $this->storeFile($request->file('nrc_passport_file'), 'nrcs', $farmer->nrcs_number);
            }
    
            if ($request->hasFile('bank_statement')) {
                $validated['bank_statement'] = $this->storeFile($request->file('bank_statement'), 'bank_statements', $farmer->nrcs_number);
            }
    
            if ($request->hasFile('other_documents')) {
                $validated['other_documents'] = $this->storeFile($request->file('other_documents'), 'other_documents', $farmer->nrcs_number);
            }
    
            $farmer->update($validated);
    
            return response()->json(['message' => 'Farmer updated successfully!'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An unexpected error occurred.'], 500);
        }
    }
    
    

    public function destroy(Farmer $farmer)
    {
        $farmer->delete();
        return redirect()->route('farmers.index')->with('success', 'Farmer deleted successfully.');
    }

    protected function storeFile($file, $directory, $uniqueIdentifier)
    {
        if (!$file) {
            return null;
        }
    
        // Generate the full directory path
        $directoryPath = storage_path("app/public/modules/FarmerManagement/Uploads/{$directory}");
    
        // Check if directory exists, if not, create it
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0755, true);
        }
    
        // Generate unique filename
        $filename = $uniqueIdentifier . '_' . time() . '.' . $file->getClientOriginalExtension();
    
        // Store file and return the file path
        $file->move($directoryPath, $filename);
    
        // Return the relative path for storage usage
        return "modules/FarmerManagement/Uploads/{$directory}/{$filename}";
    }
}
