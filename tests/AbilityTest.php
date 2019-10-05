<?php

namespace Arcanedev\LaravelPolicies\Tests;

use Arcanedev\LaravelPolicies\Ability;
use Illuminate\Foundation\Auth\User;

/**
 * Class     AbilityTest
 *
 * @package  Arcanedev\LaravelPolicies\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AbilityTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $ability = new Ability('posts.create', 'create');

        static::assertSame('posts.create', $ability->key());
        static::assertSame('create', $ability->method());
    }

    /** @test */
    public function it_can_make()
    {
        $ability = Ability::make('posts.create', 'create');

        static::assertSame('posts.create', $ability->key());
        static::assertSame('create', $ability->method());
    }

    /** @test */
    public function it_can_create_with_closure_method()
    {
        $ability = Ability::make('posts.create', function (User $user) {
            return true;
        });

        static::assertSame('posts.create', $ability->key());
        static::assertTrue(is_callable($ability->method()));
        static::assertTrue($ability->isClosure());
    }

    /** @test */
    public function it_can_set_and_get_metas()
    {
        $metas = [
            'name'        => 'List posts',
            'description' => 'Ability to list all the posts',
        ];

        $ability = Ability::make('posts.list', 'index')->setMetas($metas);

        static::assertEquals($metas, $ability->metas());
    }

    /** @test */
    public function it_can_set_and_get_single_meta()
    {
        $name        = 'List posts';
        $description = 'Ability to list all the posts';

        $ability = Ability::make('posts.list', 'index')
            ->setMeta('name', $name)
            ->setMeta('description', $description);

        static::assertSame($name, $ability->meta('name'));
        static::assertSame($description, $ability->meta('description'));
    }

    /** @test */
    public function it_can_get_meta_with_default_value()
    {
        $ability = Ability::make('posts.list', 'index');

        static::assertNull($ability->meta('name'));
        static::assertSame('List posts', $ability->meta('name', 'List posts'));
    }

    /** @test */
    public function it_can_set_and_get_nested_metas()
    {
        $ability = Ability::make('posts.update', 'update')->setMeta('roles', [
            'administrator' => true,
            'author'        => true,
        ]);

        $ability->setMeta('roles.guest', false);

        static::assertEquals([
            'administrator' => true,
            'author'        => true,
            'guest'         => false,
        ], $ability->meta('roles'));

        static::assertSame(true, $ability->meta('roles.administrator'));
        static::assertSame(true, $ability->meta('roles.author'));
        static::assertSame(false, $ability->meta('roles.guest'));
    }

    /** @test */
    public function it_can_convert_toArray()
    {
        $metas = [
            'name'        => 'List posts',
            'description' => 'Ability to list all the posts',
        ];

        $ability = Ability::make('posts.list', 'index')->setMetas($metas);

        $expected = [
            'key'    => 'posts.list',
            'method' => 'index',
            'metas'  => $metas,
        ];

        static::assertInstanceOf(\Illuminate\Contracts\Support\Arrayable::class, $ability);
        static::assertEquals($expected, $ability->toArray());
    }

    /** @test */
    public function it_can_convert_to_json()
    {
        $metas = [
            'name'        => 'List posts',
            'description' => 'Ability to list all the posts',
        ];

        $ability = Ability::make('posts.list', 'index')->setMetas($metas);

        $instanceExpectations = [
            \JsonSerializable::class,
            \Illuminate\Contracts\Support\Jsonable::class,
        ];

        foreach ($instanceExpectations as $expected) {
            static::assertInstanceOf($expected, $ability);
        }

        $expectedJson = json_encode([
            'key'    => 'posts.list',
            'method' => 'index',
            'metas'  => $metas,
        ]);

        static::assertJsonStringEqualsJsonString($expectedJson, (string) $ability);
        static::assertJsonStringEqualsJsonString($expectedJson, json_encode($ability));
        static::assertJsonStringEqualsJsonString($expectedJson, (string) $ability->toJson());
    }
}
