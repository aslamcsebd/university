<?php

namespace Tests;

use Database\Seeders\CustomAuthorizationSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    // Keep application capabilities in the initial database fixture so each
    // test transaction can reuse them without recreating the full catalog.
    protected $seed = true;

    protected $seeder = CustomAuthorizationSeeder::class;
}
