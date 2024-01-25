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
})