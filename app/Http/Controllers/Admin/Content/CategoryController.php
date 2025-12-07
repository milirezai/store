<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\PostCategoryRequest;
use App\Models\Content\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use App\Http\Services\Image\ImageService;

use App\Http\Services\Image\ImageCacheService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postCategories = PostCategory::orderBy('created_at','desc')->simplePaginate(15);
        return view('admin.content.category.index',compact('postCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.content.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCategoryRequest $request, ImageService $imageService)
    {
        $inputs = $request->all();
        if ($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images'.DIRECTORY_SEPARATOR.'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false)
                return redirect()->route('admin.content.category.index')->with('swal-error','آپلود عکس با خطا مواجه شد!');
            $inputs['image'] = $result;
        }
        PostCategory::create($inputs);
        return redirect()->route('admin.content.category.index')->with('swal-success','دسته بندی جدید با موفقیت ثبت شد')
        ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(PostCategory $postCategory)
    {
        return view('admin.content.category.edit',compact('postCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostCategoryRequest $request, PostCategory $postCategory, ImageService $imageService)
    {
        $inputs = $request->all();
        if($request->hasFile('image'))
        {
            if(!empty($postCategory->image))
            {
                $imageService->deleteDirectoryAndFiles($postCategory->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if($result === false)
            {
                return redirect()->route('admin.content.category.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }
        else{
            if(isset($inputs['currentImage']) && !empty($postCategory->image))
            {
                $image = $postCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $postCategory->update($inputs);
        return redirect()->route('admin.content.category.index')->with('swal-success','دسته بندی  با موفقیت ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PostCategory $postCategory)
    {
        $postCategory->delete();
        return redirect()->back()->with('swal-error','دسته بندی  با موفقیت حذف شد!');
    }
    public function status(PostCategory $postCategory)
    {
        $postCategory->status = $postCategory->status == 0 ? 1 : 0;
        $result = $postCategory->save();
        if ($result)
        {
            if ($postCategory->status == 0)
                return response()->json(['status' => true, 'checked' => false]);
            else
                return response()->json(['status' => true, 'checked' => true]);
        }
        else
        {
            return response()->json(['status' => false]);
        }
    }

}
