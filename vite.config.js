import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';
import liveReload from 'vite-plugin-live-reload';

export default defineConfig( {
	root: 'sources',
	server: {
		port: 5173,
		strictPort: true,
		cors: true,
	},
	build: {
		outDir: '../dist',
		assetsDir: '',
		emptyOutDir: true,
		manifest: true,
	},
	cors: true,
	plugins: [ tailwindcss(), liveReload( [ '../**/*.php', '../**/*.twig' ] ) ],
	watch: [
		'./**/*.(php|twig)',
	],
} );
