<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserEncryptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_data_is_encrypted_in_database()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'student_id' => '2020-12345'
        ]);

        // Check database contains encrypted values
        $dbUser = DB::table('users')->where('id', $user->id)->first();
        $this->assertNotEquals('test@example.com', $dbUser->email);
        $this->assertNotEquals('2020-12345', $dbUser->student_id);

        // Verify we can decrypt
        $this->assertEquals('test@example.com', Crypt::decrypt($dbUser->email));
    }

    public function test_automatic_decryption()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $retrievedUser = User::find($user->id);
        $this->assertEquals('test@example.com', $retrievedUser->email);
    }

    public function test_encrypted_search()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        $foundUser = User::whereEncrypted('email', 'test@example.com')->first();
        $this->assertEquals($user->id, $foundUser->id);
    }
}
