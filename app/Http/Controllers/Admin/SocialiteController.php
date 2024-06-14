<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SocialiteController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:setting.view|setting.update'])->only(['index']);
        $this->middleware(['permission:setting.update'])->only(['update']);
        $this->middleware('access_limitation')->only(['update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.settings.pages.socialite');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        try {
            switch ($request->type) {
                case 'google':
                    $this->updateGoogleCredential($request);
                    break;
                case 'facebook':
                    $this->updateFacebookCredential($request);
                    break;
                case 'twitter':
                    $this->updateTwitterCredential($request);
                    break;
                case 'linkedin':
                    $this->updateLinkedinCredential($request);
                    break;
                case 'github':
                    $this->updateGithubCredential($request);
                    break;
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update login with google credential
     *
     * @return void
     */
    public function updateGoogleCredential(Request $request)
    {
        $request->validate([
            'google_client_id' => ['required'],
            'google_client_secret' => ['required'],
        ]);
        try {
            checkSetConfig('services.google.client_id', $request->google_client_id);
            checkSetConfig('services.google.client_secret', $request->google_client_secret);

            sleep(2);
            Artisan::call('cache:clear');
            // session()->flash('success', ucfirst($request->type).' Setting update successfully!');
            flashSuccess('Setting update successfully!');

            return redirect()
                ->route('settings.social.login')
                ->send();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update login with facebook credential
     *
     * @return void
     */
    public function updateFacebookCredential(Request $request)
    {
        $request->validate([
            'facebook_client_id' => ['required'],
            'facebook_client_secret' => ['required'],
        ]);
        try {
            checkSetConfig('services.facebook.client_id', $request->facebook_client_id);
            checkSetConfig('services.facebook.client_secret', $request->facebook_client_secret);

            sleep(2);

            Artisan::call('cache:clear');
            session()->flash('success', ucfirst($request->type).' Setting update successfully!');

            return redirect()
                ->route('settings.social.login')
                ->send();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update login with twitter credential
     *
     * @return void
     */
    public function updateTwitterCredential(Request $request)
    {
        $request->validate([
            'twitter_client_id' => ['required'],
            'twitter_client_secret' => ['required'],
        ]);
        try {
            checkSetConfig('services.twitter.client_id', $request->twitter_client_id);
            checkSetConfig('services.twitter.client_secret', $request->twitter_client_secret);

            sleep(2);

            Artisan::call('cache:clear');

            session()->flash('success', ucfirst($request->type).' Setting update successfully!');

            return redirect()
                ->route('settings.social.login')
                ->send();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update login with linkedin credential
     *
     * @return void
     */
    public function updateLinkedinCredential(Request $request)
    {
        $request->validate([
            'linkedin_client_id' => ['required'],
            'linkedin_client_secret' => ['required'],
        ]);
        try {
            checkSetConfig('services.linkedin.client_id', $request->linkedin_client_id);
            checkSetConfig('services.linkedin.client_secret', $request->linkedin_client_secret);

            sleep(2);

            Artisan::call('cache:clear');

            session()->flash('success', ucfirst($request->type).' Setting update successfully!');

            return redirect()
                ->route('settings.social.login')
                ->send();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update login with github credential
     *
     * @return void
     */
    public function updateGithubCredential(Request $request)
    {
        $request->validate([
            'github_client_id' => ['required'],
            'github_client_secret' => ['required'],
        ]);
        try {
            checkSetConfig('services.github.client_id', $request->github_client_id);
            checkSetConfig('services.github.client_secret', $request->github_client_secret);

            sleep(2);

            Artisan::call('cache:clear');
            session()->flash('success', ucfirst($request->type).' Setting update successfully!');

            return redirect()
                ->route('settings.social.login')
                ->send();
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $type = $request->type;
            $status = $request->status;
            switch ($type) {
                case 'google':
                    setConfig('services.google.active', $status ? true : false);
                    break;
                case 'facebook':
                    setConfig('services.facebook.active', $status ? true : false);
                    break;
                case 'twitter':
                    setConfig('services.twitter.active', $status ? true : false);
                    break;
                case 'linkedin':
                    setConfig('services.linkedin.active', $status ? true : false);
                    break;
                case 'github':
                    setConfig('services.github.active', $status ? true : false);
                    break;
            }

            sleep(1);
            Artisan::call('cache:clear');

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
