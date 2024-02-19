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

    win.loadFile('./views/login/login.html')
}

app.whenReady().then(() => {
    createWindow()

    ipcMain.on('authenticated', () => {
        // Load another HTML file
        win.loadFile('./views/dashboard/dashboard.html')
    });

    ipcMain.on('set-cache', (event, data, checksum, key) => {
        let dataToSave = {
            "data": data,
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