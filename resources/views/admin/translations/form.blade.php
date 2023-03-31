@extends('admin.layouts.backend')

@section('meta')
    <title>{{ env('APP_NAME') }} - Translations | Edit</title>
    <meta name="title" content="{{ env('APP_NAME') }} - Translations | Edit">
    <meta name="description" content="{{ env('APP_NAME') }} - Translations | Edit">
@endsection

@section('header-right-block-content')
    <x-admin.dashboard.language-switcher :languages="$languages" />
    <x-admin.dashboard.buttons.save-buttons />
@endsection

@section('head-container')
    <x-admin.layouts.head-container :title="'Edit Admin'">
        <x-admin.layouts.breadcrumbs-container>
            <x-admin.dashboard.breadcrumb :href="route('admin.translations.index')" :title="'Translations'" />
            <x-admin.dashboard.breadcrumb :title="'Edit #' . $resource->id" />
        </x-admin.layouts.breadcrumbs-container>
    </x-admin.layouts.head-container>
@endsection

@section('content')
    <x-admin.layouts.block>
        <!-- Form Start --->
        {!! form_start($form) !!}

        <x-admin.layouts.block-content>
            <x-admin.layouts.validation-warning />

            {!! form_until($form, 'delimiter') !!}
        </x-admin.layouts.block-content>

        <x-admin.dashboard.buttons.save-buttons-target />

        {!! form_end($form, false); !!}<!-- Form End -->
    </x-admin.layouts.block>
@endsection
