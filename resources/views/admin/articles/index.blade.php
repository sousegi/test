@extends('admin.layouts.backend')

@section('meta')
    <title>{{ env('APP_NAME') }} - Articles</title>
    <meta name="title" content="{{ env('APP_NAME') }} - Articles}">
    <meta name="description" content="{{ env('APP_NAME') }} - Articles">
@endsection

@section('header-right-block-content')
    <x-admin.dashboard.buttons.button-add :title="'Add'" :href="route('admin.articles.create')" />
@endsection

@section('head-container')
    <x-admin.layouts.head-container :title="'Articles'" />
@endsection

@section('content')
    <x-admin.layouts.block>
        <x-admin.layouts.block-header :title="'Articles List'" />
        <x-admin.layouts.block-content>
            @if(!$collection->isEmpty())
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center" style="width: 50px;">#</th>
                            <th scope="col">Title</th>
                            <th scope="col" class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collection as $row)
                            <tr class="{{ ($row->published) ?: 'table-danger' }}">
                                <th class="text-center" scope="row">{{ $row->id }}</th>
                                <td class="fw-semibold fs-sm">
                                    <a href="{{ route('admin.articles.edit', $row->id) }}">
                                        {{ $row->title }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <x-admin.dashboard.buttons.button-edit :href="route('admin.articles.edit', $row->id)" />
                                        <x-admin.dashboard.buttons.button-publish :href="route('admin.articles.publish')" :id="$row->id" />
                                        <x-admin.dashboard.buttons.button-delete :href="route('admin.articles.destroy', $row->id)" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-admin.dashboard.pagination :collection="$collection" />
            @else
                <x-admin.layouts.not-found />
            @endif
        </x-admin.layouts.block-content>
    </x-admin.layouts.block>
@endsection
