<?php
namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;

class DokumenTenderHelper
{
    public static function downloadHelper(
        string $modelClass,
        int $id,
        string $fileField,
        string $namaFile,
    ) {
        /** @var Model|null $data */
        $data = $modelClass::find($id);
        $errorMessage = "File {$namaFile} tidak ditemukan.";
        $basePath = 'storage';

        if (!$data || empty($data->$fileField)) {
            session()->flash('error', $errorMessage);
            return null;
        }

        $filePath = public_path($basePath . '/' . $data->$fileField);

        if (!file_exists($filePath)) {
            session()->flash(
                'error',
                $errorMessage
            );
            return null;
        }

        return response()->download($filePath);
    }

    public static function downloadRevisionHelper(
        string $modelClass,
        int $id,
        string $fileField,
        string $namaFile,
        string $document_id
    ) {
        /** @var Model|null $data */
        $data = $modelClass::where($document_id, $id)->latest()->first();
        $errorMessage = "File {$namaFile} tidak ditemukan.";
        $basePath = 'storage';

        if (!$data || empty($data->$fileField)) {
            session()->flash('error', $errorMessage);
            return null;
        }

        $filePath = public_path($basePath . '/' . $data->$fileField);

        if (!file_exists($filePath)) {
            session()->flash(
                'error',
                $errorMessage
            );
            return null;
        }

        return response()->download($filePath);
    }


    public static function storeRevisionFileOnStroage(
        $file_path,
        $nama_folder
    ) {
        $original = $file_path->getClientOriginalName();
        $timestamp = time();
        $format_timestamp = date('g i a,d-m-Y', $timestamp);
        $filename = "Revision" . "_" . $format_timestamp . "_" . $original;

        // store ke storage
        $path = $file_path->storeAs($nama_folder, $filename, 'public');

        return $path;
    }

    public static function storeFileOnStroage(
        $file_path,
        $nama_folder
    ) {
        // Save to Laravel storage
        $original = $file_path->getClientOriginalName();
        $timestamp = time();
        $format_timestamp = date('g i a,d-m-Y', $timestamp);
        $filename = "New" . "_" . $format_timestamp . "_" . $original;

        // Store to Laravel storage
        $path = $file_path->storeAs($nama_folder, $filename, 'public');

        return $path;
    }

    public static function storeWaktuDibaca(
        $id,
        $modelClass, 
        $document_id
        )
    {
        /** @var Model|null $data */
        $workflow = $modelClass::where($document_id, $id)
            ->whereNull('waktu_pesan_dibaca')
            ->latest('created_at') // atau latest() saja, default ke created_at
            ->first();

        if ($workflow) {
            $workflow->update([
                'waktu_pesan_dibaca' => now(),
            ]);
        }
        return $workflow;
    }
}