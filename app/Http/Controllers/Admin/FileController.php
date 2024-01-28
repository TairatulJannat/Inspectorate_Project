<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function SaveFile($insp_id, $sec_id, $file_names, $files, $doc_type_id, $reference_no)
    {
        if ($file_names && is_array($file_names) && $files && is_array($files)) {
            foreach ($file_names as $key => $name) {

                $file = $files[$key];
                if ($file) {
                    if ($file->isValid()) {
                        $path = $file->store('uploads', 'public');

                        File::create([
                            'file_name' => $name, // Corrected variable name
                            'path' => $path,
                            'doc_type_id' => $doc_type_id,
                            'reference_no' => $reference_no,
                            'inspectorate_id' => $insp_id,
                            'section_id' => $sec_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                } else {
                    return response()->json(['success' => 'No File Found']);
                }
            }
        }else {
            return response()->json(['success' => 'No Document is Attached']);
        }

    }
}
