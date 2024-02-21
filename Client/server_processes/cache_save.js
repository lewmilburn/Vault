module.exports = function (user, data, checksum) {
    console.log('[VAULT] Saving cache to file...');
    let dataToSave = {
        "data": data,
        "checksum": checksum
    }

    let fs = require('fs');
    try {
        fs.writeFileSync(user+'.cache', JSON.stringify(dataToSave), 'utf-8');
        console.log('[VAULT] Cache saved to file.');
    } catch(error) {
        console.log('[VAULT] Failed to save cache!');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check the cache file is writeable and try again.');
    }
}