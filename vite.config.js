import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

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
	plugins: [ tailwindcss() ],
} );
