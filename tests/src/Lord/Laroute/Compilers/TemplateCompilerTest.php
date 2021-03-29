<?php

namespace Lord\Laroute\Compilers;

use Jojo\Laroute\Compilers\CompilerInterface;
use Jojo\Laroute\Compilers\TemplateCompiler;
use Mockery;
use PHPUnit\Framework\TestCase;

class TemplateCompilerTest extends TestCase
{
    protected $compiler;

    public function setUp(): void
    {
        parent::setUp();

        $this->compiler = new TemplateCompiler();
    }

    public function testItIsOfTheCorrectInterface()
    {
        $this->assertInstanceOf(
            CompilerInterface::class,
            $this->compiler
        );
    }

    public function testItCanCompileAString()
    {
        $template = 'Hello $YOU$, my name is $ME$.';
        $data     = ['you' => 'Stranger', 'me' => 'Aaron'];
        $expected = "Hello Stranger, my name is Aaron.";

        $this->assertSame($expected, $this->compiler->compile($template, $data));
    }

    public function tearDown(): void
    {
        Mockery::close();
    }

    protected function mock($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }
}
