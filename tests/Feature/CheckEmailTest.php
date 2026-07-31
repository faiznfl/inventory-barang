<?php

test('check email page loads successfully', function () {
    $response = $this->get('/check-email');

    $response->assertStatus(200);
    $response->assertSee('Check Your Email');
    $response->assertSee('Fixoria Sales');
    $response->assertSee('Open Email App');
    $response->assertSee('Resend Email');
});

