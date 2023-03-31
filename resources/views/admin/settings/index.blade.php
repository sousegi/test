@extends('admin.layouts.backend')

@section('meta')
    <title>{{ env('APP_NAME') }} - Site Settings</title>
    <meta name="title" content="{{ env('APP_NAME') }} - Site Settings">
    <meta name="description" content="{{ env('APP_NAME') }} - Site Settings">
@endsection

@section('header-right-block-content')
    <x-admin.dashboard.buttons.button-save/>
@endsection

@section('head-container')
    <x-admin.layouts.head-container :title="'Site Settings'"/>
@endsection

@section('content')
    <!-- Form Start --->
    {!! form_start($form) !!}

    <x-admin.layouts.block>
        <x-admin.layouts.tablist>
            <x-admin.dashboard.tablist.tab-link :title="'Main settings'" :active="(int) $tab === 1" :target="'main'"/>
            <x-admin.dashboard.tablist.tab-link :title="'Contacts'" :active="(int) $tab === 2" :target="'contacts'"/>
            <x-admin.dashboard.tablist.tab-link :title="'Social media'" :active="(int) $tab === 3" :target="'social-media'"/>
            <x-admin.dashboard.tablist.tab-link :title="'Embedded'" :active="(int) $tab === 4" :target="'embedded'"/>
        </x-admin.layouts.tablist>

        <x-admin.dashboard.tablist.block-content-tab>
            <x-admin.dashboard.tablist.tab-pane :target="'main'" :active="(int) $tab === 1">
                {!! form_until($form, 'site.description') !!}
            </x-admin.dashboard.tablist.tab-pane>

            <x-admin.dashboard.tablist.tab-pane :target="'contacts'" :active="(int) $tab === 2">
                {!! form_until($form, 'site.email') !!}
            </x-admin.dashboard.tablist.tab-pane>

            <x-admin.dashboard.tablist.tab-pane :target="'social-media'" :active="(int) $tab === 3">
                {!! form_until($form, 'site.cover.image') !!}
                @if(!is_null($settings['site.cover.image']))
                    <div class="form-group">
                        <div class="options-container">
                            <img src="{{ asset($settings['site.cover.image']) }}" alt="favicon" class="img-fluid">
                        </div>
                    </div>
                @endif
            </x-admin.dashboard.tablist.tab-pane>

            <x-admin.dashboard.tablist.tab-pane :target="'embedded'" :active="(int) $tab === 4">
                {!! form_until($form, 'site.google.remarketing') !!}
            </x-admin.dashboard.tablist.tab-pane>
        </x-admin.dashboard.tablist.block-content-tab>
    </x-admin.layouts.block>

    <x-admin.dashboard.buttons.save-buttons-target/>

    {!! form_end($form, false); !!}
    <!-- Form End --->
@endsection

