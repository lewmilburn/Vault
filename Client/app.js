console.log('Starting Vault...');

const electronApp = require('electron').app;
const ipcMain = require('electron').ipcMain;
const electronBrowserWindow = require('electron').BrowserWindow;
const nodePath = require('path');

let window;
let settings = require(nodePath.join(__dirname + '/server_processes/readJsonFile'))(nodePath.join(__dirname + '/settings.json'));

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
            preload: nodePath.join(__dirname, '/preload.js')
        }
    });

    window.loadFile(nodePath.join(__dirname + '/views/loading.html'))
        .then(() => {
            window.webContents.send('settings', settings);
        })
        .then(() => {
            window.name = 'Vault';
            window.show();
        });
    return window;
}

ipcMain.on('request-settings', () => {
    console.log('[Vault][IPC] Renderer requested settings.');
    window.webContents.send('settings', settings);
});
ipcMain.on('update-settings', (event, user, clientSettings) => {
    console.log('[Vault][IPC] Renderer updated settings.');
    console.log(clientSettings);
    require(nodePath.join(__dirname + '/server_processes/writeJsonFile'))(nodePath.join(__dirname + '/settings.json'), clientSettings);
    require(nodePath.join(__dirname + '/server_processes/deleteJsonFile'))(nodePath.join(__dirname + '/'+user+'.cache'));
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
ipcMain.on('screen-restart', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('restart');
});
ipcMain.on('screen-misconfiguration', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('misconfiguration');
});
ipcMain.on('full-reload', () => {
    console.log('[Vault] Starting full reload...');
    settings = require(nodePath.join(__dirname + '/server_processes/readJsonFile'))(nodePath.join(__dirname + 'settings.json'));
    console.log('[Vault] Reloaded.');
});
ipcMain.on('cache-update', (event, user, data, key) => {
    console.log('[Vault][IPC] Cache received, updating file...');
    let checksum = require(nodePath.join(__dirname + '/server_processes/checksum'))(data);
    let encryptedData = require(nodePath.join(__dirname + '/server_processes/encrypt'))(data, key,settings);
    require(nodePath.join(__dirname + '/server_processes/cache_save'))(user, encryptedData, checksum);
    console.log('[Vault][IPC] Cache updated.');
});
ipcMain.on('cache-request', (event, user, key) => {
    console.log('[Vault][IPC] Cache requested...');
    let encryptedCache = require(nodePath.join(__dirname + '/server_processes/cache_load'))(user);
    if (encryptedCache !== null) {
        let cache = require(nodePath.join(__dirname + '/server_processes/decrypt'))(encryptedCache.data, key, settings);
        window.webContents.send('cache', cache);
        console.log('[Vault][IPC] Cache sent.');
    }
});
ipcMain.on('user-request', (event, user) => {
    console.log('[Vault][IPC] User data requested...');
    let userdata = require(nodePath.join(__dirname + '/server_processes/user_load'))(user);
    if (userdata !== null) {
        window.webContents.send('user_data', userdata);
        console.log('[Vault][IPC] User data sent.');
    } else {
        return null;
    }
});
ipcMain.on('resync', (event, user, last_change) => {
    console.log('[Vault][IPC] Resync requested...');
    require(nodePath.join(__dirname + '/server_processes/user_save'))(user, last_change);
});
ipcMain.on('shutdown', () => {
    console.log('[VAULT] Goodbye!');
    electronApp.quit();
});

function screen(name) {
    let screenFilePath = '/views/' + name + '.html';
    window.loadFile(nodePath.join(__dirname + screenFilePath)).then(() => {
        console.log('[VAULT] Loaded screen "'+name+'"');
    });
}

electronApp.on('window-all-closed', () => {
    console.log('[VAULT] Goodbye!');
    electronApp.quit();
});

electronApp.on('ready', () => {
    window = createWindow()
});