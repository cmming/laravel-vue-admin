var merge = require('webpack-merge')
var prodEnv = require('./prod.env')

module.exports = merge(prodEnv, {
  NODE_ENV: '"development"',
  API_ROOT: '"/api/"',
  ROUTER_URL:'http://192.168.0.88/laravel/cmadmin/src/router/RouterMap/ansycRouterMap.js',
  ROUTER_PATH:'D:/xampp/htdocs/laravel/cmadmin/src/router/RouterMap/ansycRouterMap.js'
})
