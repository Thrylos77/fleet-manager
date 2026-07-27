<?php

test('registration screen is not publicly available', function () {
    $response = $this->get('/register');

    $response->assertStatus(404);
});
