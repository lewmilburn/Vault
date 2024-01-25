const { ipcRenderer } = require('electron');

function electronAuthenticated() {
    ipcRenderer.send('authenticated');
}