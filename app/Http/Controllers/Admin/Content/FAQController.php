<?php

namespace App\Http\Controllers\Admin\Content;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Content\FaqRequest;
use App\Models\Content\Faq;
use Illuminate\Http\Request;

class FAQController extends Controller
{

    public function index()
    {
        $faqs = Faq::orderBy('id','desc')->simplePaginate(15);
        return view('admin.content.faq.index',compact('faqs'));
    }

    public function create()
    {
        return view('admin.content.faq.create');
    }

    public function store(FaqRequest $request)
    {
        Faq::create($request->all());
        return redirect()->route('admin.content.faq.index')->with('swal-success','سوال جدید با موفقیت ثبت شد!');
    }

    public function show($id)
    {
        //
    }

    public function edit(Faq $faq)
    {
        return view('admin.content.faq.edit',compact('faq'));
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        $faq->update($request->all());
        return redirect()->route('admin.content.faq.index')->with('swal-success','سوال  با موفقیت ویرایش شد!');    }


    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->back()->with('swal-error','سوال  با موفقیت حذف شد!');
    }
    public function status(Faq $faq)
    {
        $faq->status = $faq->status == 0 ? 1 : 0;
        $result = $faq->save();
        if ($result)
        {
            if ($faq->status == 0)
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
