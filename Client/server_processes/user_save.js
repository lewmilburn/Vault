const fs = require("fs");
module.exports = function (user, lastchange) {
    console.log('[VAULT] Saving User data to file...');
    let dataToSave = {
        "last_change": lastchange
    }

    let fs = require('fs');
    try {
        fs.writeFileSync(user+'.json', JSON.stringify(dataToSave), 'utf-8');
        console.log('[VAULT] User data saved to file.');
    } catch(error) {
        console.log('[VAULT] Failed to save User data!');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check the User data file is writeable and try again.');
    }
}