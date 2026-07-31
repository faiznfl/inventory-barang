<?php

test('forgot password page loads successfully', function () {
    $response = $this->get('/forgot-password');

    $response->assertStatus(200);
    $response->assertSee('Forgot Password?');
    $response->assertSee('Fixoria Sales');
    $response->assertSee('Send Reset Link');
});

test('forgot password form submission displays status message', function () {
    $response = $this->post('/forgot-password', [
        'email' => 'test@company.com',
    ]);

    $response->assertSessionHas('status');
    $response->assertRedirect('/check-email');
});


