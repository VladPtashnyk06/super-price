<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $blogs = Blog::all();
        $queryParams = $request->only(['title']);
        $filteredParams = array_filter($queryParams);
        $query = Blog::query();

        if (isset($filteredParams['title'])) {
            $query->where('title', 'LIKE', '%' . $filteredParams['title'] . '%');
        }
        $blogs = $query->get();
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create() {
        return view('admin.blogs.create');
    }

    public function store(BlogRequest $request)
    {
        $newBlog = Blog::create($request->validated());
        if (!empty($request->validated('main_image'))) {
            $newBlog->addMedia($request->validated('main_image'))->withCustomProperties([
                'alt' => $request->validated('alt'),
            ])->toMediaCollection('blog'.$newBlog->id);
        }

        return redirect()->route('blog.index');
    }

    public function showComments(Blog $blog)
    {
        $comments = $blog->comments()->get();
        return view('admin.blogs.blogComments', compact('blog', 'comments'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->update($request->validated());

        if ($request->validated('main_media_id')) {
            $media = Media::find($request->validated('main_media_id'));
            $media->collection_name = 'blog'.$blog->id;
            $media->custom_properties = [
                'alt' => $request->validated('alt'),
            ];
            $media->save();
        }
        if ($request->validated('deleted_main_image')) {
            $idDeletedPoster = $request->validated('deleted_main_image');
            Media::find($idDeletedPoster)->delete();
        }

        if ($request->validated('main_image')) {
            $blog->addMedia($request->validated('main_image'))->withCustomProperties([
                'alt' => $request->validated('alt'),
            ])->toMediaCollection('blog'.$blog->id);
        }

        return redirect()->route('blog.index');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return back();
    }
}
