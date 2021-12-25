<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use MCStreetguy\ComposerParser\Factory as ComposerParser;

class AboutController extends Controller
{
    public function index()
    {
        $composerFile = ComposerParser::parseComposerJson(base_path('composer.json'));
        $composerLock = ComposerParser::parseLockfile(base_path('composer.lock'));
        $composerPackages = collect($composerLock->getPackages()->getData())->map(function ($package) {
            return [
                'name' => $package['name'],
                'description' => $package['description'] ?? null,
                'version' => $package['version'],
                'licenses' => $package['license'] ?? [],
            ];
        })->toArray();

        $npmJson = json_decode(file_get_contents(base_path('package-lock.json')), true);
        $npmPackages = collect($npmJson['packages']['']['devDependencies'])->map(function ($version, $package) use ($npmJson) {
            return $npmJson['dependencies'][$package]['version'];
        });

        return Inertia::render('About/Index', [
            'application' => [
                'about' => [
                    'Authors' => collect($composerFile->getAuthors())->map(function ($author) {
                        return $author->getName();
                    }),
                    'License' => $composerFile->getLicense()[0],
                ],
                'versions' => [
                    'Application' => applicationVersion(),
                    'PHP' => phpversion(),
                    'Laravel' => app()->version(),
                ],
                'extensions' => collect(get_loaded_extensions())->mapWithKeys(function ($extension) {
                    return [$extension => phpversion($extension)];
                })->toArray(),
                'libraries' => [
                    'composer' => $composerPackages,
                    'npm' => $npmPackages,
                ],
            ],
        ]);
    }
}
