const { ipcRenderer } = require('electron');

function electronAuthenticated() {
    ipcRenderer.send('screen-dashboard');
}

function electronSetCache(data) {
    ipcRenderer.send('set-cache', data, 'test-checksum', localStorage.getItem('key'));
}

function electronGetCache(data) {
    ipcRenderer.send('request-cache');
    //ipcRenderer.on('get-cache') {}
}

function isOffline() {
    ipcRenderer.send('screen-offline');
}

function loginScreen() {
    ipcRenderer.send('screen-login');
}

function doOfflineCache() {
    ipcRenderer.send('screen-dashboard');
}