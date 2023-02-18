<?php

it('has project page', function () {
    $response = $this->get('/project');

    $response->assertStatus(200);
});
