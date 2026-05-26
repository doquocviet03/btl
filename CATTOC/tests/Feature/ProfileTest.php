<?php

namespace Tests\Feature;

use App\Models\TaiKhoan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_is_displayed(): void
    {
        $user = TaiKhoan::factory()->create();

        $this->actingAs($user)->get('/profile')->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $user = TaiKhoan::factory()->create();

        $response = $this->actingAs($user)->patch('/profile', [
            'ho_ten' => 'Test User',
            'so_dien_thoai' => '0900000002',
            'email' => 'updated@example.com',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');
        $user->refresh();
        $this->assertSame('Test User', $user->ho_ten);
        $this->assertSame('updated@example.com', $user->email);
    }

    public function test_user_can_delete_their_account(): void
    {
        $user = TaiKhoan::factory()->create();

        $response = $this->actingAs($user)->delete('/profile', [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/');
        $this->assertGuest();
        $this->assertNull($user->fresh());
    }
}
