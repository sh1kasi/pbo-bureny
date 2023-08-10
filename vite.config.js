import { defineConfig } from 'vite'
import laravel from 'vite-plugin-laravel'

export default defineConfig({
	plugins: [
		laravel({
			input: 'resources/js/app.js',
            refresh: true,

		}),
	],
})
