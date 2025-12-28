const preset = require('./vendor/filament/support/tailwind.config.preset')

/** @type {import('tailwindcss').Config} */
module.exports = {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/filament/support/resources/views/**/*.blade.php',
        './vendor/filament/tables/resources/views/**/*.blade.php',
        './vendor/filament/forms/resources/views/**/*.blade.php',
        './vendor/filament/actions/resources/views/**/*.blade.php',
        './vendor/filament/notifications/resources/views/**/*.blade.php',
        './vendor/filament/widgets/resources/views/**/*.blade.php',
        './vendor/filament/infolists/resources/views/**/*.blade.php',
    ],
}
