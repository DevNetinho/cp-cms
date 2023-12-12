const { default: axios } = require('axios');

window._ = require('lodash');

try {
    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

//Interceptors implementados abaixo para tornar cookies globais em nossa aplicação
axios.interceptors.request.use(
    config => { //CONFIGURANDO O INTERCEPTOR
        
        //DEFININDO TOKEN PARA SER GLOBAL EM NOSSA APLICAÇÃO, PERMITINDO ASSIM, REQUESTS SEM A DECLARAÇÃO DO MESMO.
        const token = document.cookie.split(';')[1].split('=')[1];
        
        config.headers.Accept = 'application/json';
        config.headers.Authorization = token;
        

        console.log('Request interceptado', config);

        return config;
    },

    error => { //ERROS
        console.log('Erro: ', error)
        return Promise.reject(error)

    }

)
