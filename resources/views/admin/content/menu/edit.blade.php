@extends('admin.layouts.master')

@section('head-tag')
<title>منو</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">خانه</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">بخش فروش</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">منو</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد منو</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                  ویرایش منو
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.content.menu.index') }}" class="btn btn-info btn-sm">بازگشت</a>
            </section>

            <section>
                <form action="{{ route('admin.content.menu.update',[$menu->id]) }}" method="post" id="form">
                    @csrf
                    {{ method_field('put') }}
                    <section class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">عنوان منو</label>
                                <input value="{{ old('name',$menu->name) }}" name="name" type="text" class="form-control form-control-sm">
                            </div>
                            @error('name')
                            <span class="alert-required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="parent_id">منو والد</label>
                                <select name="parent_id" id="parent_id" class="form-control form-control-sm">
                                    <option value="">منو اصلی</option>
                                @foreach($menus as $item)
                                        <option value="{{ $item->id }}"
                                            @if(old('parent_id',$menu->parent_id) == $item->id) selected @endif>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('parent_id')
                            <span class="alert-required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">آدرس URL</label>
                                <input value="{{ old('url',$menu->url) }}" type="text" name="url" class="form-control form-control-sm">
                            </div>
                            @error('url')
                            <span class="alert-required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select name="status" id="" class="form-control form-control-sm" id="status">
                                    <option value="0" @if(old('status') == 0) selected @endif>غیرفعال</option>
                                    <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                </select>
                            </div>
                            @error('status')
                            <span class="alert-required text-danger" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                        </section>
                    </section>
                </form>
            </section>

        </section>
    </section>
</section>

@endsection
