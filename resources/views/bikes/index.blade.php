@extends('layouts.app')

@section('title', __('tid_bikes'))

@section('content')
    <div class="bikes__container__wrapper">
        <section class="bikes__filters">
            <h2>Filtros</h2>

            <details class="filter-group">
                <summary class="filter-item">
                    <span>Disponibilidad</span>
                    <x-icons.arrow-down />
                </summary>
                <div class="filter-content">
                    <label>
                        Mostrar bicicletas disponibles
                        <input type="checkbox" name="available">
                    </label>
                </div>
            </details>

            <details class="filter-group">
                <summary class="filter-item">
                    <span>Marca</span>
                    <x-icons.arrow-down />
                </summary>
                <div class="filter-content">
                    <label for="brand">Buscar por marca</label>
                    <input type="text" id="brand" name="brand">
                </div>
            </details>

            <details class="filter-group">
                <summary class="filter-item">
                    <span>Nombre</span>
                    <x-icons.arrow-down />
                </summary>
                <div class="filter-content">
                    <label for="name">Buscar por nombre</label>
                    <input type="text" id="name" name="name">
                </div>
            </details>

            <details class="filter-group">
                <summary class="filter-item">
                    <span>Precio</span>
                    <x-icons.arrow-down />
                </summary>
                <div class="filter-content">
                    <label for="price">Buscar por precio</label>
                    <input type="number" id="price" name="price" value="0.00" min="0" step="0.01" autocomplete="off">
                </div>
            </details>
        </section>
        <section class="bikes__container">
            @forelse ($bikes as $bike)
                <x-cards.bike-card :bike="$bike" />
            @empty
                <p>No hay bicis disponibles.</p>
            @endforelse
        </section>
    </div>
@endsection