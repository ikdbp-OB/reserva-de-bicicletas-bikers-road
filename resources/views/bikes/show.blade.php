@extends('layouts.app')

@section('title', __('tid_bikes'))

@section('content')
    <section class="bike-show">
        <h1 class="bike-show__title">{{ $bike->model }}</h1>

        <div class="bike-show__content">
            <div class="bike-show__image">
                <img
                    src="{{ $bike->img_route ? asset($bike->img_route) : asset('images/bikes/orbea-oiz-h30/orbea-oiz-h30.png') }}"
                    alt="{{ $bike->model }}"
                >
            </div>

            <aside class="bike-show__details">
                <div class="bike-show__price">
                    <h2>{{ __('pid_price') }}</h2>
                    <p>{{ number_format($bike->price_per_hour, 2, '.', '') }}€/h</p>
                </div>

                <div class="bike-show__option">
                    <h2>{{ __('pid_colour') }}</h2>
                    <p class="bike-show__colour-name">{{ $bike->colour }}</p>
                    <div class="bike-show__colours" aria-label="Colores disponibles">
                        <button
                            type="button"
                            class="bike-show__colour bike-show__colour--selected"
                            style="--colour: {{ $bike->colour }};"
                            aria-label="{{ $bike->colour }}"
                        ></button>
                        <button
                            type="button"
                            class="bike-show__colour bike-show__colour"
                            style="--colour: #8f1732;"
                            aria-label="Rojo"
                        ></button>
                    </div>
                </div>

                <div class="bike-show__option">
                    <h2>{{ __('pid_size') }}</h2>
                    <div class="bike-show__sizes" aria-label="Tallas disponibles">
                        @foreach ([47, 49, 51, 55, 57] as $size) <!-- array fijo de tamaños porque no disponemos de ello actualmente -->
                            <button
                                type="button"
                                class="bike-show__size {{ (int) $bike->size === $size ? 'bike-show__size--selected' : '' }}"
                            >
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="bike-show__description">
                    <h2>{{ __('pid_description') }}</h2>
                    <p>Embrague de grafeno con un peso total de 3kg con aerodinámica óptima para mountain.</p>
                </div>

                <a
                    href="{{ route('bookings.create', $bike->id) }}"
                    class="bike-show__reserve {{ $bike->status !== 'available' ? 'bike-show__reserve--disabled' : '' }}"
                    @if($bike->status !== 'available') aria-disabled="true" @endif
                >
                    <span>{{ __('pid_book') }}</span>
                    <small>{{ $bike->status }}</small>

                </a>
            </aside>
        </div>
    </section>
@endsection