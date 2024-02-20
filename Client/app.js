const { app, BrowserWindow, ipcMain } = require('electron')

let win;

const createWindow = () => {
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

    ipcMain.on('screen-dashboard', () => {
        // Load another HTML file
        win.loadFile('./views/dashboard.html')
    });

    ipcMain.on('screen-login', () => {
        // Load another HTML file
        win.loadFile('./views/login.html')
    });

    ipcMain.on('screen-offline', () => {
        // Load another HTML file
        win.loadFile('./views/offline.html')
    });

    ipcMain.on('set-cache', (event, data, checksum, key) => {
        console.log(data);
        let encryptedData = require('./server_processes/encrypt')(data, key);
        let decryptedData = require('./server_processes/decrypt')(encryptedData, key);
        console.log(decryptedData);

        let dataToSave = {
            "data": encryptedData,
            "checksum": checksum
        }

        let fs = require('fs');
        try {
            fs.writeFileSync('vault.cache', JSON.stringify(dataToSave), 'utf-8');
        } catch(error) {
            console.log('[VAULT] Failed to save cache!');
            console.log('[VAULT] Error: ' + error);
            console.log('[VAULT] Please check the cache file is writeable and try again.');
        }
    });

    ipcMain.on('request-cache', () => {
        console.log('Requested cache!');
    });
})