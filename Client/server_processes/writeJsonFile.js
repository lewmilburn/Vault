module.exports = function (file, data) {
    let fs = require('fs');

    try {
        fs.writeFileSync(file, JSON.stringify(data), 'utf-8');
    } catch(error) {
        console.log('[VAULT] Failed to read JSON file "'+file+'"');
        console.log('[VAULT] Error: ' + error);
        console.log('[VAULT] Please check "'+file+'" is readable and try again.');
    }

    return true;
}