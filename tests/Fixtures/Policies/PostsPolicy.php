<?php

namespace Arcanedev\LaravelPolicies\Tests\Fixtures\Policies;

use Arcanedev\LaravelPolicies\Policy;
use Illuminate\Foundation\Auth\User;

/**
 * Class     PostsPolicy
 *
 * @package  Arcanedev\LaravelPolicies\Tests\Fixtures\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PostsPolicy extends Policy
{
    /* -----------------------------------------------------------------
     |  Mains Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the policy's abilities.
     *
     * @return \Arcanedev\LaravelPolicies\Ability[]|iterable
     */
    public function abilities(): iterable
    {
        $this->setMetas([
            'category' => 'Blog',
        ]);

        return [

            $this->makeAbility('list-posts')->setMetas([
                'name'        => 'List all the posts',
                'description' => 'Ability to list all the posts',
            ]),

            $this->makeAbility('create-post')->setMetas([
                'name'        => 'Create a post',
                'description' => 'Ability to create a new post',
            ]),

            $this->makeAbility('update-post')->setMetas([
                'name'        => 'Update a post',
                'description' => 'Ability to update a post',
            ]),

            $this->makeAbility('delete-post')->setMetas([
                'name'        => 'Delete a post',
                'description' => 'Ability to delete a post',
            ]),

        ];
    }

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
     */

    public function listPosts(?User $user, bool $condition = true)
    {
        return $condition;
    }

    public function createPost(?User $user, bool $condition = true)
    {
        return $condition;
    }

    public function updatePost(?User $user, bool $condition = true)
    {
        return $condition;
    }

    public function deletePost(?User $user, bool $condition = true)
    {
        return $condition;
    }
}
