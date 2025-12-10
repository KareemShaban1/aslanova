<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class SubProductController extends Controller
{

    public function index()
    {
        $subProducts = SubProduct::all();
        return response()->json([
            'data' => $subProducts,
        ]);
    }

    public function show($id)
    {
        $subProduct = SubProduct::findOrFail($id);
        return response()->json([
            'data' => $subProduct,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'file' => 'required|file',
            'color' => 'required|string',
            'description' => 'required|string',
            'capital' => 'required|string',
            'price' => 'required|string',
            'quantity' => 'required|string',
            'delivery_price' => 'required|string',
            'shipping_price' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
    
        $file = $request->file('file');
        $filePath = $file->store('');
    
        $videoPath = null;
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoPath = $video->store('');
        }
    
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $images[] = $image->store('');
            }
        }
    
        $product = Product::findOrFail($request->product_id);
    
        $subProduct = SubProduct::create([
            'product_id' => $request->product_id,
            'file' => $filePath,
            'color' => $request->color,
            'name' => $request->name,
            'desc' => $request->description,
            'type' => $product->type,
            'price' => $request->price,
            'capital' => $request->capital,
            'quantity' => $request->quantity,
            'Width' => $product->Width,
            'Height' => $product->Height,
            'Thickness' => $product->Thickness,
            'video' => $videoPath,
            'images' => json_encode($images),
            'delivery_price' => $request->delivery_price,
            'shipping_price' => $request->shipping_price,
        ]);
    
        return response()->json([
            'data' => $subProduct,
        ], 201);
    }
    public function update(Request $request, $id)
{
    // Log all request data for debugging
    Log::info('SubProduct Update Request', [
        'id' => $id,
        'has_video_file' => $request->hasFile('video'),
        'all_files' => $request->allFiles(),
        'request_keys' => array_keys($request->all()),
    ]);

    // Check for video upload errors before validation
    // Handle both hasFile() and direct file access cases
    $videoFile = $request->file('video');
    $hasVideoFile = $request->hasFile('video');
    
    // Safely check if file is uploaded
    $isUploadedFile = false;
    if ($videoFile !== null) {
        try {
            $pathname = $videoFile->getPathname();
            $isUploadedFile = file_exists($pathname) && is_uploaded_file($pathname);
        } catch (\Exception $e) {
            $isUploadedFile = false;
        }
    }
    
    Log::info('Video file check', [
        'has_file' => $hasVideoFile,
        'file_exists' => $videoFile !== null,
        'is_uploaded_file' => $isUploadedFile,
    ]);
    
    if ($videoFile !== null) {
        // File exists in request, check if it's valid
        $isValid = $videoFile->isValid();
        $errorCode = $isValid ? null : $videoFile->getError();
        
        // Safely get file properties to avoid exceptions
        $fileDetails = [
            'is_valid' => $isValid,
            'error_code' => $errorCode,
        ];
        
        try {
            $fileDetails['name'] = $videoFile->getClientOriginalName();
        } catch (\Exception $e) {
            $fileDetails['name'] = 'Unknown';
        }
        
        try {
            $fileDetails['size'] = $videoFile->getSize();
            $fileDetails['size_mb'] = $fileDetails['size'] ? round($fileDetails['size'] / (1024 * 1024), 2) : 0;
        } catch (\Exception $e) {
            $fileDetails['size'] = 0;
            $fileDetails['size_mb'] = 0;
        }
        
        try {
            $fileDetails['mime_type'] = $videoFile->getMimeType();
        } catch (\Exception $e) {
            $fileDetails['mime_type'] = 'Unknown';
        }
        
        try {
            $fileDetails['extension'] = $videoFile->getClientOriginalExtension();
        } catch (\Exception $e) {
            $fileDetails['extension'] = 'Unknown';
        }
        
        try {
            $fileDetails['pathname'] = $videoFile->getPathname();
            $fileDetails['file_exists'] = file_exists($fileDetails['pathname']);
            $fileDetails['is_readable'] = is_readable($fileDetails['pathname']);
        } catch (\Exception $e) {
            $fileDetails['pathname'] = 'Unknown';
            $fileDetails['file_exists'] = false;
            $fileDetails['is_readable'] = false;
        }
        
        Log::info('Video file details', $fileDetails);
        
        // If file is invalid, doesn't exist, or not readable, return error
        if (!$isValid || !$hasVideoFile || !($fileDetails['file_exists'] ?? false) || !($fileDetails['is_readable'] ?? false)) {
            // File upload failed or file is not properly uploaded
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'Video file size exceeds server upload limit. Please reduce file size',
                UPLOAD_ERR_FORM_SIZE => 'Video file size exceeds form upload limit. Please reduce file size.',
                UPLOAD_ERR_PARTIAL => 'Video file was only partially uploaded. Please try uploading again.',
                UPLOAD_ERR_NO_FILE => 'No video file was uploaded. Please select a video file.',
                UPLOAD_ERR_NO_TMP_DIR => 'Server error: Missing temporary folder for video upload. Please contact administrator.',
                UPLOAD_ERR_CANT_WRITE => 'Server error: Failed to write video file to disk. Please contact administrator.',
                UPLOAD_ERR_EXTENSION => 'Video upload stopped by server extension. Please contact administrator.',
            ];
            
            $errorMessage = $errorCode && isset($errorMessages[$errorCode]) 
                ? $errorMessages[$errorCode] 
                : ($errorCode ? 'Video file upload failed with error code: ' . $errorCode . '. Please try again or contact support.' : 'Video file failed to upload. Please check the file and try again.');
            
            Log::error('Video upload error (before validation)', [
                'error_code' => $errorCode,
                'has_file' => $hasVideoFile,
                'is_valid' => $isValid,
                'message' => $errorMessage
            ]);
            
            return response()->json([
                'errors' => ['video' => [$errorMessage]],
                'message' => $errorMessage
            ], 422);
        }
    }

    // Only validate video if it was successfully uploaded
    $videoRules = ['nullable'];
    if ($hasVideoFile && $videoFile && $videoFile->isValid()) {
        $videoRules = [
            'nullable',
            'file',
            'mimes:mp4,avi,mov,webm',
            'mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/webm',
            'max:51200', // 50MB in KB
        ];
    }
    
    $validator = Validator::make($request->all(), [
        'color' => 'required|string',
        'video' => $videoRules,
        'file' => 'nullable|file|image|mimes:jpeg,jpg,png,gif,webp|max:5120', // 5MB for images
    ], [
        'video.file' => 'The video must be a valid file.',
        'video.mimes' => 'Invalid video file extension. Allowed extensions: MP4, AVI, MOV, WEBM.',
        'video.mimetypes' => 'Invalid video format. Allowed formats: MP4, AVI, MOV, WEBM.',
        'video.max' => 'Video file size exceeds 50MB limit. Maximum allowed size is 50MB.',
        'file.image' => 'The file must be a valid image file.',
        'file.mimes' => 'Invalid image file extension. Allowed extensions: JPG, JPEG, PNG, GIF, WEBP.',
        'file.max' => 'Image file size exceeds 5MB limit. Maximum allowed size is 5MB.',
    ]);

    if ($validator->fails()) {
        $errors = $validator->errors();
        
        // Log detailed validation failure information
        $videoErrorsArray = $errors->has('video') ? $errors->get('video') : [];
        
        Log::warning('Validation failed', [
            'errors' => $errors->toArray(),
            'failed_rules' => $errors->keys(),
            'video_errors' => $videoErrorsArray,
        ]);
        
        // Get specific error messages for video
        $videoErrors = $errors->has('video') ? $errors->get('video') : null;
        $firstError = $errors->first();
        
        // If we have video-specific errors, provide more context
        if ($videoErrors && $request->hasFile('video')) {
            $video = $request->file('video');
            $sizeInMB = round($video->getSize() / (1024 * 1024), 2);
            $extension = strtolower($video->getClientOriginalExtension());
            $mimeType = $video->getMimeType();
            
            Log::info('Video validation failed details', [
                'size_mb' => $sizeInMB,
                'extension' => $extension,
                'mime_type' => $mimeType,
                'validation_errors' => is_array($videoErrors) ? $videoErrors : [$videoErrors],
            ]);
        }
        
        return response()->json([
            'errors' => $errors,
            'message' => $firstError ?: 'Validation failed. Please check the errors below.'
        ], 422);
    }

    $subProduct = SubProduct::findOrFail($id);
    $product = Product::findOrFail($request->product_id);

    $filePath = $subProduct->file;
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filePath = $file->store('');
        Log::info('File updated', ['file_path' => $filePath]);
    }

    $videoPath = $subProduct->video;
    Log::info('Video check', [
        'has_file' => $request->hasFile('video'),
        'file_exists' => $request->file('video') !== null,
        'current_video_path' => $videoPath,
    ]);
    
    // Check both hasFile and direct file access
    if ($request->hasFile('video') || $request->file('video') !== null) {
        $video = $request->file('video');
        
        if ($video) {
            // Additional validation checks
            if (!$video->isValid()) {
                $errorCode = $video->getError();
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE => 'Video file size exceeds server upload limit.',
                    UPLOAD_ERR_FORM_SIZE => 'Video file size exceeds form upload limit.',
                    UPLOAD_ERR_PARTIAL => 'Video file was only partially uploaded.',
                    UPLOAD_ERR_NO_FILE => 'No video file was uploaded.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder for video upload.',
                    UPLOAD_ERR_CANT_WRITE => 'Failed to write video file to disk.',
                    UPLOAD_ERR_EXTENSION => 'Video upload stopped by extension.',
                ];
                
                $errorMessage = $errorMessages[$errorCode] ?? 'Video file upload failed with error code: ' . $errorCode;
                Log::error('Video upload error', ['error_code' => $errorCode, 'message' => $errorMessage]);
                
                return response()->json([
                    'errors' => ['video' => [$errorMessage]],
                    'message' => 'Video upload failed. ' . $errorMessage
                ], 422);
            }
            
            // Check file size manually (in case validation didn't catch it)
            $maxSize = 50 * 1024 * 1024; // 50MB
            if ($video->getSize() > $maxSize) {
                $sizeInMB = round($video->getSize() / (1024 * 1024), 2);
                $errorMessage = "Video file size ({$sizeInMB}MB) exceeds 50MB limit.";
                Log::warning('Video size validation failed', ['size' => $video->getSize(), 'max' => $maxSize]);
                
                return response()->json([
                    'errors' => ['video' => [$errorMessage]],
                    'message' => $errorMessage
                ], 422);
            }
            
            // Check file extension
            $allowedExtensions = ['mp4', 'avi', 'mov', 'webm'];
            $extension = strtolower($video->getClientOriginalExtension());
            if (!in_array($extension, $allowedExtensions)) {
                $errorMessage = "Invalid video file extension (.{$extension}). Allowed extensions: " . implode(', ', $allowedExtensions) . ".";
                Log::warning('Video extension validation failed', ['extension' => $extension]);
                
                return response()->json([
                    'errors' => ['video' => [$errorMessage]],
                    'message' => $errorMessage
                ], 422);
            }
            
            Log::info('Video file received and validated', [
                'name' => $video->getClientOriginalName(),
                'size' => $video->getSize(),
                'size_mb' => round($video->getSize() / (1024 * 1024), 2),
                'mime_type' => $video->getMimeType(),
                'extension' => $extension,
            ]);
            
            if ($videoPath) {
                try {
                    Storage::delete($videoPath);
                    Log::info('Old video deleted', ['path' => $videoPath]);
                } catch (\Exception $e) {
                    Log::warning('Failed to delete old video', ['path' => $videoPath, 'error' => $e->getMessage()]);
                }
            }
            
            $videoPath = $video->store('');
            Log::info('New video stored', ['path' => $videoPath]);
        }
    } else {
        Log::info('No video file in request');
    }

    $images = json_decode($subProduct->images, true) ?? [];
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $images[] = $image->store('');
        }
    }

    $subProduct->update([
        'product_id' => $request->product_id,
        'file' => $filePath,
        'color' => $request->color,
        'name' => $request->name,
        'desc' => $request->desc,
        'type' => $product->type,
        'price' => $request->price,
        'capital' => $request->capital,
        'quantity' => $request->quantity,
        'Width' => $product->Width,
        'Height' => $product->Height,
        'Thickness' => $product->Thickness,
        'video' => $videoPath,
        'images' => json_encode($images),
        'delivery_price' => $request->delivery_price,
        'shipping_price' => $request->shipping_price,
    ]);

    // Refresh the model to get updated data
    $subProduct->refresh();

    Log::info('SubProduct updated', [
        'id' => $subProduct->id,
        'video_path' => $subProduct->video,
    ]);

    return response()->json([
        'data' => $subProduct,
        'message' => 'Product updated successfully',
        'video_updated' => $request->hasFile('video'),
    ], 200);
}


    public function destroy($id)
    {
        $subProduct = SubProduct::findOrFail($id);
        $subProduct->delete();
        return response()->json(null, 204);
    }

    public function index_subproducts($productId)
    {
        $subProduct = SubProduct::where('product_id', $productId)->get();

        return response()->json(['data' => $subProduct], 200);

    }

}