require('jsdom-global')();

global.expect = require('expect')

global.axios = require('axios');
global.Vue = require('vue');
global.bus = new Vue();