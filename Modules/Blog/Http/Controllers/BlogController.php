<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Actions\CreatePost;
use Modules\Blog\Actions\DeletePost;
use Modules\Blog\Actions\UpdatePost;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;
use Modules\Blog\Http\Requests\PostFormRequest;

class BlogController extends Controller
{
    use ValidatesRequests;

    public function __construct()
    {
        abort_if(! enableModule('blog'), 404);
    }

    /**
     * Display a listing of the post list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (! userCan('post.view')) {
            return abort(403);
        }
        try {
            $data['posts'] = Post::with('category')
                ->latest()
                ->when($request->has('keyword') && $request->keyword != null, function ($q) use ($request) {
                    $q->where('title', 'LIKE', "%$request->keyword %");
                })
                ->when($request->has('category') && $request->category != null, function ($q) use ($request) {
                    $q->whereRelation('category', function ($q) use ($request) {
                        $q->where('slug', $request->category);
                    });
                })
                ->paginate(20)
                ->withQueryString();
            $data['total_posts'] = Post::count();
            $data['total_categories'] = PostCategory::count();
            $data['categories'] = PostCategory::latest()->get(['id', 'name', 'slug']);

            return view('blog::index', $data);
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! userCan('post.create')) {
            return abort(403);
        }
        try {
            $categories = PostCategory::all();

            if ($categories->count() < 1) {
                flashWarning("You don't have any post category. Please create category first.");

                return redirect()->route('module.postcategory.index');
            }

            return view('blog::create', compact('categories'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostFormRequest $request)
    {
        if (! userCan('post.create')) {
            return abort(403);
        }
        try {
            $post = CreatePost::create($request);

            if ($post) {
                flashSuccess('Post Created Successfully');

                return back();
            } else {
                flashError();

                return back();
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Show the form for editing the specified post.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (! userCan('post.update')) {
            return abort(403);
        }
        try {
            $categories = PostCategory::all();

            return view('blog::edit', compact('categories', 'post'));
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PostFormRequest $request, Post $post)
    {
        if (! userCan('post.update')) {
            return abort(403);
        }
        try {
            $post = UpdatePost::update($request, $post);

            if ($post) {
                flashSuccess('Post Updated Successfully');

                return back();
            } else {
                flashError();

                return back();
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified post from storage.
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Post $post)
    {
        try {
            if (! userCan('post.delete')) {
                return abort(403);
            }

            $post = DeletePost::delete($post);

            if ($post) {
                flashSuccess('Post Deleted Successfully');

                return back();
            } else {
                flashError();

                return back();
            }
        } catch (\Exception $e) {
            flashError('An error occurred: '.$e->getMessage());

            return back();
        }
    }
}
