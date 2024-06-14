<?php

namespace Modules\Language\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Language\Entities\Language;

class LanguageController extends Controller
{
    public function __construct()
    {
        abort_if(! enableModule('language'), 404);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        if (! userCan('setting.view')) {
            return abort(403);
        }
        try {
            $languages = Language::all();

            return view('language::index', compact('languages'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create()
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            $path = base_path('Modules/Language/Resources/json/languages.json');
            $translations = json_decode(file_get_contents($path), true);

            return view('language::create', compact('translations'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Renderable
     */
    public function store(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        $request->validate(
            [
                'name' => 'required|unique:languages,name',
                'code' => 'required|unique:languages,code',
                'icon' => 'required',
                'direction' => 'required',
            ],
            [
                'name.required' => 'You must select a language',
                'code.required' => 'You must select a language code',
                'icon.required' => 'You must select a flag',
                'direction.required' => 'You must select a direction',
                'name.unique' => 'This language already exists',
                'code.unique' => 'This code already exists',
                'icon.unique' => 'This flag already exists',
            ],
        );
        try {
            $language = Language::create([
                'name' => $request->name,
                'code' => $request->code,
                'icon' => $request->icon,
                'direction' => $request->direction,
            ]);
            flashSuccess('Language Created Successfully. Please translate the language as per your need.');
            if ($language) {
                $baseFile = base_path('resources/lang/en.json');
                $fileName = base_path('resources/lang/'.Str::slug($request->code).'.json');
                copy($baseFile, $fileName);

                flashSuccess('Language Created Successfully. Please translate the language as per your need.');
            } else {
                flashError();

                return back();
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }

        return redirect()->route('language.index');
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('language::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit(Language $language)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            $path = base_path('Modules/Language/Resources/json/languages.json');
            $translations = json_decode(file_get_contents($path), true);

            return view('language::edit', compact('translations', 'language'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(Request $request, Language $language)
    {
        // validation
        $request->validate(
            [
                'name' => "required|unique:languages,name,{$language->id}",
                'code' => "required|unique:languages,code,{$language->id}",
                'icon' => 'required',
                'direction' => 'required',
            ],
            [
                'name.required' => 'You must select a language',
                'code.required' => 'You must select a code',
                'icon.required' => 'You must select a flag',
                'direction.required' => 'You must select a direction',
                'name.unique' => 'This language already exists',
                'code.unique' => 'This code already exists',
                'icon.unique' => 'This flag already exists',
            ],
        );
        try {
            // rename file
            $oldFile = $language->code.'.json';
            $oldName = base_path('resources/lang/'.$oldFile);
            $newFile = Str::slug($request->code).'.json';
            $newName = base_path('resources/lang/'.$newFile);

            rename($oldName, $newName);

            // update
            $updated = $language->update([
                'name' => $request->name,
                'code' => $request->code,
                'icon' => $request->icon,
                'direction' => $request->direction,
            ]);

            $updated ? flashSuccess('Language updated successfully') : flashError();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy(Language $language)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            if (config('templatecookie.default_language') == $language->code) {
                flashError("You can't delete default language");

                return back();
            }

            // delete file
            if (File::exists(base_path('resources/lang/'.$language->code.'.json'))) {
                File::delete(base_path('resources/lang/'.$language->code.'.json'));
            }

            $deleted = $language->delete();

            $deleted ? flashSuccess('Language deleted successfully') : flashError();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function setLanguage(Request $request)
    {
        try {
            if (config('templatecookie.default_language') != $request->code) {
                envReplace('APP_DEFAULT_LANGUAGE', $request->code);
            }

            flashSuccess('Default Language Set Successfully');

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
