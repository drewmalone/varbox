<?php

namespace Varbox\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class FroalaController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function uploadImage(Request $request)
    {
        try {
            $file = $request->file('froala_image');

            $allowedMaxSize = 5 * 1024 * 1024;
            $allowedExtensions = ['jpeg', 'jpg', 'png', 'gif', 'svg'];

            if (!$file->isValid()) {
                throw new Exception('The image supplied is invalid!');
            }

            if ($file->getSize() > $allowedMaxSize) {
                throw new Exception('The image size must be less than 5 MB!');
            }

            if (!in_array($file->getClientOriginalExtension(), $allowedExtensions)) {
                throw new Exception('Please upload images with the following extensions: ' . implode(', ', $allowedExtensions));
            }

            $path = $request->file('froala_image')->store(null, 'froala');

            return response()->json([
                'link' => Storage::disk('froala')->url($path),
            ]);
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }
}
