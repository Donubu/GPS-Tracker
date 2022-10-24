@extends ('layouts.in')

@section ('body')

<form method="get">
    <div class="lg:flex lg:space-x-4">
        <div class="flex-grow mt-2 lg:mt-0">
            <input type="search" class="form-control form-control-lg" placeholder="{{ __('trip-index.filter') }}" data-table-search="#trip-list-table"/>
        </div>

        @if ($devices->count() > 1)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="device_id" :options="$devices" value="id" text="name" data-change-submit></x-select>
        </div>

        @endif

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="last" :options="$lasts" placeholder="{{ __('trip-index.months') }}" data-change-submit></x-select>
        </div>

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="country_id" :options="$countries" value="id" text="name" placeholder="{{ __('trip-index.country') }}" data-change-submit></x-select>
        </div>

        @if ($country)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="state_id" :options="$states" value="id" text="name" placeholder="{{ __('trip-index.state') }}" data-change-submit></x-select>
        </div>

        @endif

        @if ($state)

        <div class="flex-grow mt-2 lg:mt-0">
            <x-select name="city_id" :options="$cities" value="id" text="name" placeholder="{{ __('trip-index.city') }}" data-change-submit></x-select>
        </div>

        @endif
    </div>
</form>

<div class="overflow-auto lg:overflow-visible header-sticky">
    <table id="trip-list-table" class="table table-report sm:mt-2 font-medium text-center whitespace-nowrap" data-table-sort data-table-pagination data-table-pagination-limit="10">
        <thead>
            <tr>
                <th class="text-left">{{ __('trip-index.name') }}</th>
                <th class="text-center">{{ __('trip-index.start_at') }}</th>
                <th class="text-center">{{ __('trip-index.end_at') }}</th>
                <th class="text-center">{{ __('trip-index.distance') }}</th>
                <th class="text-center">{{ __('trip-index.time') }}</th>
                <th class="text-center">{{ __('trip-index.actions') }}</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($list as $row)

            @php ($link = route('trip.update.map', $row->id))

            <tr>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap text-left">{{ $row->name }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->start_at }}</a></td>
                <td><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">{{ $row->end_at }}</a></td>
                <td data-table-sort-value="{{ $row->distance }}"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">@distanceHuman($row->distance)</a></td>
                <td data-table-sort-value="{{ $row->time }}"><a href="{{ $link }}" class="block font-semibold whitespace-nowrap">@timeHuman($row->time)</a></td>

                <td class="text-center w-1">
                    <a href="{{ route('trip.update', $row->id) }}">@icon('edit', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ $link }}">@icon('map', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.position', $row->id) }}">@icon('map-pin', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.update.merge', $row->id) }}">@icon('git-merge', 'w-4 h-4')</a>
                    <span class="mx-2"></span>
                    <a href="{{ route('trip.export', $row->id) }}">@icon('package', 'w-4 h-4')</a>
                </td>
            </tr>

            @endforeach
        </tbody>

        <tfoot class="bg-white">
            <tr>
                <th colspan="3"></th>
                <th class="text-center">@distanceHuman($list->sum('distance'))</th>
                <th class="text-center">@timeHuman($list->sum('time'))</th>
                <th colspan="2"></th>
            </tr>
        </tfoot>
    </table>
</div>

@stop