<?php

namespace Modules\Language\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Modules\Language\Entities\Language;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationController extends Controller
{
    public function __construct()
    {
        abort_if(! enableModule('language'), 404);
    }

    public function transUpdate(Request $request)
    {
        if (! userCan('setting.update')) {
            return abort(403);
        }
        try {
            $language = Language::findOrFail($request->lang_id);
            $data = file_get_contents(base_path('resources/lang/'.$language->code.'.json'));

            $translations = json_decode($data, true);

            foreach ($translations as $key => $value) {
                if ($request->$key) {
                    $translations[$key] = $request->$key;
                } else {
                    $translations[$key] = $value;
                }
            }

            $updated = file_put_contents(base_path('resources/lang/'.$language->code.'.json'), json_encode($translations, JSON_UNESCAPED_UNICODE));

            $updated ? flashSuccess('Translations updated successfully') : flashError();

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function autoTransSingle(Request $request)
    {
        try {
            $text = autoTransLation($request->lang, $request->text);

            return response()->json($text);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function transUpdateAutoAll(Request $request)
    {
        try {
            $language = Language::findOrFail($request->lang);
            $data = file_get_contents(base_path('resources/lang/'.$language->code.'.json'));
            $translations = json_decode($data, true);

            $afterTrans = [];
            $tr = new GoogleTranslate($language->code);
            foreach ($translations as $key => $value) {
                $autoTransValue = $tr->translate($value);
                $afterTrans[$key] = $autoTransValue;
            }

            // flashSuccess('Translations updated successfully');
            return response()->json(['data' => $afterTrans]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function langView($code)
    {
        try {
            if (! userCan('setting.update')) {
                return abort(403);
            }

            $path = base_path('resources/lang/'.$code.'.json');
            $language = Language::where('code', $code)->first();
            $originalTranslations = json_decode(file_get_contents($path), true);

            // Get the search keyword from the request
            $keyword = request('keyword');

            // Filter translations based on the keyword
            $translations = $originalTranslations;
            if (! empty($keyword)) {
                $translations = array_filter($translations, function ($value) use ($keyword) {
                    // You can customize the condition based on your requirements
                    return stripos($value, $keyword) !== false;
                });
            }

            // Set the number of items per page to 100
            $perPage = 100;

            // Create a paginator using the paginate method
            $page = request()->input('page', 1);
            $offset = ($page - 1) * $perPage;
            $slicedTranslations = array_slice($translations, $offset, $perPage);
            $translations = new LengthAwarePaginator($slicedTranslations, count($translations), $perPage, $page, ['path' => route('language.view', ['code' => $code])]);

            return view('language::lang_view', compact('language', 'translations', 'keyword'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function changeLanguage($lang)
    {
        try {
            // clear old cache related with language
            forgetCache('default_language');
            forgetCache('current_language');
            session()->put('set_lang', $lang);
            app()->setLocale($lang);

            return back();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function setDefaultLanguage(Request $request)
    {
        try {
            if (env('APP_DEFAULT_LANGUAGE') != $request->code) {
                envReplace('APP_DEFAULT_LANGUAGE', $request->code);
            }

            if (session()->get('set_lang') != $request->code) {
                session()->put('set_lang', $request->code);
                app()->setLocale($request->code);
            }

            return back()->with('success', 'Default Language Added Successfully');
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
