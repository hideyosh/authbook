<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Semua user bisa lihat list
    }

    public function view(User $user, Book $book): bool
    {
        return true; // Semua user bisa lihat detail
    }

    public function create(User $user): bool
    {
        return $user->role !== 'viewer';
    }

    public function update(User $user, Book $book): bool
    {
        return $user->role !== 'viewer';
    }

    public function delete(User $user, Book $book): bool
    {
       return $user->role === 'admin';
    }

    public function restore(User $user, Book $book): bool
    {
       return $user->role === 'admin';
    }

    public function forceDelete(User $user, Book $book): bool
    {
        return $user->role === 'admin';
    }
}
