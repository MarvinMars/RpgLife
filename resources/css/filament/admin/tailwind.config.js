import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './app/Enums/*.php',
        './resources/views/filament/**/*.blade.php',
        './resources/views/filament/app/**/*.blade.php',
        './resources/views/tables/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
