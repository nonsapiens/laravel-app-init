<?php

namespace Nonsapiens\LaravelAppInit;

final class AppInit
{
    /**
     * @var string[] Additional directories (e.g. from packages) containing init files
     */
    private static array $paths = [];

    /**
     * Register a directory of init files, typically from a package service provider.
     * Inits in registered paths take precedence over an application init of the same name.
     */
    public static function loadInitsFrom(string $path): void
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        if (! in_array($path, self::$paths, true)) {
            self::$paths[] = $path;
        }
    }

    /**
     * @return string[]
     */
    public static function paths(): array
    {
        return self::$paths;
    }

    /**
     * All init files keyed by init name, sorted by name. Registered paths override the application's inits.
     *
     * @return array<string, string>
     */
    public static function files(): array
    {
        $files = [];

        foreach (array_merge([base_path('inits')], self::$paths) as $path) {
            foreach (glob($path.'/*.php') ?: [] as $file) {
                $files[pathinfo($file, PATHINFO_FILENAME)] = $file;
            }
        }

        ksort($files);

        return $files;
    }

    public static function flush(): void
    {
        self::$paths = [];
    }
}
