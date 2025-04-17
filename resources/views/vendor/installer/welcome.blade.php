@extends('vendor.installer.layouts.master')

@section('template_title')
    {{ trans('installer_messages.welcome.templateTitle') }}
@endsection

@section('title')
    {{ trans('installer_messages.welcome.title') }}
@endsection

@section('container')
    <p style="font-size: 14px;color: #495057">
        {!! trans('installer_messages.welcome.message') !!}
    </p>
    <p class="text-center" style="margin-top: 20px;margin-bottom: 0">
        <a href="{{ route('LaravelInstaller::requirements') }}" class="button">
            {{ trans('installer_messages.welcome.next') }}
            <i class="fa fa-angle-right fa-fw" aria-hidden="true"></i>
        </a>
    </p>
@endsection
