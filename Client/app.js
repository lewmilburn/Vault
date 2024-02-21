console.log('Starting Vault...');

const electronApp = require('electron').app;
const ipcMain = require('electron').ipcMain;
const electronBrowserWindow = require('electron').BrowserWindow;
const nodePath = require('path');
const crypto = require('crypto');

let window;
let settings = require('./server_processes/readJsonFile')('settings.json');

console.log("[VAULT] Loaded settings:");
console.log(settings);

function createWindow() {
    console.log("[VAULT] Creating window...");
    const window = new electronBrowserWindow({
        width: settings.APP.WINDOW_WIDTH,
        height: settings.APP.WINDOW_HEIGHT,
        show: false,
        webPreferences: {
            nodeIntegration: false,
            contextIsolation: true,
            preload: nodePath.join(__dirname, 'preload.js')
        }
    });

    window.loadFile('./views/loading.html')
        .then(() => {
            window.webContents.send('settings', settings.VAULT);
        })
        .then(() => {
            window.name = 'Vault';
            window.show();
        });

    return window;
}

ipcMain.on('request-settings', () => {
    console.log('[Vault][IPC] Renderer requested settings.');
    window.webContents.send('settings', settings.VAULT);
});
ipcMain.on('screen-offline', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('offline');
});
ipcMain.on('screen-login', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('login');
});
ipcMain.on('screen-dashboard', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('dashboard');
});
ipcMain.on('screen-misconfiguration', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('misconfiguration');
});
ipcMain.on('full-reload', () => {
    console.log('[Vault] Starting full reload...');
    settings = require('./server_processes/readJsonFile')('settings.json');
    console.log('[Vault] Reloaded.');
});
ipcMain.on('cache-update', (event, user, data, key) => {
    console.log('[Vault][IPC] Cache received, updating file...');
    let checksum = crypto.createHash('sha1').update(data).digest("hex");
    let encryptedData = require('./server_processes/encrypt')(data, key);
    require('./server_processes/cache_save')(user, encryptedData, checksum);
    console.log('[Vault][IPC] Cache updated.');
});
ipcMain.on('cache-request', (event, user, key) => {
    console.log('[Vault][IPC] Cache requested...');
    let encryptedCache = require('./server_processes/cache_load')(user);
    if (encryptedCache !== null) {
        let cache = require('./server_processes/decrypt')(encryptedCache.data, key);
        window.webContents.send('cache', cache);
        console.log('[Vault][IPC] Cache sent.');
    }
});

function screen(name) {
    let screenFilePath = './views/' + name + '.html';
    window.loadFile(screenFilePath).then(() => {
        console.log('[VAULT] Loaded screen "'+name+'"');
    });
}

electronApp.on('window-all-closed', () => {
    if (process.platform !== 'darwin') {
        electronApp.quit();
    }
});

electronApp.on('activate', () => {
    console.log("[VAULT] Electron activated.");
    if (electronBrowserWindow.getAllWindows().length === 0) {
        window = createWindow();
    }
    console.log("[VAULT] Created window.");
});