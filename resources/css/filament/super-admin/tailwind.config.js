import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/SuperAdmin/**/*.php',
        './resources/views/filament/super-admin/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
