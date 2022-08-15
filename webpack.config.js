const path = require('path');
const glob = require('glob');

module.exports = {
	mode: 'development',
	watch: true,
	entry: {
		'bundle.js': glob.sync('./src/**/**.js')
	},
	output: {
		filename: 'inpsyde-assessment.js',
		path: path.resolve(__dirname, 'dist'),
	},
	module: {
		rules: [
			{
				test: /\.s[ac]ss$/i,
				use: [
					"style-loader",
					"css-loader",
					{
						loader: "sass-loader",
						options: {
							implementation: require("sass"),
							sourceMap: true,
							sassOptions: {
								outputStyle: "compressed",
							},
						},
					},
				],
			}
		]
	}
};