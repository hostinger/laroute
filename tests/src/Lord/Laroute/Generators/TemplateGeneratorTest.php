<?php

namespace Lord\Laroute\Generators;

use Illuminate\Filesystem\Filesystem;
use Jojo\Laroute\Compilers\CompilerInterface;
use Jojo\Laroute\Generators\GeneratorInterface;
use Jojo\Laroute\Generators\TemplateGenerator;
use Mockery;
use PHPUnit\Framework\TestCase;

class TemplateGeneratorTest extends TestCase
{
    protected $compiler;

    protected $filesystem;

    protected $generator;

    public function setUp(): void
    {
        parent::setUp();

        $this->compiler   = $this->mock(CompilerInterface::class);
        $this->filesystem = $this->mock(Filesystem::class);

        $this->generator = new TemplateGenerator($this->compiler, $this->filesystem);
    }

    public function testItIsOfTheCorrectInterface()
    {
        $this->assertInstanceOf(
            GeneratorInterface::class,
            $this->generator
        );
    }

    public function testItWillCompileAndSaveATemplate()
    {
        $template     = "Template";
        $templatePath = '/templatePath';
        $templateData = ['foo', 'bar'];
        $filePath     = '/filePath';

        $this->filesystem
            ->shouldReceive('get')
            ->once()
            ->with($templatePath)
            ->andReturn($template);

        $this->filesystem
            ->shouldReceive('isDirectory')
            ->once()
            ->andReturn(true);

        $this->compiler
            ->shouldReceive('compile')
            ->once()
            ->with($template, $templateData)
            ->andReturn($template);

        $this->filesystem
            ->shouldReceive('put')
            ->once()
            ->with($filePath, $template);

        $actual = $this->generator->compile($templatePath, $templateData, $filePath);
        $this->assertSame($actual, $filePath);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    protected function mock($class, $app = [])
    {
        $mock = Mockery::mock($class, $app);

        return $mock;
    }
}
