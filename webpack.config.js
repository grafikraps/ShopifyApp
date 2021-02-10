const path = require('path');

module.exports = {
  entry: {
    redirect: path.resolve(__dirname, 'resources/js/redirect.js'),
  },

  output: {
    path: path.resolve(__dirname, './public'),
    filename: '[name].js',
  },

  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: ['babel-loader'],
      },
      {
        test: /\.css$/,
        use: ['style-loader', 'css-loader'],
      },
    ],
  },

  resolve: {
    extensions: ['*', '.js'],
  },
};
