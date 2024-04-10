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

        shutdown: () => {
            ipcRenderer.send('shutdown');
        },

        requestCache: () => {
            let user = localStorage.getItem('user');
            let key = localStorage.getItem('key');
            ipcRenderer.send('cache-request', user, key);
        },

        requestUser: () => {
            ipcRenderer.send('user-request', localStorage.getItem('user'));
        },

        updateSettings: () => {
            let settings = {
                "VAULT": {
                    "SYNC_SERVER_URL": document.getElementById('vault.sync_server_url').value,
                    "ALLOW_OFFLINE_MODE": document.getElementById('vault.allow_offline_mode').value,
                    "FORCE_OFFLINE_MODE": document.getElementById('vault.force_offline_mode').value
                },
                "APP": {
                    "WINDOW_WIDTH": document.getElementById('app.window_width').value,
                    "WINDOW_HEIGHT": document.getElementById('app.window_height').value,
                    "CACHE_ENCRYPTION_METHOD": document.getElementById('app.cache_encryption_method').value
                }
            }
            ipcRenderer.send('update-settings', localStorage.getItem('user'), settings);
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

        screenRestart: () => {
            ipcRenderer.send('screen-restart');
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