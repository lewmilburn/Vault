const { ipcRenderer } = require('electron');

function electronAuthenticated() {
    ipcRenderer.send('authenticated');
}

function electronSetCache(data) {
    ipcRenderer.send('set-cache', data, 'test-checksum', localStorage.getItem('key'));
}

function electronGetCache(data) {
    ipcRenderer.send('request-cache');
    //ipcRenderer.on('get-cache') {}
}