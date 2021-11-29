<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_calculate_mean()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('api/report/mean');
        $response->assertStatus(200);
        $response->assertSee('23:38:28');
        
    }
}
