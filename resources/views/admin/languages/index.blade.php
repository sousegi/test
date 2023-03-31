@extends('admin.layouts.backend')

@section('meta')
    <title>{{ env('APP_NAME') }} - Languages</title>
    <meta name="title" content="{{ env('APP_NAME') }} - Languages">
    <meta name="description" content="{{ env('APP_NAME') }} - Languages">
@endsection

@section('header-right-block-content')
    <x-admin.dashboard.buttons.button-add :title="'Add'" :href="route('admin.languages.create')" />
@endsection

@section('head-container')
    <x-admin.layouts.head-container :title="'Languages'" />
@endsection

@section('content')
    <x-admin.layouts.block>
        <x-admin.layouts.block-header :title="'Languages List'" />
        <x-admin.layouts.block-content>
            @if(!$collection->isEmpty())
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th scope="col">Language</th>
                            <th scope="col">Locale</th>
                            <th scope="col">Enabled on website</th>
                            <th scope="col">Enabled on website</th>
                            <th scope="col" class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collection as $row)
                            <tr>
                                <th class="fw-semibold fs-sm">
                                    <a href="{{ route('admin.languages.edit', $row->id) }}">
                                        {{ $row->title }}
                                    </a>
                                </th>

                                <td>{{ $row->locale }}</td>

                                <td>
                                    @if($row->site)
                                        <x-admin.dashboard.badge :title="'Yes'" :type="'success'"/>
                                    @else
                                        <x-admin.dashboard.badge :title="'No'" :type="'danger'"/>
                                    @endif
                                </td>

                                <td>
                                    @if($row->admin)
                                        <x-admin.dashboard.badge :title="'Yes'" :type="'success'"/>
                                    @else
                                        <x-admin.dashboard.badge :title="'No'" :type="'danger'"/>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <x-admin.dashboard.buttons.button-edit :href="route('admin.languages.edit', $row->id)" />
                                        <x-admin.dashboard.buttons.button-delete :href="route('admin.languages.destroy', $row->id)" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <x-admin.layouts.not-found />
            @endif
        </x-admin.layouts.block-content>
    </x-admin.layouts.block>
@endsection
