<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('mengarahkan user yang belum login ke halaman login (Authentication)', function () {
    // Mencoba mengakses halaman index tanpa login
    $response = $this->get('/tasks');

    // Harus di-redirect ke halaman login
    $response->assertRedirect('/login');
});

it('mengizinkan user yang sudah login untuk menyimpan task baru', function () {
    $user = User::factory()->create();

    $taskData = [
        'description' => 'Menyelesaikan UI Adaptive',
        'due_date' => now()->addDays(2)->format('Y-m-d'),
        'priority' => 'medium',
    ];

    // Simulasi user sedang login (actingAs) lalu post data
    $response = $this->actingAs($user)->post('/tasks', $taskData);

    // Harus di-redirect kembali ke index dengan sukses
    $response->assertRedirect(route('tasks.index'));
    $response->assertSessionHas('success');

    // Pastikan data tersimpan di DB atas nama user tersebut
    $this->assertDatabaseHas('tasks', [
        'user_id' => $user->id,
        'description' => 'Menyelesaikan UI Adaptive',
    ]);
});

it('menolak input jika validasi form request gagal', function () {
    $user = User::factory()->create();

    // Mengirim data kosong untuk mengetes FormRequest
    $response = $this->actingAs($user)->post('/tasks', []);

    // Memastikan error validasi muncul untuk field yang required
    $response->assertSessionHasErrors(['description', 'due_date', 'priority']);
});