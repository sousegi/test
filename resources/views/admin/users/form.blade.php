@extends('admin.layouts.backend')

@section('meta')
    @if(isset($resource->id))
        <title>{{ env('APP_NAME') }} - Users | Edit</title>
        <meta name="title" content="{{ env('APP_NAME') }} - Users | Edit">
        <meta name="description" content="{{ env('APP_NAME') }} - Users | Edit">
    @else
        <title>{{ env('APP_NAME') }} - Users | Create new User</title>
        <meta name="title" content="{{ env('APP_NAME') }} - Users | Create new User">
        <meta name="description" content="{{ env('APP_NAME') }} - Users | Create new User">
    @endif
@endsection

@section('header-right-block-content')
    <x-admin.dashboard.language-switcher :languages="$languages" />
    <x-admin.dashboard.buttons.save-buttons />
@endsection

@section('head-container')
    @if(isset($resource->id))
        <x-admin.layouts.head-container :title="'Edit User'">
            <x-admin.layouts.breadcrumbs-container>
                <x-admin.dashboard.breadcrumb :href="route('admin.users.index')" :title="'Users'" />
                <x-admin.dashboard.breadcrumb :title="'Edit #' . $resource->id" />
            </x-admin.layouts.breadcrumbs-container>
        </x-admin.layouts.head-container>
    @else
        <x-admin.layouts.head-container :title="'Create new User'">
            <x-admin.layouts.breadcrumbs-container>
                <x-admin.dashboard.breadcrumb :href="route('admin.users.index')" :title="'Users'" />
                <x-admin.dashboard.breadcrumb :title="'Create new User'" />
            </x-admin.layouts.breadcrumbs-container>
        </x-admin.layouts.head-container>
    @endif
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
