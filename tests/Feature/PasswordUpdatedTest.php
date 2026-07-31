<?php

test('password updated page loads successfully', function () {
    $response = $this->get('/password-updated');

    $response->assertStatus(200);
    $response->assertSee('Password Updated!');
    $response->assertSee('Fixoria Sales');
    $response->assertSee('Sign In Now');
});

