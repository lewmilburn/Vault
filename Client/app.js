console.log('Starting Vault...');

const electronApp = require('electron').app;
const ipcMain = require('electron').ipcMain;
const electronBrowserWindow = require('electron').BrowserWindow;
const nodePath = require('path');

require(__dirname + '/server_processes/settings')(electronApp);

let window;
let settings = require(nodePath.join(__dirname + '/server_processes/readJsonFile'))(require(__dirname + '/server_processes/path')(electronApp, '/settings.json'));

if (settings === null || settings === undefined) {
    const {dialog} = require('electron');
    dialog.showErrorBox('Vault Error (12)', 'Unable to fetch settings.');
}

console.log("[VAULT] Loaded settings:");
console.log(settings);

/**
 * createWindow() creates the initial application window.
 * @returns {Electron.CrossProcessExports.BrowserWindow}
 */
function createWindow() {
    console.log("[VAULT] Creating window...");
    const window = new electronBrowserWindow({
        width: settings.APP.WINDOW_WIDTH,
        height: settings.APP.WINDOW_HEIGHT,
        show: false,
        webPreferences: {
            nodeIntegration: false,
            contextIsolation: true,
            preload: nodePath.join(__dirname, '/preload.js'),
            devTools: false
        },
        autoHideMenuBar: true
    });

    window.loadFile(nodePath.join(__dirname + '/views/loading.html'))
        .then(() => {
            window.webContents.send('settings', settings);
        })
        .then(() => {
            window.name = 'Vault';
            window.show();

            if (!require(nodePath.join(__dirname + '/server_processes/fileExists'))(require(__dirname + '/server_processes/path')(electronApp, '/vault.json'))) {
                screen('misconfiguration');
            }
        });
    return window;
}

/**
 * Sends settings upon request by client.
 */
ipcMain.on('request-settings', () => {
    console.log('[Vault][IPC] Renderer requested settings.');
    window.webContents.send('settings', settings);
});

/**
 * Updates settings and saves to file.
 */
ipcMain.on('update-settings', (event, user, clientSettings) => {
    console.log('[Vault][IPC] Renderer updated settings.');
    console.log(clientSettings);
    require(nodePath.join(__dirname + '/server_processes/writeJsonFile'))(require(__dirname + '/server_processes/path')(electronApp, '/settings.json'), clientSettings);
    require(nodePath.join(__dirname + '/server_processes/deleteJsonFile'))(require(__dirname + '/server_processes/path')(electronApp, '/'+user+'.cache'));
});

/**
 * Displays the offline screen.
 */
ipcMain.on('screen-offline', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('offline');
});

/**
 * Displays the login screen.
 */
ipcMain.on('screen-login', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('login');
});

/**
 * Displays the dashboard screen.
 */
ipcMain.on('screen-dashboard', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('dashboard');
});

/**
 * Displays the restart screen.
 */
ipcMain.on('screen-restart', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    screen('restart');
});

/**
 * Displays the misconfiguration screen.
 */
ipcMain.on('screen-misconfiguration', () => {
    console.log('[Vault][IPC] Renderer requested screen change.');
    const {dialog} = require('electron');
    dialog.showErrorBox(
        'Vault Error (13)',
        'Vault is misconfigured, please check your settings and try again.'
    );
    screen('misconfiguration');
});

/**
 * Fully reloads the application settings.
 */
ipcMain.on('full-reload', () => {
    console.log('[Vault] Starting full reload...');
    settings = require(nodePath.join(__dirname + '/server_processes/readJsonFile'))(require(__dirname + '/server_processes/path')(electronApp, '/settings.json'));
    console.log('[Vault] Reloaded.');
});

/**
 * Updates the cache from user sent data.
 */
ipcMain.on('cache-update', (event, user, data, key) => {
    console.log('[Vault][IPC] Cache received, updating file...');
    let checksum = require(nodePath.join(__dirname + '/server_processes/checksum'))(data);
    let encryptedData = require(nodePath.join(__dirname + '/server_processes/encrypt'))(data, key,settings);
    require(nodePath.join(__dirname + '/server_processes/cache_save'))(user, encryptedData, checksum, electronApp);
    let date = require(nodePath.join(__dirname + '/server_processes/currentDate'))();
    require(nodePath.join(__dirname + '/server_processes/user_save'))(user, date, electronApp);
    console.log('[Vault][IPC] Cache updated.');
});

/**
 * Sends cache back to client upon request.
 */
ipcMain.on('cache-request', (event, user, key) => {
    console.log('[Vault][IPC] Cache requested...');
    let encryptedCache = require(nodePath.join(__dirname + '/server_processes/cache_load'))(user, electronApp);
    if (encryptedCache !== null) {
        let cache = require(nodePath.join(__dirname + '/server_processes/decrypt'))(encryptedCache.data, key, settings);
        window.webContents.send('cache', cache);
        console.log('[Vault][IPC] Cache sent.');
    }
});

/**
 * Sends user data back to the client upon request.
 */
ipcMain.on('user-request', (event, user) => {
    console.log('[Vault][IPC] User data requested...');
    let userdata = require(nodePath.join(__dirname + '/server_processes/user_load'))(user, electronApp);
    if (userdata !== null) {
        window.webContents.send('user_data', userdata);
        console.log('[Vault][IPC] User data sent.');
    } else {
        return null;
    }
});

/**
 * Resyncs the cache.
 */
ipcMain.on('resync', (event, user) => {
    console.log('[Vault][IPC] Resync requested...');
    let date = require(nodePath.join(__dirname + '/server_processes/currentDate'))();
    require(nodePath.join(__dirname + '/server_processes/user_save'))(user, date, electronApp);
});

/**
 * Shuts down Vault Client.
 */
ipcMain.on('shutdown', () => {
    console.log('[VAULT] Goodbye!');
    electronApp.quit();
});

/**
 * Shuts down Vault Client.
 */
electronApp.on('window-all-closed', () => {
    console.log('[VAULT] Goodbye!');
    electronApp.quit();
});

/**
 * When electron is ready, call the createWindow() function.
 */
electronApp.on('ready', () => {
    window = createWindow()
});

/**
 * Changes the screen.
 * @param name
 */
function screen(name) {
    let screenFilePath = '/views/' + name + '.html';
    window.loadFile(nodePath.join(__dirname + screenFilePath)).then(() => {
        console.log('[VAULT] Loaded screen "'+name+'"');
    });
}