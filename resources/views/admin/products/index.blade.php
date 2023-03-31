@extends('admin.layouts.backend')

@section('meta')
    <title>{{ env('APP_NAME') }} - Products</title>
    <meta name="title" content="{{ env('APP_NAME') }} - Products}">
    <meta name="description" content="{{ env('APP_NAME') }} - Products">
@endsection

@section('header-right-block-content')
    <x-admin.dashboard.buttons.button-add :title="'Add'" :href="route('admin.products.create')" />
@endsection

@section('head-container')
    <x-admin.layouts.head-container :title="'Products'" />
@endsection

@section('content')
    <x-admin.layouts.block>
        <x-admin.layouts.block-header :title="'Products List'" />
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
                                    <a href="{{ route('admin.products.edit', $row->id) }}">
                                        {{ $row->title }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <x-admin.dashboard.buttons.button-edit :href="route('admin.products.edit', $row->id)" />
                                        <x-admin.dashboard.buttons.button-publish :href="route('admin.products.publish')" :id="$row->id" />
                                        <x-admin.dashboard.buttons.button-delete :href="route('admin.products.destroy', $row->id)" />
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
