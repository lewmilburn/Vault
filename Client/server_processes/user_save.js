/**
 * Saves user data to file.
 *
 * @param user
 * @param lastchange
 */
module.exports = function (user, lastchange) {
    console.log('[VAULT] Saving User data to file...');
    let dataToSave = {
        "last_change": lastchange
    }

    let fs = require('fs');
    try {
        if (fs.existsSync(__dirname + '/../' + user+'.json')) {
            fs.writeFileSync(__dirname + '/../' + user+'.json', JSON.stringify(dataToSave), 'utf-8');
        } else {
            const { dialog } = require('electron');
            dialog.showErrorBox("User file does not exist.",dataToSave.toString());
            fs.writeFileSync(__dirname + '/../' + user+'.json', JSON.stringify(dataToSave), 'utf-8');
            let data = fs.readFileSync(__dirname + '/../' + user+'.json');
            dialog.showErrorBox("Saved data",data.toString());
        }
        console.log('[VAULT] User data saved to file.');
    } catch(error) {
        console.log('[VAULT] Failed to save User data!');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check the User data file is writeable and try again.');
    }
}