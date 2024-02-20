const { app, BrowserWindow, ipcMain } = require('electron')

console.log('[VAULT] Starting client...');

let win;

const createWindow = () => {
    console.log('[VAULT] Creating window...');
    win = new BrowserWindow({
        width: 800,
        height: 600,
        webPreferences: {
            nodeIntegration: true,
            enableRemoteModule: true,
            contextIsolation: false
        },
    })

    win.loadFile('./views/loading.html')
}

app.whenReady().then(() => {
    createWindow()
    console.log('[VAULT] Window created.');

    ipcMain.on('screen-dashboard', () => {
        console.log('[VAULT][IPC] Change screen to "dashboard".');
        // Load another HTML file
        win.loadFile('./views/dashboard.html')
    });

    ipcMain.on('screen-login', () => {
        console.log('[VAULT][IPC] Change screen to "login".');
        // Load another HTML file
        win.loadFile('./views/login.html')
    });

    ipcMain.on('screen-offline', () => {
        console.log('[VAULT][IPC] Change screen to "offline".');
        // Load another HTML file
        win.loadFile('./views/offline.html')
    });

    ipcMain.on('set-cache', (event, data, checksum, key) => {
        console.log('[VAULT][IPC] Setting cache');
        let encryptedData = require('./server_processes/encrypt')(data, key);

        let dataToSave = {
            "data": encryptedData,
            "checksum": checksum
        }

        let fs = require('fs');
        try {
            console.log('[VAULT] Saving cache to file...');
            fs.writeFileSync('vault.cache', JSON.stringify(dataToSave), 'utf-8');
            console.log('[VAULT] Cache saved to file.');
        } catch(error) {
            console.log('[VAULT] Failed to save cache!');
            console.log('[VAULT] Error: ' + error);
            console.log('[VAULT] Please check the cache file is writeable and try again.');
        }
        console.log('[VAULT][IPC] Set cache');
    });

    ipcMain.on('request-cache', (event, key) => {
        console.log('[VAULT][IPC] Requested cache');

        let fs = require('fs');

        console.log('[VAULT] Loading cache from file...');
        let cache = fs.readFileSync('vault.cache', 'utf-8');
        console.log('[VAULT] Loaded cache from file.');

        cache = JSON.parse(cache.toString());
        let decryptedData = require('./server_processes/decrypt')(cache.data, key);

        ipcMain.emit('cache-data', decryptedData);
        console.log('[VAULT][IPC] Sent cache');
    });

    console.log('[VAULT] Client started.');
})