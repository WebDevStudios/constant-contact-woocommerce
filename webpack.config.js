const path = require('path');

module.exports = {
	entry: {
		'bundle': './app/index.js',
		'admin-bundle': './app/admin.js',
	},
	output: {
		filename: '[name].js',
		path: path.resolve(__dirname, 'app')
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /(node_modules)/,
				use: [
					{
						loader: 'babel-loader',
						options: {
							presets: ['@babel/preset-env']
						}
					}
				]
			}
		]
	}
};