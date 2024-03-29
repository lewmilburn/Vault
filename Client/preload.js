const contextBridge = require('electron').contextBridge;
const ipcRenderer = require('electron').ipcRenderer;

contextBridge.exposeInMainWorld(
    'bridge', {

        // From main to render
        sendSettings: (vaultSettings) => {
            ipcRenderer.on('settings', vaultSettings);
        },

        requestSettings: () => {
            ipcRenderer.send('request-settings');
        },

        updateCache: () => {
            let user = localStorage.getItem('user');
            let key = localStorage.getItem('key');
            let data = localStorage.getItem('cache');
            localStorage.setItem('cache','');
            ipcRenderer.send('cache-update', user, data, key);
        },

        requestCache: () => {
            let user = localStorage.getItem('user');
            let key = localStorage.getItem('key');
            ipcRenderer.send('cache-request', user, key);
        },

        requestUser: () => {
            let user = localStorage.getItem('user');
            ipcRenderer.send('user-request', user);
        },

        resync: () => {
            let user = localStorage.getItem('user');
            let last_change = localStorage.getItem('remote_change');
            ipcRenderer.send('resync', user, last_change);
        },

        recieveCache: (cache) => {
            ipcRenderer.on('cache', cache);
        },

        recieveUserData: (userdata) => {
            ipcRenderer.on('user_data', userdata);
        },

        screenDashboard: () => {
            ipcRenderer.send('screen-dashboard');
        },

        screenMisconfiguration: () => {
            ipcRenderer.send('screen-misconfiguration');
        },

        fullReload: () => {
            ipcRenderer.send('full-reload');
        },

        screenLogin: () => {
            ipcRenderer.send('screen-login');
        },

        screenOffline: () => {
            console.log('test');
            ipcRenderer.send('screen-offline');
        }
    }
);