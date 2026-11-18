<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseTransactions;

    public function test_about_page_is_public(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee('Tentang NOK')
            ->assertSee('PT NOK');
    }

    public function test_authenticated_user_can_update_own_phone_and_password(): void
    {
        $user = User::create([
            'name' => 'Profil Pengguna',
            'email' => 'profil-'.uniqid().'@example.test',
            'password' => Hash::make('password123'),
            'role' => 'karyawan',
        ]);

        $this->actingAs($user)->patch(route('profile.update'), [
            'phone' => '08123456789',
            'password' => 'password-baru',
            'password_confirmation' => 'password-baru',
        ])->assertSessionHasNoErrors()->assertRedirect();

        $user->refresh();
        $this->assertSame('08123456789', $user->phone);
        $this->assertTrue(Hash::check('password-baru', $user->password));
    }

    public function test_user_can_upload_and_remove_own_profile_photo(): void
    {
        Storage::fake('public');
        $user = User::create([
            'name' => 'Foto Pengguna',
            'email' => 'foto-'.uniqid().'@example.test',
            'password' => Hash::make('password123'),
            'role' => 'karyawan',
        ]);

        $this->actingAs($user)->patch(route('profile.update'), [
            'photo' => UploadedFile::fake()->image('foto.png'),
        ])->assertSessionHasNoErrors();

        $path = $user->fresh()->profile_photo_path;
        $this->assertNotNull($path);
        Storage::disk('public')->assertExists($path);

        $this->actingAs($user->fresh())->patch(route('profile.update'), ['remove_photo' => true])
            ->assertSessionHasNoErrors();

        $this->assertNull($user->fresh()->profile_photo_path);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_profile_rejects_non_image_or_large_uploads(): void
    {
        $user = User::create([
            'name' => 'Validasi Foto',
            'email' => 'validasi-'.uniqid().'@example.test',
            'password' => Hash::make('password123'),
            'role' => 'karyawan',
        ]);

        $this->actingAs($user)->from(route('profile.edit'))->patch(route('profile.update'), [
            'photo' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('profile.edit'))->assertSessionHasErrors('photo');

        $this->actingAs($user)->from(route('profile.edit'))->patch(route('profile.update'), [
            'photo' => UploadedFile::fake()->image('besar.jpg')->size(2049),
        ])->assertRedirect(route('profile.edit'))->assertSessionHasErrors('photo');
    }
}
