<?php

namespace App\Http\Controllers;

use ZipArchive;
use App\Asset;
use App\Http\Requests\AssetsStoreRequest;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $this->authorize('user_contribute_to_project', $project);
        $assets = Asset::pimp()->where('project_id', $project_id)->get();
        return response()->json($assets);
    }

    /**
     * Download a specific asset.
     *
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, $asset_id)
    {
        $asset = Asset::with('Project')->findOrFail($asset_id);
        $this->authorize('user_contribute_to_project', $asset->Project);

        if (!Storage::exists($asset->path)) {
            return response()->json(['error' => 'Asset not found'], 404);
        }

        $path = storage_path("app/{$asset->path}");
        return response()->download($path, $asset->name);
    }

    /**
     * Download all assets from a project
     *
     * @return \Illuminate\Http\Response
     */
    public function download_all(Request $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $this->authorize('user_contribute_to_project', $project);
        $assets = Asset::pimp()->where('project_id', $project_id)->get();

        $zip_name = uniqid();
        $zip_path = storage_path("app/arhive/{$zip_name}");
        $zip = new \ZipArchive();
        if ($zip->open($zip_path, \ZipArchive::CREATE)) {
            foreach ($assets as $asset) {
                $path = storage_path("app/{$asset->path}");
                $zip->addFile($path, $asset->name);
            }
        } else {
            return response()->json(['error' => 'Can\'t make zip file']);
        }
        $zip->close();

        return response()->download($zip_path, $zip_name)->deleteFileAfterSend(true);;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssetsStoreRequest $request)
    {
        $asset_file = $request->file('assets');
        $path = $asset_file->store('assets');
        if (Asset::where('path', $path)->exists()) {
            return response()->json(['error' => 'File already exists on this project'], 400);
        }
        $assets = new Asset([
            'name' => $asset_file->getClientOriginalName(),
            'extension' => $asset_file->extension()
        ]);
        $assets->path = $path;
        $assets->project_id = $request->project_id;
        $assets->user_id = auth()->user()->id;
        $assets->save();

        return response()->json(['assets' => $assets]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $asset_id)
    {
        $asset = Asset::with('Project')->findOrFail($asset_id);
        $this->authorize('user_contribute_to_project', $asset->Project);
        $asset->delete();
        return response()->json(['message' => 'Asset deleted successfully']);
    }
}
