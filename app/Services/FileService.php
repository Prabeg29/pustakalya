<?php

namespace App\Services;

use App\Repositories\FileRepositoryInterface;

class FileService
{
    protected $fileRepository;

    /**
     * FileService constructor.
     * @param FileRepositoryInterface $fileRepository
     */
    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function upload(array $data)
    {
        $file = $this->fileStore($data);
        return $this->fileRepository->create($file);
    }

    private function fileStore(array $data)
    {
        $fileName = time() . '_' . $data["file"]->getClientOriginalName();
        $filePath = '/storage/' . $data["file"]->storeAs('uploads', $fileName, 'public');

        return array("name" => $fileName, "file_path" => $filePath);
    }
}
