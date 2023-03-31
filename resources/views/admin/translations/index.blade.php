@extends('admin.layouts.backend')

@section('meta')
    <title>{{ env('APP_NAME') }} - Translations</title>
    <meta name="title" content="{{ env('APP_NAME') }} - Translations">
    <meta name="description" content="{{ env('APP_NAME') }} - Translations">
@endsection

@section('head-container')
   <x-admin.layouts.head-container :title="'Translations'" />
@endsection

@section('content')
    <x-admin.layouts.block>
        <x-admin.layouts.block-header :title="'Translations List'" />
        <x-admin.layouts.block-content>
            @if(!$collection->isEmpty())
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th scope="col" class="text-center" style="width: 50px;">#</th>
                            <th scope="col">Constant</th>

                            @foreach($languages as $key => $lang)
                                <th scope="col">Content {{ strtoupper($lang['locale']) }}</th>
                            @endforeach

                            <th scope="col" class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($collection as $row)
                            <tr>
                                <th class="text-center" scope="row">{{ $row->id }}</th>
                                <td class="fw-semibold fs-sm">
                                    <a href="{{ route('admin.translations.edit', $row->id) }}">
                                        {{ $row->key }}
                                    </a>
                                </td>
                                @foreach($languages as $key => $lang)
                                    <th scope="col">{!! $row->getTranslation('content', $lang['locale'], false) !!}</th>
                                @endforeach
                                <td class="text-center">
                                    <div class="btn-group">
                                        <x-admin.dashboard.buttons.button-edit :href="route('admin.translations.edit', $row->id)" />
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
