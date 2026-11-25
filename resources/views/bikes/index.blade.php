@extends('layouts.app')

@section('title', __('tid_bikes'))

@section('content')
    <div class="bikes__container__wrapper">
        <section class="bikes__filters">
            <h2>{{ __('pid_bikes_filters') }}</h2>

            <details class="filter-group">
                <summary class="filter-item">
                    <span>{{ __('pid_bikes_availability') }}</span>
                    <x-icons.arrow-down />
                </summary>
                <div class="filter-content">
                    <label>
                        {{ __('pid_bikes_available_only') }}
                        <input type="checkbox" name="available">
                    </label>
                </div>
            </details>

            <details class="filter-group">
                <summary class="filter-item">
                    <span>{{ __('pid_bikes_brand') }}</span>
                    <x-icons.arrow-down />
                </summary>
                <div class="filter-content">
                    <label for="brand">{{ __('pid_bikes_search_brand') }}</label>
                    <input type="text" id="brand" name="brand">
                </div>
            </details>

            <details class="filter-group">
                <summary class="filter-item">
                    <span>{{ __('pid_bikes_model') }}</span>
                    <x-icons.arrow-down />
                </summary>
                <div class="filter-content">
                    <label for="name">{{ __('pid_bikes_search_model') }}</label>
                    <input type="text" id="name" name="name">
                </div>
            </details>

            <details class="filter-group">
                <summary class="filter-item">
                    <span>{{ __('pid_bikes_price') }}</span>
                    <x-icons.arrow-down />
                </summary>
                <div class="filter-content">
                    <label for="price">{{ __('pid_bikes_max_price') }}</label>
                    <input type="number" id="price" name="price" min="0" step="0.01" autocomplete="off">
                </div>
            </details>
        </section>
        <div class="bikes__results">
            <div class="bikes__results-controls">
                <label for="bike-sort">{{ __('pid_bikes_sort') }}</label>
                <select id="bike-sort" name="sort">
                    <option value="">{{ __('pid_bikes_sort_default') }}</option>
                    <option value="price-ascending">{{ __('pid_bikes_sort_ascending') }}</option>
                    <option value="price-descending">{{ __('pid_bikes_sort_descending') }}</option>
                </select>
                <button type="button" id="reset-bike-filters">{{ __('pid_bikes_reset_filters') }}</button>
            </div>
            <p class="bikes__results-count" aria-live="polite">
                {{ __('pid_bikes_results') }}:
                <span id="bike-results-count">{{ $bikes->count() }}</span>
            </p>
            <section class="bikes__container">
                @forelse ($bikes as $bike)
                    <x-cards.bike-card :bike="$bike" />
                @empty
                    <p id="bikes-empty-message">{{ __('pid_bikes_no_results') }}</p>
                @endforelse
                <p id="bikes-filtered-empty-message" hidden>{{ __('pid_bikes_no_results') }}</p>
            </section>
        </div>
    </div>
@endsection