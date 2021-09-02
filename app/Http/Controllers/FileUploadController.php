<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use App\Http\Requests\FileUploadRequest;

class FileUploadController extends Controller
{
    protected $fileService;

    /**
     * FileUploadController constructor.
     * @param FileService $fileService
     */
    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param FileUploadRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(FileUploadRequest $request)
    {
        $file = $this->fileService->upload($request->all());
        return response()->json($file, 201);
    }
}
