@extends('layouts.client');
@section('title')
    {{$title}}
@endsection

@section('sidebar')
    @parent
    <h3>Home sidebar</h3>
@endsection

@section('content')
    @if(session('msg'))
    <div class="alert alert-{{session('type')}}">
        {{session('msg')}}
    </div>
    @endif
    <h1>Trang chu</h1>
    
    @include('clients.contents.slide')
    @include('clients.contents.about')

    @env('production')
    <p>Moi truong Production</p>
    @elseenv('test')
    <p>Moi truong test</p>
    @elseenv
    <p>Moi truong dev</p>
    @endenv
    
    <x-alert type="info" :content="$message" data-icon="youtube"/>

    {{-- <x-inputs.button /> --}}

    {{-- <x-form-button/> --}}

    {{-- <x-forms.button /> --}}
    <p><img src="https://carshop.vn/wp-content/uploads/2022/07/hinh-sieu-xe-1.jpg" alt=""></p>

    <p><a href="{{ route('download-image', ['image' => public_path('storage/THM_zing.jpg')]) }}" class="btn btn-primary">Download ảnh</a></p>

    <p><a href="{{ route('download-doc', ['file' => public_path('storage/demo_pdf.pdf')]) }}" class="btn btn-primary">Download tài liệu</a></p>

@endsection

@section('css')
    <style>
        img{
            max-width: 100%;
            height: auto;
        }
    </style>
@endsection

@section('js')

@endsection