module.exports = {
	content: [
		'./sources/**/*.js', // tes scripts Vite
		'./sources/**/*.css', // tes styles
		'./**/*.php', // tous les fichiers PHP du thème
		'./**/*.twig', // si tu utilises Timber/Twig
	],

	theme: {
		extend: {},
	},

	plugins: [],
};
