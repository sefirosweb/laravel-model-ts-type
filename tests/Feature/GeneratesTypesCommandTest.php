<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

/**
 * @internal
 */
class GeneratesTypesCommandTest extends TestCase
{
    /**
     * The model list to test.
     *
     * @var string[]
     */
    protected $modelList = ['bar', 'foo'];

    /**
     * Test for the general generate command.
     *
     * @return void
     */
    public function test_command_absolute_path()
    {
        $modelDir = __DIR__ . '/../Models';
        $outputDir = __DIR__ . '/../Output';

        foreach ($this->modelList as $modelName) {
            $outputFile = $outputDir . '/' . $modelName . '.d.ts';

            if (file_exists($outputFile)) {
                error_log('The output file for ' . $modelName . ' does already exist.');
            }
        }

        $this->artisan("types:generate --modelDir={$modelDir} --outputDir={$outputDir}")
            ->assertExitCode(0);

        $this->reloadApplication();

        foreach ($this->modelList as $modelName) {
            $outputFile = $outputDir . '/' . $modelName . '.d.ts';

            $this->assertFileExists($outputFile);
        }
    }
}
