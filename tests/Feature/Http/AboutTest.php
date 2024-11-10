<?php

namespace Tests\Feature\Http;

use Inertia\Testing\AssertableInertia;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Tests\Feature\TestCase;

class AboutTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_it_returns_about_page(): void
    {
        $response = $this->get('/about');

        $response->assertStatus(HttpResponse::HTTP_OK);

        $response->assertInertia(function (AssertableInertia $page) {
            $page->component('About');
        });
    }
}
