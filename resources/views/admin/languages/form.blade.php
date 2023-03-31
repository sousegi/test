@extends('admin.layouts.backend')

@section('meta')
    @if(isset($resource->id))
        <title>{{ env('APP_NAME') }} - Languages | Edit</title>
        <meta name="title" content="{{ env('APP_NAME') }} - Languages | Edit">
        <meta name="description" content="{{ env('APP_NAME') }} - Languages | Edit">
    @else
        <title>{{ env('APP_NAME') }} - Languages | Create new language</title>
        <meta name="title" content="{{ env('APP_NAME') }} - Languages | Create new language">
        <meta name="description" content="{{ env('APP_NAME') }} - Languages | Create new language">
    @endif
@endsection

@section('header-right-block-content')
    <x-admin.dashboard.buttons.save-buttons />
@endsection

@section('head-container')
    @if(isset($resource->id))
        <x-admin.layouts.head-container :title="'Edit Language'">
            <x-admin.layouts.breadcrumbs-container>
                <x-admin.dashboard.breadcrumb :href="route('admin.languages.index')" :title="'Languages'" />
                <x-admin.dashboard.breadcrumb :title="'Edit #' . $resource->id" />
            </x-admin.layouts.breadcrumbs-container>
        </x-admin.layouts.head-container>
    @else
        <x-admin.layouts.head-container :title="'Create new language'">
            <x-admin.layouts.breadcrumbs-container>
                <x-admin.dashboard.breadcrumb :href="route('admin.languages.index')" :title="'Languages'" />
                <x-admin.dashboard.breadcrumb :title="'Create new language'" />
            </x-admin.layouts.breadcrumbs-container>
        </x-admin.layouts.head-container>
    @endif
@endsection

@section('content')
    <x-admin.layouts.block>
        <!-- Form Start --->
        {!! form_start($form) !!}

        <x-admin.layouts.block-content>
            {!! form_until($form, 'delimiter') !!}
        </x-admin.layouts.block-content>

        <x-admin.dashboard.buttons.save-buttons-target />

        {!! form_end($form, false); !!}<!-- Form End -->
    </x-admin.layouts.block>
@endsection
