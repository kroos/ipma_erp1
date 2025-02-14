import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
	purge: false,

	content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		'./storage/framework/views/*.php',
		'./resources/views/**/*.blade.php',
	],

	corePlugins: {
		preflight: false, // Prevents Tailwind from overriding Bootstrap styles
	},
	theme: {
		extend: {
			fontFamily: {
				sans: ['Cactus Classical Serif', ...defaultTheme.fontFamily.sans],
			},
		},
	},
	plugins: [forms],
};
