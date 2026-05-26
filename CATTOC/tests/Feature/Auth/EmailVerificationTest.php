<?php

namespace Tests\Feature\Auth;

use App\Models\TaiKhoan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
        $user = TaiKhoan::factory()->create();
        $this->actingAs($user)->get('/verify-email')->assertStatus(200);
    }
}
