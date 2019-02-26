<?php

namespace App\Traits;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait FileUploader
{
    /**
     * @param Request $request
     * @param Model $instance
     * @param string $resource
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function uploadFiles(Request &$request, Model $instance, $resource)
    {
        $now = Carbon::now();
        $folder = $now->format("Y/d") . "/" . $instance->getKey();
        $files = $request->files;

        foreach ($files as $name => $nameF) {
            $file = $request->file($name);
            $field = str_replace("_file", "", $name);
            $value = $request->get($field, "");
            $value = json_decode($value, true);
            $rename = $request->get("${field}_rename", false);
            if (!is_array($file))
                $file = [$file];
            foreach ($file as $uploadedFile) {
                if ($rename)
                    $foto = uniqid() . "." . $uploadedFile->extension();
                else
                    $foto = $uploadedFile->getClientOriginalName();
                $foto = $this->validateFileName("$folder/$foto", $resource);
                Storage::disk($resource)->put($foto, $uploadedFile->get());
                $value[] = $foto;
            }
            $this->removeUnusedFiles($instance->$field, json_encode($value), $resource);
            $request->merge([$field => json_encode($value)]);
            $instance->update([$field => json_encode($value)]);
        }
    }

    protected function validateFileName($file, $resource)
    {
        while (Storage::disk($resource)->exists($file)) {
            $end = last_strpos($file, ".");
            if ($end === false) {
                $end = strlen($file);
            }
            $file2 = substr($file, 0, $end);
            $file3 = substr($file, $end, strlen($file));
            $file = "$file2(copy)$file3";
        }
        return $file;
    }

    protected function removeUnusedFiles($olds, $news, $resource)
    {
        $olds = json_decode($olds, true);
        $news = json_decode($news, true);
        $removibles = [];
        foreach ($olds as $old) {
            if (!in_array($old, $news))
                $removibles[] = $old;
        }
        foreach ($removibles as $removible)
            Storage::disk($resource)->delete($removible);

    }
}