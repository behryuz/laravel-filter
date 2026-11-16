<?php

namespace Filter\Tests;

use Illuminate\Filesystem\Filesystem;

class CommandsTest extends TestCase
{
    private string $dir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->dir = $this->app->path('Filters');
        (new Filesystem)->deleteDirectory($this->dir);
    }

    protected function tearDown(): void
    {
        (new Filesystem)->deleteDirectory($this->dir);
        parent::tearDown();
    }

    public function test_commands_are_registered(): void
    {
        $all = $this->app->make(\Illuminate\Contracts\Console\Kernel::class)->all();

        $this->assertArrayHasKey('model:filter', $all);
        $this->assertArrayHasKey('model:filter-node', $all);
    }

    public function test_make_filter_creates_file(): void
    {
        $this->artisan('model:filter', ['name' => 'Foo/bar'])->assertExitCode(0);

        $file = $this->dir . '/Foo/BarFilter.php';
        $this->assertFileExists($file);
        $this->assertStringContainsString('namespace App\Filters\Foo;', file_get_contents($file));
        $this->assertStringContainsString('class BarFilter extends Filter', file_get_contents($file));
    }

    public function test_make_filter_fails_if_exists(): void
    {
        $this->artisan('model:filter', ['name' => 'Baz'])->assertExitCode(0);
        $this->artisan('model:filter', ['name' => 'Baz'])->assertExitCode(1);
    }

    public function test_make_node_filter_creates_file(): void
    {
        $this->artisan('model:filter-node', ['name' => 'Foo/Status'])->assertExitCode(0);

        $file = $this->dir . '/Foo/StatusNodeFilter.php';
        $this->assertFileExists($file);
        $this->assertStringContainsString('class StatusNodeFilter implements NodeFilter', file_get_contents($file));
    }
}
