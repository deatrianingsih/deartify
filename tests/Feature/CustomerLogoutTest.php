<?php

use App\Models\User;

test('a customer can log out to the public landing page', function () {
    $customer = User::factory()->make([
        'role' => 'customer',
        'remember_token' => null,
    ]);

    $this->actingAs($customer)
        ->post(route('logout'))
        ->assertRedirect('/');

    $this->assertGuest();
});
