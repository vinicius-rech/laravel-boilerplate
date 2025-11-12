<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create the users table.
     * @param Blueprint $table
     * @Target
     */
    private function createUsersTable(Blueprint $table): void
    {
        $table->id();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->rememberToken();
        $table->timestamp('email_verified_at')->nullable();
        $table->boolean('active')->default(true);
        $table->timestamps();
    }

    /**
     * Create the password reset tokens table.
     * @param Blueprint $table
     */
    private function createPasswordResetTokensTable(Blueprint $table): void
    {
        $table->string('email')->primary();
        $table->string('token');
        $table->timestamp('created_at')->nullable();
    }

    /**
     * Create the sessions table.
     * @param Blueprint $table
     */
    private function createSessionsTable(Blueprint $table): void
    {
        $table->string('id')->primary();
        $table->foreignId('user_id')->nullable()->index();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    }

    /**
     * Create the roles table.
     * @param Blueprint $table
     */
    private function createRolesTable(Blueprint $table): void
    {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->timestamps();
    }

    /**
     * Create the permissions table.
     * @param Blueprint $table
     */
    private function createPermissionsTable(Blueprint $table): void
    {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->foreignId('permission_type_id')->constrained()->cascadeOnDelete();
        $table->foreignId('permission_group_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
    }

    /**
     * Create the permission types table.
     * @param Blueprint $table
     */
    private function createPermissionTypesTable(Blueprint $table): void
    {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->timestamps();
    }

    /**
     * Create the permission groups table.
     * @param Blueprint $table
     */
    private function createPermissionGroupsTable(Blueprint $table): void
    {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->timestamps();
    }

    /**
     * Create the user role table.
     * @param Blueprint $table
     */
    private function createUserRoleTable(Blueprint $table): void
    {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('role_id')->constrained()->cascadeOnDelete();
        $table->timestamps();

        $table->unique(['user_id', 'role_id']);
    }

    /**
     * Create the role permission group table.
     * @param Blueprint $table
     */
    private function createRolePermissionGroupTable(Blueprint $table): void
    {
        $table->id();
        $table->foreignId('role_id')->constrained()->cascadeOnDelete();
        $table->foreignId('permission_group_id')->constrained()->cascadeOnDelete();
        $table->timestamps();

        $table->unique(['role_id', 'permission_group_id']);
    }

    /**
     * Create the role permission table.
     * @param Blueprint $table
     */
    private function createRolePermissionTable(Blueprint $table): void
    {
        $table->id();
        $table->unique(['role_id', 'permission_id']);
        $table->foreignId('role_id')->constrained()->cascadeOnDelete();
        $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
        $table->timestamps();

    }

/**
 *
 */
  public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $this->createUsersTable($table);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $this->createPasswordResetTokensTable($table);
        });

        Schema::create('sessions', function (Blueprint $table) {
            $this->createSessionsTable($table);
        });

        Schema::create('roles', function (Blueprint $table) {
            $this->createRolesTable($table);
        });

        Schema::create('permission_types', function (Blueprint $table) {
            $this->createPermissionTypesTable($table);
        });

        Schema::create('permission_groups', function (Blueprint $table) {
            $this->createPermissionGroupsTable($table);
        });

        Schema::create('permissions', function (Blueprint $table) {
            $this->createPermissionsTable($table);
        });

        Schema::create('user_role', function (Blueprint $table) {
            $this->createUserRoleTable($table);
        });

        Schema::create('role_permission_group', function (Blueprint $table) {
            $this->createRolePermissionGroupTable($table);
        });

        Schema::create('role_permission', function (Blueprint $table) {
            $this->createRolePermissionTable($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
        Schema::dropIfExists('role_permission_group');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('permission_groups');
        Schema::dropIfExists('permission_types');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
