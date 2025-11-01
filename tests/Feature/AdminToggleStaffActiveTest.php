<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Branch;

uses(RefreshDatabase::class);

it('allows admin to toggle staff active in their branch and prevents toggling other branch staff', function () {
    // Create two branches
    $branchA = Branch::factory()->create();
    $branchB = Branch::factory()->create();

    // Create an admin assigned to branch A
    $admin = User::factory()->create(['role' => 'admin', 'branch_id' => $branchA->id]);

    // Create staff in branch A and branch B
    $staffA = User::factory()->create(['role' => 'staff', 'branch_id' => $branchA->id, 'active' => true]);
    $staffB = User::factory()->create(['role' => 'staff', 'branch_id' => $branchB->id, 'active' => true]);

    // Acting as admin, toggle staffA
    $this->actingAs($admin)
        ->put(route('admin.toggleStaffActive', $staffA->id))
        ->assertRedirect();

    expect((bool)$staffA->fresh()->active)->toBeFalse();

    // Acting as admin, attempt to toggle staffB (should be forbidden / redirected with error)
    $response = $this->actingAs($admin)
        ->put(route('admin.toggleStaffActive', $staffB->id));

    // Should redirect back with errors
    $response->assertRedirect();
    $response->assertSessionHasErrors();

    // Ensure staffB still active
    expect((bool)$staffB->fresh()->active)->toBeTrue();
});
