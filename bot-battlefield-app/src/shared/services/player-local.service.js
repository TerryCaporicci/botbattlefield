/**
 * @type {String}
 */
const key = "player";

/**
 * @type {PlayerLocalService}
 */
export class PlayerLocalService {

    /**
     * @constructor
     */
    constructor() { }

    /**
     * @returns {Promise}
     */
    static read() {
        return new Promise((resolve, reject) => {
            try {
                resolve(JSON.parse(window.localStorage.getItem(key)));
            } catch (error) {
                reject(error);
            }
        });
    }

    /**
     * @param {PlayerModel} player
     * @returns {Promise}
     */
    static create(player) {
        return new Promise((resolve, reject) => {
            try {
                window.localStorage.setItem(key, JSON.stringify(player));
                resolve();
            } catch (error) {
                reject(error);
            }
        });
    }

}
