const path = require("path");
const defaultConfig = require("@wordpress/scripts/config/webpack.config");

module.exports = {
  entry: path.resolve(__dirname, "assets/js/index.js"),
  output: {
    path: path.resolve(__dirname),
    filename: "index.js",
    hashFunction: "xxhash64",
  },
  module: {
    ...defaultConfig.module,
  },
};
