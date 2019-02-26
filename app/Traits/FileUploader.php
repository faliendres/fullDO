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
            $multiple = true;
            $file = $request->file($name);
            $field = str_replace("_file", "", $name);
            $value = $request->get($field, "");
            $value = json_decode($value, true);
            if (!is_array($file)) {
                $multiple = false;
                $file = [$file];
            }
            foreach ($file as $uploadedFile) {
                $foto = $uploadedFile->getClientOriginalName();
                $foto = $this->validateFileName("$folder/$foto", $resource);
                Storage::disk($resource)->put($foto, $uploadedFile->get());
                $value[] = $foto;
            }
            if ($multiple)
                $value = json_encode($value);
            else
                $value = array_first($value);
            $this->removeUnusedFiles($instance->$field, $value, $resource);
            $request->merge([$field => $value]);
            $instance->update([$field => $value]);
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
        $olds = json_decode($olds, true) ?? $olds;
        $news = json_decode($news, true) ?? $news;
        $removibles = [];
        if (!is_array($olds))
            $olds = [$olds];
        if (!is_array($news))
            $news = [$news];

        foreach ($olds as $old) {
            if (!in_array($old, $news))
                $removibles[] = $old;
        }
        foreach ($removibles as $removible)
            Storage::disk($resource)->delete($removible);

    }
}