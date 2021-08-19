<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileUploadRequest;
use App\Models\File;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function fileUpload(FileUploadRequest $request)
    {
        $request->validated();

        $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads', $fileName, 'public');

        $fileModel = new File();
        $fileModel->name = $fileName;
        $fileModel->file_path = '/storage/'. $filePath;
        $fileModel->save();

        return response()->json([
            "status" => "Success",
            "message" => "File uploaded successfully",
            "filePath" => $fileModel->file_path
        ], 201);
    }
}
