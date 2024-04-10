const crypto = require("crypto");
/**
 * @name checksum.js
 * @description Creates a checksum.
 *
 * @param data
 * @returns {string}
 */
module.exports = function (data) {
    return crypto.createHash('sha512').update(data).digest("hex");
}