<?php

use App\Http\Livewire\Auth\ForgetPassword;
use App\Mail\SendResetPasswordMail;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Modules\Blog\Entities\Post;
use Modules\Blog\Entities\PostCategory;

test('user can visit home page', function () {
    $response = $this->get(route('frontend.index'));
    $response->assertStatus(200);
});

test('user can visit about page', function () {
    $response = $this->get(route('frontend.about'));
    $response->assertStatus(200);
});

test('user can visit faq page', function () {
    $response = $this->get(route('frontend.faq'));
    $response->assertStatus(200);
});

test('user can visit terms and conditions page', function () {
    $response = $this->get(route('frontend.terms'));
    $response->assertStatus(200);
});

test('user can visit blog page', function () {
    $response = $this->get(route('frontend.blog'));
    $response->assertStatus(200);
});

test('user can visit single blog page', function () {
    $this->seed(UserSeeder::class);

    PostCategory::factory()->create();
    $post = Post::factory()->create();

    $response = $this->get(route('frontend.single.blog', ['blog' => $post->slug]));
    $response->assertStatus(200);
});

test('user can get comments count for a post', function () {
    $this->seed(UserSeeder::class);

    PostCategory::factory()->create();
    $post = Post::factory()->create();

    $response = $this->get(route('frontend.commentsCount', ['post_id' => $post->id]));
    $response->assertStatus(200);
});

test('user can visit contact page', function () {
    $response = $this->get(route('frontend.contact'));
    $response->assertStatus(200);
});

test('user can visit price plan page', function () {
    $response = $this->get(route('frontend.priceplan'));
    $response->assertStatus(200);
});

test('user can see password reset form', function () {
    $this->seed(UserSeeder::class);
    $user = User::first();
    $token = Str::random(60);
    DB::table('password_resets')->insert([
        'email' => $user->email,
        'token' => $token,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
    $response = $this->get(route('password.reset', ['token' => $token]));
    $response->assertStatus(200);
});

test('it sends password reset link with valid data', function () {
    $this->seed(UserSeeder::class);
    $user = User::first();
    Mail::fake();
    Livewire::test(ForgetPassword::class)
        ->set('email', $user->email)
        ->call('sendPasswordResetLink');
    Mail::assertSent(SendResetPasswordMail::class, function ($mail) use ($user) {
        return $mail->hasTo($user->email);
    });
});

test('it displays validation errors for invalid data', function () {
    Livewire::test(ForgetPassword::class)
        ->set('email', 'invalid-email')
        ->call('sendPasswordResetLink')
        ->assertHasErrors(['email' => 'email'])
        ->assertSee('The email must be a valid email address');
});

test('user can see password reset form and update password', function () {
    $this->seed(UserSeeder::class);
    $user = User::first();
    $token = uniqid();
    DB::table('password_resets')->insert([
        'email' => $user->email,
        'token' => $token,
        'created_at' => date('Y-m-d H:i:s'),
    ]);
    $this->get(route('password.reset', [
        'token' => $token,
        'email' => $user->email,
    ]))->assertStatus(200);

    $this->post(route('customer.password.update', [
        'token' => $token,
        'email' => $user->email,
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]))->assertStatus(302);
});

test('user can visit promotions page', function () {
    $response = $this->get(route('frontend.promotions'));
    $response->assertStatus(200);
});
