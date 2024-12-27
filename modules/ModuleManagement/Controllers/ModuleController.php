<?php

namespace Modules\ModuleManagement\Controllers;

use Illuminate\Http\Request;
use Modules\ModuleManagement\Models\Module;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ModuleController extends Controller
{


    public function create()
    {
        return view('ModuleManagement::create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'module_name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);
    
        $moduleName = ucfirst($request->module_name);
        $modulePath = base_path("Modules/$moduleName");
    
        if (File::exists($modulePath)) {
            return back()->withErrors(['error' => 'Module already exists.']);
        }
    
        // Create module folder structure
        File::makeDirectory("$modulePath/Controllers", 0755, true);
        File::makeDirectory("$modulePath/Models", 0755, true);
        File::makeDirectory("$modulePath/Views", 0755, true);
    
        // Add a module.json file
        File::put("$modulePath/module.json", json_encode([
            'name' => $moduleName,
            'description' => $request->description,
        ], JSON_PRETTY_PRINT));
    
        // Register the module in the modules table
        DB::table('modules')->insert([
            'name' => $moduleName,
            'description' => $request->description,
            'path' => $modulePath,
            'is_active' => 1, // Default to active
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->route('modules.index')->with('success', 'Module created and registered successfully!');
    }
    
    public function destroy($module)
    {
        $modulePath = base_path("Modules/$module");

        if (File::exists($modulePath)) {
            File::deleteDirectory($modulePath);
            return redirect()->route('modules.index')->with('success', 'Module deleted successfully!');
        }

        return redirect()->route('modules.index')->withErrors(['error' => 'Module not found.']);
    }

    public function index()
{
    $moduleDirectoryPath = base_path('Modules');
    
    // Scan the Modules folder for directories
    $moduleFolders = File::directories($moduleDirectoryPath);

    foreach ($moduleFolders as $folder) {
        $moduleName = basename($folder); // Get module name from folder
        $moduleJsonPath = $folder . '/module.json';

        if (File::exists($moduleJsonPath)) {
            // Read the module.json file
            $moduleData = json_decode(File::get($moduleJsonPath), true);

            // Check if module is already in the database
            $existingModule = Module::where('name', $moduleName)->first();

            if (!$existingModule) {
                // Insert the module into the database
                Module::create([
                    'name' => $moduleName,
                    'description' => $moduleData['description'] ?? 'No description provided.',
                    'path' => $folder,
                    'is_active' => 1, // Default to active
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    // Fetch all modules from the database
    $modules = Module::all();

    return view('ModuleManagement::index', compact('modules'));
}
    public function install(Request $request)
{
    $request->validate([
        'module' => 'required|file|mimes:zip',
    ]);

    $zip = $request->file('module');
    $moduleName = pathinfo($zip->getClientOriginalName(), PATHINFO_FILENAME);

    // Extract the module
    $modulePath = base_path("Modules/{$moduleName}");
    if (file_exists($modulePath)) {
        return back()->with('error', 'Module already exists.');
    }

    $zip->storeAs('modules', $zip->getClientOriginalName());
    $zipArchive = new \ZipArchive();
    $zipArchive->open(storage_path("app/modules/{$zip->getClientOriginalName()}"));
    $zipArchive->extractTo($modulePath);
    $zipArchive->close();

    // Run module migrations
    Artisan::call('migrate', ['--path' => "Modules/{$moduleName}/migrations"]);

    // Register the module in the database
    Module::create([
        'name' => $moduleName,
        'path' => "Modules/{$moduleName}",
        'status' => 'active',
    ]);

    return back()->with('success', 'Module installed successfully.');
}

public function toggleStatus($id)
{
    $module = Module::findOrFail($id);

    // Toggle the `is_active` column value
    $module->is_active = !$module->is_active; // Flip the active status
    $module->updated_at = now(); // Update the timestamp
    $module->save();

    $status = $module->is_active ? 'activated' : 'deactivated';
    return back()->with('success', "Module {$module->name} has been {$status}.");
}


public function delete($id)
{
    $module = Module::findOrFail($id);
    $modulePath = base_path($module->path);

    // Delete module files
    if (file_exists($modulePath)) {
        File::deleteDirectory($modulePath);
    }

    // Optionally, drop module-related tables
    if ($module->has_database_cleanup) {
        Artisan::call('migrate:rollback', ['--path' => "{$module->path}/migrations"]);
    }

    $module->delete();

    return back()->with('success', 'Module deleted successfully.');
}


}
