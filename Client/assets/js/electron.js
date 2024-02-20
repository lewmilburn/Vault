
const { ipcRenderer, ipcMain} = require('electron');
const fs = require("fs");

ipcRenderer.on('cache-data', (_event, value) => {
    console.log(value);
})

function electronAuthenticated() {
    ipcRenderer.send('screen-dashboard');
}

function electronSetCache(data) {
    ipcRenderer.send('set-cache', data, 'test-checksum', localStorage.getItem('key'));
}

function electronGetCache() {
    ipcRenderer.send('request-cache', localStorage.getItem('key'));
}

function isOffline() {
    ipcRenderer.send('screen-offline');
}

function loginScreen() {
    ipcRenderer.send('screen-login');
}

function doOfflineCache() {
    localStorage.setItem('using-cache', 'true')
    ipcRenderer.send('screen-dashboard');
    electronGetCache();
}