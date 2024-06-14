<?php

namespace Modules\Ad\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ad\Actions\CreateAdGallery;
use Modules\Ad\Actions\DeleteAdGallery;
use Modules\Ad\Entities\AdGallery;

class GalleryController extends Controller
{
    // show gallery page
    public function showGallery($id)
    {
        $adGalleries = AdGallery::where('ad_id', $id)
            ->with('ad:id,title')
            ->latest()
            ->get();

        return view('ad::gallery', compact('id', 'adGalleries'));
    }

    // store gallery images
    public function storeGallery(Request $request, $id)
    {
        try {
            $gallery = CreateAdGallery::create($request, $id);

            if ($gallery) {
                return response()->json([
                    'message' => 'Images Saved Successfully',
                    'url' => route('module.ad.show_gallery', $id),
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
    public function deleteGallery(AdGallery $image)
    {
        try {
            $gallery = DeleteAdGallery::delete($image);

            $gallery ? flashSuccess('Image Deleted Successfully') : flashError();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
