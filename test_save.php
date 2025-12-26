<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;

try {
    // Test 1: Direct DB insert
    echo "Test 1: Direct DB insert...\n";
    DB::table('users')->insert([
        'name' => 'Direct Test',
        'email' => 'direct@test.com',
        'password' => bcrypt('password'),
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "✓ Direct DB insert successful!\n\n";

    // Test 2: Eloquent create
    echo "Test 2: Eloquent create...\n";
    $user = User::create([
        'name' => 'Eloquent Test',
        'email' => 'eloquent@test.com',
        'password' => 'password'
    ]);
    echo "✓ Eloquent create successful! User ID: " . $user->id . "\n\n";

    // Test 3: Eloquent save
    echo "Test 3: Eloquent save...\n";
    $user2 = new User();
    $user2->name = 'Save Test';
    $user2->email = 'save@test.com';
    $user2->password = 'password';
    $result = $user2->save();
    echo $result ? "✓ Eloquent save successful! User ID: " . $user2->id . "\n\n" : "✗ Eloquent save failed!\n\n";

    echo "All tests passed! Data saving is working correctly.\n";
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}
