<!-- resources/views/upload_citizens.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">إضافة الى مشروع عن طريق ملف Excel</div>
                                     
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-{{ session('status')['type'] }}">
                            {{ session('status')['message'] }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('upload.citizens') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="distribution_id">اختر التوزيع</label>
                            <select name="distribution_id" id="distribution_id" class="form-control" required>
                                <option value="">-- اختر التوزيع --</option>
                                @foreach($distributions as $distribution)
                                    <option value="{{ $distribution->id }}">{{ $distribution->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="citizens_file">ملف Excel للمواطنين</label>
                            <input type="file" name="citizens_file" id="citizens_file" class="form-control-file" required>
                            <small class="form-text text-muted">
                                يجب أن يحتوي الملف على الأعمدة التالية: id (إلزامي)، quantity، recipient، note، done، date.
                                <br>
                                - العمود 'id' يجب أن يحتوي على أرقام هويات المواطنين.
                                <br>
                                - العمود 'done' يجب أن يحتوي على قيم منطقية (TRUE/FALSE).
                                <br>
                                - العمود 'date' يجب أن يكون بتنسيق تاريخ صالح.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary">رفع وإضافة المواطنين</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection