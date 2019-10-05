<?php

namespace Arcanedev\LaravelPolicies\Tests\Fixtures\Policies;

use Arcanedev\LaravelPolicies\Policy;

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
        return [
            $this->makeAbility('admin::blog.posts.index', 'index')->setMetas([
                'name'        => 'List all the posts',
                'description' => 'Ability to list all the posts',
            ]),

            $this->makeAbility('admin::blog.posts.create', 'create')->setMetas([
                'name'        => 'Create a post',
                'description' => 'Ability to create a new post',
            ]),

            $this->makeAbility('admin::blog.posts.update', 'update')->setMetas([
                'name'        => 'Update a post',
                'description' => 'Ability to update a post',
            ]),

            $this->makeAbility('admin::blog.posts.delete')->setMetas([
                'name'        => 'Delete a post',
                'description' => 'Ability to delete a post',
            ])->callback(function () {
                return false;
            }),
        ];
    }

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
     */

    public function index()
    {
        return true;
    }

    public function create()
    {
        return true;
    }

    public function update()
    {
        return false;
    }
}
