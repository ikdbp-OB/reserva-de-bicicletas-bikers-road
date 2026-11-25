<?php

use App\Models\Bike;
use App\Models\User;

it('stores booking datetimes in UTC after receiving Madrid local times', function () {
    $user = User::factory()->create();
    $bike = Bike::factory()->create(['status' => 'available']);

    $this->actingAs($user)
        ->post(route('bookings.store'), [
            'bike_id' => $bike->id,
            'start_time' => '2030-07-15T10:30',
            'end_time' => '2030-07-16T12:45',
        ])
        ->assertRedirect(route('bookings.index'));

    $this->assertDatabaseHas('bookings', [
        'bike_id' => $bike->id,
        'start_time' => '2030-07-15 08:30:00',
        'end_time' => '2030-07-16 10:45:00',
    ]);
});

it('rejects a booking whose end time is not after its start time', function () {
    $user = User::factory()->create();
    $bike = Bike::factory()->create(['status' => 'available']);

    $this->actingAs($user)
        ->post(route('bookings.store'), [
            'bike_id' => $bike->id,
            'start_time' => '2030-07-15T10:30',
            'end_time' => '2030-07-15T10:30',
        ])
        ->assertSessionHasErrors('end_time');

    $this->assertDatabaseCount('bookings', 0);
});
