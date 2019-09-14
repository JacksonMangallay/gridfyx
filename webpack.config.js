const path = require('path');
const ExtractCSS = require('mini-css-extract-plugin');
const BabelMinify = require('babel-minify-webpack-plugin');
const OptimizeCSS = require('optimize-css-assets-webpack-plugin');
const UglifyJS = require('uglifyjs-webpack-plugin');

var mode = 'production';

var entry = {
    app: './index.js'
}

var output = {
    publicPath: 'dist/',
    path: path.resolve(__dirname, 'dist'),
    filename: 'public/assets/js/[name].js'
}

var optimization = {
    minimizer: [
        new OptimizeCSS({
            cssProcessor: require('cssnano'),
            cssProcessorPluginOptions: {
                preset: [
                    'default', 
                    { discardComments: 
                        { 
                            removeAll: true 
                        } 
                    }
                ]
            }
        }),
        new UglifyJS({
            uglifyOptions: {
                output: {
                    comments: false
                }
            }
        })
    ],
    splitChunks: {
        automaticNameDelimiter: '.',
        cacheGroups: {
            vendors: {
                test: /[\\/]node_modules[\\/]/,
                name: 'chunk-vendors',
                chunks: 'all'
            }
        }
    }
}

var modules = {
    rules: [
        {
            test: /\.js/,
            exclude: /(node_modules)/,
            use: [{
                loader: 'babel-loader'
            }]
        },
        {
            test: /\.scss$/,
            use: [
                {
                    loader: ExtractCSS.loader
                },
                'css-loader',
                'sass-loader'
            ]
        },
        {
            test: /\.(woff|woff2|eot|ttf)(\?.*$|$)?/,
            use: [
                {
                    loader: 'file-loader',
                    options: {
                        name: 'public/assets/fonts/[name].[ext]',
                        publicPath: function(url){
                            return url.replace(/public/, '..')
                        }
                    }
                }
            ]
        },
        {
            test: /\.(png|gif|jpe|jpg|svg)(\?.*$|$)?/,
            use: [
                {
                    loader: 'file-loader',
                    options: {
                        name: 'public/assets/images/[name].[ext]',
                        publicPath: function(url){
                            return url.replace(/public/, '..')
                        }
                    }
                }
            ]
        }
    ]
}

var resolve = {
    alias: {
        vue: 'vue/dist/vue.min.js'
    }
}

var plugins = [
    new ExtractCSS({
        filename: 'public/assets/css/[name].css'
    }),
    new BabelMinify()
]

module.exports = {
    mode: mode,
    optimization: optimization,
    entry: entry,
    output: output,
    module: modules,
    resolve: resolve,
    plugins: plugins
};