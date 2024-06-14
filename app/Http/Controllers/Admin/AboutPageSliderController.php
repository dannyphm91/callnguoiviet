<?php

namespace App\Http\Controllers\Admin;

use App\Actions\File\FileDelete;
use App\Http\Controllers\Controller;
use App\Models\AboutPageSlider;
use Illuminate\Http\Request;

class AboutPageSliderController extends Controller
{
    // store gallery images
    public function aboutStoreGallery(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        try {
            session(['cms_part' => 'about']);

            foreach ($request->file as $image) {
                if ($image && $image->isValid()) {

                    $url = uploadImage($image, 'about-slider-images', true);

                    $aboutSlider = AboutPageSlider::create([
                        'url' => $url,
                    ]);
                }
            }

            if ($aboutSlider) {
                return response()->json([
                    'message' => 'Images Saved Successfully',
                    'url' => route('settings.cms'),
                ]);
            } else {
                flashError();

                return back();
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    // delete gallery image
    public function aboutDeleteGallery(AboutPageSlider $image)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }

        try {
            session(['cms_part' => 'about']);

            $imagePath = public_path($image->url);

            // Check if the file exists before attempting to delete it
            if (file_exists($imagePath)) {
                FileDelete::delete($imagePath);
            }

            $image->delete();

            $imagePath ? flashSuccess('Image Deleted Successfully') : flashError();

            return back();

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
