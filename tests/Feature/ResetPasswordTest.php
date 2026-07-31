<?php

test('reset password page loads successfully', function () {
    $response = $this->get('/reset-password/sample-token');

    $response->assertStatus(200);
    $response->assertSee('Create New Password');
    $response->assertSee('Fixoria Sales');
    $response->assertSee('Confirm New Password');
    $response->assertSee('PASSWORD REQUIREMENTS');
});

test('reset password form submission redirects to login', function () {
    $response = $this->post('/reset-password', [
        'token' => 'sample-token',
        'email' => 'user@company.com',
        'password' => 'NewPassword123!',
        'password_confirmation' => 'NewPassword123!',
    ]);

    $response->assertRedirect('/password-updated');
});


