// Load configuration from environment or config file
const path = require('path');

module.exports = {
  webpack: {
    configure: (webpackConfig, { env, paths }) => {
      // Ensure proper public path for WordPress theme directory
      if (env === 'production') {
        webpackConfig.output.publicPath = './build/';
      }
      
      // Optimize for WordPress integration
      webpackConfig.optimization = {
        ...webpackConfig.optimization,
        splitChunks: {
          chunks: 'all',
          cacheGroups: {
            vendor: {
              test: /[\\/]node_modules[\\/]/,
              name: 'vendors',
              chunks: 'all',
            },
          },
        },
      };
      
      return webpackConfig;
    },
  },
  
  // Development server configuration
  devServer: {
    port: 3000,
    hot: true,
    // Allow WordPress to proxy to React dev server
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
      'Access-Control-Allow-Headers': 'X-Requested-With, content-type, Authorization',
    },
    // Handle React Router in development
    historyApiFallback: {
      disableDotRule: true,
    },
  },
  
  // PostCSS configuration for Tailwind
  style: {
    postcss: {
      plugins: [
        require('tailwindcss'),
        require('autoprefixer'),
      ],
    },
  },
};