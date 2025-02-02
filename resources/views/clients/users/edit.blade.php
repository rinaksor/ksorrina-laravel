@extends('layouts.client')

@section('title')
    {{ $title }}
@endsection

@section('content')
    @hasSection('msg')
        <div class="alert alert-success">{{ session('msg') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">Dữ liệu nhập vào không hợp lệ. Vui lòng kiểm tra lại.</div>
    @endif

    <h1>{{ $title }}</h1>

    <form action="{{route('users.post-edit')}}" method="POST">
        <div class="md-3">
            <label for="">Họ và tên</label>
            <input type="text" class="form-control" name="fullname" placeholder="Họ và tên..." value="{{old('fulname') ??  $userDetail->fullname}}">
            @error('fullname')
            <span style="color: red">{{$message}}</span>
            @enderror
        </div>

        <div class="md-3">
            <label for="">Email</label>
            <input type="text" class="form-control" name="email" placeholder="Email..." value="{{old('fulname') ?? $userDetail->email}}">
            @error('email')
            <span style="color: red">{{$message}}</span>
            @enderror
        </div>

        <div class="md-3">
            <label for="">Nhóm</label>
            <select name="group_id" class="form-control" id="">
                <option value="0">Chọn nhóm </option>
                @if (!empty($allGroups))
                    @foreach($allGroups as $item)
                        <option value="{{$item->id}}" {{old('group_id')==$item->id|| $userDetail->group_id==$item->id?'selected':false}}>{{$item->name}}</option>
                    @endforeach
                @endif
            </select>
            @error('group_id')
            <span style="color:red">{{$message}}</span>
            @enderror
            
        </div>

        <div class="md-3">
            <label for="">Trạng thái</label>
            <select name="status" class="form-control" id="">
                <option value="0" {{old('status')==0|| $usserDetail->status==0?'selected':false}}>Chưa kích hoạt </option>
                <option value="1" {{old('status')==1|| $usserDetail->status==1?'selected':false}}>Kích hoạt </option>
                
            </select>
            
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{route('users.index')}}" class="btn btn-warning">Quay lại</a>
        @csrf
    </form>
@endsection
