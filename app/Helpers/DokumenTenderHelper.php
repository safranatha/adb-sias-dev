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
}