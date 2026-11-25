@props(['bike'])

<a href="{{ route('bikes.show', $bike->id) }}" class="card card-bikes">
    <div class="card-bikes__image">
        <img class="card-img" src="/images/bikes/orbea-oiz-h30/orbea-oiz-h30.png" alt="{{ $bike->model }}">
    </div>
    <div class="card-bikes__details">
        <h2 class="card-bikes__model">{{ $bike->model }}</h2>
        <div class="card-bikes__colour-container">
            <div class="card-bikes__colour-preview" style="background-color: {{ $bike->colour }};"></div>
            <p class="card-bikes__colour-text">{{ $bike->colour }}</p>
        </div>
        <p class="card-bikes__size">{{ __('pid_size') }}: {{ $bike->size }}</p>
        <p class="card-bikes__price">{{ $bike->price_per_hour }}€/h</p>
    </div>
</a>