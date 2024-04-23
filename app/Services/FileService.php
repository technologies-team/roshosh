<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Http\UploadedFile as HttpFile;
use Illuminate\Support\Facades\Storage;

class FileService extends Service
{
    /**
     * 
     */
    public function store(HttpFile $upload)
    {
        $mime_type = $upload->getMimeType();
        $dir = 'files';

        try {
            $path = $upload->store($dir);
            $name = explode('/', $path);
            $name = last($name);
        } catch (\Throwable $th) {
            throw new \Exception('files:upload:errors:failed');
        }
        $file = new File();
        $file->name = $name;
        $file->mime_type = $mime_type;
        $file->path = $path;

        try {
            $file->saveOrFail();
        } catch (\Throwable $th) {
            Storage::delete($path);
        }
        return $file;
    }

    /**
     * 
     */
    public function upload(HttpFile $upload)
    {
        return $this->ok($this->store($upload), 'files:upload:succeeded');
    }

    public function find(int $id)
    {
        return File::query()->where('id', '=', $id)->first();
    }

    public function get(int $id)
    {
        return $this->ok($this->find($id), 'files:get:succeeded');
    }

    /**
     * 
     */
    public function download(string $name)
    {
        $file = File::query()->where('name', $name)->first();
        if ($file instanceof File) {
            return Storage::download($file->path);
        }
        throw new \Exception('files:download:errors:not_found');
    }
}
