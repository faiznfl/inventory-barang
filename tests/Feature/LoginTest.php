<?php

test('login page loads successfully', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
    $response->assertSee('Fixoria Sales');
    $response->assertSee('Welcome Back');
    $response->assertSee('Email Address');
});

test('root redirects to login page', function () {
    $response = $this->get('/');

    $response->assertRedirect('/login');
});

